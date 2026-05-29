<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Faskes Sibolga — Beranda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif']
                    },
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .hero-gradient {
            background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 35%, #0d9488 70%, #0891b2 100%);
            background-size: 300% 300%;
            animation: gradientShift 8s ease infinite;
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .blob {
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.15;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) scale(1);
            }

            50% {
                transform: translateY(-20px) scale(1.04);
            }
        }

        .stat-card {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -8px rgba(0, 0, 0, 0.12);
        }

        .table-row {
            transition: background 0.15s ease;
        }

        .table-row:hover td {
            background-color: #eff6ff;
        }

        .badge-negeri {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-swasta {
            background: #fce7f3;
            color: #9d174d;
        }

        .badge-bpjs {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-nonbpjs {
            background: #fee2e2;
            color: #991b1b;
        }

        .nav-link {
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            right: 0;
            height: 2px;
            background: #2563eb;
            border-radius: 99px;
            transform: scaleX(0);
            transition: transform 0.2s ease;
        }

        .nav-link:hover::after {
            transform: scaleX(1);
        }

        .nav-link.active::after {
            transform: scaleX(1);
        }

        /* Peta tombol shimmer */
        .btn-peta {
            position: relative;
            overflow: hidden;
            background: linear-gradient(90deg, #2563eb, #0891b2);
        }

        .btn-peta::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 60%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
            animation: shimmer 2.5s infinite;
        }

        @keyframes shimmer {
            to {
                left: 150%;
            }
        }

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
</head>

<body class="bg-slate-50 text-slate-800">

    {{-- ══════════ NAVBAR ══════════ --}}
    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
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

                {{-- Desktop nav --}}
                <div class="hidden md:flex items-center gap-7 text-sm font-medium text-slate-600">
                    <a href="{{ route('homepage') }}" class="nav-link active text-blue-600 transition-colors">
                        Beranda
                    </a>
                    <a href="{{ route('peta') }}" class="nav-link hover:text-blue-600 transition-colors">
                        Peta Interaktif
                    </a>
                    <a href="{{ route('faskes.index') }}" class="nav-link hover:text-blue-600 transition-colors">
                        Data Faskes
                    </a>
                    <a href="{{ route('profil') }}" class="nav-link hover:text-blue-600 transition-colors">
                        Profil
                    </a>
                    <a href="{{ route('faskes.create') }}"
                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-blue-600 text-white font-semibold hover:bg-blue-700 transition-colors text-xs shadow-md">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Faskes
                    </a>
                </div>

                {{-- Mobile toggle --}}
                <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')"
                    class="md:hidden p-2 rounded-lg hover:bg-slate-100 transition-colors">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            {{-- Mobile menu --}}
            <div id="mobile-menu" class="hidden md:hidden pb-3 pt-2 border-t border-slate-100 space-y-1">
                <a href="{{ route('homepage') }}"
                    class="block px-3 py-2 rounded-lg text-sm font-semibold text-blue-600 bg-blue-50">Beranda</a>
                <a href="{{ route('peta') }}"
                    class="block px-3 py-2 rounded-lg text-sm text-slate-700 hover:bg-slate-50">Peta Interaktif</a>
                <a href="{{ route('faskes.index') }}"
                    class="block px-3 py-2 rounded-lg text-sm text-slate-700 hover:bg-slate-50">Data Faskes</a>
                <a href="{{ route('faskes.create') }}"
                    class="block px-3 py-2 rounded-lg text-sm font-semibold text-blue-600 hover:bg-blue-50">+ Tambah
                    Faskes</a>
            </div>
        </div>
    </nav>

    {{-- Alert session --}}
    @if (session('success'))
        <div id="alert-success" class="fixed top-5 right-5 z-[9999] max-w-sm w-full animate-slideIn">
            <div class="bg-white border border-emerald-200 rounded-2xl shadow-xl p-4 flex items-start gap-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-slate-800">Berhasil!</p>
                    <p class="text-xs text-slate-500 mt-0.5">{{ session('success') }}</p>
                </div>
                <button onclick="this.closest('#alert-success').remove()"
                    class="text-slate-300 hover:text-slate-500">✕</button>
            </div>
        </div>
        <script>
            setTimeout(() => {
                const el = document.getElementById('alert-success');
                if (el) {
                    el.style.opacity = '0';
                    el.style.transition = 'opacity 0.4s';
                    setTimeout(() => el.remove(), 400);
                }
            }, 4000);
        </script>
    @endif

    {{-- ══════════ HERO ══════════ --}}
    <section class="hero-gradient relative overflow-hidden py-24 md:py-32">
        <div class="blob absolute -top-20 -left-20 w-80 h-80 bg-white"></div>
        <div class="blob absolute bottom-0 right-0 w-96 h-96 bg-teal-400" style="animation-delay:3s"></div>
        <div class="blob absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-sky-300"
            style="animation-delay:1.5s"></div>

        <div class="relative max-w-4xl mx-auto px-6 text-center">
            <span
                class="inline-block mb-4 px-4 py-1.5 rounded-full bg-white/20 text-white text-xs font-semibold tracking-wider uppercase backdrop-blur-sm border border-white/30">
                🏥 Sistem Informasi Geografi
            </span>
            <h1 class="text-4xl md:text-6xl font-extrabold text-white leading-tight mb-5 drop-shadow-lg">
                Fasilitas Kesehatan<br>
                <span class="text-teal-300">Kota Sibolga</span>
            </h1>
            <p class="text-blue-100 text-lg md:text-xl leading-relaxed max-w-2xl mx-auto mb-10">
                Direktori lengkap fasilitas kesehatan di Kota Sibolga —
                terintegrasi dengan peta interaktif untuk memudahkan akses layanan kesehatan.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="#daftar"
                    class="px-7 py-3 rounded-full bg-white text-blue-700 font-bold shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">
                    Lihat Daftar Faskes
                </a>
                <a href="{{ route('peta') }}"
                    class="btn-peta px-7 py-3 rounded-full text-white font-semibold transition-all flex items-center justify-center gap-2 shadow-lg hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                    Buka Peta Interaktif
                </a>
            </div>
        </div>
    </section>

    {{-- ══════════ STAT CARDS ══════════ --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

            {{-- Total Faskes → index --}}
            <a href="{{ route('faskes.index') }}"
                class="stat-card bg-white rounded-2xl shadow-md border border-slate-100 p-5 block group">
                <div
                    class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center mb-3 group-hover:bg-blue-100 transition-colors">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <p class="text-2xl font-extrabold text-slate-800">{{ number_format($totalFaskes) }}</p>
                <p class="text-sm text-slate-500 mt-0.5">Total Faskes</p>
                <p class="text-xs text-blue-500 mt-2 font-semibold group-hover:underline">Lihat semua →</p>
            </a>

            {{-- Faskes Aktif → index filter aktif --}}
            <a href="{{ route('faskes.index') }}?status=Aktif"
                class="stat-card bg-white rounded-2xl shadow-md border border-slate-100 p-5 block group">
                <div
                    class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center mb-3 group-hover:bg-emerald-100 transition-colors">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-2xl font-extrabold text-slate-800">{{ number_format($totalAktif) }}</p>
                <p class="text-sm text-slate-500 mt-0.5">Faskes Aktif</p>
                <p class="text-xs text-emerald-500 mt-2 font-semibold group-hover:underline">Filter aktif →</p>
            </a>

            {{-- BPJS → index filter bpjs --}}
            <a href="{{ route('faskes.index') }}?bpjs=1"
                class="stat-card bg-white rounded-2xl shadow-md border border-slate-100 p-5 block group">
                <div
                    class="w-11 h-11 rounded-xl bg-indigo-50 flex items-center justify-center mb-3 group-hover:bg-indigo-100 transition-colors">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <p class="text-2xl font-extrabold text-slate-800">{{ number_format($totalBpjs) }}</p>
                <p class="text-sm text-slate-500 mt-0.5">Melayani BPJS</p>
                <p class="text-xs text-indigo-500 mt-2 font-semibold group-hover:underline">Filter BPJS →</p>
            </a>

            {{-- Jenis → peta --}}
            <a href="{{ route('peta') }}"
                class="stat-card bg-white rounded-2xl shadow-md border border-slate-100 p-5 block group">
                <div
                    class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center mb-3 group-hover:bg-amber-100 transition-colors">
                    <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                </div>
                <p class="text-2xl font-extrabold text-slate-800">{{ number_format($totalJenis) }}</p>
                <p class="text-sm text-slate-500 mt-0.5">Jenis Fasilitas</p>
                <p class="text-xs text-amber-500 mt-2 font-semibold group-hover:underline">Lihat di peta →</p>
            </a>

        </div>
    </section>

    {{-- ══════════ JENIS FASILITAS ══════════ --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-800">Jenis Fasilitas</h2>
                <p class="text-slate-500 text-sm mt-1">Pilih kategori untuk melihat daftar faskes</p>
            </div>
            <a href="{{ route('peta') }}"
                class="text-sm font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1 transition-colors">
                Lihat semua di peta
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            @forelse($jenisFasilitas as $jenis)
                {{-- Klik jenis → halaman index filter by jenis --}}
                <a href="{{ route('faskes.index') }}?jenis={{ $jenis->id }}"
                    class="group bg-white rounded-2xl border border-slate-100 p-4 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-200 text-center">
                    <div class="w-12 h-12 rounded-xl mx-auto mb-3 flex items-center justify-center text-2xl shadow-sm"
                        style="background-color: {{ $jenis->warna_marker ?? '#3b82f6' }}22;">
                        {!! $jenis->ikon ?? '🏥' !!}
                    </div>
                    <p
                        class="text-sm font-semibold text-slate-700 group-hover:text-blue-600 transition-colors leading-snug">
                        {{ $jenis->nama_jenis }}
                    </p>
                    <p class="mt-1 text-xs text-slate-400">{{ $jenis->fasilitas_kesehatan_count }} faskes</p>
                    <p
                        class="mt-2 text-xs font-semibold text-blue-500 opacity-0 group-hover:opacity-100 transition-opacity">
                        Lihat daftar →
                    </p>
                </a>
            @empty
                <p class="col-span-full text-slate-400 text-sm">Belum ada jenis fasilitas.</p>
            @endforelse
        </div>
    </section>

    {{-- ══════════ DAFTAR FASKES ══════════ --}}
    <section id="daftar" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16 mb-20">

        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-800">Daftar Fasilitas Kesehatan</h2>
                <p class="text-slate-500 text-sm mt-1">Klik tombol peta untuk melihat lokasi faskes di peta interaktif
                </p>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <a href="{{ route('faskes.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-full border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    Kelola Data
                </a>
                <a href="{{ route('peta') }}"
                    class="btn-peta inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-white text-sm font-bold shadow-md hover:-translate-y-0.5 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                    Buka Peta
                </a>
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-700 to-blue-800 text-white">
                            <th class="text-left px-5 py-4 font-semibold text-xs uppercase tracking-wider w-10">No</th>
                            <th class="text-left px-5 py-4 font-semibold text-xs uppercase tracking-wider">Nama Faskes
                            </th>
                            <th class="text-left px-5 py-4 font-semibold text-xs uppercase tracking-wider">Jenis</th>
                            <th class="text-left px-5 py-4 font-semibold text-xs uppercase tracking-wider">Kecamatan
                            </th>
                            <th class="text-left px-5 py-4 font-semibold text-xs uppercase tracking-wider">Kepemilikan
                            </th>
                            <th class="text-center px-5 py-4 font-semibold text-xs uppercase tracking-wider">BPJS</th>
                            <th class="text-center px-5 py-4 font-semibold text-xs uppercase tracking-wider">Lokasi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($faskes as $index => $item)
                            <tr class="table-row">
                                <td class="px-5 py-4 text-slate-400 font-medium text-xs">
                                    {{ $faskes->firstItem() + $index }}
                                </td>
                                <td class="px-5 py-4">
                                    <p class="font-semibold text-slate-800">{{ $item->nama_faskes }}</p>
                                    <p class="text-xs text-slate-400 mt-0.5 truncate max-w-xs">{{ $item->alamat }}</p>
                                </td>
                                <td class="px-5 py-4">
                                    {{-- Klik jenis → filter index --}}
                                    <a href="{{ route('faskes.index') }}?jenis={{ $item->jenis_faskes_id }}"
                                        class="inline-block px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 hover:bg-blue-100 transition-colors">
                                        {{ $item->jenisFasilitas->nama_jenis ?? '-' }}
                                    </a>
                                </td>
                                <td class="px-5 py-4 text-slate-600 text-xs">{{ $item->kecamatan }}</td>
                                <td class="px-5 py-4">
                                    @php $kep = strtolower($item->status_kepemilikan ?? ''); @endphp
                                    @if (str_contains($kep, 'negeri') || str_contains($kep, 'pemerintah'))
                                        <span
                                            class="badge-negeri inline-block px-2.5 py-1 rounded-full text-xs font-semibold">
                                            {{ $item->status_kepemilikan }}
                                        </span>
                                    @else
                                        <span
                                            class="badge-swasta inline-block px-2.5 py-1 rounded-full text-xs font-semibold">
                                            {{ $item->status_kepemilikan ?? '-' }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-center">
                                    @if ($item->bpjs)
                                        <span
                                            class="badge-bpjs inline-block px-2.5 py-1 rounded-full text-xs font-semibold">✓
                                            BPJS</span>
                                    @else
                                        <span
                                            class="badge-nonbpjs inline-block px-2.5 py-1 rounded-full text-xs font-semibold">Non
                                            BPJS</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-center">
                                    {{-- Tombol lihat di peta — bawa lat/lon ke halaman peta --}}
                                    @if ($item->latitude && $item->longitude)
                                        <a href="{{ route('peta') }}?lat={{ $item->latitude }}&lon={{ $item->longitude }}&id={{ $item->id }}&nama={{ urlencode($item->nama_faskes) }}"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold text-white transition-all hover:-translate-y-0.5 shadow-sm"
                                            style="background: {{ $item->jenisFasilitas->warna_marker ?? '#2563eb' }};"
                                            title="Lihat {{ $item->nama_faskes }} di peta">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            Peta
                                        </a>
                                    @else
                                        <span
                                            class="inline-block px-3 py-1.5 rounded-full text-xs text-slate-400 bg-slate-100">
                                            Belum ada koordinat
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-14 text-center text-slate-400">
                                    <div class="text-4xl mb-3">🏥</div>
                                    <p class="font-semibold text-slate-600 mb-3">Belum ada data fasilitas kesehatan</p>
                                    <a href="{{ route('faskes.create') }}"
                                        class="inline-block px-5 py-2 rounded-full bg-blue-600 text-white text-xs font-bold hover:bg-blue-700 transition-colors">
                                        + Tambah Faskes Pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($faskes->hasPages())
                <div
                    class="px-5 py-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <p class="text-xs text-slate-400">
                        Menampilkan {{ $faskes->firstItem() }}–{{ $faskes->lastItem() }} dari {{ $faskes->total() }}
                        faskes
                    </p>
                    <div class="flex items-center gap-1">
                        @if ($faskes->onFirstPage())
                            <span class="px-3 py-1.5 rounded-lg text-xs text-slate-300 cursor-not-allowed">‹
                                Prev</span>
                        @else
                            <a href="{{ $faskes->previousPageUrl() }}"
                                class="px-3 py-1.5 rounded-lg text-xs text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition-colors">‹
                                Prev</a>
                        @endif

                        @foreach ($faskes->getUrlRange(max(1, $faskes->currentPage() - 2), min($faskes->lastPage(), $faskes->currentPage() + 2)) as $page => $url)
                            @if ($page == $faskes->currentPage())
                                <span
                                    class="px-3 py-1.5 rounded-lg text-xs font-bold bg-blue-600 text-white">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}"
                                    class="px-3 py-1.5 rounded-lg text-xs text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition-colors">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if ($faskes->hasMorePages())
                            <a href="{{ $faskes->nextPageUrl() }}"
                                class="px-3 py-1.5 rounded-lg text-xs text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition-colors">Next
                                ›</a>
                        @else
                            <span class="px-3 py-1.5 rounded-lg text-xs text-slate-300 cursor-not-allowed">Next
                                ›</span>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Footer tabel --}}
            <div class="px-5 py-3 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                <p class="text-xs text-slate-400">Data diperbarui secara real-time dari database</p>
                <a href="{{ route('faskes.index') }}"
                    class="text-xs font-semibold text-blue-600 hover:underline transition-colors">
                    Lihat & kelola semua data →
                </a>
            </div>
        </div>
    </section>

    {{-- ══════════ FOOTER ══════════ --}}
    <footer class="bg-slate-800 text-slate-400 text-sm py-10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row items-start justify-between gap-8 mb-8">
                <div>
                    <a href="{{ route('homepage') }}" class="flex items-center gap-2 mb-3">
                        <div
                            class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-teal-400 flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <span class="text-white font-bold text-base">Faskes Sibolga</span>
                    </a>
                    <p class="text-xs text-slate-500 max-w-xs leading-relaxed">
                        Sistem Informasi Geografis Fasilitas Kesehatan Kota Sibolga, Sumatra Utara.
                    </p>
                </div>
                <div class="grid grid-cols-2 gap-x-12 gap-y-2 text-xs">
                    <div>
                        <p class="text-slate-300 font-bold mb-2 uppercase tracking-wider text-xs">Navigasi</p>
                        <div class="space-y-1.5">
                            <a href="{{ route('homepage') }}"
                                class="block hover:text-white transition-colors">Beranda</a>
                            <a href="{{ route('peta') }}" class="block hover:text-white transition-colors">Peta
                                Interaktif</a>
                            <a href="{{ route('faskes.index') }}"
                                class="block hover:text-white transition-colors">Data Faskes</a>
                        </div>
                    </div>
                    <div>
                        <p class="text-slate-300 font-bold mb-2 uppercase tracking-wider text-xs">Kelola</p>
                        <div class="space-y-1.5">
                            <a href="{{ route('faskes.create') }}"
                                class="block hover:text-white transition-colors">Tambah Faskes</a>
                            <a href="{{ route('faskes.index') }}?status=Aktif"
                                class="block hover:text-white transition-colors">Faskes Aktif</a>
                            <a href="{{ route('faskes.index') }}?bpjs=1"
                                class="block hover:text-white transition-colors">Faskes BPJS</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-t border-slate-700 pt-6 flex flex-col sm:flex-row items-center justify-between gap-2">
                <p class="text-xs">© {{ date('Y') }} Sistem Informasi Fasilitas Kesehatan — Kota Sibolga</p>
                <p class="text-xs text-slate-500">Dibuat oleh <span class="text-white font-semibold">Imanuel Reformata
                        Hulu</span> · Tugas Akhir Query PostgreSQL TRPL</p>
            </div>
        </div>
    </footer>

</body>

</html>
