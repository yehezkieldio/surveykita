<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Admin SurveyKita' }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#FBFBFA] text-[#111111]">
        <div class="min-h-screen lg:flex">
            <aside class="border-b border-zinc-200 bg-white lg:w-64 lg:border-b-0 lg:border-r">
                <div class="flex items-center justify-between px-6 py-6 lg:block lg:border-b lg:border-zinc-100">
                    <div>
                        <p class="font-mono text-[10px] uppercase tracking-[0.2em] text-zinc-400">System Portal</p>
                        <p class="mt-1 text-lg font-bold uppercase tracking-tight text-zinc-900">SurveyKita</p>
                    </div>
                </div>

                <nav class="grid gap-1 py-6 text-sm text-zinc-600">
                    <p class="px-6 mb-2 font-mono text-[10px] uppercase tracking-wider text-zinc-400">Navigasi Utama</p>
                    @foreach ([
                        'admin.dashboard' => 'Dashboard',
                        'admin.students.index' => 'Mahasiswa',
                        'admin.periods.index' => 'Periode',
                        'admin.forms.index' => 'Form Evaluasi',
                        'admin.categories.index' => 'Kategori',
                        'admin.questions.index' => 'Pertanyaan',
                        'admin.results.index' => 'Hasil Evaluasi',
                    ] as $routeName => $label)
                        @if (Route::has($routeName))
                            <a href="{{ route($routeName) }}" @class([
                                'px-6 py-2.5 transition-all duration-200 border-l-2 text-sm',
                                'border-transparent text-zinc-600 hover:bg-zinc-50 hover:text-zinc-900' => !request()->routeIs($routeName) && !request()->routeIs(str_replace('.index', '', $routeName) . '.*'),
                                'border-zinc-900 bg-[#FBFBFA] text-zinc-950 font-semibold' => request()->routeIs($routeName) || request()->routeIs(str_replace('.index', '', $routeName) . '.*'),
                            ])>{{ $label }}</a>
                        @endif
                    @endforeach
                </nav>
            </aside>

            <div class="min-w-0 flex-1 flex flex-col">
                <header class="border-b border-zinc-200 bg-white px-8 py-5">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="font-mono text-[10px] uppercase tracking-[0.15em] text-zinc-400">{{ $eyebrow ?? 'Administrator' }}</p>
                            <h1 class="mt-0.5 text-xl font-bold tracking-tight text-zinc-900 uppercase">{{ $heading ?? 'Dashboard' }}</h1>
                        </div>

                        @auth
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-button type="submit" variant="secondary" class="!min-h-9 !py-1 text-xs">Keluar</x-button>
                            </form>
                        @endauth
                    </div>
                </header>

                <main class="flex-1 px-8 py-8 animate-reveal">
                    <x-alert />
                    {{ $slot }}
                </main>
            </div>
        </div>

        @stack('scripts')
    </body>
</html>
