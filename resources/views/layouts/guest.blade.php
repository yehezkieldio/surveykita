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
        <main class="flex min-h-[100dvh] items-center justify-center px-4 py-12 sm:px-6 animate-reveal">
            <section class="w-full max-w-md">
                <div class="mb-8 text-center">
                    <h1 class="font-display text-5xl font-semibold leading-none tracking-[-0.07em] text-zinc-950">SurveyKita</h1>
                    <p class="mt-3 text-sm font-medium text-zinc-600">Universitas Mulia</p>
                </div>

                <div>
                    {{ $slot }}
                </div>
            </section>
        </main>
    </body>
</html>
