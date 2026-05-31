@props(['type' => null, 'message' => null])

@php
    $flashType = $type ?? (session('success') ? 'success' : (session('error') ? 'error' : (session('status') ? 'status' : null)));
    $flashMessage = $message ?? session('success') ?? session('error') ?? session('status');

    $classes = [
        'success' => 'border-emerald-200 bg-emerald-50/50 text-emerald-800',
        'error' => 'border-red-200 bg-red-50/50 text-red-800',
        'status' => 'border-zinc-200 bg-zinc-50 text-zinc-800',
    ];
@endphp

@if ($flashMessage)
    <div {{ $attributes->merge(['class' => 'mb-6 rounded-lg border px-4 py-3.5 text-sm font-medium '.$classes[$flashType]]) }} role="status">
        {{ $flashMessage }}
    </div>
@endif
