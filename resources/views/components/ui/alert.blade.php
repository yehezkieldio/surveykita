@if (session('success'))
    <div class="mb-8 flex items-start gap-x-3 border border-teal-100 bg-teal-50/50 p-4 text-sm text-teal-800 animate-reveal">
        <svg class="h-5 w-5 shrink-0 text-teal-500" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
        </svg>
        <p class="min-w-0 leading-6">{{ session('success') }}</p>
    </div>
@endif

@if (session('error'))
    <div class="mb-8 flex items-start gap-x-3 border border-red-100 bg-red-50/50 p-4 text-sm text-red-800 animate-reveal">
        <svg class="h-5 w-5 shrink-0 text-red-500" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
        </svg>
        <p class="min-w-0 leading-6">{{ session('error') }}</p>
    </div>
@endif

@if (session('status'))
    <div class="mb-8 flex items-start gap-x-3 border border-zinc-200 bg-white p-4 text-sm text-zinc-800 animate-reveal">
        <svg class="h-5 w-5 shrink-0 text-zinc-400" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.25v2.75a.75.75 0 001.5 0v-3.75A.75.75 0 0010 9H9z" clip-rule="evenodd" />
        </svg>
        <p class="min-w-0 leading-6">{{ session('status') }}</p>
    </div>
@endif
