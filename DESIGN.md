---
name: Ghanaian womenswear storefront
description: Paper-and-ink boutique system for a feed-first shop priced in cedis
colors:
  ink: "#0b0b0c"
  ink-soft: "#17171a"
  paper: "#ffffff"
  mist: "#f5f5f4"
  line: "#e4e4e4"
  line-strong: "#c8c8c8"
  muted: "#57575c"
  on-ink: "#ffffff"
  on-ink-muted: "#b9b9bf"
  signal: "#c8102e"
  signal-soft: "#fdeef1"
typography:
  display:
    fontFamily: "Bricolage Grotesque, Archivo, ui-sans-serif, system-ui, sans-serif"
    fontSize: "1.9rem"
    fontWeight: 800
    lineHeight: 1.06
    letterSpacing: "-0.035em"
  section:
    fontFamily: "Bricolage Grotesque, Archivo, ui-sans-serif, system-ui, sans-serif"
    fontSize: "1.25rem"
    fontWeight: 800
    lineHeight: 1.15
    letterSpacing: "-0.025em"
  card:
    fontFamily: "Bricolage Grotesque, Archivo, ui-sans-serif, system-ui, sans-serif"
    fontSize: "0.9375rem"
    fontWeight: 700
    lineHeight: 1.35
    letterSpacing: "-0.015em"
  body:
    fontFamily: "Archivo, ui-sans-serif, system-ui, sans-serif"
    fontSize: "0.875rem"
    fontWeight: 400
    lineHeight: 1.6
    letterSpacing: "normal"
  micro:
    fontFamily: "Archivo, ui-sans-serif, system-ui, sans-serif"
    fontSize: "0.75rem"
    fontWeight: 600
    lineHeight: 1
    letterSpacing: "0.12em"
rounded:
  control: "12px"
  card: "16px"
  inner: "9px"
  pill: "999px"
spacing:
  xs: "4px"
  sm: "8px"
  md: "16px"
  lg: "24px"
  xl: "32px"
  section: "80px"
components:
  button-primary:
    backgroundColor: "{colors.ink}"
    textColor: "{colors.paper}"
    rounded: "{rounded.control}"
    padding: "14px 20px"
  button-primary-hover:
    backgroundColor: "{colors.ink-soft}"
    textColor: "{colors.paper}"
  button-secondary:
    backgroundColor: "{colors.paper}"
    textColor: "{colors.ink}"
    rounded: "{rounded.control}"
    padding: "14px 20px"
  button-inverse:
    backgroundColor: "{colors.paper}"
    textColor: "{colors.ink}"
    rounded: "{rounded.control}"
    padding: "14px 20px"
  field:
    backgroundColor: "{colors.paper}"
    textColor: "{colors.ink}"
    rounded: "{rounded.control}"
    padding: "13px 14px"
  chip:
    backgroundColor: "{colors.mist}"
    textColor: "{colors.muted}"
    rounded: "{rounded.pill}"
    padding: "5px 10px"
  card:
    backgroundColor: "{colors.paper}"
    textColor: "{colors.ink}"
    rounded: "{rounded.card}"
    padding: "16px"
---

## Overview

**Creative North Star: "The Shop Window That Behaves Like the Feed"**

This is a Ghanaian womenswear storefront whose customers already buy through Instagram and WhatsApp. The interface therefore refuses the category default — a decorative hero above a generic product grid — and instead opens on the brand's own latest post at full feed scale, with the garment taken straight out of it. The catalogue *is* the feed; browsing is the same gesture the shopper already makes in a chat app.

The world is paper and ink: a white field for merchandise, near-black fields for the moments that carry weight (the hero media, the closing band, the bag count), hairline rules instead of boxes, and exactly one saturated colour that is never decoration. Type does the expressive work — a compressed grotesque display voice against a neutral workhorse text face — which is what keeps a two-colour page from reading as a wireframe.

Everything visible is placeholder: the brand name, the catalogue, the cedi prices and the photography are illustrative, and the interface says so out loud rather than letting a visitor mistake it for the shop's real offer. That disclosure is part of the design, not a banner bolted on.

