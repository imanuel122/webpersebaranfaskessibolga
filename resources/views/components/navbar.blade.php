{{-- resources/views/components/navbar.blade.php --}}
<nav class="sticky top-0 z-[999] bg-white/80 backdrop-blur-md border-b border-slate-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <a href="{{ route('homepage') }}" class="flex items-center gap-3">
                <div
                    class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-600 to-teal-500 flex items-center justify-center shadow-md">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-base font-extrabold text-slate-800 leading-none">Faskes Sibolga</p>
                    <p class="text-xs text-slate-400 leading-none mt-0.5">Kota Sibolga, Sumatra Utara</p>
                </div>
            </a>
            <div class="hidden md:flex items-center gap-6 text-sm font-medium text-slate-600">
                <a href="{{ route('homepage') }}"
                    class="hover:text-blue-600 transition-colors {{ request()->routeIs('homepage') ? 'text-blue-600 font-semibold' : '' }}">Beranda</a>
                <a href="{{ route('peta') }}"
                    class="hover:text-blue-600 transition-colors {{ request()->routeIs('peta') ? 'text-blue-600 font-semibold' : '' }}">Peta</a>
                <a href="{{ route('faskes.index') }}"
                    class="hover:text-blue-600 transition-colors {{ request()->routeIs('faskes.*') ? 'text-blue-600 font-semibold' : '' }}">Data
                    Faskes</a>
                <a href="{{ route('profil') }}"
                    class="hover:text-blue-600 transition-colors {{ request()->routeIs('profil*') ? 'text-blue-600 font-semibold' : '' }}">Profil</a>
                <a href="{{ route('faskes.create') }}"
                    class="px-4 py-1.5 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition-colors flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Faskes
                </a>
            </div>
        </div>
    </div>
</nav>

{{-- Alert / Toast --}}
@if (session('success'))
    <div id="alert-success" class="fixed top-5 right-5 z-[9999] max-w-sm w-full">
        <div
            class="bg-white border border-emerald-200 rounded-2xl shadow-xl p-4 flex items-start gap-3 animate-slideIn">
            <div class="w-9 h-9 rounded-xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-slate-800">Berhasil!</p>
                <p class="text-xs text-slate-500 mt-0.5">{{ session('success') }}</p>
            </div>
            <button onclick="document.getElementById('alert-success').remove()"
                class="text-slate-300 hover:text-slate-500 flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
@endif

@if (session('error'))
    <div id="alert-error" class="fixed top-5 right-5 z-[9999] max-w-sm w-full">
        <div class="bg-white border border-red-200 rounded-2xl shadow-xl p-4 flex items-start gap-3 animate-slideIn">
            <div class="w-9 h-9 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-slate-800">Gagal!</p>
                <p class="text-xs text-slate-500 mt-0.5">{{ session('error') }}</p>
            </div>
            <button onclick="document.getElementById('alert-error').remove()"
                class="text-slate-300 hover:text-slate-500 flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
@endif

<style>
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(100%);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .animate-slideIn {
        animation: slideIn 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
</style>

<script>
    // Auto dismiss alert setelah 4 detik
    setTimeout(() => {
        ['alert-success', 'alert-error'].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.style.opacity = '0';
                el.style.transition = 'opacity 0.4s';
                setTimeout(() => el.remove(), 400);
            }
        });
    }, 4000);
</script>
