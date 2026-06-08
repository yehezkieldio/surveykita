@props([
    'title' => null,
    'heading' => null,
    'eyebrow' => null,
    'sidebar' => true,
])

<x-layouts.app :title="$title ?? $heading">
    <div class="min-h-full bg-zinc-50">
        @if($sidebar)
            <aside class="hidden lg:fixed lg:inset-y-0 lg:flex lg:w-72 lg:flex-col lg:border-r lg:border-zinc-800 lg:bg-zinc-950 lg:text-white">
                <div class="flex h-full flex-col px-6 py-8">
                    <div class="mb-10 flex h-8 shrink-0 items-center">
                        <a href="{{ route('student.dashboard') }}" class="flex items-center gap-2 font-display text-xl font-bold tracking-tight text-white">
                            SurveyKita
                        </a>
                    </div>

                    <div class="flex flex-1 flex-col gap-y-8 overflow-y-auto">
                        <div>
                            <p class="mb-4 text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-500">Portal Mahasiswa</p>
                            <nav>
                                <ul role="list" class="flex flex-col gap-y-1">
                                    <li>
                                        <x-ui.nav-link
                                            href="{{ route('student.dashboard') }}"
                                            :active="request()->routeIs('student.dashboard')"
                                            icon="house"
                                            class="{{ request()->routeIs('student.dashboard') ? 'border-l-2 border-teal-500 bg-zinc-900 text-teal-400' : 'border-l-2 border-transparent text-zinc-400 hover:bg-white/5 hover:text-white' }} rounded-none pl-3"
                                        >
                                            Beranda
                                        </x-ui.nav-link>
                                    </li>
                                    <li>
                                        <x-ui.nav-link
                                            href="{{ route('student.evaluations.index') }}"
                                            :active="request()->routeIs('student.evaluations.*')"
                                            icon="clipboard-document-list"
                                            class="{{ request()->routeIs('student.evaluations.*') ? 'border-l-2 border-teal-500 bg-zinc-900 text-teal-400' : 'border-l-2 border-transparent text-zinc-400 hover:bg-white/5 hover:text-white' }} rounded-none pl-3"
                                        >
                                            Evaluasi Aktif
                                        </x-ui.nav-link>
                                    </li>
                                    <li>
                                        <x-ui.nav-link
                                            href="{{ route('student.submissions.index') }}"
                                            :active="request()->routeIs('student.submissions.*')"
                                            icon="clock"
                                            class="{{ request()->routeIs('student.submissions.*') ? 'border-l-2 border-teal-500 bg-zinc-900 text-teal-400' : 'border-l-2 border-transparent text-zinc-400 hover:bg-white/5 hover:text-white' }} rounded-none pl-3"
                                        >
                                            Riwayat Pengisian
                                        </x-ui.nav-link>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                        <div class="mt-4">
                            <p class="mb-4 text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-500">Pengaturan</p>
                            <nav>
                                <ul role="list" class="flex flex-col gap-y-1">
                                    <li>
                                        <x-ui.nav-link
                                            href="{{ route('student.profile.complete') }}"
                                            :active="request()->routeIs('student.profile.*')"
                                            icon="user"
                                            class="{{ request()->routeIs('student.profile.*') ? 'border-l-2 border-teal-500 bg-zinc-900 text-teal-400' : 'border-l-2 border-transparent text-zinc-400 hover:bg-white/5 hover:text-white' }} rounded-none pl-3"
                                        >
                                            Profil
                                        </x-ui.nav-link>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <div class="mt-auto border-t border-zinc-900 pt-8">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="group flex w-full items-center gap-x-3 rounded-none py-2 text-sm font-medium text-zinc-500 transition-colors hover:text-red-400">
                                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            <div class="lg:hidden">
                <input id="student-mobile-nav" type="checkbox" class="peer sr-only">

                <div class="sticky top-0 z-40 flex items-center gap-3 border-b border-zinc-200 bg-white/95 px-4 py-3 backdrop-blur-sm sm:px-6">
                    <label for="student-mobile-nav" class="inline-flex h-10 w-10 cursor-pointer items-center justify-center border border-zinc-200 bg-white text-zinc-950 transition-colors hover:bg-zinc-100">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </label>
                    <div class="min-w-0 flex-1">
                        <p class="font-display text-lg font-bold tracking-tight text-zinc-950">SurveyKita</p>
                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Portal Mahasiswa</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="inline-flex h-10 w-10 items-center justify-center border border-zinc-200 bg-white text-zinc-500 transition-colors hover:bg-zinc-100 hover:text-zinc-950">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                            </svg>
                        </button>
                    </form>
                </div>

                <label for="student-mobile-nav" class="pointer-events-none fixed inset-0 z-40 bg-zinc-950/45 opacity-0 transition-opacity duration-300 peer-checked:pointer-events-auto peer-checked:opacity-100"></label>

                <aside class="fixed inset-y-0 left-0 z-50 flex w-[18rem] max-w-[85vw] -translate-x-full flex-col border-r border-zinc-800 bg-zinc-950 text-white transition-transform duration-300 peer-checked:translate-x-0">
                    <div class="flex items-center justify-between border-b border-zinc-900 px-5 py-4">
                        <div>
                            <p class="font-display text-lg font-bold tracking-tight text-white">SurveyKita</p>
                            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-500">Portal Mahasiswa</p>
                        </div>
                        <label for="student-mobile-nav" class="inline-flex h-9 w-9 cursor-pointer items-center justify-center border border-zinc-800 text-zinc-400 transition-colors hover:border-zinc-700 hover:text-white">
                            <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </label>
                    </div>

                    <div class="flex-1 overflow-y-auto px-5 py-6">
                        <div>
                            <p class="mb-4 text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-500">Portal Mahasiswa</p>
                            <nav>
                                <ul role="list" class="flex flex-col gap-y-1">
                                    <li>
                                        <x-ui.nav-link
                                            href="{{ route('student.dashboard') }}"
                                            :active="request()->routeIs('student.dashboard')"
                                            icon="house"
                                            class="{{ request()->routeIs('student.dashboard') ? 'border-l-2 border-teal-500 bg-zinc-900 text-teal-400' : 'border-l-2 border-transparent text-zinc-400 hover:bg-white/5 hover:text-white' }} rounded-none pl-3"
                                        >
                                            Beranda
                                        </x-ui.nav-link>
                                    </li>
                                    <li>
                                        <x-ui.nav-link
                                            href="{{ route('student.evaluations.index') }}"
                                            :active="request()->routeIs('student.evaluations.*')"
                                            icon="clipboard-document-list"
                                            class="{{ request()->routeIs('student.evaluations.*') ? 'border-l-2 border-teal-500 bg-zinc-900 text-teal-400' : 'border-l-2 border-transparent text-zinc-400 hover:bg-white/5 hover:text-white' }} rounded-none pl-3"
                                        >
                                            Evaluasi Aktif
                                        </x-ui.nav-link>
                                    </li>
                                    <li>
                                        <x-ui.nav-link
                                            href="{{ route('student.submissions.index') }}"
                                            :active="request()->routeIs('student.submissions.*')"
                                            icon="clock"
                                            class="{{ request()->routeIs('student.submissions.*') ? 'border-l-2 border-teal-500 bg-zinc-900 text-teal-400' : 'border-l-2 border-transparent text-zinc-400 hover:bg-white/5 hover:text-white' }} rounded-none pl-3"
                                        >
                                            Riwayat Pengisian
                                        </x-ui.nav-link>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                        <div class="mt-8">
                            <p class="mb-4 text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-500">Pengaturan</p>
                            <nav>
                                <ul role="list" class="flex flex-col gap-y-1">
                                    <li>
                                        <x-ui.nav-link
                                            href="{{ route('student.profile.complete') }}"
                                            :active="request()->routeIs('student.profile.*')"
                                            icon="user"
                                            class="{{ request()->routeIs('student.profile.*') ? 'border-l-2 border-teal-500 bg-zinc-900 text-teal-400' : 'border-l-2 border-transparent text-zinc-400 hover:bg-white/5 hover:text-white' }} rounded-none pl-3"
                                        >
                                            Profil
                                        </x-ui.nav-link>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <div class="border-t border-zinc-900 px-5 py-5">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="group flex w-full items-center gap-x-3 rounded-none py-2 text-sm font-medium text-zinc-500 transition-colors hover:text-red-400">
                                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </aside>
            </div>
        @endif

        <main @class([
            'flex-1',
            'lg:pl-72' => $sidebar,
        ])>
            <div class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-12">
                <header class="mb-10 animate-reveal">
                    @if($eyebrow)
                        <p class="mb-2 text-xs font-bold uppercase tracking-[0.2em] text-zinc-500">{{ $eyebrow }}</p>
                    @endif
                    <h1 class="font-display text-3xl font-bold tracking-tight text-zinc-950 sm:text-4xl lg:text-5xl leading-tight">
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
