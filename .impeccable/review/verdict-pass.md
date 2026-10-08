# Verdict pass

Scoring the fixes from `finish-review.md` against the recaptured evidence over
the same paths. No new hunt; the reviewer still has no image-viewing capability,
so every score rests on measurement rather than sight.

## verdict

1. **Carousel dot tap targets** — **resolved.** `[data-carousel-dot]` now
   measures `32x24` (active) and `14x24` (inactive); the bars they contain are
   unchanged at `24x6` / `6x6`, so the visual size the comp-free world promised
   is intact. State still updates: clicking dot 2 gives bars `[6, 24]`,
   index `2`, and `aria-current="true"` on the selected dot. Controls smaller
   than 24px on both axes: `0`.
2. **Blur as decoration** — **resolved.** `backdrop-blur` no longer appears
   anywhere in `resources/views`, `resources/css` or `resources/js`. The sticky
   header keeps its `bg-paper/95` field with no compositor layer, and the two
   over-media chips moved to `bg-ink/85` without blur.
3. **Inline links under a 24px target** — **resolved.** Header wordmark,
   "Browse everything" and the feed-chip product names all gained vertical
   padding; the sub-24px control count on the home mobile capture is `0`.
4. **Visual composite row** — **unresolved.** Nothing the parent can apply
   closes it: this harness has no image viewer, so no fix batch can produce the
   sight judgment. It closes on the user's screen, not in a recapture.

Regressions introduced by the fix batch (judged by the same matrix rules):
- Minor and non-material: the dot row is now 24px tall over the photograph
  instead of 6px, so it covers slightly more of the image's lower edge. No
  overflow was introduced (`scrollWidth − clientWidth = 0` at 390, 1440 and
  1600), and no other sampled geometry changed.

## remaining

The composite row above. Everything this pass could measure is resolved; the
first viewport has still not been looked at by an eye.

**disposition: fix** — recomputed against what remains open. Unresolved rows do
not recompute to ship. The three applied fixes are resolved; the surface is not
gate-closed because the visual composite is unverified, and that is a limit of
the harness rather than a defect the parent can patch.
