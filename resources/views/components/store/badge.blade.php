@props(['tone' => 'paper', 'label'])

<span @class([
    'chip',
    'bg-ink text-paper' => $tone === 'ink',
    'bg-signal text-paper' => $tone === 'signal',
    'bg-paper text-ink shadow-sm' => $tone === 'paper',
    'bg-mist text-muted' => $tone === 'mist',
    'bg-signal-soft text-signal' => $tone === 'signal-quiet',
])>{{ $label }}</span>
