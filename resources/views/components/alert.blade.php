@props(['type' => null, 'message' => null])

@php
    $flashType = $type ?? (session('success') ? 'success' : (session('error') ? 'error' : (session('status') ? 'status' : null)));
    $flashMessage = $message ?? session('success') ?? session('error') ?? session('status');

    $classes = [
        'success' => 'border-[#346538]/20 bg-[#EDF3EC] text-[#346538]',
        'error' => 'border-[#9F2F2D]/20 bg-[#FDEBEC] text-[#9F2F2D]',
        'status' => 'border-[#1F6C9F]/20 bg-[#E1F3FE] text-[#1F6C9F]',
    ];
@endphp

@if ($flashMessage)
    <div {{ $attributes->merge(['class' => 'mb-6 rounded-none border px-4 py-3 text-xs font-mono uppercase tracking-wider '.$classes[$flashType]]) }} role="status">
        {{ $flashMessage }}
    </div>
@endif
