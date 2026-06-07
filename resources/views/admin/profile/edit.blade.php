<x-layouts.admin title="Profil Saya" heading="Profil Saya">
    <div class="max-w-2xl">
        @if (session('success'))
            <x-ui.alert type="success" class="mb-6">
                {{ session('success') }}
            </x-ui.alert>
        @endif

        <x-ui.card title="Informasi Profil" description="Perbarui informasi profil dan alamat email akun Anda.">
            <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-medium text-zinc-700">Nama</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                        class="mt-1 block w-full border border-zinc-300 px-3 py-2 text-sm focus:border-zinc-950 focus:outline-none transition-colors" required>
                    <x-ui.error field="name" />
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-zinc-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                        class="mt-1 block w-full border border-zinc-300 px-3 py-2 text-sm focus:border-zinc-950 focus:outline-none transition-colors" required>
                    <x-ui.error field="email" />
                </div>

                <div class="pt-6 border-t border-zinc-100">
                    <h3 class="text-sm font-semibold text-zinc-950">Perbarui Kata Sandi</h3>
                    <p class="mt-1 text-xs text-zinc-500">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk tetap aman.</p>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-zinc-700">Kata Sandi Baru</label>
                    <input type="password" name="password" id="password" 
                        class="mt-1 block w-full border border-zinc-300 px-3 py-2 text-sm focus:border-zinc-950 focus:outline-none transition-colors">
                    <x-ui.error field="password" />
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-zinc-700">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                        class="mt-1 block w-full border border-zinc-300 px-3 py-2 text-sm focus:border-zinc-950 focus:outline-none transition-colors">
                </div>

                <div class="flex justify-end pt-2">
                    <x-ui.button type="submit">
                        Simpan Perubahan
                    </x-ui.button>
                </div>
            </form>
        </x-ui.card>
    </div>
</x-layouts.admin>
