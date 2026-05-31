<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Mahasiswa SurveyKita' }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#FBFBFA] text-[#111111]">
        <header class="border-b border-zinc-200 bg-white">
            <div class="mx-auto flex max-w-5xl flex-wrap items-center justify-between gap-4 px-6 py-5">
                <div>
                    <p class="font-mono text-[10px] uppercase tracking-[0.2em] text-zinc-400">Student Portal</p>
                    <p class="mt-0.5 text-lg font-bold uppercase tracking-tight text-zinc-900">SurveyKita</p>
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
                                'px-3 py-1.5 transition-all duration-200 text-xs uppercase tracking-wider font-semibold border-b-2',
                                'border-transparent text-zinc-500 hover:text-zinc-900' => !request()->routeIs($routeName),
                                'border-zinc-950 text-zinc-950' => request()->routeIs($routeName),
                            ])>{{ $label }}</a>
                        @endif
                    @endforeach

                    @auth
                        <form method="POST" action="{{ route('logout') }}" class="ml-2">
                            @csrf
                            <x-button type="submit" variant="secondary" class="!min-h-8 !py-1 !px-3 text-xs">Keluar</x-button>
                        </form>
                    @endauth
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-5xl px-6 py-10 animate-reveal">
            <div class="mb-8 border-b border-zinc-200 pb-6">
                <p class="font-mono text-[10px] uppercase tracking-[0.15em] text-zinc-400">{{ $eyebrow ?? 'Portal Mahasiswa' }}</p>
                <h1 class="mt-1 text-2xl font-bold tracking-tight text-zinc-900 uppercase">{{ $heading ?? 'Dashboard' }}</h1>
            </div>

            <x-alert />
            {{ $slot }}
        </main>
    </body>
</html>
