@props(['type' => null, 'message' => null])

@php
    $flashType = $type ?? (session('success') ? 'success' : (session('error') ? 'error' : (session('status') ? 'status' : null)));
    $flashMessage = $message ?? session('success') ?? session('error') ?? session('status');

    $classes = [
        'success' => 'border-emerald-300 bg-emerald-50 text-emerald-900',
        'error' => 'border-red-300 bg-red-50 text-red-900',
        'status' => 'border-zinc-300 bg-white text-zinc-900',
    ];
@endphp

@if ($flashMessage)
    <div {{ $attributes->merge(['class' => 'mb-6 border px-4 py-3 text-sm font-medium '.$classes[$flashType]]) }} role="status">
        {{ $flashMessage }}
    </div>
@endif
