@props([
    'eyebrow' => null,
    'title',
    'subtitle' => null,
    'eyebrowTone' => 'emerald',
    'containerClass' => '',
])

@php
    $tones = [
        'emerald' => [
            'text' => 'text-emerald-600',
            'bg' => 'bg-emerald-50',
            'dot' => 'bg-emerald-500',
        ],
        'rose' => [
            'text' => 'text-rose-600',
            'bg' => 'bg-rose-50',
            'dot' => 'bg-rose-500',
        ],
        'slate' => [
            'text' => 'text-slate-600',
            'bg' => 'bg-slate-100',
            'dot' => 'bg-slate-500',
        ],
    ];

    $tone = $tones[$eyebrowTone] ?? $tones['emerald'];
@endphp

<div {{ $attributes->class(['bg-white border border-slate-200 rounded-2xl p-6 shadow-sm', $containerClass]) }}>
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div class="space-y-2">
            @if(filled($eyebrow))
                <p class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] {{ $tone['text'] }} {{ $tone['bg'] }}">
                    <span class="mr-2 h-2 w-2 rounded-full {{ $tone['dot'] }}"></span>
                    {{ $eyebrow }}
                </p>
            @endif

            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-slate-900 leading-tight">{{ $title }}</h1>
                @if(filled($subtitle))
                    <p class="text-sm md:text-base text-slate-500">{{ $subtitle }}</p>
                @endif
            </div>
        </div>

        @isset($actions)
            <div class="flex w-full flex-wrap items-center gap-2 md:w-auto md:justify-end md:gap-3">
                {{ $actions }}
            </div>
        @endisset
    </div>
</div>
