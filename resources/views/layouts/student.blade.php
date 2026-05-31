<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Mahasiswa SurveyKita' }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-zinc-50">
        <header class="border-b border-zinc-200 bg-white">
            <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 px-4 py-4">
                <div>
                    <p class="text-xs font-semibold uppercase text-teal-700">SurveyKita</p>
                    <p class="mt-1 text-lg font-bold text-zinc-950">Portal Mahasiswa</p>
                </div>

                <nav class="flex flex-wrap items-center gap-2 text-sm font-medium text-zinc-700">
                    @foreach ([
                        'student.dashboard' => 'Dashboard',
                        'student.profile.complete' => 'Profil',
                        'student.evaluations.index' => 'Evaluasi',
                        'student.submissions.index' => 'Riwayat',
                    ] as $routeName => $label)
                        @if (Route::has($routeName))
                            <a href="{{ route($routeName) }}" @class([
                                'rounded-md px-3 py-2 hover:bg-teal-50 hover:text-teal-800',
                                'bg-teal-50 text-teal-800' => request()->routeIs($routeName),
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

        <main class="mx-auto max-w-6xl px-4 py-6">
            <div class="mb-6">
                <p class="text-sm text-zinc-500">{{ $eyebrow ?? 'Portal Mahasiswa' }}</p>
                <h1 class="text-2xl font-semibold text-zinc-950">{{ $heading ?? 'Dashboard' }}</h1>
            </div>

            <x-alert />
            {{ $slot }}
        </main>
    </body>
</html>
