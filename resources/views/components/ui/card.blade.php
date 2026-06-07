<div {{ $attributes->merge(['class' => 'bg-white border border-zinc-200']) }}>
    @if($title ?? null)
        <div class="border-b border-zinc-100 px-6 py-4">
            <h3 class="text-sm font-semibold text-zinc-950">{{ $title }}</h3>
            @if($description ?? null)
                <p class="mt-1 text-xs text-zinc-500">{{ $description }}</p>
            @endif
        </div>
    @endif

    <div @class(['px-6 py-5' => !($noPadding ?? false)])>
        {{ $slot }}
    </div>

    @if($footer ?? null)
        <div class="border-t border-zinc-100 bg-zinc-50/50 px-6 py-4">
            {{ $footer }}
        </div>
    @endif
</div>
