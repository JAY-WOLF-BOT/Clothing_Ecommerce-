# Product

<!-- impeccable:product-schema 1 -->

## Platform

web

## Users

**Primary — the shopper.** Mobile-first customers in Ghana buying women's clothing from their phones. They already discover and buy from this brand through Instagram and WhatsApp, so they arrive used to scrolling a social feed, asking questions in a chat, and closing the order in a conversation with a human. They are not yet used to a cart, an account, or an online payment flow.

**Secondary — the store admin.** The person who runs the brand's Instagram/WhatsApp presence and posts the outfits, hauls, and lookbook content. The current storefront surface assumes they author that content (an Instagram-style "Store Feed" of admin posts with shoppable product cards).

## Product Purpose

An online storefront for a Ghanaian clothing brand that currently sells only through Instagram and WhatsApp. It exists to give those shoppers a real shop: browse the collection on the web, add items to a bag, and eventually pay online — instead of closing every sale by chat.

Success means orders are placed and paid for on the site, with the WhatsApp handoff no longer the transaction path.

## Positioning

The shopfront is built around the channel the customers already shop in. Browsing keeps the shape of the brand's own social feed — outfit, haul, and lookbook posts with the garment shoppable inside the post — rather than a generic product grid. Trust is carried by the brand voice the audience already follows, not by marketplace-style proof.

## Operating Context

- Sales today happen entirely on Instagram and WhatsApp. Customers discover in social, ask fit/stock/price questions in chat, and order by message.
- Market is Ghana. Prices are quoted in Ghanaian cedi (GHS).
- Everything shoppers see today — "$120.00" prices, product names, stock, photos — is placeholder content, not the real catalog.
- Shopping happens on phones; desktop is a secondary case.

## Capabilities and Constraints

**Shipped today (Laravel 13, server-rendered Blade, Tailwind CSS v4 via Vite):**

- Home page: hero plus the "Store Feed" — admin video and image posts, each with an inline shoppable product card and "Shop Now" link.
- Category browse at `/category/{slug}` for `dresses`, `tops`, `outerwear`, and `sale`, each with size/color filter and sort controls (controls are presentational only).
- Product detail at `/product/1`: size selector, "Add to Bag", and a secondary "Order via WhatsApp" button.
- Product grid cards with badges (Best Seller, New, Trending, discount).

**Not built yet:** no cart, no checkout, no payment provider, no accounts, no product/price/inventory data model, no admin interface. All product, category, and feed content is hardcoded in Blade views.

**Planned:** online checkout. The bag becomes real and payment happens on the site; "Order via WhatsApp" is a stopgap, not the destination.

**Explicitly undecided:** the brand name; the real product catalog and prices; whether free/paid delivery and which regions are covered; payment providers; whether customer accounts are required; whether "Add to Bag" is one step or later replaced by a richer bag/checkout flow.

**Not established:** no accessibility standard has been set for this product.

## Brand Commitments

- **The brand name is not settled yet.** "BrandName" / "BRANDNAME" / "@brandname_official" appear throughout the code as placeholder copy only. Never treat them as the real brand, and never extend them into new copy or assets.
- No logo, wordmark, or visual identity exists; none has been designed.
- Voice and personality are not yet established.

## Evidence on Hand

- **Real storefront content: none.** All product photography is Unsplash stock imagery referenced by URL; product names, prices, sizes, and stock states are invented placeholders.
- No testimonials, reviews, press, customer counts, case studies, or benchmark claims exist.
- No logo or brand asset files exist in the repository.
- The Instagram/WhatsApp channels are real and active, and are the only genuine proof of the brand today.

Future work must not present any placeholder catalog, pricing, photography, or proof as fact, and must not invent brand assets to fill the gap.

## Product Principles

1. **Sell in the shopper's reality.** Ghanaian customers, cedi prices, phone-first. Treat the displayed USD figures as placeholder, not a pricing decision.
2. **Move the transaction without losing the conversation.** Chat is where this audience trusts and buys; checkout should feel as direct as messaging a seller, not like an unfamiliar institution.
3. **The feed is the shopfront.** Merchandising follows the social format customers already scroll, with garments shoppable inside posts.
4. **Never dress up placeholder content as truth.** Until the real name, catalog, and photography land, keep visible content honestly provisional.
5. **Earn trust the way the brand already does.** The audience follows a person and a voice, so the site carries that identity rather than generic retail reassurance.
