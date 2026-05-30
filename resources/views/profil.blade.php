<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profil Pengembang — Faskes Sibolga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Hero gradient — sama dengan homepage */
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

        /* Blobs — sama dengan homepage */
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

        /* Avatar ring */
        .avatar-ring {
            background: linear-gradient(135deg, #2563eb, #0d9488, #38bdf8);
            padding: 3px;
            border-radius: 50%;
        }

        .avatar-inner {
            background: white;
            border-radius: 50%;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* Skill bar */
        .skill-track {
            height: 8px;
            background: #e2e8f0;
            border-radius: 99px;
            overflow: hidden;
        }

        .skill-fill {
            height: 100%;
            border-radius: 99px;
            width: 0;
            transition: width 1.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Card hover */
        .hover-card {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .hover-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -8px rgba(0, 0, 0, 0.12);
        }

        /* Tech badge */
        .tech-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 99px;
            border: 1.5px solid #e2e8f0;
            background: white;
            font-size: 12px;
            font-weight: 600;
            color: #475569;
            transition: all 0.2s;
        }

        .tech-pill:hover {
            border-color: #2563eb;
            color: #2563eb;
            background: #eff6ff;
            transform: translateY(-2px);
        }

        /* Query code block */
        .code-block {
            background: #0f172a;
            border-radius: 14px;
            border: 1px solid #1e293b;
            overflow: hidden;
        }

        .code-header {
            background: #1e293b;
            padding: 10px 16px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .code-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        pre {
            padding: 16px;
            font-size: 12px;
            line-height: 1.7;
            color: #94a3b8;
            font-family: 'Courier New', monospace;
            overflow-x: auto;
        }

        .kw {
            color: #60a5fa;
        }

        /* keyword */
        .fn {
            color: #34d399;
        }

        /* function */
        .str {
            color: #fbbf24;
        }

        /* string */
        .cm {
            color: #475569;
        }

        /* comment */
        .num {
            color: #f472b6;
        }

        /* number */

        /* Reveal */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .reveal {
            opacity: 0;
            animation: fadeUp 0.6s ease forwards;
        }

        /* Stat hover */
        .stat-card {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -8px rgba(37, 99, 235, 0.15);
        }

        /* Nav link underline effect */
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
            transition: transform 0.2s;
        }

        .nav-link:hover::after {
            transform: scaleX(1);
        }

        .nav-link.active::after {
            transform: scaleX(1);
        }


        /* Responsive improvements */
        html {
            scroll-behavior: smooth;
        }

        img,
        svg {
            max-width: 100%;
        }

        @media (max-width: 640px) {
            .blob {
                filter: blur(55px);
                opacity: 0.12;
            }

            pre {
                font-size: 11px;
                padding: 14px;
                line-height: 1.65;
            }

            .code-header {
                padding: 9px 12px;
            }

            .tech-pill {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800">

    {{-- ══ NAVBAR RESPONSIVE ══ --}}
    <nav class="sticky top-0 z-[999] bg-white/90 backdrop-blur-md border-b border-slate-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('homepage') }}" class="flex items-center gap-3 min-w-0">
                    <div
                        class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-600 to-teal-500 flex items-center justify-center shadow-md flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm sm:text-base font-extrabold text-slate-800 leading-none truncate">Faskes
                            Sibolga</p>
                        <p class="text-[10px] sm:text-xs text-slate-400 leading-none mt-0.5 truncate">Kota Sibolga,
                            Sumatra Utara</p>
                    </div>
                </a>

                <div class="hidden lg:flex items-center gap-7 text-sm font-medium text-slate-600">
                    <a href="{{ route('homepage') }}" class="nav-link hover:text-blue-600 transition-colors">Beranda</a>
                    <a href="{{ route('peta') }}" class="nav-link hover:text-blue-600 transition-colors">Peta</a>
                    <a href="{{ route('faskes.index') }}" class="nav-link hover:text-blue-600 transition-colors">Data
                        Faskes</a>
                    <a href="{{ route('profil') }}" class="nav-link active text-blue-600 font-semibold">Profil</a>
                    <a href="{{ route('faskes.create') }}"
                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-blue-600 text-white font-semibold hover:bg-blue-700 transition-colors text-xs shadow-md">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Faskes
                    </a>
                </div>

                <button type="button" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')"
                    class="lg:hidden p-2 rounded-xl hover:bg-slate-100 transition-colors" aria-label="Buka menu">
                    <svg class="w-6 h-6 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <div id="mobile-menu" class="hidden lg:hidden pb-4 pt-3 border-t border-slate-100 space-y-1">
                <a href="{{ route('homepage') }}"
                    class="block px-3 py-2.5 rounded-xl text-sm text-slate-700 hover:bg-slate-50">Beranda</a>
                <a href="{{ route('peta') }}"
                    class="block px-3 py-2.5 rounded-xl text-sm text-slate-700 hover:bg-slate-50">Peta</a>
                <a href="{{ route('faskes.index') }}"
                    class="block px-3 py-2.5 rounded-xl text-sm text-slate-700 hover:bg-slate-50">Data Faskes</a>
                <a href="{{ route('profil') }}"
                    class="block px-3 py-2.5 rounded-xl text-sm font-semibold text-blue-600 bg-blue-50">Profil</a>
                <a href="{{ route('faskes.create') }}"
                    class="block px-3 py-2.5 rounded-xl text-sm font-semibold text-blue-600 hover:bg-blue-50">+ Tambah
                    Faskes</a>
            </div>
        </div>
    </nav>

    {{-- ══ HERO — selaras dengan hero homepage ══ --}}
    <section class="hero-gradient relative overflow-hidden py-16 sm:py-20 lg:py-28">
        <div class="blob absolute -top-20 -left-20 w-64 h-64 sm:w-80 sm:h-80 bg-white"></div>
        <div class="blob absolute bottom-0 right-0 w-72 h-72 sm:w-96 sm:h-96 bg-teal-400" style="animation-delay:3s">
        </div>
        <div class="blob absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-56 h-56 sm:w-64 sm:h-64 bg-sky-300"
            style="animation-delay:1.5s"></div>

        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center justify-center gap-8 sm:gap-10 lg:gap-14">

                {{-- Avatar --}}
                <div class="flex-shrink-0 reveal" style="animation-delay:0.1s;">
                    <div
                        class="avatar-ring w-40 h-40 min-[420px]:w-48 min-[420px]:h-48 md:w-56 md:h-56 lg:w-64 lg:h-64 float">
                        <div class="avatar-inner">
                            {{-- Ganti emoji dengan foto: <img src="foto.jpg" class="w-full h-full object-cover"/> --}}
                            {{-- <div class="text-center">
                                <div class="text-7xl">👨‍💻</div>
                                <p class="text-xs text-slate-400 mt-1 font-medium">Foto Kamu</p>
                            </div> --}}
                            <img src="{{ asset('images/foto-profil.jpg') }}"
                                class="w-full h-full object-cover object-center" alt="Foto Profil" />
                        </div>
                    </div>
                </div>

                {{-- Bio --}}
                <div class="text-center lg:text-left max-w-xl">
                    <div class="reveal" style="animation-delay:0.15s;">
                        <span
                            class="inline-block px-4 py-1.5 rounded-full bg-white/20 text-white text-xs font-semibold tracking-wider uppercase backdrop-blur-sm border border-white/30 mb-4">
                            👨‍💻 Pengembang Aplikasi
                        </span>
                    </div>
                    <h1 class="text-3xl min-[420px]:text-4xl md:text-5xl font-extrabold text-white leading-tight mb-3 drop-shadow-lg reveal"
                        style="animation-delay:0.2s;">
                        Imanuel Reformata<br>Hulu
                    </h1>
                    <p class="text-blue-100 text-sm sm:text-base md:text-lg font-medium mb-1 reveal"
                        style="animation-delay:0.25s;">
                        Mahasiswa Teknologi Rekayasa Perangkat Lunak
                    </p>
                    <p class="text-blue-200/70 text-sm mb-6 reveal" style="animation-delay:0.3s;">
                        Politeknik Negeri Medan · Angkatan 2023
                    </p>
                    <p class="text-blue-100/80 text-sm leading-relaxed max-w-lg mb-8 reveal"
                        style="animation-delay:0.35s;">
                        Passionate membangun aplikasi web berbasis data spasial. Proyek ini mengimplementasikan
                        <span class="text-teal-300 font-semibold">PostGIS</span>,
                        <span class="text-sky-300 font-semibold">Laravel</span>, dan
                        <span class="text-white font-semibold">Leaflet.js</span>
                        untuk membantu pemetaan layanan kesehatan Kota Sibolga.
                    </p>
                    <div class="flex flex-wrap gap-3 justify-center lg:justify-start reveal"
                        style="animation-delay:0.4s;">
                        <a href="{{ route('peta') }}"
                            class="w-full min-[420px]:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-full bg-white text-blue-700 font-bold text-sm shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                            Lihat Proyek
                        </a>
                        <a href="mailto:imanuelhulu01@gmail.com"
                            class="w-full min-[420px]:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-full bg-teal-400/30 border border-teal-300/50 text-white font-semibold text-sm hover:bg-teal-400/50 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Hubungi Saya
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ══ STAT CARDS — sama gaya dengan homepage ══ --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 relative z-10">
        <div class="grid grid-cols-1 min-[420px]:grid-cols-2 lg:grid-cols-4 gap-4">
            @php
                $stats = [
                    ['icon' => '🏥', 'val' => '30+', 'label' => 'Data Faskes', 'color' => 'blue'],
                    ['icon' => '🗺', 'val' => '4', 'label' => 'Query Spasial', 'color' => 'emerald'],
                    ['icon' => '⚡', 'val' => '5+', 'label' => 'Teknologi', 'color' => 'indigo'],
                    ['icon' => '📍', 'val' => '4', 'label' => 'Kecamatan', 'color' => 'amber'],
                ];
            @endphp
            @foreach ($stats as $i => $s)
                <div class="stat-card bg-white rounded-2xl shadow-md border border-slate-100 p-5 reveal"
                    style="animation-delay:{{ 0.1 * $i }}s;">
                    <div
                        class="w-11 h-11 rounded-xl bg-{{ $s['color'] }}-50 flex items-center justify-center mb-3 text-xl">
                        {{ $s['icon'] }}
                    </div>
                    <p class="text-xl sm:text-2xl font-extrabold text-slate-800">{{ $s['val'] }}</p>
                    <p class="text-sm text-slate-500 mt-0.5">{{ $s['label'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ══ TENTANG PROYEK ══ --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 sm:mt-16 lg:mt-20">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 sm:mb-8 gap-3 reveal">
            <div>
                <h2 class="text-xl sm:text-2xl font-extrabold text-slate-800">Tentang Proyek</h2>
                <p class="text-slate-500 text-sm mt-1">Sistem Informasi Geografis Persebaran Faskes Kota Sibolga</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
            @php
                $features = [
                    [
                        'icon' => '🗺',
                        'title' => 'Peta Interaktif',
                        'desc' =>
                            'Visualisasi 30+ faskes di peta Leaflet.js dengan marker berwarna per jenis, filter, search, dan popup detail.',
                        'delay' => 0.1,
                    ],
                    [
                        'icon' => '📍',
                        'title' => 'Analisis Spasial PostGIS',
                        'desc' =>
                            'Query ST_DWithin, ST_Distance, ST_MakePoint, ST_AsGeoJSON dengan spatial index GIST yang teroptimasi.',
                        'delay' => 0.2,
                    ],
                    [
                        'icon' => '🛣',
                        'title' => 'Routing via Jalan',
                        'desc' =>
                            'Perhitungan rute faskes terdekat dan jarak antar faskes menggunakan OSRM — bukan garis lurus.',
                        'delay' => 0.3,
                    ],
                    [
                        'icon' => '🔍',
                        'title' => 'Filter & Pencarian',
                        'desc' =>
                            'Filter jenis, status, BPJS, dan kecamatan secara real-time dengan query parameterized yang aman.',
                        'delay' => 0.15,
                    ],
                    [
                        'icon' => '🏗',
                        'title' => 'CRUD Lengkap',
                        'desc' =>
                            'Form tambah dan edit data faskes dengan input koordinat via klik peta atau GPS, beserta validasi lengkap.',
                        'delay' => 0.25,
                    ],
                    [
                        'icon' => '📊',
                        'title' => 'Materialized View',
                        'desc' =>
                            'Statistik faskes per kecamatan menggunakan mv_faskes_per_kecamatan untuk performa query optimal.',
                        'delay' => 0.35,
                    ],
                ];
            @endphp

            @foreach ($features as $f)
                <div class="hover-card bg-white rounded-2xl border border-slate-100 p-5 sm:p-6 shadow-sm reveal"
                    style="animation-delay:{{ $f['delay'] }}s;">
                    <div
                        class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-50 to-teal-50 flex items-center justify-center text-2xl mb-4 shadow-sm border border-slate-100">
                        {{ $f['icon'] }}
                    </div>
                    <h3 class="font-extrabold text-slate-800 text-sm mb-2">{{ $f['title'] }}</h3>
                    <p class="text-slate-500 text-xs leading-relaxed">{{ $f['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ══ TECH STACK ══ --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 sm:mt-16 lg:mt-20">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 sm:mb-8 gap-3 reveal">
            <div>
                <h2 class="text-xl sm:text-2xl font-extrabold text-slate-800">Tech Stack</h2>
                <p class="text-slate-500 text-sm mt-1">Teknologi yang digunakan dalam proyek ini</p>
            </div>
        </div>

        @php
            $stacks = [
                [
                    'label' => 'Backend',
                    'dot' => 'bg-blue-500',
                    'techs' => [
                        ['name' => 'Laravel 11', 'icon' => '🔧', 'desc' => 'PHP Framework'],
                        ['name' => 'PostgreSQL 18', 'icon' => '🐘', 'desc' => 'Relational DB'],
                        ['name' => 'PostGIS', 'icon' => '🌍', 'desc' => 'Spatial Extension'],
                        ['name' => 'OSRM', 'icon' => '🛣', 'desc' => 'Route Engine'],
                    ],
                ],
                [
                    'label' => 'Frontend',
                    'dot' => 'bg-teal-500',
                    'techs' => [
                        ['name' => 'Tailwind CSS', 'icon' => '🎨', 'desc' => 'Utility CSS'],
                        ['name' => 'Leaflet.js', 'icon' => '🗺', 'desc' => 'Interactive Map'],
                        ['name' => 'Blade Templates', 'icon' => '💎', 'desc' => 'View Engine'],
                        ['name' => 'JavaScript', 'icon' => '⚡', 'desc' => 'Interactivity'],
                    ],
                ],
                [
                    'label' => 'Tools & Format',
                    'dot' => 'bg-indigo-500',
                    'techs' => [
                        ['name' => 'pgAdmin 4', 'icon' => '🖥', 'desc' => 'DB Management'],
                        ['name' => 'Laragon', 'icon' => '🛠', 'desc' => 'Local Server'],
                        ['name' => 'VS Code', 'icon' => '💻', 'desc' => 'Code Editor'],
                        ['name' => 'GeoJSON', 'icon' => '📐', 'desc' => 'Spatial Format'],
                    ],
                ],
            ];
        @endphp

        {{-- Grid 2 kolom: kiri pills, kanan cards detail --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 sm:gap-6">

            {{-- Kolom KIRI: kategori + pill badges --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 reveal space-y-6">
                @foreach ($stacks as $stack)
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <span class="w-2.5 h-2.5 rounded-full {{ $stack['dot'] }} flex-shrink-0"></span>
                            <p class="text-xs font-extrabold text-slate-400 uppercase tracking-widest">
                                {{ $stack['label'] }}</p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($stack['techs'] as $t)
                                <span class="tech-pill">
                                    <span>{{ $t['icon'] }}</span>
                                    {{ $t['name'] }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @if (!$loop->last)
                        <div class="border-t border-slate-100"></div>
                    @endif
                @endforeach
            </div>

            {{-- Kolom KANAN: cards detail tiap teknologi --}}
            <div class="grid grid-cols-1 min-[420px]:grid-cols-2 gap-3 reveal" style="animation-delay:0.15s;">
                @foreach ($stacks as $stack)
                    @foreach ($stack['techs'] as $t)
                        <div
                            class="hover-card bg-white rounded-2xl border border-slate-100 p-4 shadow-sm flex items-start gap-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-50 to-teal-50 flex items-center justify-center text-xl border border-slate-100 flex-shrink-0">
                                {{ $t['icon'] }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-extrabold text-slate-800 leading-snug">{{ $t['name'] }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $t['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>

        </div>
    </section>

    {{-- ══ SKILLS ══ --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 sm:mt-16 lg:mt-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 sm:gap-8">

            {{-- Skill bars --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 reveal">
                <h2 class="text-xl font-extrabold text-slate-800 mb-6">Keahlian Teknis</h2>
                @php
                    $skills = [
                        ['name' => 'Laravel / PHP', 'pct' => 85, 'from' => '#2563eb', 'to' => '#1d4ed8'],
                        ['name' => 'PostgreSQL / PostGIS', 'pct' => 80, 'from' => '#0d9488', 'to' => '#0891b2'],
                        ['name' => 'Tailwind CSS', 'pct' => 85, 'from' => '#06b6d4', 'to' => '#0284c7'],
                        ['name' => 'JavaScript', 'pct' => 75, 'from' => '#f59e0b', 'to' => '#d97706'],
                        ['name' => 'GIS / Leaflet.js', 'pct' => 78, 'from' => '#10b981', 'to' => '#059669'],
                        ['name' => 'Git', 'pct' => 70, 'from' => '#8b5cf6', 'to' => '#7c3aed'],
                    ];
                @endphp
                <div class="space-y-5" id="skills-list">
                    @foreach ($skills as $s)
                        <div class="skill-item" data-pct="{{ $s['pct'] }}" data-from="{{ $s['from'] }}"
                            data-to="{{ $s['to'] }}">
                            <div class="flex justify-between items-center mb-1.5">
                                <span class="text-sm font-semibold text-slate-700">{{ $s['name'] }}</span>
                                <span class="text-xs font-bold text-slate-400">{{ $s['pct'] }}%</span>
                            </div>
                            <div class="skill-track">
                                <div class="skill-fill"
                                    style="background:linear-gradient(90deg, {{ $s['from'] }}, {{ $s['to'] }});">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Query PostGIS highlight --}}
            <div class="space-y-4 reveal" style="animation-delay:0.15s;">
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                    <h2 class="text-xl font-extrabold text-slate-800 mb-4">PostGIS Queries</h2>
                    <div class="space-y-3">

                        {{-- Query 1 --}}
                        <div class="code-block">
                            <div class="code-header">
                                <div class="code-dot bg-red-400"></div>
                                <div class="code-dot bg-yellow-400"></div>
                                <div class="code-dot bg-green-400"></div>
                                <span class="text-xs text-slate-500 ml-2 font-semibold">INSERT + ST_MakePoint</span>
                            </div>
                            <pre><span class="kw">ST_SetSRID</span>(<span class="fn">ST_MakePoint</span>(
  longitude, latitude
), <span class="num">4326</span>)
<span class="cm">-- ✅ Menyimpan koordinat ke kolom geom</span></pre>
                        </div>

                        {{-- Query 2 --}}
                        <div class="code-block">
                            <div class="code-header">
                                <div class="code-dot bg-red-400"></div>
                                <div class="code-dot bg-yellow-400"></div>
                                <div class="code-dot bg-green-400"></div>
                                <span class="text-xs text-slate-500 ml-2 font-semibold">ST_DWithin — Radius</span>
                            </div>
                            <pre><span class="kw">WHERE</span> <span class="fn">ST_DWithin</span>(
  geom::geography,
  <span class="fn">ST_MakePoint</span>(lon, lat)::geography,
  <span class="num">1000</span> <span class="cm">-- meter</span>
)
<span class="cm">-- ✅ Index Scan: idx_faskes_geom_geography</span></pre>
                        </div>

                        {{-- Query 3 --}}
                        <div class="code-block">
                            <div class="code-header">
                                <div class="code-dot bg-red-400"></div>
                                <div class="code-dot bg-yellow-400"></div>
                                <div class="code-dot bg-green-400"></div>
                                <span class="text-xs text-slate-500 ml-2 font-semibold">Materialized View</span>
                            </div>
                            <pre><span class="kw">CREATE MATERIALIZED VIEW</span>
  mv_faskes_per_kecamatan <span class="kw">AS</span>
<span class="kw">SELECT</span> kecamatan,
  <span class="fn">COUNT</span>(*) <span class="kw">AS</span> total_faskes,
  <span class="fn">SUM</span>(<span class="kw">CASE WHEN</span> bpjs <span class="kw">THEN</span> <span class="num">1</span>
    <span class="kw">ELSE</span> <span class="num">0</span> <span class="kw">END</span>) <span class="kw">AS</span> total_bpjs
<span class="kw">FROM</span> fasilitas_kesehatan
<span class="kw">GROUP BY</span> kecamatan;</pre>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ══ KONTAK ══ --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 sm:mt-16 lg:mt-20 mb-14 sm:mb-20">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 sm:mb-8 gap-3 reveal">
            <div>
                <h2 class="text-xl sm:text-2xl font-extrabold text-slate-800">Kontak</h2>
                <p class="text-slate-500 text-sm mt-1">Punya pertanyaan? Jangan ragu untuk menghubungi</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-5">
            @php
                $contacts = [
                    [
                        'icon' => '📧',
                        'label' => 'Email',
                        'val' => 'imanuelhulu01@gmail.com',
                        'href' => 'mailto:imanuelhulu01@gmail.com',
                        'hint' => 'Kirim email',
                    ],
                    [
                        'icon' => '💼',
                        'label' => 'LinkedIn',
                        'val' => 'linkedin.com/in/imanuel-reformata-hulu-12437a2a7',
                        'href' => 'https://www.linkedin.com/in/imanuel-reformata-hulu-12437a2a7',
                        'hint' => 'Lihat profil',
                    ],
                    [
                        'icon' => '🐙',
                        'label' => 'GitHub',
                        'val' => 'github.com/imanuel122',
                        'href' => 'https://github.com/imanuel122',
                        'hint' => 'Lihat kode',
                    ],
                ];
            @endphp

            @foreach ($contacts as $i => $c)
                <a href="{{ $c['href'] }}" target="_blank"
                    class="hover-card bg-white rounded-2xl border border-slate-100 p-5 sm:p-6 shadow-sm block group reveal"
                    style="animation-delay:{{ 0.1 * $i }}s;">
                    <div class="flex items-start gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-50 to-teal-50 flex items-center justify-center text-2xl border border-slate-100 flex-shrink-0 group-hover:from-blue-100 group-hover:to-teal-100 transition-colors">
                            {{ $c['icon'] }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-extrabold text-slate-400 uppercase tracking-wider mb-1">
                                {{ $c['label'] }}</p>
                            <p class="text-sm font-bold text-slate-800 break-words">{{ $c['val'] }}</p>
                            <p class="text-xs text-blue-500 font-semibold mt-2 group-hover:underline">
                                {{ $c['hint'] }} →</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- ══ FOOTER (sama dengan homepage) ══ --}}
    <footer class="bg-slate-800 text-slate-400 text-sm py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
                        <span class="text-white font-bold">Faskes Sibolga</span>
                    </a>
                    <p class="text-xs text-slate-500 max-w-xs leading-relaxed">
                        Sistem Informasi Geografis Fasilitas Kesehatan Kota Sibolga, Sumatra Utara.
                    </p>
                </div>
                <div class="grid grid-cols-1 min-[420px]:grid-cols-2 gap-x-12 gap-y-6 text-xs w-full md:w-auto">
                    <div>
                        <p class="text-slate-300 font-bold mb-2 uppercase tracking-wider text-xs">Navigasi</p>
                        <div class="space-y-1.5">
                            <a href="{{ route('homepage') }}"
                                class="block hover:text-white transition-colors">Beranda</a>
                            <a href="{{ route('peta') }}" class="block hover:text-white transition-colors">Peta
                                Interaktif</a>
                            <a href="{{ route('faskes.index') }}"
                                class="block hover:text-white transition-colors">Data Faskes</a>
                            <a href="{{ route('profil') }}"
                                class="block hover:text-white transition-colors">Profil</a>
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
            <div
                class="border-t border-slate-700 pt-6 flex flex-col sm:flex-row items-center justify-between gap-2 text-center sm:text-left">
                <p class="text-xs">© {{ date('Y') }} Sistem Informasi Fasilitas Kesehatan — Kota Sibolga</p>
                <p class="text-xs text-slate-500">Dibuat oleh <span class="text-white font-semibold">Imanuel Reformata
                        Hulu</span> · Tugas Akhir Query PostgreSQL TRPL</p>
            </div>
        </div>
    </footer>

    <script>
        // ── Skill bars (intersection observer) ──
        const skillsObs = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;
                entry.target.querySelectorAll('.skill-item').forEach((item, i) => {
                    const pct = item.dataset.pct;
                    const from = item.dataset.from;
                    const to = item.dataset.to;
                    setTimeout(() => {
                        const bar = item.querySelector('.skill-fill');
                        bar.style.background = `linear-gradient(90deg, ${from}, ${to})`;
                        bar.style.width = pct + '%';
                    }, i * 130);
                });
                skillsObs.unobserve(entry.target);
            });
        }, {
            threshold: 0.3
        });

        const skillsEl = document.getElementById('skills-list');
        if (skillsEl) skillsObs.observe(skillsEl);

        // ── Reveal on scroll ──
        const revealObs = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.style.opacity = '1';
                    revealObs.unobserve(e.target);
                }
            });
        }, {
            threshold: 0.1
        });
        document.querySelectorAll('.reveal').forEach(el => revealObs.observe(el));
    </script>

</body>

</html>
