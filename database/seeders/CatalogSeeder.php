<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Support\Money;
use Illuminate\Database\Seeder;

/**
 * ILLUSTRATIVE CATALOGUE — not real stock.
 *
 * PRODUCT.md records that no real catalogue, prices or photography exist yet.
 * The garments, cedi prices, stock counts and photographs below are authored
 * placeholders so the interface can be judged at full fidelity; the site says
 * so out loud while `store.preview` is on. Every photograph was verified to
 * resolve before it was written down here.
 */
class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Dresses', 'slug' => 'dresses', 'tagline' => 'Slips, gowns and everyday midis cut for Accra heat.', 'position' => 1],
            ['name' => 'Tops', 'slug' => 'tops', 'tagline' => 'Tees, shirts and knitwear that carry the whole outfit.', 'position' => 2],
            ['name' => 'Outerwear', 'slug' => 'outerwear', 'tagline' => 'Coats and jackets for harmattan mornings.', 'position' => 3],
            ['name' => 'Sale', 'slug' => 'sale', 'tagline' => 'Last sizes, reduced until they are gone.', 'is_sale' => true, 'position' => 4],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }

        $dresses = Category::where('slug', 'dresses')->firstOrFail();
        $tops = Category::where('slug', 'tops')->firstOrFail();
        $outerwear = Category::where('slug', 'outerwear')->firstOrFail();

        $catalogue = [
            [
                'category' => $dresses, 'name' => 'Adjoa Silk Slip Dress', 'slug' => 'adjoa-silk-slip-dress',
                'series' => 'Silk Series', 'price' => 780, 'colour' => 'Black', 'badge' => 'Best seller',
                'description' => 'A bias-cut slip in heavyweight silk that skims rather than clings. Cut to the knee with adjustable straps, so it moves between a lunch and a late dinner without changing anything else.',
                'details' => '100% mulberry silk · bias cut · adjustable straps · dry clean only',
                'sizes' => ['XS' => 2, 'S' => 4, 'M' => 3, 'L' => 2, 'XL' => 0],
                'images' => [
                    ['photo-1515886657613-9f3515b0c78f', 'Adjoa silk slip dress, full length'],
                    ['photo-1595777457583-95e059d581b8', 'Adjoa silk slip dress, detail'],
                    ['photo-1567401893414-76b7b1e5a7a5', 'Adjoa silk slip dress, worn'],
                ],
            ],
            [
                'category' => $dresses, 'name' => 'Akosua Satin Wrap Gown', 'slug' => 'akosua-satin-wrap-gown',
                'series' => 'Evening', 'price' => 1150, 'colour' => 'Beige', 'badge' => null,
                'description' => 'A floor-length wrap gown in matte satin, tied at the waist so the drape sits where you put it. Made for weddings, dinners and the photographs afterwards.',
                'details' => 'Matte satin · wrap tie · floor length · cool hand wash',
                'sizes' => ['XS' => 1, 'S' => 3, 'M' => 2, 'L' => 1, 'XL' => 1],
                'images' => [
                    ['photo-1572804013309-59a88b7e92f1', 'Akosua satin wrap gown'],
                    ['photo-1581044777550-4cfa60707c03', 'Akosua satin wrap gown, sleeves'],
                    ['photo-1594633312681-425c7b97ccd1', 'Akosua satin wrap gown, hem'],
                ],
            ],
            [
                'category' => $dresses, 'name' => 'Abena Tiered Midi Dress', 'slug' => 'abena-tiered-midi-dress',
                'series' => 'Everyday', 'price' => 620, 'colour' => 'White', 'badge' => 'New',
                'description' => 'Three tiers of soft cotton voile with a drawstring waist, lined to the knee. The one you reach for on a hot Saturday.',
                'details' => 'Cotton voile · fully lined · drawstring waist · machine wash cold',
                'sizes' => ['XS' => 3, 'S' => 5, 'M' => 4, 'L' => 3, 'XL' => 2],
                'images' => [
                    ['photo-1496747611176-843222e1e57c', 'Abena tiered midi dress'],
                    ['photo-1591047139829-d91aecb6caea', 'Abena tiered midi dress, movement'],
                    ['photo-1618244972963-dbee1a7edc95', 'Abena tiered midi dress, waist detail'],
                ],
            ],
            [
                'category' => $dresses, 'name' => 'Naa Print Shift Dress', 'slug' => 'naa-print-shift-dress',
                'series' => 'Print Studio', 'price' => 690, 'colour' => 'Multi', 'badge' => null,
                'description' => 'A straight-cut shift in a printed cotton we had made up in small runs. No waist seam, no fuss.',
                'details' => 'Printed cotton · shift cut · side pockets · machine wash cold',
                'sizes' => ['XS' => 0, 'S' => 2, 'M' => 3, 'L' => 2, 'XL' => 1],
                'images' => [
                    ['photo-1485968579580-b6d095142e6e', 'Naa print shift dress'],
                    ['photo-1560243563-062bfc001d68', 'Naa print shift dress, print detail'],
                    ['photo-1571945153237-4929e783af4a', 'Naa print shift dress, worn'],
                ],
            ],
            [
                'category' => $dresses, 'name' => 'Efua Linen Sundress', 'slug' => 'efua-linen-sundress',
                'series' => 'Summer Linen', 'price' => 540, 'compare_at' => 760, 'colour' => 'Beige', 'badge' => null,
                'description' => 'Washed linen with a square neck and a full skirt, softened to the point where it feels already worn in.',
                'details' => 'Washed linen · square neck · full skirt · machine wash cold',
                'sizes' => ['XS' => 2, 'S' => 3, 'M' => 2, 'L' => 1, 'XL' => 0],
                'images' => [
                    ['photo-1487222477894-8943e31ef7b2', 'Efua linen sundress'],
                    ['photo-1539008835657-9e8e9680c956', 'Efua linen sundress, skirt'],
                    ['photo-1544022613-e87ca75a784a', 'Efua linen sundress, neckline'],
                ],
            ],
            [
                'category' => $tops, 'name' => 'Amma Classic Cotton Tee', 'slug' => 'amma-classic-cotton-tee',
                'series' => 'Basics', 'price' => 180, 'colour' => 'White', 'badge' => 'New',
                'description' => 'Heavyweight cotton jersey with a ribbed collar that holds its shape. Cut boxy enough to tuck or leave out.',
                'details' => '240gsm cotton jersey · ribbed collar · pre-shrunk · machine wash',
                'sizes' => ['XS' => 6, 'S' => 8, 'M' => 9, 'L' => 6, 'XL' => 4],
                'images' => [
                    ['photo-1503342217505-b0a15ec3261c', 'Amma classic cotton tee'],
                    ['photo-1521572267360-ee0c2909d518', 'Amma classic cotton tee, collar'],
                    ['photo-1523381210434-271e8be1f52b', 'Amma classic cotton tee, rail'],
                ],
            ],
            [
                'category' => $tops, 'name' => 'Yaa Oversized Linen Shirt', 'slug' => 'yaa-oversized-linen-shirt',
                'series' => 'Workroom', 'price' => 320, 'colour' => 'White', 'badge' => null,
                'description' => 'An oversized linen shirt with a dropped shoulder and a long hem. Wear it open over the slip, or buttoned as a shirt on its own.',
                'details' => 'European linen · dropped shoulder · mother-of-pearl buttons · warm iron',
                'sizes' => ['XS' => 1, 'S' => 4, 'M' => 5, 'L' => 3, 'XL' => 2],
                'images' => [
                    ['photo-1618354691373-d851c5c3a990', 'Yaa oversized linen shirt'],
                    ['photo-1596755094514-f87e34085b2c', 'Yaa oversized linen shirt, cuffs'],
                    ['photo-1485462537746-965f33f7f6a7', 'Yaa oversized linen shirt, worn'],
                ],
            ],
            [
                'category' => $tops, 'name' => 'Esi Ribbed Crop Top', 'slug' => 'esi-ribbed-crop-top',
                'series' => 'Knitwear', 'price' => 240, 'compare_at' => 320, 'colour' => 'Black', 'badge' => null,
                'description' => 'A fine rib knit that stretches to sit exactly where you want it. Cropped, fitted, and the layer under everything else.',
                'details' => 'Rib knit · cropped · fitted · hand wash cool',
                'sizes' => ['XS' => 2, 'S' => 3, 'M' => 3, 'L' => 2, 'XL' => 1],
                'images' => [
                    ['photo-1554412933-514a83d2f3c8', 'Esi ribbed crop top'],
                    ['photo-1620799140408-edc6dcb6d633', 'Esi ribbed crop top, rib detail'],
                    ['photo-1509319117193-57bab727e09d', 'Esi ribbed crop top, worn'],
                ],
            ],
            [
                'category' => $tops, 'name' => 'Adwoa Silk Camisole', 'slug' => 'adwoa-silk-camisole',
                'series' => 'Silk Series', 'price' => 290, 'compare_at' => 420, 'colour' => 'Beige', 'badge' => null,
                'description' => 'The same silk as the slip, cut as a camisole with a straight neck and thin straps. Layering, or on its own in the evenings.',
                'details' => '100% mulberry silk · straight neck · dry clean only',
                'sizes' => ['XS' => 1, 'S' => 2, 'M' => 2, 'L' => 1, 'XL' => 0],
                'images' => [
                    ['photo-1479064555552-3ef4979f8908', 'Adwoa silk camisole'],
                    ['photo-1495121605193-b116b5b9c5fe', 'Adwoa silk camisole, strap detail'],
                    ['photo-1552374196-c4e7ffc6e126', 'Adwoa silk camisole, worn'],
                ],
            ],
            [
                'category' => $outerwear, 'name' => 'Ama Classic Trench Coat', 'slug' => 'ama-classic-trench-coat',
                'series' => 'Coats', 'price' => 1480, 'colour' => 'Beige', 'badge' => 'Trending',
                'description' => 'A double-breasted trench with a storm flap and a belt you can actually tie. Cotton gabardine, unlined above the waist so it stays wearable.',
                'details' => 'Cotton gabardine · double breasted · belted · dry clean only',
                'sizes' => ['XS' => 1, 'S' => 2, 'M' => 3, 'L' => 2, 'XL' => 1],
                'images' => [
                    ['photo-1539109136881-3be0616acf4b', 'Ama classic trench coat'],
                    ['photo-1525507119028-ed4c629a60a3', 'Ama classic trench coat, collar'],
                    ['photo-1445205170230-053b83016050', 'Ama classic trench coat, belted'],
                ],
            ],
            [
                'category' => $outerwear, 'name' => 'Sena Leather Biker Jacket', 'slug' => 'sena-leather-biker-jacket',
                'series' => 'Jackets', 'price' => 1950, 'colour' => 'Black', 'badge' => null,
                'description' => 'Soft lambskin with an asymmetric zip and a collar that sits flat when it is open. It softens into shape over the first month.',
                'details' => 'Lambskin leather · asymmetric zip · fully lined · leather specialist clean',
                'sizes' => ['XS' => 0, 'S' => 1, 'M' => 2, 'L' => 2, 'XL' => 1],
                'images' => [
                    ['photo-1551028719-00167b16eac5', 'Sena leather biker jacket'],
                    ['photo-1558769132-cb1aea458c5e', 'Sena leather biker jacket, zip'],
                    ['photo-1542272604-787c3835535d', 'Sena leather biker jacket, worn'],
                ],
            ],
            [
                'category' => $outerwear, 'name' => 'Abena Wool Blazer', 'slug' => 'abena-wool-blazer',
                'series' => 'Tailoring', 'price' => 1290, 'colour' => 'Beige', 'badge' => null,
                'description' => 'A single-breasted wool blazer with a soft shoulder and patch pockets. Tailored enough for a meeting, loose enough for the rest of the week.',
                'details' => 'Wool blend · single breasted · patch pockets · dry clean only',
                'sizes' => ['XS' => 2, 'S' => 3, 'M' => 3, 'L' => 2, 'XL' => 1],
                'images' => [
                    ['photo-1548883354-7622d03aca27', 'Abena wool blazer'],
                    ['photo-1483985988355-763728e1935b', 'Abena wool blazer, lapel'],
                    ['photo-1490481651871-ab68de25d43d', 'Abena wool blazer, worn'],
                ],
            ],
        ];

        foreach ($catalogue as $index => $item) {
            $product = Product::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'category_id' => $item['category']->id,
                    'name' => $item['name'],
                    'series' => $item['series'],
                    'description' => $item['description'],
                    'details' => $item['details'],
                    'price' => Money::toPesewas($item['price']),
                    'compare_at_price' => isset($item['compare_at']) ? Money::toPesewas($item['compare_at']) : null,
                    'badge' => $item['badge'],
                    'colour' => $item['colour'],
                    'is_featured' => in_array($item['slug'], ['adjoa-silk-slip-dress', 'ama-classic-trench-coat', 'amma-classic-cotton-tee'], true),
                    'position' => $index + 1,
                ]
            );

            $product->images()->delete();
            foreach ($item['images'] as $position => [$id, $alt]) {
                $product->images()->create([
                    'path' => "https://images.unsplash.com/{$id}?w=1100&q=80&auto=format&fit=crop&fm=jpg",
                    'alt' => $alt,
                    'position' => $position,
                ]);
            }

            $product->variants()->delete();
            $position = 0;
            foreach ($item['sizes'] as $size => $stock) {
                $product->variants()->create([
                    'size' => $size,
                    'stock' => $stock,
                    'position' => $position++,
                ]);
            }
        }
    }
}
