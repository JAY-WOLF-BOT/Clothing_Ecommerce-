<?php

namespace App\Support;

use App\Models\Product;
use Illuminate\Contracts\Session\Session;

/**
 * The bag is session state keyed by "productId-size", so a shopper can leave
 * the site, come back, and still find their items — the step a WhatsApp chat
 * never had. Stock caps are applied on every write, so a stale tab cannot
 * order more than exists.
 */
class Bag
{
    public const SESSION_KEY = 'bag';

    public function __construct(private Session $session) {}

    /**
     * @return array<int, array{key: string, product: Product, size: string, quantity: int, unit_price: int, total: int, stock: int}>
     */
    public function lines(): array
    {
        $raw = $this->raw();

        if ($raw === []) {
            return [];
        }

        $ids = collect(array_keys($raw))
            ->map(fn (string $key) => (int) str($key)->before('-')->toString())
            ->unique()
            ->values();

        $products = Product::with(['images', 'variants'])
            ->whereIn('id', $ids)
            ->get()
            ->keyBy('id');

        $lines = [];
        $pruned = false;

        foreach ($raw as $key => $quantity) {
            [$id, $size] = array_pad(explode('-', (string) $key, 2), 2, '');
            $product = $products->get((int) $id);
            $variant = $product?->variants->firstWhere('size', $size);

            // A product or size that no longer exists cannot stay invisible in
            // the totals: drop the line rather than charge for it.
            if (! $product || ! $variant || $variant->stock < 1) {
                unset($raw[$key]);
                $pruned = true;

                continue;
            }

            $quantity = max(1, min((int) $quantity, $variant->stock));

            $lines[] = [
                'key' => (string) $key,
                'product' => $product,
                'size' => $size,
                'quantity' => $quantity,
                'unit_price' => $product->price,
                'total' => $product->price * $quantity,
                'stock' => $variant->stock,
            ];
        }

        if ($pruned) {
            $this->put($raw);
        }

        return $lines;
    }

    public function add(Product $product, string $size, int $quantity = 1): bool
    {
        $product->loadMissing('variants');
        $variant = $product->variants->firstWhere('size', $size);

        if (! $variant || $variant->stock < 1) {
            return false;
        }

        $key = $this->key($product->id, $size);
        $raw = $this->raw();
        $current = (int) ($raw[$key] ?? 0);

        $raw[$key] = max(1, min($current + max(1, $quantity), $variant->stock));

        $this->put($raw);

        return true;
    }

    public function setQuantity(string $key, int $quantity): bool
    {
        $raw = $this->raw();

        if (! array_key_exists($key, $raw)) {
            return false;
        }

        if ($quantity < 1) {
            unset($raw[$key]);
            $this->put($raw);

            return true;
        }

        [$id, $size] = array_pad(explode('-', $key, 2), 2, '');
        $stock = (int) (Product::with('variants')->find((int) $id)?->variants->firstWhere('size', $size)?->stock ?? 0);

        if ($stock < 1) {
            unset($raw[$key]);
            $this->put($raw);

            return true;
        }

        $raw[$key] = min($quantity, $stock);
        $this->put($raw);

        return true;
    }

    public function remove(string $key): void
    {
        $raw = $this->raw();
        unset($raw[$key]);
        $this->put($raw);
    }

    public function clear(): void
    {
        $this->session->forget(self::SESSION_KEY);
    }

    /** Total number of garments, not lines. */
    public function count(): int
    {
        return array_sum($this->raw());
    }

    /** Subtotal in pesewas. */
    public function subtotal(): int
    {
        return array_sum(array_column($this->lines(), 'total'));
    }

    public function isEmpty(): bool
    {
        return $this->lines() === [];
    }

    /** A URL-safe line key: "12-M". Sizes never contain a dash. */
    public function key(int $productId, string $size): string
    {
        return $productId.'-'.$size;
    }

    /** @return array<string, int> */
    private function raw(): array
    {
        $value = $this->session->get(self::SESSION_KEY, []);

        return is_array($value) ? $value : [];
    }

    /** @param array<string, int> $bag */
    private function put(array $bag): void
    {
        $this->session->put(self::SESSION_KEY, $bag);
    }
}
