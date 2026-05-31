<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? config('app.name', 'SurveyKita') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=stack-sans-text:400,500,600,700|stack-sans-headline:500,600,700" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="sk-page font-sans">
        <main class="grid min-h-[100dvh] lg:grid-cols-[minmax(0,1fr)_32rem]">
            <section class="hidden border-r border-zinc-200 bg-white p-10 lg:flex lg:flex-col lg:justify-between">
                <div>
                    <p class="font-display text-3xl font-semibold tracking-[-0.06em] text-zinc-950">SurveyKita</p>
                    <p class="mt-4 max-w-xl text-lg leading-8 text-zinc-600">Evaluasi akademik yang rapi, terbaca, dan mudah diaudit oleh admin serta mahasiswa.</p>
                </div>
                <div class="grid grid-cols-3 gap-px border border-zinc-200 bg-zinc-200">
                    <div class="bg-zinc-50 p-5"><p class="font-display text-4xl font-semibold tracking-[-0.06em]">01</p><p class="mt-2 text-sm text-zinc-600">Form</p></div>
                    <div class="bg-zinc-50 p-5"><p class="font-display text-4xl font-semibold tracking-[-0.06em]">02</p><p class="mt-2 text-sm text-zinc-600">Respons</p></div>
                    <div class="bg-zinc-50 p-5"><p class="font-display text-4xl font-semibold tracking-[-0.06em]">03</p><p class="mt-2 text-sm text-zinc-600">Laporan</p></div>
                </div>
            </section>

            <section class="flex items-center justify-center px-4 py-12 sm:px-8 animate-reveal">
                <div class="w-full max-w-md">
                    {{ $slot }}
                </div>
            </section>
        </main>
    </body>
</html>
