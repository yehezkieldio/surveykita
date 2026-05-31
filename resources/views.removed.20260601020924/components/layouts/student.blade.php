@include('layouts.student', [
    'slot' => $slot,
    'title' => $title ?? null,
    'eyebrow' => $eyebrow ?? null,
    'heading' => $heading ?? null,
])
