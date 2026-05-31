@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between gap-4 text-sm">
        <div class="flex flex-1 justify-between sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="inline-flex min-h-10 items-center border border-zinc-200 bg-zinc-100 px-4 py-2 font-medium text-zinc-400">Sebelumnya</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex min-h-10 items-center border border-zinc-300 bg-white px-4 py-2 font-semibold text-zinc-950 transition-colors hover:border-zinc-950">Sebelumnya</a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex min-h-10 items-center border border-zinc-300 bg-white px-4 py-2 font-semibold text-zinc-950 transition-colors hover:border-zinc-950">Berikutnya</a>
            @else
                <span class="inline-flex min-h-10 items-center border border-zinc-200 bg-zinc-100 px-4 py-2 font-medium text-zinc-400">Berikutnya</span>
            @endif
        </div>

        <div class="hidden w-full sm:flex sm:items-center sm:justify-between">
            <p class="text-sm text-zinc-600">
                Menampilkan
                <span class="font-semibold text-zinc-950">{{ $paginator->firstItem() }}</span>
                sampai
                <span class="font-semibold text-zinc-950">{{ $paginator->lastItem() }}</span>
                dari
                <span class="font-semibold text-zinc-950">{{ $paginator->total() }}</span>
                data
            </p>

            <div class="flex items-center gap-px border border-zinc-200 bg-zinc-200">
                @if ($paginator->onFirstPage())
                    <span aria-disabled="true" aria-label="Sebelumnya" class="inline-flex min-h-10 items-center bg-zinc-100 px-3 py-2 font-medium text-zinc-400">Sebelumnya</span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Sebelumnya" class="inline-flex min-h-10 items-center bg-white px-3 py-2 font-semibold text-zinc-950 transition-colors hover:bg-zinc-50">Sebelumnya</a>
                @endif

                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span aria-disabled="true" class="inline-flex min-h-10 items-center bg-white px-3 py-2 font-medium text-zinc-500">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page" class="inline-flex min-h-10 items-center bg-zinc-950 px-3 py-2 font-semibold text-white">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="inline-flex min-h-10 items-center bg-white px-3 py-2 font-semibold text-zinc-950 transition-colors hover:bg-zinc-50">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Berikutnya" class="inline-flex min-h-10 items-center bg-white px-3 py-2 font-semibold text-zinc-950 transition-colors hover:bg-zinc-50">Berikutnya</a>
                @else
                    <span aria-disabled="true" aria-label="Berikutnya" class="inline-flex min-h-10 items-center bg-zinc-100 px-3 py-2 font-medium text-zinc-400">Berikutnya</span>
                @endif
            </div>
        </div>
    </nav>
@endif
