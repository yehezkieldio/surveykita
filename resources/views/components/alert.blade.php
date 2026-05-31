@props(['type' => null, 'message' => null])

@php
    $flashType = $type ?? (session('success') ? 'success' : (session('error') ? 'error' : (session('status') ? 'status' : null)));
    $flashMessage = $message ?? session('success') ?? session('error') ?? session('status');

    $classes = [
        'success' => 'border-emerald-200 bg-emerald-50 text-emerald-900',
        'error' => 'border-red-200 bg-red-50 text-red-900',
        'status' => 'border-teal-200 bg-teal-50 text-teal-900',
    ];
@endphp

@if ($flashMessage)
    <div {{ $attributes->merge(['class' => 'mb-4 rounded-md border px-4 py-3 text-sm '.$classes[$flashType]]) }} role="status">
        {{ $flashMessage }}
    </div>
@endif
