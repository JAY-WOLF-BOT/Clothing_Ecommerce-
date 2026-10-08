@php
    $toasts = [];

    if (session('status')) {
        $toasts[] = ['tone' => 'ink', 'message' => session('status')];
    }

    if (session('error')) {
        $toasts[] = ['tone' => 'signal', 'message' => session('error')];
    }
@endphp

<div data-toast-host
     class="pointer-events-none fixed inset-x-0 bottom-4 z-[60] flex flex-col items-center gap-2 px-4 sm:bottom-6">
    @foreach ($toasts as $toast)
        <div data-toast
             role="status"
             class="toast-in pointer-events-auto flex w-full max-w-md items-start gap-3 rounded-card bg-paper px-4 py-3 shadow-lift">
            <span @class([
                'mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full',
                'bg-ink text-paper' => $toast['tone'] === 'ink',
                'bg-signal-soft text-signal' => $toast['tone'] === 'signal',
            ])>
                <x-icon name="{{ $toast['tone'] === 'signal' ? 'alert' : 'check' }}" class="h-3.5 w-3.5" />
            </span>
            <p class="text-sm leading-relaxed text-ink">{{ $toast['message'] }}</p>
        </div>
    @endforeach
</div>
