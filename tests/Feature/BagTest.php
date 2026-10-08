<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BagTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    private function product(string $slug = 'adjoa-silk-slip-dress'): Product
    {
        return Product::with('variants')->where('slug', $slug)->firstOrFail();
    }

    public function test_a_garment_can_be_added_to_the_bag(): void
    {
        $product = $this->product();

        $response = $this->postJson('/bag', [
            'product_id' => $product->id,
            'size' => 'M',
            'quantity' => 1,
        ]);

        $response->assertOk()
            ->assertJsonPath('ok', true)
            ->assertJsonPath('count', 1)
            ->assertJsonPath('subtotal_label', 'GH₵ 780');

        $this->get('/bag')
            ->assertOk()
            ->assertSee('Adjoa Silk Slip Dress')
            ->assertSee('Size M');
    }

    public function test_the_bag_survives_later_requests(): void
    {
        $product = $this->product();

        $this->postJson('/bag', ['product_id' => $product->id, 'size' => 'S'])->assertOk();

        // A second, independent request still sees the line.
        $this->getJson('/bag')->assertOk();
        $this->get('/bag')->assertOk()->assertSee('Size S');
    }

    public function test_the_same_size_adds_up_rather_than_duplicating_a_line(): void
    {
        $product = $this->product();

        $this->postJson('/bag', ['product_id' => $product->id, 'size' => 'M'])->assertOk();
        $this->postJson('/bag', ['product_id' => $product->id, 'size' => 'M'])
            ->assertOk()
            ->assertJsonPath('count', 2)
            ->assertJsonCount(1, 'lines');
    }

    public function test_an_out_of_stock_size_is_refused_and_nothing_is_added(): void
    {
        $product = $this->product();

        $this->assertSame(0, $product->stockFor('XL'));

        $this->postJson('/bag', ['product_id' => $product->id, 'size' => 'XL'])
            ->assertStatus(422)
            ->assertJsonPath('ok', false)
            ->assertJsonPath('count', 0);

        $this->get('/bag')->assertOk()->assertSee('Nothing in the bag yet');
    }

    public function test_quantity_is_capped_at_the_stock_that_exists(): void
    {
        $product = $this->product();
        $stock = $product->stockFor('M');

        $this->postJson('/bag', ['product_id' => $product->id, 'size' => 'M', 'quantity' => 3])->assertOk();

        // Ask for far more than exists; the bag holds what the rail holds.
        $this->patchJson("/bag/{$product->id}-M", ['quantity' => 10])
            ->assertOk()
            ->assertJsonPath('lines.0.quantity', $stock);
    }

    public function test_a_line_can_be_reduced_and_removed(): void
    {
        $product = $this->product();

        $this->postJson('/bag', ['product_id' => $product->id, 'size' => 'M', 'quantity' => 2])->assertOk();

        $this->patchJson("/bag/{$product->id}-M", ['quantity' => 1])
            ->assertOk()
            ->assertJsonPath('lines.0.quantity', 1);

        // Zero removes the line outright.
        $this->patchJson("/bag/{$product->id}-M", ['quantity' => 0])
            ->assertOk()
            ->assertJsonPath('empty', true);
    }

    public function test_a_line_can_be_deleted(): void
    {
        $product = $this->product();

        $this->postJson('/bag', ['product_id' => $product->id, 'size' => 'M'])->assertOk();

        $this->deleteJson("/bag/{$product->id}-M")
            ->assertOk()
            ->assertJsonPath('empty', true)
            ->assertJsonPath('count', 0);
    }

    public function test_totals_add_up_across_two_styles(): void
    {
        $dress = $this->product();
        $top = $this->product('amma-classic-cotton-tee');

        $this->postJson('/bag', ['product_id' => $dress->id, 'size' => 'M'])->assertOk();
        $this->postJson('/bag', ['product_id' => $top->id, 'size' => 'M'])
            ->assertOk()
            ->assertJsonPath('count', 2)
            ->assertJsonPath('subtotal', $dress->price + $top->price);
    }

    public function test_checkout_opens_once_the_bag_holds_something(): void
    {
        $product = $this->product();

        $this->postJson('/bag', ['product_id' => $product->id, 'size' => 'M'])->assertOk();

        $this->get('/checkout')
            ->assertOk()
            ->assertSee('Send this order on WhatsApp')
            ->assertSee('Adjoa Silk Slip Dress')
            ->assertSee('Paying online is not live yet.');
    }

    public function test_a_size_is_required(): void
    {
        $product = $this->product();

        $this->postJson('/bag', ['product_id' => $product->id])
            ->assertStatus(422)
            ->assertJsonValidationErrors('size');
    }

    public function test_a_line_whose_variant_disappears_is_dropped_rather_than_charged(): void
    {
        $product = $this->product();

        $this->postJson('/bag', ['product_id' => $product->id, 'size' => 'M'])->assertOk();

        ProductVariant::where('product_id', $product->id)->where('size', 'M')->update(['stock' => 0]);

        // Reading the bag prunes a line whose size can no longer be bought,
        // rather than leaving it in the total.
        $this->patchJson("/bag/{$product->id}-M", ['quantity' => 1])
            ->assertOk()
            ->assertJsonPath('empty', true)
            ->assertJsonPath('count', 0);
    }
}
