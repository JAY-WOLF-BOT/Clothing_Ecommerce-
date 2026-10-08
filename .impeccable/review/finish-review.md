# Finish review — storefront build

Run inline (no subagent capability in this harness), per
`reference/degraded/finish-reviewer.md`. Editing nothing while reviewing.

Unread / missing inputs: no QUALITY BAR card and no approved comp exist (no image
generation on this machine, so the direction round was replaced by the user
pinning the incumbent world; the build is code-led by contract). No
`.impeccable/build/state.json`, `.impeccable/build/spec.json`, or `diff/`
directories — all comp-led inputs. No hook findings were produced by the
harness. **This reviewer has no image-viewing capability**, so the visual
element matrix is derived from measured computed styles, DOM geometry and pixel
statistics rather than from sight; the one row it cannot close is named as
such below.

---

**disposition: fix**

## persistence

pass. `PRODUCT.md` exists at the project root (5,064 bytes, `impeccable:product-schema 1`,
`## Platform` = `web`). The surface brief `.impeccable/surfaces/storefront.md`
carries all six contract blocks (THESIS, OWN-WORLD, STORY, FIRST VIEWPORT,
FORM, FINISH) plus the pinned-world note. Code-led build: no comp round, no
build state, and no `.impeccable/mocks/` comps are expected, so their absence is
not a finding. No DESIGN.md predates this build; the documenter writes it after
this review.

## fidelity

No approved comp exists, so TYPE and MATERIAL are judged against the contract's
OWN-WORLD and GROUND against the colour OWN-WORLD names.

| element | verdict | evidence |
|---|---|---|
| TYPE — display lettering | match | Self-hosted `Bricolage Grotesque` (display) and `Archivo` (text); `document.fonts` reports both `loaded`; computed `h1` family = Bricolage Grotesque. No system-display fallback in play. |
| TYPE — scale and steps | match | `h1` 41.6px/800 on the 404, 24–38px elsewhere; body 14px; micro 12px; card titles 15px. Steps are legible and ordered. |
| MATERIAL — focal imagery | match | Rasters are real photographs (`<img>` + `object-cover`), all URLs HEAD-verified 200 before use. No gradient, bevel, `clip-path`, SVG illustration or CSS imitation of a material anywhere in source. |
| GROUND — field value and temperature | match | Dominant sampled pixel of `desktop.png` is `#F8F8F8`, neutral; paper field samples `#EFEFF0` / `#FCFBFB`; ink cluster `#161415`. No warm-cream drift and no blue-black slate drift. |
| composition, density, z-order, focal scale, overlaps | **unverified** | This reviewer cannot see the captures. Measured structure is coherent (hero media 8/12 columns, panel 4/12, overlapping plate inside the media frame) but composite judgment is owed to an eye. |
| added without approval | none found | Screen-space additions (preview strip, spec list, size-in-post chips) are each named in the surface brief or forced by PRODUCT.md's placeholder rules. |

## ceiling

No QUALITY BAR card exists on this build (no image generation), so the card
check cannot run; the contract's FINISH line is the standing bar instead. Native
devices the build left unused: the carousel has no arrow/keyboard affordance
beyond native scroll, and filter navigation has no loading skeleton, only an
opacity dip.

## material_fixes

1. **Carousel dots are 6×6px tap targets** (`[data-carousel-dot]` measured
   `24x6` active, `6x6` inactive) — below any touch floor; the padding must move
   onto the button and stay off the bar.
2. **Blur used as decoration** — `backdrop-blur-md` on a 95%-opaque sticky
   header does nothing but cost a compositor layer, and two over-media chips
   carry `backdrop-blur-sm`; the craft floor refuses glass/blur that is not a
   specific effect.
3. **Inline links under a 24px target** — the header wordmark (`97x23`), the
   "Browse everything" link (`146x20`) and feed-chip product names (`108x16`).
4. **The composite row above is unverified** — the build cannot be pronounced
   sight-checked by this harness; the user's own screen is the remaining
   evidence for the first viewport.

## keep

The paper/ink ground and the hairline-at-rest / single-lift-on-hover elevation
rule, the labelled-placeholder honesty (preview strip, price-per-listing notes,
the WhatsApp-is-the-only-payment line), and the no-fade reveal — text must never
dip below full contrast while in motion.
