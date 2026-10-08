@props([
    'name',
    'id' => null,
    'options' => [],
    'selected' => null,
    'labelledby' => null,
    'label' => null,
    'tone' => null,
    'icon' => null,
])

@php
    $id = $id ?? 'select-'.$name;

    $options = $options instanceof \Illuminate\Support\Collection ? $options->all() : (array) $options;

    // A plain list of values is its own set of labels.
    if (array_is_list($options)) {
        $options = array_combine($options, $options) ?: [];
    }

    $selected = (string) ($selected ?? '');
    $chosen = array_key_exists($selected, $options) ? $selected : (string) array_key_first($options);

    $toneClass = match ($tone) {
        'sm' => ' select-sm',
        'xs' => ' select-xs',
        default => '',
    };
@endphp

{{-- A real select holds the value and is the control whenever scripting is not
     there to draw the list; the trigger and the listbox are the enhancement. --}}
<div {{ $attributes->merge(['class' => 'select'.$toneClass]) }} data-select>
    <select id="{{ $id }}"
            name="{{ $name }}"
            class="field select-native"
            data-select-native>
        @foreach ($options as $value => $text)
            <option value="{{ $value }}" @selected((string) $value === $chosen)>{{ $text }}</option>
        @endforeach
    </select>

    <button type="button"
            class="select-trigger"
            data-select-trigger
            role="combobox"
            aria-haspopup="listbox"
            aria-expanded="false"
            @if ($labelledby) aria-labelledby="{{ $labelledby }}" @elseif ($label) aria-label="{{ $label }}" @endif>
        @if ($icon)
            <x-icon :name="$icon" class="h-4 w-4 shrink-0" />
        @endif
        <span class="select-value" data-select-label>{{ $options[$chosen] ?? '' }}</span>
        <x-icon name="chevron-down" class="select-chevron h-4 w-4" />
    </button>
</div>
