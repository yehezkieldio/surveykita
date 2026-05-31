<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'SurveyKita') }}</title>

        <!-- Inter Font (International Swiss Style) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-zinc-50/50">
        <main class="flex min-h-screen items-center justify-center px-4 py-16 animate-reveal">
            <div class="w-full max-w-md">
                <div class="mb-8 text-center">
                    <p class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Universitas Mulia</p>
                    <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-zinc-950">SurveyKita</h1>
                    <p class="mt-2 text-sm text-zinc-500 leading-relaxed">
                        Evaluasi Kepuasan Mahasiswa terhadap Layanan Akademik
                    </p>
                </div>

                <div class="rounded-xl border border-zinc-200 bg-white p-8 shadow-sm">
                    {{ $slot }}
                </div>
            </div>
        </main>
    </body>
</html>
