<x-layouts.guest title="Google Login Ditolak - SurveyKita">
    <x-card heading="Google Login Ditolak" subheading="SurveyKita hanya menerima akun Google mahasiswa Universitas Mulia.">
        <x-alert type="error" :message="session('error') ?? 'Gunakan email @students.universitasmulia.ac.id.'" />

        <x-button href="{{ route('login') }}">Kembali ke Login</x-button>
    </x-card>
</x-layouts.guest>
