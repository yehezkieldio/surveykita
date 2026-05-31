<x-layouts.guest title="Masuk - SurveyKita">
    <x-card heading="Masuk" subheading="Gunakan akun yang diberikan admin atau akun Google mahasiswa Universitas Mulia.">
        <x-alert />

        <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block font-mono text-[10px] uppercase tracking-wider text-zinc-500 font-bold">Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    autocomplete="email"
                    required
                    class="mt-2 block w-full rounded-none border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-950 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 focus:outline-none"
                >
                <x-form-error name="email" />
            </div>

            <div>
                <label for="password" class="block font-mono text-[10px] uppercase tracking-wider text-zinc-500 font-bold">Kata Sandi</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    autocomplete="current-password"
                    required
                    class="mt-2 block w-full rounded-none border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-950 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 focus:outline-none"
                >
                <x-form-error name="password" />
            </div>

            <label class="flex items-center gap-2 text-xs font-mono uppercase tracking-wider text-zinc-500 font-bold">
                <input name="remember" type="checkbox" value="1" class="rounded-none border-zinc-300 text-zinc-950 focus:ring-zinc-950 focus:ring-offset-0">
                Ingat saya
            </label>

            <x-button type="submit" class="w-full mt-2">Masuk</x-button>
        </form>

        @if (Route::has('auth.google.redirect'))
            <div class="mt-6 border-t border-zinc-100 pt-6">
                <x-button href="{{ route('auth.google.redirect') }}" variant="secondary" class="w-full">
                    Masuk dengan Google
                </x-button>
            </div>
        @endif
    </x-card>
</x-layouts.guest>
