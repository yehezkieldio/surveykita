<x-layouts.guest title="Google Login Ditolak - SurveyKita">
    <div class="space-y-6">
        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-red-50 text-red-600">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
            </svg>
        </div>
        
        <div>
            <h2 class="text-xl font-bold tracking-tight text-zinc-950">Akses Google Ditolak</h2>
            <p class="mt-2 text-sm text-zinc-600">
                SurveyKita saat ini hanya menerima autentikasi melalui email institusi yang terdaftar.
            </p>
        </div>

        <div class="p-4 bg-red-50 border border-red-100 text-sm text-red-800">
            {{ session('error') ?? 'Gunakan akun Google Workspace institusi Anda.' }}
        </div>

        <div class="pt-4">
            <x-ui.button href="{{ route('login') }}" variant="secondary" class="w-full">
                Kembali ke Login
                <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
            </x-ui.button>
        </div>
    </div>
</x-layouts.guest>
