<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? 'SurveyKita' }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-white text-zinc-950 antialiased">
        <main class="flex min-h-screen items-center justify-center px-6 text-center">
            <h1 class="text-4xl font-semibold tracking-tight">Hello, world</h1>
        </main>
    </body>
</html>
