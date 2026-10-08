<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorefrontTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_home_opens_on_the_feed_rather_than_a_product_grid(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('Womenswear, priced in cedis.')
            ->assertSee('From the feed')
            ->assertSee('Shop this post')
            ->assertSee('In stock now');
    }

    public function test_home_discloses_that_the_content_is_placeholder(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Preview')
            ->assertSee('Placeholder build');
    }

    public function test_the_header_links_every_shop_category(): void
    {
        $response = $this->get('/');

        foreach (['Dresses', 'Tops', 'Outerwear', 'Sale'] as $category) {
            $response->assertSee($category);
        }
    }

    public function test_a_category_lists_only_its_own_garments(): void
    {
        $this->get('/category/dresses')
            ->assertOk()
            ->assertSee('Adjoa Silk Slip Dress')
            ->assertSee('Efua Linen Sundress')
            ->assertDontSee('Ama Classic Trench Coat');
    }

    public function test_the_sale_category_shows_only_discounted_garments(): void
    {
        $onSale = Product::query()->onSale()->pluck('name')->all();

        $response = $this->get('/category/sale')->assertOk();

        foreach ($onSale as $name) {
            $response->assertSee($name);
        }

        $response->assertDontSee('Adjoa Silk Slip Dress');
    }

    public function test_filters_narrow_the_grid_and_report_the_count(): void
    {
        $response = $this->get('/category/tops?size=M&colour=Black')->assertOk();

        $response->assertDontSee('Adjoa Silk Slip Dress');
        $response->assertSee('Esi Ribbed Crop Top');
        $response->assertDontSee('Amma Classic Cotton Tee');
        $response->assertSee('1 piece');
    }

    public function test_an_impossible_filter_combination_states_that_nothing_matches(): void
    {
        $this->get('/category/outerwear?size=XS&colour=Multi')
            ->assertOk()
            ->assertSee('Nothing matches those filters')
            ->assertSee('Clear filters');
    }

    public function test_a_category_page_states_the_result_count(): void
    {
        $dresses = Product::query()->whereHas('category', fn ($q) => $q->where('slug', 'dresses'))->count();

        $this->get('/category/dresses')
            ->assertOk()
            ->assertSee($dresses.' pieces');
    }

    public function test_a_product_page_prices_in_cedis_and_marks_sold_out_sizes(): void
    {
        $this->get('/product/adjoa-silk-slip-dress')
            ->assertOk()
            ->assertSee('Adjoa Silk Slip Dress')
            ->assertSee('GH₵ 780')
            ->assertSee('Silk Series')
            ->assertSee('Sold out')          // XL has no stock
            ->assertSee('Order on WhatsApp')
            ->assertSee('disabled', false);
    }

    public function test_a_garment_on_sale_shows_both_prices_and_the_discount(): void
    {
        $this->get('/product/efua-linen-sundress')
            ->assertOk()
            ->assertSee('GH₵ 540')
            ->assertSee('GH₵ 760')
            ->assertSee('29% off');
    }

    public function test_checkout_requires_something_in_the_bag(): void
    {
        $this->get('/checkout')->assertRedirect(route('bag.index'));
    }

    public function test_an_unknown_url_answers_with_the_not_found_page(): void
    {
        $this->get('/no-such-page')
            ->assertNotFound()
            ->assertSee('That page is not on the rail.')
            ->assertSee('Shop instead');
    }

    public function test_the_preview_disclosure_can_be_switched_off_with_real_content(): void
    {
        config()->set('store.preview', false);

        $this->get('/')->assertOk()->assertDontSee('Placeholder build');
    }
}
