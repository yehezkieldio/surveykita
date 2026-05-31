<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Admin SurveyKita' }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-zinc-50">
        <div class="min-h-screen lg:flex">
            <aside class="border-b border-zinc-200 bg-white lg:w-72 lg:border-b-0 lg:border-r">
                <div class="flex items-center justify-between px-5 py-4 lg:block">
                    <div>
                        <p class="text-xs font-semibold uppercase text-teal-700">SurveyKita</p>
                        <p class="mt-1 text-lg font-bold text-zinc-950">Admin Akademik</p>
                    </div>
                </div>

                <nav class="grid gap-1 px-3 pb-4 text-sm font-medium text-zinc-700 lg:py-4">
                    @foreach ([
                        'admin.dashboard' => 'Dashboard',
                        'admin.students.index' => 'Mahasiswa',
                        'admin.periods.index' => 'Periode',
                        'admin.forms.index' => 'Form Evaluasi',
                        'admin.categories.index' => 'Kategori',
                        'admin.questions.index' => 'Pertanyaan',
                        'admin.results.index' => 'Hasil',
                    ] as $routeName => $label)
                        @if (Route::has($routeName))
                            <a href="{{ route($routeName) }}" @class([
                                'rounded-md px-3 py-2 hover:bg-teal-50 hover:text-teal-800',
                                'bg-teal-50 text-teal-800' => request()->routeIs($routeName),
                            ])>{{ $label }}</a>
                        @endif
                    @endforeach
                </nav>
            </aside>

            <div class="min-w-0 flex-1">
                <header class="border-b border-zinc-200 bg-white">
                    <div class="flex items-center justify-between gap-4 px-5 py-4">
                        <div>
                            <p class="text-sm text-zinc-500">{{ $eyebrow ?? 'Panel Admin' }}</p>
                            <h1 class="text-xl font-semibold text-zinc-950">{{ $heading ?? 'Dashboard' }}</h1>
                        </div>

                        @auth
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-button type="submit" variant="secondary">Keluar</x-button>
                            </form>
                        @endauth
                    </div>
                </header>

                <main class="px-5 py-6">
                    <x-alert />
                    {{ $slot }}
                </main>
            </div>
        </div>

        @stack('scripts')
    </body>
</html>
