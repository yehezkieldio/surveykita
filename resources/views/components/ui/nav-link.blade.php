@props(['active' => false, 'icon' => null])

@php
$classes = ($active ?? false)
    ? 'flex items-center gap-x-3 rounded-md bg-zinc-950 p-2.5 text-sm font-medium leading-6 text-white'
    : 'flex items-center gap-x-3 rounded-md p-2.5 text-sm font-medium leading-6 text-zinc-500 hover:bg-zinc-50 hover:text-zinc-950 transition-colors';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon === 'house')
        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
        </svg>
    @elseif($icon === 'clipboard-document-list')
        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .415.162.798.425 1.081.263.283.646.445 1.075.445.429 0 .812-.162 1.095-.445.283-.283.445-.666.445-1.081 0-.231-.035-.454-.1-.664m-5.801 0A22.509 22.509 0 0112 2.25c2.768 0 5.36.495 7.75 1.392m-7.75 0a22.509 22.509 0 00-7.75 1.392" />
        </svg>
    @elseif($icon === 'clock')
        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    @elseif($icon === 'user')
        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
        </svg>
    @endif
    {{ $slot }}
</a>
