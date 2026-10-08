<?php

namespace Database\Seeders;

use App\Models\FeedPost;
use App\Models\Product;
use Illuminate\Database\Seeder;

/**
 * ILLUSTRATIVE FEED — placeholder photography.
 *
 * The store already sells through Instagram and WhatsApp (PRODUCT.md, Operating
 * Context), so the shopfront opens on the same format its customers scroll:
 * a post, a caption, and the garment inside it shoppable. The photographs are
 * verified stock placeholders, disclosed on the site while `store.preview` is
 * on. Only image carousels ship: a video whose contents cannot be verified has
 * no business carrying a fashion caption.
 */
class FeedSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'caption' => 'Two silks, one evening. The slip under the wrap gown if you are layering, or on its own if Accra stays warm.',
                'place' => 'Osu studio',
                'badge' => 'Just landed',
                'badge_tone' => 'ink',
                'published_at' => now()->subHours(3),
                'images' => [
                    ['photo-1469334031218-e382a71b716b', 'Silk slip dress styled with a wrap gown'],
                    ['photo-1516762689617-e1cffcef479d', 'Silk layers photographed on a rail'],
                ],
                'products' => ['adjoa-silk-slip-dress', 'akosua-satin-wrap-gown'],
            ],
            [
                'caption' => 'Trench weather in the morning, warm by noon. Wear it open and let the belt hang.',
                'place' => 'Airport City',
                'badge' => 'Lookbook',
                'badge_tone' => 'mist',
                'published_at' => now()->subDay(),
                'images' => [
                    ['photo-1434389677669-e08b4cac3105', 'Trench coat worn open on a morning street'],
                    ['photo-1475180098004-ca77a66827be', 'Trench coat belt detail'],
                ],
                'products' => ['ama-classic-trench-coat'],
            ],
            [
                'caption' => 'Back on the rail: the cotton tee in every size again, and the rib crop top in black.',
                'place' => 'Shop floor',
                'badge' => 'Back in stock',
                'badge_tone' => 'signal',
                'published_at' => now()->subDays(3),
                'images' => [
                    ['photo-1583744946564-b52ac1c389c8', 'Folded cotton tees restocked on a shelf'],
                    ['photo-1564859228273-274232fdb516', 'Ribbed knit tops hanging on a rail'],
                ],
                'products' => ['amma-classic-cotton-tee', 'esi-ribbed-crop-top'],
            ],
            [
                'caption' => 'How we have been styling the wool blazer: over the linen shirt, sleeves pushed up.',
                'place' => 'Studio',
                'badge' => 'Styling',
                'badge_tone' => 'mist',
                'published_at' => now()->subDays(5),
                'images' => [
                    ['photo-1441984904996-e0b6ba687e04', 'Wool blazer styled over a linen shirt'],
                    ['photo-1441986300917-64674bd600d8', 'Blazer and shirt hanging in the studio'],
                ],
                'products' => ['abena-wool-blazer', 'yaa-oversized-linen-shirt'],
            ],
        ];

        foreach ($posts as $index => $data) {
            $post = FeedPost::updateOrCreate(
                ['caption' => $data['caption']],
                [
                    'kind' => 'image',
                    'place' => $data['place'],
                    'badge' => $data['badge'],
                    'badge_tone' => $data['badge_tone'],
                    'is_placeholder' => true,
                    'published_at' => $data['published_at'],
                    'position' => $index + 1,
                ]
            );

            $post->images()->delete();
            foreach ($data['images'] as $position => [$id, $alt]) {
                $post->images()->create([
                    'path' => "https://images.unsplash.com/{$id}?w=1200&q=80&auto=format&fit=crop&fm=jpg",
                    'alt' => $alt,
                    'position' => $position,
                ]);
            }

            $ids = Product::whereIn('slug', $data['products'])->pluck('id', 'slug');

            $post->products()->sync(
                collect($data['products'])
                    ->mapWithKeys(fn (string $slug, int $i) => [$ids[$slug] => ['position' => $i]])
                    ->all()
            );
        }
    }
}
