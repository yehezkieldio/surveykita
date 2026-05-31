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
            <div class="mx-auto flex max-w-7xl flex-col gap-5 px-4 py-5 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
                <a href="{{ route('student.dashboard') }}" class="font-display text-2xl font-semibold tracking-[-0.05em] text-zinc-950">SurveyKita</a>

                <nav class="grid grid-cols-2 gap-px border border-zinc-200 bg-zinc-200 text-sm sm:flex sm:items-center">
                    @foreach ([
                        'student.dashboard' => 'Beranda',
                        'student.profile.complete' => 'Profil',
                        'student.evaluations.index' => 'Evaluasi',
                        'student.submissions.index' => 'Riwayat',
                    ] as $routeName => $label)
                        @if (Route::has($routeName))
                            <a href="{{ route($routeName) }}" @class([
                                'bg-white px-4 py-2.5 text-center font-medium transition-colors',
                                'text-zinc-600 hover:text-zinc-950' => !request()->routeIs($routeName),
                                'bg-zinc-950 text-white' => request()->routeIs($routeName),
                            ])>{{ $label }}</a>
                        @endif
                    @endforeach

                    @auth
                        <form method="POST" action="{{ route('logout') }}" class="contents">
                            @csrf
                            <button type="submit" class="bg-white px-4 py-2.5 text-center font-medium text-zinc-600 transition-colors hover:text-zinc-950">Keluar</button>
                        </form>
                    @endauth
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 animate-reveal">
            <section class="mb-8 grid gap-6 border-b border-zinc-200 pb-8 lg:grid-cols-[minmax(0,1fr)_18rem] lg:items-end">
                <div>
                    @if ($eyebrow ?? null)
                        <p class="mb-3 text-sm font-medium text-zinc-500">{{ $eyebrow }}</p>
                    @endif
                    <h1 class="max-w-5xl font-display text-5xl font-semibold leading-[0.92] tracking-[-0.07em] text-zinc-950 md:text-6xl">{{ $heading ?? 'Dashboard' }}</h1>
                </div>
                <div class="border border-zinc-200 bg-white p-4">
                    <p class="text-xs font-medium text-zinc-500">Portal Mahasiswa</p>
                    <p class="mt-2 text-sm leading-6 text-zinc-700">Isi evaluasi aktif, pantau riwayat, dan lengkapi identitas akademik dari satu alur.</p>
                </div>
            </section>

            <x-alert />
            {{ $slot }}
        </main>
    </body>
</html>
