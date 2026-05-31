<x-layouts.guest title="Masuk - SurveyKita">
    <x-card heading="Masuk" subheading="Gunakan akun yang diberikan admin atau akun Google mahasiswa Universitas Mulia.">
        <x-alert />

        <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-zinc-700">Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    autocomplete="email"
                    required
                    class="mt-1.5 block w-full"
                >
                <x-form-error name="email" />
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-zinc-700">Kata Sandi</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    autocomplete="current-password"
                    required
                    class="mt-1.5 block w-full"
                >
                <x-form-error name="password" />
            </div>

            <label class="flex items-center gap-2 text-sm text-zinc-600">
                <input name="remember" type="checkbox" value="1" class="rounded border-zinc-300 text-zinc-900 focus:ring-zinc-900 focus:ring-offset-0">
                Ingat saya
            </label>

            <x-button type="submit" class="w-full mt-2">Masuk</x-button>
        </form>

        @if (Route::has('auth.google.redirect'))
            <div class="mt-6 border-t border-zinc-150 pt-6">
                <x-button href="{{ route('auth.google.redirect') }}" variant="secondary" class="w-full">
                    Masuk dengan Google
                </x-button>
            </div>
        @endif
    </x-card>
</x-layouts.guest>
