@props(['title' => null, 'heading' => null, 'eyebrow' => null])

<x-layouts.app :title="$title ?? $heading">
    <div class="flex min-h-full">
        {{-- Sidebar --}}
        <aside class="hidden lg:fixed lg:inset-y-0 lg:flex lg:w-72 lg:flex-col lg:border-r lg:border-zinc-200 lg:bg-white">
            <div class="flex grow flex-col gap-y-8 overflow-y-auto px-6 py-8">
                <div class="flex h-8 shrink-0 items-center">
                    <a href="{{ route('student.dashboard') }}" class="font-display text-xl font-bold tracking-tight text-zinc-950">SurveyKita</a>
                </div>

                <div class="flex flex-col gap-y-1">
                    <p class="mb-4 text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-400">Portal Mahasiswa</p>

                    <nav class="flex flex-1 flex-col">
                        <ul role="list" class="flex flex-1 flex-col gap-y-1">
                            <li>
                                <x-ui.nav-link href="{{ route('student.dashboard') }}" :active="request()->routeIs('student.dashboard')" icon="house">
                                    Beranda
                                </x-ui.nav-link>
                            </li>
                            <li>
                                <x-ui.nav-link href="{{ route('student.evaluations.index') }}" :active="request()->routeIs('student.evaluations.*')" icon="clipboard-document-list">
                                    Evaluasi Aktif
                                </x-ui.nav-link>
                            </li>
                            <li>
                                <x-ui.nav-link href="{{ route('student.submissions.index') }}" :active="request()->routeIs('student.submissions.*')" icon="clock">
                                    Riwayat Pengisian
                                </x-ui.nav-link>
                            </li>
                            <li>
                                <x-ui.nav-link href="{{ route('student.profile.complete') }}" :active="request()->routeIs('student.profile.*')" icon="user">
                                    Profil
                                </x-ui.nav-link>
                            </li>
                        </ul>
                    </nav>
                </div>

                <div class="mt-auto">
                    <div class="mb-6 rounded-lg bg-zinc-50 p-4">
                        <p class="text-xs font-medium text-zinc-500">Mahasiswa</p>
                        <p class="mt-1 text-sm font-semibold truncate text-zinc-950">{{ Auth::user()->name }}</p>
                        @if(Auth::user()->student?->nim)
                            <p class="text-[10px] font-mono text-zinc-400">{{ Auth::user()->student->nim }}</p>
                        @endif
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="group flex w-full items-center gap-x-3 rounded-md py-2 text-sm font-medium text-zinc-500 transition-colors hover:text-red-600">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                            </svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Mobile Header --}}
        <div class="sticky top-0 z-40 flex items-center gap-x-6 bg-white px-4 py-4 shadow-sm sm:px-6 lg:hidden border-b border-zinc-200">
            <div class="flex-1 font-display text-lg font-bold tracking-tight text-zinc-950">SurveyKita</div>
            <nav class="flex items-center gap-4">
                <a href="{{ route('student.dashboard') }}" class="@if(request()->routeIs('student.dashboard')) text-zinc-950 @else text-zinc-400 @endif">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>
                </a>
                <a href="{{ route('student.evaluations.index') }}" class="@if(request()->routeIs('student.evaluations.*')) text-zinc-950 @else text-zinc-400 @endif">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .415.162.798.425 1.081.263.283.646.445 1.075.445.429 0 .812-.162 1.095-.445.283-.283.445-.666.445-1.081 0-.231-.035-.454-.1-.664m-5.801 0A22.509 22.509 0 0112 2.25c2.768 0 5.36.495 7.75 1.392m-7.75 0a22.509 22.509 0 00-7.75 1.392" /></svg>
                </a>
                <a href="{{ route('student.submissions.index') }}" class="@if(request()->routeIs('student.submissions.*')) text-zinc-950 @else text-zinc-400 @endif">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </a>
                <a href="{{ route('student.profile.complete') }}" class="@if(request()->routeIs('student.profile.*')) text-zinc-950 @else text-zinc-400 @endif">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="contents">
                    @csrf
                    <button type="submit" class="text-zinc-400">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" /></svg>
                    </button>
                </form>
            </nav>
        </div>

        {{-- Main Content --}}
        <main class="lg:pl-72 flex-1">
            <div class="px-4 py-8 sm:px-6 lg:px-12 max-w-5xl">
                <header class="mb-12 animate-reveal">
                    @if($eyebrow)
                        <p class="mb-2 text-xs font-bold uppercase tracking-[0.2em] text-zinc-400">{{ $eyebrow }}</p>
                    @endif
                    <h1 class="font-display text-4xl font-bold tracking-tight text-zinc-950 sm:text-5xl leading-tight">
                        {{ $heading ?? 'Dashboard' }}
                    </h1>
                </header>

                <div class="animate-reveal [animation-delay:100ms]">
                    <x-ui.alert />
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>
</x-layouts.app>
