<x-layouts.dashboard :title="$title">
    <section class="rounded-md border border-slate-200 bg-white p-6 shadow-sm">
        <div class="max-w-3xl">
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Modul Dashboard</p>
            <h2 class="mt-2 text-2xl font-semibold text-slate-950">{{ $title }}</h2>
            <p class="mt-3 leading-7 text-slate-600">{{ $description }}</p>
            <div class="mt-6 rounded-md border border-dashed border-slate-300 bg-slate-50 p-5">
                <p class="text-sm text-slate-600">
                    Halaman ini sudah terhubung ke routing dan layout dashboard. Logic form, validasi request, service, serta tabel data detail bisa dilanjutkan pada sprint modul berikutnya.
                </p>
            </div>
        </div>
    </section>
</x-layouts.dashboard>
