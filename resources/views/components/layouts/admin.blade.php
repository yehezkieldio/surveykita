@props(['title' => null, 'heading' => null, 'eyebrow' => null])

@push('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@endpush

@push('scripts')
    <script>
        window.adminTables = {
            escape(value) {
                return $('<div>').text(value ?? '').html();
            },
            stack(primary, secondary = '', primaryClass = 'sk-cell-title', secondaryClass = 'sk-cell-support') {
                const safePrimary = this.escape(primary);
                const safeSecondary = this.escape(secondary);

                return `
                    <div class="sk-cell-stack">
                        <div class="${primaryClass}">${safePrimary}</div>
                        ${safeSecondary ? `<div class="${secondaryClass}">${safeSecondary}</div>` : ''}
                    </div>
                `;
            },
            badge(label, tone = 'neutral') {
                const tones = {
                    neutral: 'sk-table-badge sk-table-badge-neutral',
                    info: 'sk-table-badge sk-table-badge-info',
                    success: 'sk-table-badge sk-table-badge-success',
                    warning: 'sk-table-badge sk-table-badge-warning',
                };

                return `<span class="${tones[tone] ?? tones.neutral}">${this.escape(label)}</span>`;
            },
            create(selector, options) {
                return $(selector).DataTable($.extend(true, {
                    processing: true,
                    serverSide: true,
                    pageLength: 25,
                    autoWidth: false,
                    searchDelay: 350,
                    language: {
                        search: '',
                        lengthMenu: '_MENU_',
                        zeroRecords: 'Tidak ada data yang cocok dengan pencarian ini.',
                        emptyTable: 'Belum ada data untuk ditampilkan.',
                        infoEmpty: 'Belum ada data untuk ditampilkan.',
                        paginate: {
                            previous: 'Sebelumnya',
                            next: 'Berikutnya',
                        },
                    },
                }, options));
            },
            mountFilters(table, selector) {
                const filterBar = document.querySelector(selector);

                if (!filterBar) {
                    return;
                }

                const topRow = table.table().container().querySelector('.dt-layout-row:first-child .dt-layout-cell:first-child');

                if (!topRow) {
                    filterBar.classList.remove('hidden');
                    filterBar.classList.add('flex');

                    return;
                }

                filterBar.classList.remove('hidden');
                filterBar.classList.add('flex');
                topRow.prepend(filterBar);
            },
        };
    </script>
@endpush

<x-layouts.app :title="$title ?? $heading">
    <div class="flex min-h-full">
        {{-- Sidebar --}}
        <aside class="hidden lg:fixed lg:inset-y-0 lg:flex lg:w-72 lg:flex-col lg:border-r lg:border-zinc-800 lg:bg-zinc-950 lg:text-white">
            <div class="flex grow flex-col gap-y-8 overflow-y-auto px-6 py-8">
                <div class="flex h-8 shrink-0 items-center">
                    <a href="{{ route('admin.dashboard') }}" class="font-display text-xl font-bold tracking-tight text-white flex items-center gap-2">
                        SurveyKita
                    </a>
                </div>

                <div class="flex flex-col gap-y-1">
                    <p class="mb-4 text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-500">Admin Console</p>

                    <nav class="flex flex-1 flex-col">
                        <ul role="list" class="flex flex-1 flex-col gap-y-1">
                            <li>
                                <x-ui.nav-link
                                    href="{{ route('admin.dashboard') }}"
                                    :active="request()->routeIs('admin.dashboard')"
                                    icon="house"
                                    class="{{ request()->routeIs('admin.dashboard') ? 'bg-zinc-900 text-teal-400 border-l-2 border-teal-500' : 'text-zinc-400 hover:bg-white/5 hover:text-white border-l-2 border-transparent' }} rounded-none pl-3"
                                >
                                    Dashboard
                                </x-ui.nav-link>
                            </li>
                            <li>
                                <x-ui.nav-link
                                    href="{{ route('admin.students.index') }}"
                                    :active="request()->routeIs('admin.students.*')"
                                    icon="users"
                                    class="{{ request()->routeIs('admin.students.*') ? 'bg-zinc-900 text-teal-400 border-l-2 border-teal-500' : 'text-zinc-400 hover:bg-white/5 hover:text-white border-l-2 border-transparent' }} rounded-none pl-3"
                                >
                                    Mahasiswa
                                </x-ui.nav-link>
                            </li>
                            <li>
                                <x-ui.nav-link
                                    href="{{ route('admin.periods.index') }}"
                                    :active="request()->routeIs('admin.periods.*')"
                                    icon="calendar"
                                    class="{{ request()->routeIs('admin.periods.*') ? 'bg-zinc-900 text-teal-400 border-l-2 border-teal-500' : 'text-zinc-400 hover:bg-white/5 hover:text-white border-l-2 border-transparent' }} rounded-none pl-3"
                                >
                                    Periode
                                </x-ui.nav-link>
                            </li>
                            <li>
                                <x-ui.nav-link
                                    href="{{ route('admin.forms.index') }}"
                                    :active="request()->routeIs('admin.forms.*')"
                                    icon="rectangle-stack"
                                    class="{{ request()->routeIs('admin.forms.*') ? 'bg-zinc-900 text-teal-400 border-l-2 border-teal-500' : 'text-zinc-400 hover:bg-white/5 hover:text-white border-l-2 border-transparent' }} rounded-none pl-3"
                                >
                                    Form Evaluasi
                                </x-ui.nav-link>
                            </li>
                            <li>
                                <x-ui.nav-link
                                    href="{{ route('admin.categories.index') }}"
                                    :active="request()->routeIs('admin.categories.*')"
                                    icon="tag"
                                    class="{{ request()->routeIs('admin.categories.*') ? 'bg-zinc-900 text-teal-400 border-l-2 border-teal-500' : 'text-zinc-400 hover:bg-white/5 hover:text-white border-l-2 border-transparent' }} rounded-none pl-3"
                                >
                                    Kategori
                                </x-ui.nav-link>
                            </li>
                            <li>
                                <x-ui.nav-link
                                    href="{{ route('admin.questions.index') }}"
                                    :active="request()->routeIs('admin.questions.*')"
                                    icon="question-mark-circle"
                                    class="{{ request()->routeIs('admin.questions.*') ? 'bg-zinc-900 text-teal-400 border-l-2 border-teal-500' : 'text-zinc-400 hover:bg-white/5 hover:text-white border-l-2 border-transparent' }} rounded-none pl-3"
                                >
                                    Pertanyaan
                                </x-ui.nav-link>
                            </li>
                            <li>
                                <x-ui.nav-link
                                    href="{{ route('admin.results.index') }}"
                                    :active="request()->routeIs('admin.results.*')"
                                    icon="presentation-chart-bar"
                                    class="{{ request()->routeIs('admin.results.*') ? 'bg-zinc-900 text-teal-400 border-l-2 border-teal-500' : 'text-zinc-400 hover:bg-white/5 hover:text-white border-l-2 border-transparent' }} rounded-none pl-3"
                                >
                                    Hasil Evaluasi
                                </x-ui.nav-link>
                            </li>
                        </ul>
                    </nav>
                </div>

                <div class="mt-auto">
                    <div class="mb-6 rounded-lg bg-zinc-900 p-4 border border-zinc-800">
                        <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-500">Administrator</p>
                        <p class="mt-1 text-sm font-semibold truncate text-white">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] font-mono text-zinc-600">{{ Auth::user()->email }}</p>
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
        <div class="sticky top-0 z-40 flex items-center gap-x-6 bg-zinc-950 px-4 py-4 shadow-sm sm:px-6 lg:hidden">
            <div class="flex-1 font-display text-lg font-bold tracking-tight text-white">SurveyKita <span class="text-[10px] font-mono text-zinc-500 ml-2">ADMIN</span></div>
            <form method="POST" action="{{ route('logout') }}" class="contents">
                @csrf
                <button type="submit" class="text-zinc-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" /></svg>
                </button>
            </form>
        </div>

        {{-- Main Content --}}
        <main class="lg:pl-72 flex-1 w-0">
            <div class="px-4 py-8 sm:px-6 lg:px-12 max-w-full mx-auto overflow-hidden">
                <header class="mb-10 animate-reveal">
                    @if($eyebrow)
                        <p class="mb-2 text-xs font-bold uppercase tracking-[0.2em] text-zinc-500">{{ $eyebrow }}</p>
                    @endif
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <h1 class="font-display text-3xl font-bold tracking-tight text-zinc-950 sm:text-4xl leading-tight">
                            {{ $heading ?? 'Dashboard Admin' }}
                        </h1>
                        {{ $actions ?? '' }}
                    </div>
                </header>

                <div class="animate-reveal [animation-delay:100ms]">
                    <x-ui.alert />
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>
</x-layouts.app>
