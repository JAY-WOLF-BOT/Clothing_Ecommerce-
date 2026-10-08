---
version: 1
slug: "storefront"
primary_target: "storefront"
related_targets: ["category","product","bag","checkout"]
---

# Storefront — home feed, category, product, bag

## Scope

Primary target: `/` (home). Related targets: `/category/{slug}`, `/product/{slug}`, `/bag`, `/checkout`, site chrome. Visitor mode: **Persuade** on home, category and product (the visitor decides and acts); **Operate** on bag and checkout (the visitor completes a task).

## Audience and job

Mobile-first shoppers in Ghana who already buy this brand through Instagram and WhatsApp. Arriving from a chat or a post, they need to recognize the brand, find the garment they saw, know the price in cedis, and get it into a bag without opening a conversation first.

Action: add a garment to the bag, then send the order. Content on hand: none real — catalog, prices and photography are illustrative placeholders and stay labelled as such.

## Chosen direction

The user pinned the incumbent world: paper-white ground, ink-black fields, hairline rules, a minimal boutique register. This build preserves that identity and raises its craft rather than replacing it. No direction roll was run — a user-pinned world beats the roll.

Memorable moment: the feed post opens into its own product, and the garment lifts out of the post into the bag with the bag count landing in the header.

Constraints: PHP 8.5 / Laravel 13 / Blade / Tailwind v4 / vanilla JS on Vite. No image generation available, so this is a code-led build. No payment provider — the order still closes in WhatsApp, so checkout must say so plainly.

## Direction contract

**THESIS.** The shop window behaves like the brand's own feed: every garment is reachable from the post it appeared in, and the price is legible before any conversation. It refuses the category default of a generic product grid behind a decorative hero.

**OWN-WORLD.** Paper white (`#FFFFFF`) with ink fields (`#0B0B0C`) and hairline rules (`#E4E4E4`); one signal red (`#C8102E`) reserved strictly for discount. Display type is Bricolage Grotesque, tight tracking, with Archivo for text. Cards read by a 1px hairline at rest and a single offset-plus-blur lift on hover — never both at once. Radii: 16px cards, 12px controls, full pills for chips only.

**STORY.** The visitor recognizes yesterday's post, taps the garment inside it, reads the price in cedis, picks a size, and adds it to a bag that survives a reload — the step chat never had. On the bag they see the total and the honest options: send the order to WhatsApp now, or wait for online payment.

**FIRST VIEWPORT.** Ink hero at full bleed on a paper page: the store's own latest post occupying the left two thirds at real feed scale, its garment chip and "Add to bag" sitting inside the media frame; the right third carries what a first-time visitor must know — what this is, the cedi price, and a single primary action into the collection. Below the fold the feed continues as the catalog.

**FORM.** Incumbent boutique language extended, not replaced; no roll and no seed key (world pinned by the user).

**FINISH.** unreviewed and undocumented is unfinished; this build ends with the finish review, the verdict, DESIGN.md, and every shipping raster carrying its provenance

## Unresolved

Real brand name, real catalog and prices, delivery coverage, payment provider, and whether accounts are required. All recorded in PRODUCT.md as undecided.
