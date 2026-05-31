<x-layouts.guest title="Masuk - SurveyKita">
    <div class="border border-zinc-200 bg-white">
        <div class="border-b border-zinc-200 p-6">
            <h1 class="font-display text-4xl font-semibold leading-none tracking-[-0.06em] text-zinc-950">Masuk</h1>
            <p class="mt-3 text-sm leading-6 text-zinc-600">Gunakan akun admin atau akun Google mahasiswa Universitas Mulia.</p>
        </div>

        <div class="p-6">
            <x-alert />

            <form method="POST" action="{{ route('login.store') }}" class="grid gap-5">
                @csrf
                <div class="sk-field">
                    <label for="email" class="sk-label">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required>
                    <x-form-error name="email" />
                </div>
                <div class="sk-field">
                    <label for="password" class="sk-label">Kata Sandi</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required>
                    <x-form-error name="password" />
                </div>
                <label class="flex items-center gap-3 text-sm text-zinc-700">
                    <input name="remember" type="checkbox" value="1">
                    Ingat saya
                </label>
                <x-button type="submit" class="w-full">Masuk</x-button>
            </form>

            @if (Route::has('auth.google.redirect'))
                <div class="mt-6 border-t border-zinc-200 pt-6">
                    <x-button href="{{ route('auth.google.redirect') }}" variant="secondary" class="w-full">Masuk dengan Google</x-button>
                </div>
            @endif
        </div>
    </div>
</x-layouts.guest>
