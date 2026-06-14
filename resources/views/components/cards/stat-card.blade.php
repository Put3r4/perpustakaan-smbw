@props(['label', 'value', 'tone' => 'slate'])

@php
    $tones = [
        'emerald' => 'border-emerald-200 bg-emerald-50 text-emerald-800',
        'amber' => 'border-amber-200 bg-amber-50 text-amber-800',
        'sky' => 'border-sky-200 bg-sky-50 text-sky-800',
        'rose' => 'border-rose-200 bg-rose-50 text-rose-800',
        'slate' => 'border-slate-200 bg-white text-slate-800',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'rounded-md border p-4 shadow-sm '.$tones[$tone]]) }}>
    <p class="text-sm font-medium opacity-80">{{ $label }}</p>
    <p class="mt-3 text-3xl font-semibold">{{ $value }}</p>
</div>
