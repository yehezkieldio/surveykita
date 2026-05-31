<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Admin SurveyKita' }}</title>

        <!-- Inter Font (International Swiss Style) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-zinc-50/50 text-zinc-950 font-sans">
        <div class="min-h-screen lg:flex">
            <aside class="border-b border-zinc-200 bg-white lg:w-64 lg:border-b-0 lg:border-r">
                <div class="flex items-center justify-between px-6 py-5 lg:block lg:border-b lg:border-zinc-200/50">
                    <div>
                        <p class="text-[10px] font-semibold uppercase tracking-wider text-zinc-400">System Portal</p>
                        <p class="mt-0.5 text-lg font-bold tracking-tight text-zinc-950">SurveyKita</p>
                    </div>
                </div>

                <nav class="grid gap-1 px-4 py-6 text-sm">
                    <p class="px-2 mb-2 text-[10px] font-semibold uppercase tracking-wider text-zinc-400">Navigasi Utama</p>
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
                                'flex items-center rounded-md px-3 py-2 transition-all duration-200 text-sm font-medium',
                                'text-zinc-500 hover:bg-zinc-100 hover:text-zinc-900' => !request()->routeIs($routeName) && !request()->routeIs(str_replace('.index', '', $routeName) . '.*'),
                                'bg-zinc-100 text-zinc-900 font-semibold' => request()->routeIs($routeName) || request()->routeIs(str_replace('.index', '', $routeName) . '.*'),
                            ])>{{ $label }}</a>
                        @endif
                    @endforeach
                </nav>
            </aside>

            <div class="min-w-0 flex-1 flex flex-col">
                <header class="border-b border-zinc-200 bg-white px-8 py-4.5">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-[10px] font-semibold uppercase tracking-wider text-zinc-400">{{ $eyebrow ?? 'Administrator' }}</p>
                            <h1 class="mt-0.5 text-xl font-bold tracking-tight text-zinc-950">{{ $heading ?? 'Dashboard' }}</h1>
                        </div>

                        @auth
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-button type="submit" variant="secondary" class="h-8 text-xs">Keluar</x-button>
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
