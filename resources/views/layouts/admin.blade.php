<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? 'Admin SurveyKita' }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=stack-sans-text:400,500,600,700|stack-sans-headline:500,600,700" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="sk-page font-sans">
        <div class="min-h-[100dvh] lg:grid lg:grid-cols-[16rem_minmax(0,1fr)]">
            <aside class="border-b border-zinc-200 bg-white lg:sticky lg:top-0 lg:h-[100dvh] lg:border-b-0 lg:border-r">
                <div class="border-b border-zinc-200 px-5 py-5">
                    <p class="font-display text-2xl font-semibold tracking-[-0.06em] text-zinc-950">SurveyKita</p>
                    <p class="mt-2 text-xs leading-5 text-zinc-500">Admin console</p>
                </div>

                <nav class="grid gap-px p-2 text-sm">
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
                                'px-3 py-2.5 font-medium transition-colors',
                                'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-950' => !request()->routeIs($routeName) && !request()->routeIs(str_replace('.index', '', $routeName) . '.*'),
                                'bg-zinc-950 text-white' => request()->routeIs($routeName) || request()->routeIs(str_replace('.index', '', $routeName) . '.*'),
                            ])>{{ $label }}</a>
                        @endif
                    @endforeach
                </nav>
            </aside>

            <div class="min-w-0">
                <header class="border-b border-zinc-200 bg-white">
                    <div class="flex flex-col gap-4 px-4 py-5 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
                        <div>
                            @if ($eyebrow ?? null)
                                <p class="mb-2 text-sm font-medium text-zinc-500">{{ $eyebrow }}</p>
                            @endif
                            <h1 class="font-display text-4xl font-semibold leading-none tracking-[-0.06em] text-zinc-950 md:text-5xl">{{ $heading ?? 'Dashboard' }}</h1>
                        </div>
                        @auth
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-button type="submit" variant="secondary">Keluar</x-button>
                            </form>
                        @endauth
                    </div>
                </header>

                <main class="px-4 py-6 sm:px-6 lg:px-8 animate-reveal">
                    <x-alert />
                    {{ $slot }}
                </main>
            </div>
        </div>
        @stack('scripts')
    </body>
</html>
