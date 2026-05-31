@props(['variant' => 'neutral'])

@php
    $variants = [
        'success' => 'bg-[#EDF3EC] text-[#346538] border-[#346538]/10',
        'warning' => 'bg-[#FBF3DB] text-[#956400] border-[#956400]/10',
        'danger' => 'bg-[#FDEBEC] text-[#9F2F2D] border-[#9F2F2D]/10',
        'info' => 'bg-[#E1F3FE] text-[#1F6C9F] border-[#1F6C9F]/10',
        'neutral' => 'bg-[#F7F6F3] text-[#787774] border-[#787774]/10',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-none px-2 py-0.5 text-[9px] font-mono uppercase tracking-wider border '.$variants[$variant]]) }}>
    {{ $slot }}
</span>
