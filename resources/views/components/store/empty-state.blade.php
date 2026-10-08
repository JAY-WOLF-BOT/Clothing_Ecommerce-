@props(['icon' => 'bag', 'title', 'body' => null])

<div class="card flex flex-col items-center gap-4 px-6 py-14 text-center">
    <span class="flex h-12 w-12 items-center justify-center rounded-full bg-mist text-ink">
        <x-icon :name="$icon" class="h-5 w-5" />
    </span>

    <div class="space-y-2">
        <p class="font-display text-lg font-bold tracking-[-0.02em] text-ink">{{ $title }}</p>
        @if ($body)
            <p class="mx-auto max-w-sm text-sm leading-relaxed text-muted">{{ $body }}</p>
        @endif
    </div>

    @if (! $slot->isEmpty())
        <div class="pt-1">{{ $slot }}</div>
    @endif
</div>
