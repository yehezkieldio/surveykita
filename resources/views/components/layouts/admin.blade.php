@include('layouts.admin', [
    'slot' => $slot,
    'title' => $title ?? null,
    'eyebrow' => $eyebrow ?? null,
    'heading' => $heading ?? null,
])
