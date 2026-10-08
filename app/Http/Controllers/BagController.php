<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Support\Bag;
use App\Support\Money;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BagController extends Controller
{
    public function index(Bag $bag): View
    {
        return view('bag.index', [
            'lines' => $bag->lines(),
            'subtotal' => $bag->subtotal(),
        ]);
    }

    public function store(Request $request, Bag $bag): JsonResponse|RedirectResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'size' => ['required', 'string', 'max:8'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:10'],
        ]);

        $product = Product::with('variants')->findOrFail($data['product_id']);
        $quantity = (int) ($data['quantity'] ?? 1);

        if (! $bag->add($product, $data['size'], $quantity)) {
            $message = $data['size'].' is out of stock in the '.$product->name.'.';

            return $request->expectsJson()
                ? response()->json($this->payload($bag) + ['ok' => false, 'message' => $message], 422)
                : back()->with('error', $message);
        }

        $message = $product->name.' — size '.$data['size'].' added to your bag.';

        return $request->expectsJson()
            ? response()->json($this->payload($bag) + ['ok' => true, 'message' => $message])
            : back()->with('status', $message);
    }

    public function update(Request $request, string $line, Bag $bag): JsonResponse|RedirectResponse
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:0', 'max:10'],
        ]);

        $bag->setQuantity($line, (int) $data['quantity']);

        return $request->expectsJson()
            ? response()->json($this->payload($bag) + ['ok' => true, 'line' => $line])
            : back();
    }

    public function destroy(Request $request, string $line, Bag $bag): JsonResponse|RedirectResponse
    {
        $bag->remove($line);

        return $request->expectsJson()
            ? response()->json($this->payload($bag) + ['ok' => true])
            : back()->with('status', 'Removed from your bag.');
    }

    /**
     * The single shape every bag mutation answers with, so the header badge,
     * the line totals and the summary all read from one truth.
     *
     * @return array<string, mixed>
     */
    private function payload(Bag $bag): array
    {
        return [
            'count' => $bag->count(),
            'subtotal' => $bag->subtotal(),
            'subtotal_label' => Money::format($bag->subtotal()),
            'empty' => $bag->isEmpty(),
            'lines' => collect($bag->lines())->map(fn (array $line) => [
                'key' => $line['key'],
                'quantity' => $line['quantity'],
                'total' => $line['total'],
                'total_label' => Money::format($line['total']),
            ])->values(),
        ];
    }
}
