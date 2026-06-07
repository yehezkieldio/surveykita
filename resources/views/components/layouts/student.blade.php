@props(['title' => null, 'heading' => null, 'eyebrow' => null])

<x-layouts.app :title="$title ?? $heading">
    <div class="flex min-h-full">
        {{-- Sidebar --}}
        <aside class="hidden lg:fixed lg:inset-y-0 lg:flex lg:w-72 lg:flex-col lg:border-r lg:border-zinc-800 lg:bg-zinc-950 lg:text-white">
            <div class="flex grow flex-col gap-y-8 overflow-y-auto px-6 py-8">
                <div class="flex h-8 shrink-0 items-center">
                    <a href="{{ route('student.dashboard') }}" class="font-display text-xl font-bold tracking-tight text-white flex items-center gap-2">
                        SurveyKita
                    </a>
                </div>

                <div class="flex flex-col gap-y-1">
                    <p class="mb-4 text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-500">Portal Mahasiswa</p>

                    <nav class="flex flex-1 flex-col">
                        <ul role="list" class="flex flex-1 flex-col gap-y-1">
                            <li>
                                <x-ui.nav-link 
                                    href="{{ route('student.dashboard') }}" 
                                    :active="request()->routeIs('student.dashboard')" 
                                    icon="house"
                                    class="{{ request()->routeIs('student.dashboard') ? 'bg-zinc-900 text-teal-400 border-l-2 border-teal-500' : 'text-zinc-400 hover:bg-white/5 hover:text-white border-l-2 border-transparent' }} rounded-none pl-3"
                                >
                                    Beranda
                                </x-ui.nav-link>
                            </li>
                            <li>
                                <x-ui.nav-link 
                                    href="{{ route('student.evaluations.index') }}" 
                                    :active="request()->routeIs('student.evaluations.*')" 
                                    icon="clipboard-document-list"
                                    class="{{ request()->routeIs('student.evaluations.*') ? 'bg-zinc-900 text-teal-400 border-l-2 border-teal-500' : 'text-zinc-400 hover:bg-white/5 hover:text-white border-l-2 border-transparent' }} rounded-none pl-3"
                                >
                                    Evaluasi Aktif
                                </x-ui.nav-link>
                            </li>
                            <li>
                                <x-ui.nav-link 
                                    href="{{ route('student.submissions.index') }}" 
                                    :active="request()->routeIs('student.submissions.*')" 
                                    icon="clock"
                                    class="{{ request()->routeIs('student.submissions.*') ? 'bg-zinc-900 text-teal-400 border-l-2 border-teal-500' : 'text-zinc-400 hover:bg-white/5 hover:text-white border-l-2 border-transparent' }} rounded-none pl-3"
                                >
                                    Riwayat Pengisian
                                </x-ui.nav-link>
                            </li>

                            <li class="mt-auto pt-8">
                                <p class="mb-4 text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-500">Pengaturan</p>
                                <x-ui.nav-link 
                                    href="{{ route('student.profile.complete') }}" 
                                    :active="request()->routeIs('student.profile.*')" 
                                    icon="user"
                                    class="{{ request()->routeIs('student.profile.*') ? 'bg-zinc-900 text-teal-400 border-l-2 border-teal-500' : 'text-zinc-400 hover:bg-white/5 hover:text-white border-l-2 border-transparent' }} rounded-none pl-3"
                                >
                                    Profil
                                </x-ui.nav-link>
                            </li>
                        </ul>
                    </nav>
                </div>

                <div class="mt-auto">
                    <div class="mb-6 rounded-lg bg-zinc-900 p-4 border border-zinc-800">
                        <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-500">Mahasiswa</p>
                        <p class="mt-1 text-sm font-semibold truncate text-white">{{ Auth::user()->name }}</p>
                        @if(Auth::user()->student?->nim)
                            <p class="text-[10px] font-mono text-zinc-600">{{ Auth::user()->student->nim }}</p>
                        @endif
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="group flex w-full items-center gap-x-3 rounded-md py-2 text-sm font-medium text-zinc-500 transition-colors hover:text-red-400">
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
        <div class="sticky top-0 z-40 flex items-center gap-x-6 bg-zinc-950 px-4 py-4 sm:px-6 lg:hidden border-b border-zinc-800">
            <div class="flex-1 font-display text-lg font-bold tracking-tight text-white">SurveyKita <span class="text-[10px] font-mono text-zinc-500 ml-2">PORTAL</span></div>
            <nav class="flex items-center gap-4">
                <form method="POST" action="{{ route('logout') }}" class="contents">
                    @csrf
                    <button type="submit" class="text-zinc-500">
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
                        <p class="mb-2 text-xs font-bold uppercase tracking-[0.2em] text-zinc-500">{{ $eyebrow }}</p>
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