**Key Characteristics:**

- Paper-white field, ink-black moments, hairline rules; no third ground.
- One signal red, reserved strictly for discount and out-of-stock.
- Display type does the expression; the layout stays quiet.
- Elevation is declared once per state — a hairline at rest, a single lift on hover.
- Motion settles, never fades.
- Placeholder content is labelled as placeholder, in the interface itself.

## Colors

The palette is a two-ground system with a single functional accent.

- **Ink (`#0b0b0c`)** — the hero media frame, the closing band, primary actions, the bag badge. It is the counterweight that makes merchandise read as merchandise.
- **Ink soft (`#17171a`)** — the primary button's hover only. It exists so ink can move.
- **Paper (`#ffffff`)** and **Mist (`#f5f5f4`)** — the page field and the recessed field inside it (media placeholders while images load, the footer band, quiet chips).
- **Line (`#e4e4e4`)** and **Line strong (`#c8c8c8`)** — hairlines. Line draws every boundary; line-strong appears on hover and in scrollbars.
- **Muted (`#57575c`)** — all secondary text on light grounds. Measured 7.19:1 on paper, 6.59:1 on mist.
- **On-ink (`#ffffff`)** and **On-ink-muted (`#b9b9bf`)** — text on ink fields. On-ink-muted measures 10.08:1 on ink.
- **Signal (`#c8102e`)** and **Signal soft (`#fdeef1`)** — discount prices, discount badges, sold-out, and destructive affordances. Nothing else.

**The One Signal Rule.** Signal red is a fact about money, never a mood. It may mark a discount, a sold-out state, or a destructive action; it may not appear as an accent, a border, an illustration fill, or a brand flourish. A page with no discount shows no red at all.

## Typography

Two self-hosted variable grotesques, latin subset, served from the project's own files — no hosted stylesheet.

- **Bricolage Grotesque** (`400–800`) — display voice: page headings, section headings, card titles, product names. Tight tracking (`-0.035em` at page scale, `-0.015em` on card titles), weights 700–800. Its slightly compressed, slightly awkward character is the page's personality.
- **Archivo** (`400–700`) — text voice: body copy, controls, labels, prices, numerals.

The ramp: page display `1.9rem` → `2.4rem` at `sm`; section headings `1.25rem` → `1.5rem`; card titles `0.9375rem`; body `0.875rem`; small/meta `0.75rem`; micro labels `0.75rem` uppercase at `0.12em`.

**The Two-Grotesque Rule.** Display is Bricolage Grotesque and text is Archivo; a system display face (Impact, Arial Black, the platform sans) never stands in for the display voice, and the two never swap roles.

**The Micro Ceiling Rule.** Nothing functional is set below `0.75rem` (12px). Micro labels earn their smallness from uppercase tracking, not from shrinking past legibility.

## Layout

A single centred shell: `max-width: 84rem` with `1.25rem` → `2rem` → `2.5rem` inline padding at `sm` and `lg`.

- The first viewport is a 12-column split: the store's latest post at 7 columns (8 at `xl`), a facts-and-action rail at 5 (4 at `xl`).
- Merchandise grids run 1 → 2 → 3 columns. Category tiles run 1 → 2.
- Sections are separated by `5rem`–`6rem` of space, and each section header is a hairline rule under the heading (`border-b`, `1rem` below).
- Product media is always `4:5`; feed media is `4:5`; category tiles are text-only.

**The Above-Above Rule.** Space above a heading always exceeds space below it: `5rem` above a section header, `1rem` beneath the heading's rule, `2rem` before its content. A heading never floats in the middle of its own section.

## Elevation & Depth

Depth is declared once per state, never twice at once.

