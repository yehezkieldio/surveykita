<x-layouts.guest title="Masuk - SurveyKita">
    <div class="border border-zinc-200 bg-white">
        <div class="border-b border-zinc-200 p-6">
            <h1 class="font-display text-4xl font-semibold leading-none tracking-[-0.06em] text-zinc-950">Masuk</h1>
            <p class="mt-3 text-sm leading-6 text-zinc-600">Gunakan akun yang terdaftar untuk membuka portal.</p>
        </div>

        <div class="p-6">
            <x-alert />

            <form method="POST" action="{{ route('login.store') }}" class="grid gap-5">
                @csrf
                <div class="sk-field">
                    <label for="email" class="sk-label">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required>
                    <x-form-error name="email" />
                </div>
                <div class="sk-field">
                    <label for="password" class="sk-label">Kata Sandi</label>
                    <input id="password" name="password" type="password" required>
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
                    <x-button href="{{ route('auth.google.redirect') }}" variant="secondary" class="w-full gap-3">
                        <svg class="size-4" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09Z" />
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23Z" />
                            <path fill="#FBBC05" d="M5.84 14.1c-.22-.66-.35-1.36-.35-2.1s.13-1.44.35-2.1V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l3.66-2.84Z" />
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06L5.84 9.9C6.71 7.31 9.14 5.38 12 5.38Z" />
                        </svg>
                        Masuk dengan Google
                    </x-button>
                </div>
            @endif
        </div>
    </div>
</x-layouts.guest>
