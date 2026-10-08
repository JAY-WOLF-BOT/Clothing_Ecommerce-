@props([
    'for',
    'label',
    'icon' => null,
    'hint' => null,
])

{{-- The control is written before the addon so the tab order matches the
     reading order; `data-align` is what places the addon on its side. --}}
<div {{ $attributes }}>
    <label for="{{ $for }}" class="micro text-muted">{{ $label }}</label>

    <div class="input-group mt-2">
        {{ $slot }}

        @if ($icon)
            <span class="input-group-addon" data-align="inline-start" aria-hidden="true">
                <x-icon :name="$icon" class="h-4 w-4" />
            </span>
        @endif
    </div>

    @if ($hint)
        <p class="mt-2 text-xs leading-relaxed text-muted">{{ $hint }}</p>
    @endif
</div>
