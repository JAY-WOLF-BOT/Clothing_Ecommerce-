<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\CatalogSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_has_summary_cards_and_product_table(): void
    {
        $this->seed(CatalogSeeder::class);

        $this->get('/admin')
            ->assertOk()
            ->assertSee('Admin dashboard')
            ->assertSee('Total products')
            ->assertSee('Inventory value')
            ->assertSee('Products');
    }

    public function test_admin_can_create_a_product(): void
    {
        $category = Category::create([
            'name' => 'Accessories',
            'slug' => 'accessories',
            'position' => 1,
        ]);

        $this->post('/admin/products', [
            'category_id' => $category->id,
            'name' => 'Luna Tote',
            'slug' => 'luna-tote',
            'description' => 'A clean everyday tote.',
            'details' => 'Canvas, 100% cotton',
            'price' => 450,
            'compare_at_price' => 550,
            'colour' => 'Sand',
            'badge' => 'New',
            'is_featured' => true,
            'stock' => 12,
        ])->assertRedirect('/admin');

        $this->assertDatabaseHas('products', [
            'slug' => 'luna-tote',
            'name' => 'Luna Tote',
        ]);

        $product = Product::where('slug', 'luna-tote')->firstOrFail();
        $this->assertDatabaseHas('product_variants', [
            'product_id' => $product->id,
            'size' => 'One Size',
            'stock' => 12,
        ]);
    }
}
