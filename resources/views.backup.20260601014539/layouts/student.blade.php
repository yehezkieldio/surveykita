<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Mahasiswa SurveyKita' }}</title>

        <!-- Inter Font (International Swiss Style) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-zinc-50/50 text-zinc-950 font-sans">
        <header class="border-b border-zinc-200 bg-white">
            <div class="mx-auto flex max-w-5xl flex-wrap items-center justify-between gap-4 px-6 py-4">
                <div>
                    <p class="text-[10px] font-semibold uppercase tracking-wider text-zinc-400">Student Portal</p>
                    <p class="mt-0.5 text-lg font-bold tracking-tight text-zinc-950">SurveyKita</p>
                </div>

                <nav class="flex flex-wrap items-center gap-1 text-sm">
                    @foreach ([
                        'student.dashboard' => 'Dashboard',
                        'student.profile.complete' => 'Profil Saya',
                        'student.evaluations.index' => 'Evaluasi Aktif',
                        'student.submissions.index' => 'Riwayat',
                    ] as $routeName => $label)
                        @if (Route::has($routeName))
                            <a href="{{ route($routeName) }}" @class([
                                'rounded-md px-3 py-2 transition-all duration-200 text-sm font-medium',
                                'text-zinc-500 hover:bg-zinc-100 hover:text-zinc-900' => !request()->routeIs($routeName),
                                'bg-zinc-100 text-zinc-900 font-semibold' => request()->routeIs($routeName),
                            ])>{{ $label }}</a>
                        @endif
                    @endforeach

                    @auth
                        <form method="POST" action="{{ route('logout') }}" class="ml-2">
                            @csrf
                            <x-button type="submit" variant="secondary" class="h-8 text-xs">Keluar</x-button>
                        </form>
                    @endauth
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-5xl px-6 py-8 animate-reveal">
            <div class="mb-6 border-b border-zinc-200 pb-5">
                <p class="text-[10px] font-semibold uppercase tracking-wider text-zinc-400">{{ $eyebrow ?? 'Portal Mahasiswa' }}</p>
                <h1 class="mt-0.5 text-2xl font-bold tracking-tight text-zinc-950">{{ $heading ?? 'Dashboard' }}</h1>
            </div>

            <x-alert />
            {{ $slot }}
        </main>
    </body>
</html>
