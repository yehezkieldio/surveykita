<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'SurveyKita') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-zinc-50">
        <main class="flex min-h-screen items-center justify-center px-4 py-10">
            <div class="w-full max-w-md">
                <div class="mb-8 text-center">
                    <p class="text-sm font-semibold text-teal-700">Universitas Mulia</p>
                    <h1 class="mt-2 text-3xl font-bold text-zinc-950">SurveyKita</h1>
                    <p class="mt-2 text-sm text-zinc-600">Evaluasi Kepuasan Mahasiswa terhadap Layanan Akademik</p>
                </div>

                {{ $slot }}
            </div>
        </main>
    </body>
</html>