- At rest a surface is a `1px` hairline on a paper field — no shadow.
- On interaction the element gives up its border (`border-color: transparent`) and takes **Lift** (`0 1px 2px rgb(11 11 12 / 0.05), 0 18px 32px -20px rgb(11 11 12 / 0.28)`) plus a `-3px` rise.
- Two elements float without interaction — the garment panel over the hero media and the toast — and they carry Lift with a transparent border, because a floating surface has nothing to be a hairline against.
- The mobile drawer takes **Sheet** (`0 28px 60px -28px rgb(11 11 12 / 0.4)`).
- Blur is not a depth device here: a translucent field over a photograph is made opaque enough to carry its own contrast instead of relying on `backdrop-filter`.

**The Hairline or Lift Rule.** An element shows a defined edge or a soft elevation, never both. A `1px` border sitting under a wide diffuse shadow is the ghost card this system refuses.

## Shapes

- **Cards and media frames** — `16px`.
- **Controls** (buttons, fields, steppers, segmented groups) — `12px`.
- **Chips, badges, dots, the bag count** — fully rounded pills.
- **Thumbnails nested inside a control row** — `9px`, tighter than their parent so the nesting reads.
- Corners are uniform; there is no mixed-radius language and no `clip-path` geometry. Media is always a plain rectangle with these radii.

**The Nested Radius Rule.** An element nested inside a rounded control takes a smaller radius than its parent (9px inside 12px), so the two curves stay concentric instead of fighting.

## Components

- **Primary button** — ink field, paper text, `12px`, 600 weight at `0.875rem`, `14px 20px`. Hover moves to ink-soft; `:active` drops 1px; disabled drops to 40% and loses its pointer.
- **Secondary button** — paper field, hairline border, ink text; hover swaps the border to ink. Used for the WhatsApp order path so it never competes with Add to bag.
- **Inverse button** — paper field on an ink band, for actions inside the closing section.
- **Field** — paper field, hairline, `12px`, hover darkens the hairline, focus swaps the border to ink and adds a `3px` ink wash at 8%. Invalid state uses signal-soft.
- **Chip / badge** — `0.75rem` uppercase at `0.06em`, pill, five tones: paper, mist, ink, signal, signal-quiet.
- **Product card** — `4:5` media, badge cluster top-left, card title, series meta, price row with a "Take a size" affordance. Interactive: hover gives up the border and takes Lift.
- **Garment chip** — the signature shoppable row inside a feed post: thumbnail, name, cedi price, and a size selector plus Add. It is a real form, so it works with scripting off.
- **Sticky header** — `64px`, paper at 95%, hairline underneath, wordmark, category nav, bag link with a count badge that pops on change.
- **Bag line stepper** — a padded hairline group with minus, quantity in tabular numerals, and plus. Minus disables at one; the explicit Remove sits beside it.

**The Given Size Rule.** Add to bag always carries a chosen size. A control that adds a garment without one is not allowed; where space is tight (a feed post), the size selector rides inside the chip rather than being assumed.

## Do's and Don'ts

### Do:

- **Do** keep the page field paper-white and the ink fields ink; there is no third ground.
- **Do** draw boundaries with the `1px` hairline and reserve shadows for hover and for genuinely floating surfaces.
- **Do** set prices, quantities and stock counts in tabular numerals so columns align.
- **Do** give every interactive element a `2px` ink focus ring with a `2px` offset, on paper and on ink alike.
- **Do** label illustrative content as illustrative, wherever a visitor could mistake it for the shop's real offer.
- **Do** keep functional text at or above `0.75rem`, and interactive targets at or above `24px` on both axes.

### Don't:

- **Don't** use signal red as decoration; it belongs to discount, sold-out and destructive actions only.
- **Don't** combine a visible border with a wide diffuse shadow on the same element in the same state.
- **Don't** fade or blur text as an entrance effect — a reader may be mid-sentence when a fade would drop contrast below the floor.
- **Don't** set the display voice in a system font, or swap the two faces' roles.
- **Don't** put a decorative eyebrow or kicker above a heading; the heading carries its own weight and the section rule does the framing.
- **Don't** invent brand assets — no logo, monogram or wordmark exists yet, so the interface uses a neutral placeholder frame and the placeholder name, never a fabricated identity.
- **Don't** present placeholder catalogue, prices or photography as fact.
