<x-layouts.app :title="$title ?? 'Masuk - SurveyKita'">
    <div class="flex min-h-full">
        {{-- Left Side: Marketing/Context --}}
        <div class="hidden lg:flex lg:flex-1 lg:flex-col lg:justify-center lg:bg-zinc-900 lg:px-12 lg:text-white">
            <div class="max-w-md mx-auto">
                <a href="/" class="font-display text-3xl font-bold tracking-tight">SurveyKita</a>
                <p class="mt-8 text-lg text-zinc-400">
                    Suara Anda membantu kami membangun pengalaman akademik yang lebih baik.
                </p>
                <div class="mt-12 space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-6 h-6 rounded-full border border-zinc-700 flex items-center justify-center text-xs font-mono text-zinc-500">01</div>
                        <div>
                            <h3 class="text-sm font-semibold">Aspirasi Berdampak</h3>
                            <p class="mt-1 text-sm text-zinc-500">Setiap masukan yang Anda berikan menjadi fondasi utama dalam pengambilan kebijakan dan peningkatan fasilitas kampus.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-6 h-6 rounded-full border border-zinc-700 flex items-center justify-center text-xs font-mono text-zinc-500">02</div>
                        <div>
                            <h3 class="text-sm font-semibold">Berkelanjutan & Terarah</h3>
                            <p class="mt-1 text-sm text-zinc-500">Hasil evaluasi diolah secara berkala untuk menciptakan lingkungan akademik yang adaptif dan terus berkembang.</p>
                        </div>
                    </div>

                </div>
                <div class="mt-24 pt-8 border-t border-zinc-800">
                    <p class="text-xs text-zinc-600 font-mono tracking-widest uppercase">&copy; {{ date('Y') }} Kelompok Tiga</p>
                </div>
            </div>
        </div>

        {{-- Right Side: Login Card --}}
        <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24 bg-white">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <div class="lg:hidden mb-12">
                    <span class="font-display text-2xl font-bold tracking-tight text-zinc-950">SurveyKita</span>
                </div>

                <div>
                    <h2 class="text-2xl font-semibold tracking-tight text-zinc-950">Selamat Datang Kembali</h2>
                    <p class="mt-2 text-sm text-zinc-500">Gunakan akun Anda untuk masuk ke dashboard.</p>
                </div>

                <div class="mt-10">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
