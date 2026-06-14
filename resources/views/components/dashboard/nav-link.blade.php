@props(['href', 'active' => false])

<a href="{{ $href }}" {{ $attributes->merge(['class' => $active
    ? 'block rounded-md bg-emerald-50 px-3 py-2 font-semibold text-emerald-800'
    : 'block rounded-md px-3 py-2 font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-950']) }}>
    {{ $slot }}
</a>
