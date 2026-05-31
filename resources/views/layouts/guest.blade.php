<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'SurveyKita') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#FBFBFA]">
        <main class="flex min-h-screen items-center justify-center px-4 py-16 animate-reveal">
            <div class="w-full max-w-md">
                <div class="mb-10 text-center">
                    <p class="font-mono text-xs uppercase tracking-[0.2em] text-zinc-500">Universitas Mulia</p>
                    <h1 class="mt-3 text-4xl font-extrabold tracking-tight text-zinc-950 uppercase">SurveyKita</h1>
                    <div class="mx-auto mt-4 h-[1px] w-12 bg-zinc-200"></div>
                    <p class="mt-4 text-xs font-medium uppercase tracking-wider text-zinc-600 leading-relaxed">
                        Evaluasi Kepuasan Mahasiswa<br>terhadap Layanan Akademik
                    </p>
                </div>

                <div class="border border-zinc-200 bg-white p-8 shadow-none transition-all duration-300 hover:border-zinc-300">
                    {{ $slot }}
                </div>
            </div>
        </main>
    </body>
</html>
