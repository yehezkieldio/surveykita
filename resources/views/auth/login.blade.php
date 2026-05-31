<x-layouts.guest title="Masuk - SurveyKita">
    <x-card heading="Masuk" subheading="Gunakan akun yang diberikan admin atau akun Google mahasiswa Universitas Mulia.">
        <x-alert />

        <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-zinc-800">Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    autocomplete="email"
                    required
                    class="mt-1 block w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-950 shadow-sm"
                >
                <x-form-error name="email" />
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-zinc-800">Kata Sandi</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    autocomplete="current-password"
                    required
                    class="mt-1 block w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-950 shadow-sm"
                >
                <x-form-error name="password" />
            </div>

            <label class="flex items-center gap-2 text-sm text-zinc-700">
                <input name="remember" type="checkbox" value="1" class="rounded border-zinc-300 text-teal-700">
                Ingat saya
            </label>

            <x-button type="submit" class="w-full">Masuk</x-button>
        </form>

        @if (Route::has('auth.google.redirect'))
            <div class="mt-5 border-t border-zinc-200 pt-5">
                <x-button href="{{ route('auth.google.redirect') }}" variant="secondary" class="w-full">
                    Login dengan Google
                </x-button>
            </div>
        @endif
    </x-card>
</x-layouts.guest>
