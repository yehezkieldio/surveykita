<x-layouts.guest title="Akses Ditolak - SurveyKita">
    <x-card heading="Akses Ditolak" subheading="Akun Anda tidak memiliki izin untuk membuka halaman ini.">
        <x-alert type="error" message="Silakan masuk dengan akun yang sesuai." />

        @if (Route::has('login'))
            <x-button href="{{ route('login') }}">Kembali ke Login</x-button>
        @endif
    </x-card>
</x-layouts.guest>
