<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? 'Mahasiswa SurveyKita' }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=stack-sans-text:400,500,600,700|stack-sans-headline:500,600,700" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="sk-page font-sans">
        <header class="border-b border-zinc-200 bg-white">
            <div class="mx-auto flex max-w-6xl flex-col gap-4 px-4 py-5 sm:px-6 lg:flex-row lg:items-center lg:justify-between">
                <a href="{{ route('student.dashboard') }}" class="font-display text-2xl font-semibold tracking-[-0.05em] text-zinc-950">SurveyKita</a>

                <nav class="flex flex-wrap items-center gap-2 text-sm">
                    @foreach ([
                        'student.dashboard' => 'Dashboard',
                        'student.profile.complete' => 'Profil Saya',
                        'student.evaluations.index' => 'Evaluasi Aktif',
                        'student.submissions.index' => 'Riwayat',
                    ] as $routeName => $label)
                        @if (Route::has($routeName))
                            <a href="{{ route($routeName) }}" @class([
                                'border px-3 py-2 font-medium transition-colors',
                                'border-transparent text-zinc-600 hover:border-zinc-200 hover:bg-zinc-50 hover:text-zinc-950' => !request()->routeIs($routeName),
                                'border-zinc-950 bg-zinc-950 text-white' => request()->routeIs($routeName),
                            ])>{{ $label }}</a>
                        @endif
                    @endforeach

                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-button type="submit" variant="secondary">Keluar</x-button>
                        </form>
                    @endauth
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-6xl px-4 py-8 sm:px-6 animate-reveal">
            <div class="mb-8 border-b border-zinc-200 pb-6">
                @if ($eyebrow ?? null)
                    <p class="mb-2 text-sm font-medium text-zinc-500">{{ $eyebrow }}</p>
                @endif
                <h1 class="font-display text-4xl font-semibold leading-none tracking-[-0.06em] text-zinc-950 md:text-5xl">{{ $heading ?? 'Dashboard' }}</h1>
            </div>

            <x-alert />
            {{ $slot }}
        </main>
    </body>
</html>
