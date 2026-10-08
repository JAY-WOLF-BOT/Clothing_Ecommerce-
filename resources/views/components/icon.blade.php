@props(['name', 'size' => 'h-5 w-5'])

@php
    // Authored geometry on a single 24px grid, one 1.5 stroke, round caps.
    $icons = [
        'bag' => '<path d="M5.5 8.5h13l1 11h-15l1-11Z"/><path d="M9 8.5V6.75a3 3 0 0 1 6 0V8.5"/>',
        // The provisional store mark: a photo frame with a slash. It stands in
        // for an identity that does not exist yet, so it never implies one.
        'mark' => '<rect x="4.75" y="4.75" width="14.5" height="14.5" rx="2.5"/><path d="M9 15 15 9"/>',
        'home' => '<path d="M4 10.5 12 4l8 6.5"/><path d="M6.5 9.5V19h11v-9.5"/><path d="M10 19v-5.5h4V19"/>',
        'menu' => '<path d="M3.5 7.5h17"/><path d="M3.5 12h17"/><path d="M3.5 16.5h11"/>',
        'close' => '<path d="M6 6l12 12"/><path d="M18 6L6 18"/>',
        'arrow-right' => '<path d="M4 12h16"/><path d="M13.5 5.5 20 12l-6.5 6.5"/>',
        'arrow-left' => '<path d="M20 12H4"/><path d="M10.5 18.5 4 12l6.5-6.5"/>',
        'arrow-up-right' => '<path d="M7 17 17 7"/><path d="M8.5 7H17v8.5"/>',
        'plus' => '<path d="M12 5v14"/><path d="M5 12h14"/>',
        'minus' => '<path d="M5 12h14"/>',
        'check' => '<path d="M4.5 12.5 9 17l10.5-10.5"/>',
        'alert' => '<path d="M12 4.5 21 19.5H3l9-15Z"/><path d="M12 10v4.5"/><path d="M12 17.2h.01"/>',
        'chat' => '<path d="M20.5 11.5a7.5 7.5 0 0 1-10.9 6.7L4 20l1.8-5.4A7.5 7.5 0 1 1 20.5 11.5Z"/><path d="M9 11h6"/><path d="M9 14h3.5"/>',
        'truck' => '<path d="M3.5 7.5h10v9h-10z"/><path d="M13.5 10.5h3.2l2.8 3v3h-6z"/><path d="M7 19.5a1.75 1.75 0 1 0 0-3.5 1.75 1.75 0 0 0 0 3.5Z"/><path d="M17 19.5a1.75 1.75 0 1 0 0-3.5 1.75 1.75 0 0 0 0 3.5Z"/>',
        'chevron-down' => '<path d="M6 9.5 12 15l6-5.5"/>',
        'user' => '<circle cx="12" cy="8" r="3.25"/><path d="M5.75 19.5a6.25 5.5 0 0 1 12.5 0"/>',
        'filter' => '<path d="M4 6.5h16"/><path d="M7 12h10"/><path d="M10 17.5h4"/>',
        'refresh' => '<path d="M20 6.5v5h-5"/><path d="M4 17.5v-5h5"/><path d="M5.6 9.3A7 7 0 0 1 18.8 8"/><path d="M18.4 14.7A7 7 0 0 1 5.2 16"/>',
        'trash' => '<path d="M5 7.5h14"/><path d="M9.5 7.5V5.8a1.3 1.3 0 0 1 1.3-1.3h2.4a1.3 1.3 0 0 1 1.3 1.3v1.7"/><path d="M6.8 7.5 7.6 19h8.8l.8-11.5"/>',
        'spark' => '<path d="M12 4.5 13.9 10 19.5 12 13.9 14 12 19.5 10.1 14 4.5 12 10.1 10 12 4.5Z"/>',
        'eye-off' => '<path d="M4 4l16 16"/><path d="M9.9 9.9a3 3 0 0 0 4.2 4.2"/><path d="M6.6 6.9C4.9 8.1 3.6 9.8 3 12c1.3 4 4.9 6 9 6 1.6 0 3.1-.4 4.4-1.1"/><path d="M10.6 6.2A8.8 8.8 0 0 1 12 6c4.1 0 7.7 2 9 6-.3.9-.7 1.7-1.3 2.4"/>',
        'hand' => '<path d="M8 12V6.8a1.4 1.4 0 0 1 2.8 0V11"/><path d="M10.8 11V5.6a1.4 1.4 0 0 1 2.8 0V11"/><path d="M13.6 11.2V7.4a1.4 1.4 0 0 1 2.8 0V13c0 3.3-2.2 6-5.4 6-2.4 0-3.7-1-4.8-2.6L4.6 13a1.5 1.5 0 0 1 2.4-1.8L8 12.6"/>',
    ];
@endphp

<svg
    {{ $attributes->merge(['class' => $size]) }}
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    stroke-width="1.5"
    stroke-linecap="round"
    stroke-linejoin="round"
    aria-hidden="true"
    focusable="false"
>{!! $icons[$name] ?? '' !!}</svg>
