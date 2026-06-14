<x-layouts.app title="Login Petugas">
    <section class="mx-auto flex min-h-[calc(100vh-73px)] max-w-md items-center px-4 py-10">
        <div class="w-full rounded-md border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Akses Sistem</p>
            <h1 class="mt-2 text-2xl font-semibold text-slate-950">Login</h1>

            <form method="POST" action="{{ route('login.store') }}" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label for="email" class="text-sm font-medium text-slate-700">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100">
                    @error('email')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="text-sm font-medium text-slate-700">Password</label>
                    <input id="password" name="password" type="password" required class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100">
                    @error('password')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full rounded-md bg-emerald-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-emerald-800">Masuk</button>
            </form>
        </div>
    </section>
</x-layouts.app>
