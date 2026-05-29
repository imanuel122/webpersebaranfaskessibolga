<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Peta Faskes — Kota Sibolga</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
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
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        html,
        body {
            height: 100%;
            overflow: hidden;
        }

        #map {
            height: 100%;
            width: 100%;
        }

        /* Popup Leaflet custom */
        .leaflet-popup-content-wrapper {
            border-radius: 14px !important;
            padding: 0 !important;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15) !important;
            border: none !important;
        }

        .leaflet-popup-content {
            margin: 0 !important;
            width: 240px !important;
        }

        .leaflet-popup-tip-container {
            display: none;
        }

        .leaflet-popup-close-button {
            color: white !important;
            font-size: 16px !important;
            top: 8px !important;
            right: 10px !important;
            z-index: 999;
        }

        /* Sidebar scroll */
        .scroll-area {
            overflow-y: auto;
        }

        .scroll-area::-webkit-scrollbar {
            width: 4px;
        }

        .scroll-area::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .scroll-area::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 99px;
        }

        /* Tabs */
        .tab-btn {
            transition: all 0.2s;
            cursor: pointer;
        }

        .tab-btn.active {
            background: rgba(255, 255, 255, 0.25);
            color: white;
            font-weight: 700;
        }

        .tab-btn:not(.active) {
            color: rgba(255, 255, 255, 0.6);
        }

        .tool-panel {
            display: none;
        }

        .tool-panel.active {
            display: flex;
            flex-direction: column;
            flex: 1;
            overflow: hidden;
        }

        /* Faskes card */
        .faskes-card {
            transition: all 0.2s ease;
            cursor: pointer;
            border-left: 3px solid transparent;
        }

        .faskes-card:hover {
            background: #f8faff;
            border-left-color: #93c5fd;
        }

        .faskes-card.selected-card {
            background: #eff6ff;
            border-left-color: #2563eb;
        }

        /* Animasi */
        .result-card {
            animation: slideIn 0.2s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Detail panel slide in dari kanan */
        #detail-panel {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            width: 360px;
            z-index: 20;
            background: white;
            box-shadow: -4px 0 30px rgba(0, 0, 0, 0.12);
            transform: translateX(100%);
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
        }

        #detail-panel.open {
            transform: translateX(0);
        }

        /* Spinner */
        .spinner {
            border: 3px solid #e2e8f0;
            border-top-color: #2563eb;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 0.7s linear infinite;
            display: inline-block;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Jarak result gradient */
        .jarak-result {
            background: linear-gradient(135deg, #1e40af 0%, #0891b2 100%);
        }

        /* Route styling */
        input[type=range] {
            accent-color: #2563eb;
        }

        .btn-mode-active {
            background: #eff6ff !important;
            border-color: #2563eb !important;
            color: #2563eb !important;
        }

        /* Info row di detail panel */
        .info-row {
            display: flex;
            gap: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #f1f5f9;
            align-items: flex-start;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-icon {
            width: 18px;
            flex-shrink: 0;
            color: #94a3b8;
            margin-top: 1px;
        }

        .info-value {
            font-size: 13px;
            color: #334155;
        }


        /* Legend panel */
        #legend-panel {
            position: absolute;
            bottom: 24px;
            left: 12px;
            z-index: 10;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.13);
            min-width: 190px;
            max-width: 220px;
            overflow: hidden;
            animation: legendIn 0.5s ease 0.8s both;
        }

        #legend-body {
            overflow: hidden;
            transition: max-height 0.35s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.25s;
        }

        #legend-body.expanded {
            max-height: 400px;
            opacity: 1;
        }

        #legend-body.collapsed {
            max-height: 0;
            opacity: 0;
        }

        @keyframes legendIn {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Navbar z-index override */
        .app-navbar {
            position: relative;
            z-index: 999;
            flex-shrink: 0;
        }

        /* Pulse marker */
        @keyframes markerPulse {

            0%,
            100% {
                transform: rotate(-45deg) scale(1);
            }

            50% {
                transform: rotate(-45deg) scale(1.25);
            }
        }

        .marker-pulse div {
            animation: markerPulse 0.5s ease 3;
        }

        /* Route info badge */
        .route-badge {
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            border-radius: 99px;
            padding: 8px 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 700;
            color: #1e40af;
            z-index: 10;
            white-space: nowrap;
            animation: slideIn 0.3s ease;
        }
    </style>
</head>

<body class="bg-slate-100" style="height:100vh; display:flex; flex-direction:column;">

    {{-- ══ NAVBAR ══ --}}
    <nav class="app-navbar bg-white border-b border-slate-100 shadow-sm">
        <div class="max-w-full px-4 sm:px-6">
            <div class="flex items-center justify-between h-14">
                <a href="{{ route('homepage') }}" class="flex items-center gap-2.5">
                    <div
                        class="w-8 h-8 rounded-xl bg-gradient-to-br from-blue-600 to-teal-500 flex items-center justify-center shadow-md">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-extrabold text-slate-800 leading-none">Faskes Sibolga</p>
                        <p class="text-xs text-slate-400 leading-none mt-0.5">Peta Interaktif</p>
                    </div>
                </a>
                <div class="flex items-center gap-1">
                    <a href="{{ route('homepage') }}"
                        class="px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-500 hover:bg-slate-100 hover:text-slate-700 transition-colors flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Beranda
                    </a>
                    <a href="{{ route('faskes.index') }}"
                        class="px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-500 hover:bg-slate-100 hover:text-slate-700 transition-colors flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                        Data Faskes
                    </a>
                    <a href="{{ route('faskes.create') }}"
                        class="ml-1 px-3 py-1.5 rounded-lg text-xs font-bold bg-blue-600 text-white hover:bg-blue-700 transition-colors flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Faskes
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- ══ MAIN LAYOUT ══ --}}
    <div class="flex flex-1 overflow-hidden">

        {{-- ── SIDEBAR KIRI ── --}}
        <aside class="relative z-20 flex flex-col bg-white shadow-xl flex-shrink-0" style="width:340px;">

            {{-- Sidebar header --}}
            <div class="bg-gradient-to-br from-blue-700 via-blue-600 to-teal-600 px-4 py-3 flex-shrink-0">
                <p class="text-white font-bold text-sm mb-3">🗺 Peta Fasilitas Kesehatan</p>
                <div class="grid grid-cols-4 gap-1 bg-white/10 rounded-xl p-1">
                    <button onclick="switchTab('peta')" id="tab-peta"
                        class="tab-btn active py-1.5 rounded-lg text-xs font-semibold text-center">🗺 Peta</button>
                    <button onclick="switchTab('terdekat')" id="tab-terdekat"
                        class="tab-btn py-1.5 rounded-lg text-xs font-semibold text-center">📍 Dekat</button>
                    <button onclick="switchTab('radius')" id="tab-radius"
                        class="tab-btn py-1.5 rounded-lg text-xs font-semibold text-center">⭕ Radius</button>
                    <button onclick="switchTab('jarak')" id="tab-jarak"
                        class="tab-btn py-1.5 rounded-lg text-xs font-semibold text-center">📏 Jarak</button>
                </div>
            </div>

            {{-- ── PANEL PETA ── --}}
            <div id="panel-peta" class="tool-panel active">
                {{-- Focus banner --}}
                <div id="focus-banner" class="hidden px-4 py-2 bg-blue-600 flex-shrink-0">
                    <div class="flex items-center justify-between gap-2">
                        <p id="focus-nama" class="text-white text-xs font-bold truncate flex-1">—</p>
                        <button onclick="clearFocus()"
                            class="text-blue-200 hover:text-white text-xs font-semibold px-2 py-0.5 rounded-lg hover:bg-white/20 transition-colors flex-shrink-0">✕
                            Semua</button>
                    </div>
                </div>

                {{-- Search --}}
                <div class="px-3 py-2.5 border-b border-slate-100 flex-shrink-0">
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input id="search-input" type="text" placeholder="Cari nama faskes..."
                            class="w-full pl-8 pr-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:border-blue-400 transition-colors" />
                    </div>
                </div>

                {{-- Filter chips --}}
                <div class="px-3 py-2 border-b border-slate-100 flex-shrink-0">
                    <div id="filter-container" class="flex flex-wrap gap-1.5">
                        <button onclick="filterJenis('semua')"
                            class="filter-btn active px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-600 text-white">Semua</button>
                    </div>
                </div>

                {{-- Stats --}}
                <div class="px-3 py-2 border-b border-slate-100 flex-shrink-0">
                    <div class="flex gap-2">
                        <div class="flex-1 bg-blue-50 rounded-lg p-2 text-center">
                            <p id="stat-total" class="text-base font-extrabold text-blue-700">—</p>
                            <p class="text-xs text-slate-400">Total</p>
                        </div>
                        <div class="flex-1 bg-emerald-50 rounded-lg p-2 text-center">
                            <p id="stat-tampil" class="text-base font-extrabold text-emerald-600">—</p>
                            <p class="text-xs text-slate-400">Tampil</p>
                        </div>
                        <div class="flex-1 bg-indigo-50 rounded-lg p-2 text-center">
                            <p id="stat-bpjs" class="text-base font-extrabold text-indigo-600">—</p>
                            <p class="text-xs text-slate-400">BPJS</p>
                        </div>
                    </div>
                </div>

                {{-- List faskes --}}
                <div id="faskes-list" class="scroll-area flex-1 divide-y divide-slate-50"></div>
            </div>

            {{-- ── PANEL TERDEKAT ── --}}
            <div id="panel-terdekat" class="tool-panel">
                <div class="px-4 py-4 border-b border-slate-100 flex-shrink-0 space-y-3">
                    <div>
                        <h3 class="font-extrabold text-slate-800 text-sm mb-1">📍 Faskes Terdekat</h3>
                        <p class="text-xs text-slate-500">Cari faskes terdekat via jalur jalan nyata (bukan garis
                            lurus).</p>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="aktivasiKlikPeta('terdekat')" id="btn-klik-terdekat"
                            class="flex-1 py-2 rounded-xl border-2 border-blue-200 text-blue-600 text-xs font-bold hover:bg-blue-50 transition-all">
                            🖱 Klik Peta
                        </button>
                        <button onclick="gunakanGPS()"
                            class="flex-1 py-2 rounded-xl border-2 border-emerald-200 text-emerald-600 text-xs font-bold hover:bg-emerald-50 transition-all">
                            📡 GPS Saya
                        </button>
                    </div>
                    <div id="terdekat-koordinat" class="hidden p-2.5 bg-blue-50 rounded-xl">
                        <p class="text-xs font-semibold text-blue-800 mb-0.5">📌 Titik dipilih:</p>
                        <p id="terdekat-lat-lon" class="text-xs text-blue-700 font-mono">—</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <label class="text-xs text-slate-600 font-semibold whitespace-nowrap">Tampilkan</label>
                        <select id="terdekat-limit"
                            class="flex-1 text-xs border border-slate-200 rounded-lg px-2 py-1.5 focus:outline-none focus:border-blue-400">
                            <option value="3">3 faskes</option>
                            <option value="5" selected>5 faskes</option>
                            <option value="10">10 faskes</option>
                        </select>
                    </div>
                    <div id="terdekat-hint"
                        class="p-2.5 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-700 font-medium">
                        💡 Klik "Klik Peta" lalu pilih titik lokasi kamu.
                    </div>
                </div>
                <div id="hasil-terdekat" class="scroll-area flex-1 px-3 py-2 space-y-2"></div>
            </div>

            {{-- ── PANEL RADIUS ── --}}
            <div id="panel-radius" class="tool-panel">
                <div class="px-4 py-4 border-b border-slate-100 flex-shrink-0 space-y-3">
                    <div>
                        <h3 class="font-extrabold text-slate-800 text-sm mb-1">⭕ Faskes dalam Radius</h3>
                        <p class="text-xs text-slate-500">Klik titik pusat di peta lalu atur radius pencarian.</p>
                    </div>
                    <button onclick="aktivasiKlikPeta('radius')" id="btn-klik-radius"
                        class="w-full py-2 rounded-xl border-2 border-blue-200 text-blue-600 text-xs font-bold hover:bg-blue-50 transition-all">
                        🖱 Klik Titik Pusat di Peta
                    </button>
                    <div id="radius-koordinat" class="hidden p-2.5 bg-blue-50 rounded-xl">
                        <p class="text-xs font-semibold text-blue-800 mb-0.5">📌 Titik pusat:</p>
                        <p id="radius-lat-lon" class="text-xs text-blue-700 font-mono">—</p>
                    </div>
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <label class="text-xs font-semibold text-slate-600">Radius</label>
                            <span id="radius-label-display" class="text-sm font-extrabold text-blue-600">1.000
                                m</span>
                        </div>
                        <input type="range" id="radius-slider-tool" min="250" max="5000" step="250"
                            value="1000" class="w-full" oninput="updateRadiusLabel(this.value)" />
                        <div class="flex justify-between text-xs text-slate-400 mt-1"><span>250m</span><span>5km</span>
                        </div>
                    </div>
                    <button onclick="jalankanRadius()" id="btn-cari-radius"
                        class="w-full py-2 rounded-xl bg-blue-600 text-white text-xs font-bold hover:bg-blue-700 transition-all disabled:opacity-40 disabled:cursor-not-allowed"
                        disabled>
                        🔍 Cari Faskes dalam Radius
                    </button>
                    <button onclick="clearRadius()"
                        class="w-full py-1.5 rounded-xl border border-slate-200 text-xs text-slate-500 hover:bg-slate-50">Hapus
                        & Reset</button>
                </div>
                <div id="hasil-radius" class="scroll-area flex-1 px-3 py-2 space-y-2"></div>
            </div>

            {{-- ── PANEL JARAK ── --}}
            <div id="panel-jarak" class="tool-panel">
                <div class="px-4 py-4 border-b border-slate-100 flex-shrink-0 space-y-3">
                    <div>
                        <h3 class="font-extrabold text-slate-800 text-sm mb-1">📏 Jarak Antar Faskes</h3>
                        <p class="text-xs text-slate-500">Hitung jarak via jalur jalan nyata antara dua faskes.</p>
                    </div>
                    <div>
                        <label class="flex items-center gap-1.5 text-xs font-bold text-slate-600 mb-1.5">
                            <span
                                class="w-5 h-5 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs">A</span>
                            Faskes Pertama
                        </label>
                        <select id="jarak-faskes-a"
                            class="w-full text-xs border border-slate-200 rounded-xl px-3 py-2 focus:outline-none focus:border-blue-400 bg-white">
                            <option value="">— Pilih Faskes A —</option>
                        </select>
                    </div>
                    <div class="flex justify-center">
                        <button onclick="swapFaskes()"
                            class="w-7 h-7 rounded-full border-2 border-slate-200 bg-white text-slate-500 hover:border-blue-400 hover:text-blue-500 transition-all text-sm shadow-sm">⇅</button>
                    </div>
                    <div>
                        <label class="flex items-center gap-1.5 text-xs font-bold text-slate-600 mb-1.5">
                            <span
                                class="w-5 h-5 rounded-full bg-rose-500 text-white flex items-center justify-center text-xs">B</span>
                            Faskes Kedua
                        </label>
                        <select id="jarak-faskes-b"
                            class="w-full text-xs border border-slate-200 rounded-xl px-3 py-2 focus:outline-none focus:border-blue-400 bg-white">
                            <option value="">— Pilih Faskes B —</option>
                        </select>
                    </div>
                    <button onclick="hitungJarak()"
                        class="w-full py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-cyan-500 text-white text-xs font-bold hover:opacity-90 transition-all shadow-md">
                        📏 Hitung via Jalur Jalan
                    </button>
                </div>
                <div id="hasil-jarak" class="scroll-area flex-1 px-4 py-3"></div>
            </div>
        </aside>

        {{-- ── MAP AREA ── --}}
        <div class="flex-1 relative">
            <div id="map" class="absolute inset-0 z-0"></div>

            {{-- Loading --}}
            <div id="loading"
                class="absolute inset-0 z-30 bg-white/80 backdrop-blur-sm flex flex-col items-center justify-center">
                <div class="w-10 h-10 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin mb-3"></div>
                <p class="text-sm font-semibold text-slate-600">Memuat data faskes...</p>
            </div>

            {{-- Mode indicator --}}
            <div id="mode-indicator"
                class="hidden absolute top-4 left-1/2 -translate-x-1/2 z-10 bg-amber-500 text-white rounded-full shadow-lg px-5 py-2 text-xs font-bold pointer-events-none">
                🖱 Klik peta untuk memilih titik...
            </div>

            {{-- Focus badge --}}
            <div id="focus-badge"
                class="hidden absolute top-4 left-4 z-10 bg-blue-600 text-white rounded-2xl shadow-lg px-4 py-2 text-xs font-bold flex items-center gap-2 max-w-xs">
                <span>📍</span>
                <span id="focus-badge-nama" class="truncate">—</span>
                <button onclick="clearFocus()" class="ml-1 text-blue-200 hover:text-white">✕</button>
            </div>

            {{-- Route distance badge --}}
            <div id="route-badge" class="hidden route-badge">
                <span>🛣</span>
                <span id="route-badge-text">—</span>
                <button onclick="clearRoute()"
                    class="ml-2 text-slate-400 hover:text-slate-600 font-normal text-xs">✕</button>
            </div>

            {{-- ── LEGENDA PETA ── --}}
            <div id="legend-panel">
                <div class="flex items-center justify-between px-3 py-2.5 bg-gradient-to-r from-blue-700 to-blue-600 cursor-pointer select-none rounded-t-2xl"
                    onclick="toggleLegend()">
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                        <span class="text-white text-xs font-bold">Legenda Peta</span>
                    </div>
                    <span id="legend-toggle-icon" class="text-white text-xs font-bold">▲</span>
                </div>
                <div id="legend-body" class="expanded">
                    <div class="px-3 pt-2.5 pb-1">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Jenis Fasilitas</p>
                        <div id="legend-items" class="space-y-1.5">
                            <div class="flex items-center gap-2">
                                <div class="w-5 h-5 rounded-full bg-slate-200 animate-pulse flex-shrink-0"></div>
                                <div class="h-2.5 bg-slate-200 rounded animate-pulse flex-1"></div>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-5 h-5 rounded-full bg-slate-200 animate-pulse flex-shrink-0"></div>
                                <div class="h-2.5 bg-slate-200 rounded animate-pulse w-3/4"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mx-3 border-t border-slate-100 my-2"></div>
                    <div class="px-3 pb-1">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Status Operasional
                        </p>
                        <div class="space-y-1.5">
                            <div class="flex items-center gap-2">
                                <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 flex-shrink-0"
                                    style="box-shadow:0 0 0 3px #d1fae5;"></div>
                                <span class="text-xs text-slate-600 font-medium">Aktif</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-2.5 h-2.5 rounded-full bg-slate-400 flex-shrink-0"
                                    style="box-shadow:0 0 0 3px #f1f5f9;"></div>
                                <span class="text-xs text-slate-600 font-medium">Tidak Aktif</span>
                            </div>
                        </div>
                    </div>
                    <div class="mx-3 border-t border-slate-100 my-2"></div>
                    <div class="px-3 pb-2">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Layanan BPJS</p>
                        <div class="space-y-1.5">
                            <div class="flex items-center gap-2">
                                <span
                                    class="inline-block px-2 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100 whitespace-nowrap">✓
                                    BPJS</span>
                                <span class="text-xs text-slate-500">Menerima BPJS</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span
                                    class="inline-block px-2 py-0.5 rounded-full text-xs font-bold bg-rose-50 text-rose-600 border border-rose-100 whitespace-nowrap">✗
                                    Non</span>
                                <span class="text-xs text-slate-500">Tidak BPJS</span>
                            </div>
                        </div>
                    </div>
                    <div class="mx-3 border-t border-slate-100 my-2"></div>
                    <div class="px-3 pb-3">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Simbol Analisis</p>
                        <div class="space-y-1.5">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-2 rounded-full flex-shrink-0" style="background:#2563eb;"></div>
                                <span class="text-xs text-slate-600">Rute jalur jalan</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-6 flex-shrink-0 border-t-2 border-dashed border-blue-400"></div>
                                <span class="text-xs text-slate-600">Batas radius</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-full flex-shrink-0"
                                    style="background:#f59e0b;border:2px solid white;box-shadow:0 0 0 2px #fef3c7;">
                                </div>
                                <span class="text-xs text-slate-600">Titik pencarian</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-full flex-shrink-0"
                                    style="background:#10b981;border:2px solid white;box-shadow:0 0 0 2px #d1fae5;">
                                </div>
                                <span class="text-xs text-slate-600">Lokasi GPS kamu</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tile + GPS --}}
            <div class="absolute bottom-6 right-4 z-10 flex flex-col gap-2">
                <button onclick="setTile('street')" id="btn-street"
                    class="tile-btn w-9 h-9 rounded-xl bg-white shadow-md flex items-center justify-center hover:bg-blue-50 transition-all border-2 border-blue-500"
                    title="Peta Jalan">
                    <svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                </button>
                <button onclick="setTile('satellite')" id="btn-satellite"
                    class="tile-btn w-9 h-9 rounded-xl bg-white shadow-md flex items-center justify-center hover:bg-blue-50 transition-all border-2 border-transparent"
                    title="Satelit">
                    <svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </button>
                <button onclick="locateMe()"
                    class="w-9 h-9 rounded-xl bg-blue-600 shadow-md flex items-center justify-center hover:bg-blue-700 transition-all"
                    title="GPS">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
            </div>

            {{-- ── DETAIL PANEL (slide dari kanan) ── --}}
            <div id="detail-panel">
                {{-- Header detail --}}
                <div id="detail-header" class="flex-shrink-0 p-5 pb-4" style="background:#2563eb;">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex-1 min-w-0">
                            <div id="detail-badge"
                                class="inline-block px-2.5 py-1 rounded-full text-xs font-bold bg-white/20 text-white mb-2">
                                —</div>
                            <p id="detail-nama" class="text-white font-extrabold text-base leading-snug">—</p>
                            <p id="detail-alamat" class="text-white/70 text-xs mt-1">—</p>
                        </div>
                        <button onclick="closeDetail()"
                            class="flex-shrink-0 w-8 h-8 rounded-xl bg-white/20 hover:bg-white/30 text-white flex items-center justify-center transition-colors mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    {{-- Status badges --}}
                    <div id="detail-badges" class="flex flex-wrap gap-2 mt-3"></div>
                </div>

                {{-- Body detail --}}
                <div class="scroll-area flex-1 px-5 py-4 space-y-1" id="detail-body"></div>

                {{-- Footer aksi --}}
                <div class="flex-shrink-0 p-4 border-t border-slate-100 space-y-2" id="detail-footer"></div>
            </div>
        </div>
    </div>

    <script>
        const BASE_URL = window.location.origin;
        const CENTER = [1.7417, 98.7792];
        const OSRM = 'https://router.project-osrm.org/route/v1/driving';

        let allFeatures = [];
        let markerMap = {};
        let activeJenis = 'semua';
        let selectedCard = null;
        let mapClickMode = null;
        let radiusCenter = null;
        let radiusLayer = null;
        let centerMarker = null;
        let terdekatLayers = [];
        let routeLayer = null;
        let focusedId = null;

        // ── MAP ──
        const map = L.map('map', {
            center: CENTER,
            zoom: 14,
            zoomControl: true
        });
        const tiles = {
            street: L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap',
                maxZoom: 19
            }),
            satellite: L.tileLayer(
                'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    attribution: '© Esri',
                    maxZoom: 19
                }),
        };
        tiles.street.addTo(map);

        function setTile(type) {
            Object.values(tiles).forEach(t => map.removeLayer(t));
            tiles[type].addTo(map);
            document.querySelectorAll('.tile-btn').forEach(b => b.classList.remove('border-blue-500'));
            document.getElementById('btn-' + type).classList.add('border-blue-500');
        }

        // ── OSRM — ROUTING VIA JALUR JALAN ──
        async function getRoute(latA, lonA, latB, lonB) {
            try {
                const url = `${OSRM}/${lonA},${latA};${lonB},${latB}?overview=full&geometries=geojson`;
                const res = await fetch(url);
                const data = await res.json();
                if (data.code !== 'Ok' || !data.routes.length) return null;
                const route = data.routes[0];
                const distance = route.distance; // meter
                const duration = route.duration; // detik
                const coords = route.geometry.coordinates.map(c => [c[1], c[0]]);
                return {
                    distance,
                    duration,
                    coords
                };
            } catch (e) {
                console.error('OSRM error:', e);
                return null;
            }
        }

        function formatDuration(seconds) {
            const m = Math.round(seconds / 60);
            if (m < 60) return `${m} menit`;
            const h = Math.floor(m / 60);
            const rem = m % 60;
            return rem ? `${h} jam ${rem} menit` : `${h} jam`;
        }

        function formatDistance(meters) {
            if (meters < 1000) return `${Math.round(meters)} m`;
            return `${(meters / 1000).toFixed(2)} km`;
        }

        // ── MAP CLICK ──
        map.on('click', function(e) {
            if (!mapClickMode) return;
            const {
                lat,
                lng
            } = e.latlng;
            const mode = mapClickMode;
            nonaktifkanKlik();
            if (mode === 'terdekat') {
                document.getElementById('terdekat-koordinat').classList.remove('hidden');
                document.getElementById('terdekat-lat-lon').textContent =
                    `Lat: ${lat.toFixed(5)}, Lon: ${lng.toFixed(5)}`;
                document.getElementById('terdekat-hint').classList.add('hidden');
                cariFaskesTermedkat(lat, lng);
            } else if (mode === 'radius') {
                radiusCenter = {
                    lat,
                    lng
                };
                document.getElementById('radius-koordinat').classList.remove('hidden');
                document.getElementById('radius-lat-lon').textContent =
                    `Lat: ${lat.toFixed(5)}, Lon: ${lng.toFixed(5)}`;
                document.getElementById('btn-cari-radius').disabled = false;
                gambarPreviewRadius(lat, lng, parseInt(document.getElementById('radius-slider-tool').value));
            }
        });

        // ── TABS ──
        function switchTab(tab) {
            document.querySelectorAll('.tool-panel').forEach(p => p.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.getElementById('panel-' + tab).classList.add('active');
            document.getElementById('tab-' + tab).classList.add('active');
            nonaktifkanKlik();
            if (tab === 'peta') {
                Object.values(markerMap).forEach(m => setOpacity(m, 1));
                clearTerdekatLayers();
                clearRoute();
            }
        }

        function aktivasiKlikPeta(mode) {
            mapClickMode = mode;
            map.getContainer().style.cursor = 'crosshair';
            document.getElementById('mode-indicator').classList.remove('hidden');
            const btn = mode === 'terdekat' ? 'btn-klik-terdekat' : 'btn-klik-radius';
            document.getElementById(btn).classList.add('btn-mode-active');
        }

        function nonaktifkanKlik() {
            mapClickMode = null;
            map.getContainer().style.cursor = '';
            document.getElementById('mode-indicator').classList.add('hidden');
            ['btn-klik-terdekat', 'btn-klik-radius'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.classList.remove('btn-mode-active');
            });
        }

        function setOpacity(marker, val) {
            const el = marker.getElement();
            if (el) el.style.opacity = val;
        }

        function locateMe() {
            map.locate({
                setView: true,
                maxZoom: 16
            });
            map.once('locationfound', e => {
                L.circleMarker(e.latlng, {
                        radius: 8,
                        color: '#10b981',
                        fillColor: '#10b981',
                        fillOpacity: 0.9,
                        weight: 3
                    })
                    .addTo(map).bindPopup('<b>📡 Lokasi Anda</b>').openPopup();
            });
            map.once('locationerror', () => alert('Tidak dapat mengakses GPS.'));
        }

        function gunakanGPS() {
            map.locate({
                setView: true,
                maxZoom: 16
            });
            map.once('locationfound', e => {
                const {
                    lat,
                    lng
                } = e.latlng;
                document.getElementById('terdekat-koordinat').classList.remove('hidden');
                document.getElementById('terdekat-lat-lon').textContent =
                    `Lat: ${lat.toFixed(5)}, Lon: ${lng.toFixed(5)}`;
                document.getElementById('terdekat-hint').classList.add('hidden');
                L.circleMarker([lat, lng], {
                        radius: 8,
                        color: '#10b981',
                        fillColor: '#10b981',
                        fillOpacity: 0.9,
                        weight: 3
                    })
                    .addTo(map).bindPopup('<b>📡 Lokasi Anda</b>').openPopup();
                cariFaskesTermedkat(lat, lng);
            });
            map.once('locationerror', () => alert('Tidak dapat mengakses GPS.'));
        }

        // ══════════════════════════════════════
        // DETAIL PANEL
        // ══════════════════════════════════════
        function openDetail(p) {
            const color = p.warna_marker || '#2563eb';
            const header = document.getElementById('detail-header');
            header.style.background = `linear-gradient(135deg, ${color}, ${color}cc)`;

            document.getElementById('detail-badge').textContent = p.nama_jenis || '-';
            document.getElementById('detail-nama').textContent = p.nama_faskes;
            document.getElementById('detail-alamat').textContent = `${p.alamat || ''}, ${p.kecamatan || ''}`;

            // Status badges
            const badgesEl = document.getElementById('detail-badges');
            badgesEl.innerHTML = '';
            const badges = [{
                    show: true,
                    label: p.status === 'Aktif' ? '● Aktif' : '● Tidak Aktif',
                    cls: p.status === 'Aktif' ? 'bg-emerald-400/30 text-white' : 'bg-red-400/30 text-white'
                },
                {
                    show: p.bpjs,
                    label: '✓ BPJS',
                    cls: 'bg-indigo-400/30 text-white'
                },
                {
                    show: p.kelas_rs,
                    label: `Kelas ${p.kelas_rs}`,
                    cls: 'bg-white/20 text-white'
                },
            ];
            badges.forEach(b => {
                if (!b.show) return;
                const span = document.createElement('span');
                span.className =
                    `inline-block px-2.5 py-1 rounded-full text-xs font-semibold border border-white/20 ${b.cls}`;
                span.textContent = b.label;
                badgesEl.appendChild(span);
            });

            // Body info
            const body = document.getElementById('detail-body');
            const rows = [{
                    icon: '📋',
                    label: 'Kode Faskes',
                    val: p.kode_faskes
                },
                {
                    icon: '🏷',
                    label: 'Kategori',
                    val: p.kategori
                },
                {
                    icon: '🏢',
                    label: 'Kepemilikan',
                    val: p.status_kepemilikan
                },
                {
                    icon: '📍',
                    label: 'Kelurahan',
                    val: p.kelurahan
                },
                {
                    icon: '🏙',
                    label: 'Kecamatan',
                    val: p.kecamatan
                },
                {
                    icon: '📮',
                    label: 'Kode Pos',
                    val: p.kode_pos
                },
                {
                    icon: '📞',
                    label: 'Telepon',
                    val: p.telepon
                },
                {
                    icon: '🕐',
                    label: 'Jam Operasional',
                    val: p.jam_operasional
                },
                {
                    icon: '🛏',
                    label: 'Kapasitas TT',
                    val: p.kapasitas_tempat_tidur ? `${p.kapasitas_tempat_tidur} tempat tidur` : null
                },
                {
                    icon: '🏅',
                    label: 'Akreditasi',
                    val: p.akreditasi
                },
            ];

            body.innerHTML = '';
            rows.forEach(row => {
                if (!row.val) return;
                const div = document.createElement('div');
                div.className = 'info-row';
                div.innerHTML = `
            <span class="info-icon text-sm">${row.icon}</span>
            <div>
                <p class="text-xs text-slate-400 font-semibold">${row.label}</p>
                <p class="info-value font-medium">${row.val}</p>
            </div>`;
                body.appendChild(div);
            });

            // Footer aksi
            const footer = document.getElementById('detail-footer');
            footer.innerHTML = `
        <a href="/faskes/${p.id}"
           class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl bg-blue-600 text-white text-xs font-bold hover:bg-blue-700 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            Lihat Detail Lengkap
        </a>
        <a href="/faskes/${p.id}/edit"
           class="flex items-center justify-center gap-2 w-full py-2 rounded-xl border border-slate-200 text-slate-600 text-xs font-semibold hover:bg-slate-50 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit Data Faskes
        </a>
        ${p.link_googlemaps ? `
            <a href="${p.link_googlemaps}" target="_blank"
               class="flex items-center justify-center gap-2 w-full py-2 rounded-xl border border-slate-200 text-slate-600 text-xs font-semibold hover:bg-slate-50 transition-colors">
                🗺 Buka Google Maps
            </a>` : ''}`;

            document.getElementById('detail-panel').classList.add('open');
        }

        function closeDetail() {
            document.getElementById('detail-panel').classList.remove('open');
        }

        // ══════════════════════════════════════
        // ① FASKES TERDEKAT via OSRM
        // ══════════════════════════════════════
        async function cariFaskesTermedkat(lat, lng) {
            const limit = parseInt(document.getElementById('terdekat-limit').value);
            const hasil = document.getElementById('hasil-terdekat');
            hasil.innerHTML = `<div class="flex justify-center py-8"><div class="spinner"></div></div>`;
            clearTerdekatLayers();
            Object.values(markerMap).forEach(m => setOpacity(m, 0.2));

            // Marker titik asal
            const pusat = L.circleMarker([lat, lng], {
                    radius: 9,
                    color: '#f59e0b',
                    fillColor: '#fbbf24',
                    fillOpacity: 1,
                    weight: 3
                })
                .addTo(map).bindPopup('<b>📌 Titik Asal</b>');
            terdekatLayers.push(pusat);

            // Ambil semua faskes lalu hitung jarak via OSRM
            const candidates = allFeatures.filter(f => f.geometry?.coordinates);
            hasil.innerHTML =
                `<div class="text-center py-4 text-xs text-slate-500"><div class="spinner mx-auto mb-2"></div>Menghitung rute via jalur jalan...</div>`;

            const withRoute = [];
            // Hitung paralel, batas 10 kandidat terdekat berdasarkan jarak udara dulu
            const sorted = candidates.map(f => {
                const [flon, flat] = f.geometry.coordinates;
                const d = Math.hypot(flat - lat, flon - lng);
                return {
                    f,
                    d
                };
            }).sort((a, b) => a.d - b.d).slice(0, Math.min(15, candidates.length));

            for (const {
                    f
                }
                of sorted) {
                const [flon, flat] = f.geometry.coordinates;
                const route = await getRoute(lat, lng, flat, flon);
                if (route) withRoute.push({
                    f,
                    route
                });
                if (withRoute.length >= limit) break;
            }

            withRoute.sort((a, b) => a.route.distance - b.route.distance);

            if (!withRoute.length) {
                hasil.innerHTML =
                    `<div class="text-center py-8 text-slate-400"><p class="text-2xl mb-2">🔍</p><p class="text-sm">Tidak ada rute ditemukan.</p></div>`;
                return;
            }

            hasil.innerHTML =
                `<p class="text-xs font-bold text-slate-500 mb-2 uppercase tracking-wider">${withRoute.length} Faskes Terdekat (via jalan)</p>`;

            withRoute.forEach(({
                f,
                route
            }, idx) => {
                const p = f.properties;
                const color = p.warna_marker || '#3b82f6';
                if (markerMap[p.id]) setOpacity(markerMap[p.id], 1);

                // Gambar rute
                const routeLine = L.polyline(route.coords, {
                    color,
                    weight: 3,
                    opacity: 0.8
                }).addTo(map);
                terdekatLayers.push(routeLine);

                // Label jarak di tengah rute
                const mid = route.coords[Math.floor(route.coords.length / 2)];
                if (mid) {
                    const lbl = L.marker(mid, {
                        icon: L.divIcon({
                            className: '',
                            html: `<div style="background:white;border:1.5px solid ${color};border-radius:8px;padding:2px 7px;font-size:10px;font-weight:700;color:${color};white-space:nowrap;box-shadow:0 2px 6px rgba(0,0,0,0.12);">${formatDistance(route.distance)}</div>`,
                            iconAnchor: [35, 10],
                        }),
                    }).addTo(map);
                    terdekatLayers.push(lbl);
                }

                // Card
                const card = document.createElement('div');
                card.className =
                    'result-card bg-white rounded-xl border border-slate-100 p-3 shadow-sm cursor-pointer hover:shadow-md transition-all';
                card.onclick = () => {
                    if (markerMap[p.id]) {
                        markerMap[p.id].openPopup();
                        map.setView(markerMap[p.id].getLatLng(), 17, {
                            animate: true
                        });
                    }
                };
                card.innerHTML = `
            <div class="flex items-start gap-2.5">
                <div class="w-7 h-7 rounded-full flex-shrink-0 flex items-center justify-center text-white text-xs font-extrabold shadow-sm" style="background:${color};">${idx+1}</div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-bold text-slate-800 leading-snug">${p.nama_faskes}</p>
                    <p class="text-xs text-slate-400 truncate">${p.nama_jenis} · ${p.kecamatan}</p>
                    <div class="flex items-center gap-3 mt-1">
                        <span class="text-xs font-extrabold text-blue-600">🛣 ${formatDistance(route.distance)}</span>
                        <span class="text-xs text-slate-400">⏱ ${formatDuration(route.duration)}</span>
                    </div>
                </div>
            </div>`;
                hasil.appendChild(card);
            });

            map.fitBounds(L.latLngBounds([
                [lat, lng], ...withRoute.map(({
                    route
                }) => route.coords[0])
            ]).pad(0.2));
        }

        function clearTerdekatLayers() {
            terdekatLayers.forEach(l => map.removeLayer(l));
            terdekatLayers = [];
            Object.values(markerMap).forEach(m => setOpacity(m, 1));
        }

        // ══════════════════════════════════════
        // ② RADIUS
        // ══════════════════════════════════════
        function updateRadiusLabel(val) {
            document.getElementById('radius-label-display').textContent = Number(val).toLocaleString('id') + ' m';
            if (radiusCenter) gambarPreviewRadius(radiusCenter.lat, radiusCenter.lng, parseInt(val));
        }

        function gambarPreviewRadius(lat, lng, radius) {
            if (radiusLayer) map.removeLayer(radiusLayer);
            if (centerMarker) map.removeLayer(centerMarker);
            radiusLayer = L.circle([lat, lng], {
                radius,
                color: '#2563eb',
                fillColor: '#3b82f6',
                fillOpacity: 0.07,
                weight: 2,
                dashArray: '6,4'
            }).addTo(map);
            centerMarker = L.circleMarker([lat, lng], {
                    radius: 7,
                    color: '#2563eb',
                    fillColor: 'white',
                    fillOpacity: 1,
                    weight: 3
                })
                .addTo(map).bindPopup(
                    `<b>📌 Titik Pusat</b><br><small>Radius: ${Number(radius).toLocaleString('id')} m</small>`);
            map.fitBounds(radiusLayer.getBounds().pad(0.1));
        }

        async function jalankanRadius() {
            if (!radiusCenter) return;
            const radius = parseInt(document.getElementById('radius-slider-tool').value);
            const {
                lat,
                lng
            } = radiusCenter;
            const hasil = document.getElementById('hasil-radius');
            gambarPreviewRadius(lat, lng, radius);
            hasil.innerHTML = `<div class="flex justify-center py-6"><div class="spinner"></div></div>`;
            Object.values(markerMap).forEach(m => setOpacity(m, 0.15));
            try {
                const res = await fetch(`${BASE_URL}/api/spasial/radius?lat=${lat}&lon=${lng}&radius=${radius}`);
                const data = await res.json();
                const ids = new Set(data.data.map(d => d.id));
                Object.entries(markerMap).forEach(([id, m]) => setOpacity(m, ids.has(parseInt(id)) ? 1 : 0.1));
                if (!data.data.length) {
                    hasil.innerHTML =
                        `<div class="text-center py-8"><p class="text-2xl mb-2">🔍</p><p class="text-sm font-semibold text-slate-600">Tidak ada faskes dalam radius ${formatDistance(radius)}</p></div>`;
                    return;
                }
                hasil.innerHTML =
                    `<div class="bg-gradient-to-r from-blue-600 to-cyan-500 rounded-xl p-3 mb-2 text-center text-white shadow"><p class="text-2xl font-extrabold">${data.total}</p><p class="text-xs opacity-90">faskes dalam radius ${formatDistance(radius)}</p></div>`;
                data.data.forEach(f => {
                    const feature = allFeatures.find(ft => ft.properties.id === f.id);
                    const color = feature?.properties.warna_marker || '#3b82f6';
                    const card = document.createElement('div');
                    card.className =
                        'result-card bg-white rounded-xl border border-slate-100 p-3 shadow-sm cursor-pointer hover:shadow-md transition-all';
                    card.onclick = () => {
                        if (markerMap[f.id]) {
                            markerMap[f.id].openPopup();
                            map.setView(markerMap[f.id].getLatLng(), 17, {
                                animate: true
                            });
                        }
                    };
                    card.innerHTML = `
                <div class="flex items-start gap-2.5">
                    <div class="w-2.5 h-2.5 rounded-full mt-1.5 flex-shrink-0" style="background:${color};box-shadow:0 0 0 3px ${color}22;"></div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold text-slate-800 leading-snug">${f.nama_faskes}</p>
                        <p class="text-xs text-slate-400">${f.nama_jenis} · ${f.kecamatan}</p>
                        <span class="text-xs font-bold text-emerald-600">📍 ${formatDistance(f.jarak_meter)}</span>
                    </div>
                </div>`;
                    hasil.appendChild(card);
                });
            } catch (e) {
                hasil.innerHTML = `<p class="text-center text-red-400 text-sm py-4">⚠ Error: ${e.message}</p>`;
            }
        }

        function clearRadius() {
            if (radiusLayer) {
                map.removeLayer(radiusLayer);
                radiusLayer = null;
            }
            if (centerMarker) {
                map.removeLayer(centerMarker);
                centerMarker = null;
            }
            radiusCenter = null;
            document.getElementById('radius-koordinat').classList.add('hidden');
            document.getElementById('btn-cari-radius').disabled = true;
            document.getElementById('hasil-radius').innerHTML = '';
            Object.values(markerMap).forEach(m => setOpacity(m, 1));
        }

        // ══════════════════════════════════════
        // ③ JARAK 2 FASKES via OSRM (jalur jalan)
        // ══════════════════════════════════════
        function swapFaskes() {
            const a = document.getElementById('jarak-faskes-a');
            const b = document.getElementById('jarak-faskes-b');
            [a.value, b.value] = [b.value, a.value];
        }

        function clearRoute() {
            if (routeLayer) {
                map.removeLayer(routeLayer);
                routeLayer = null;
            }
            Object.values(markerMap).forEach(m => setOpacity(m, 1));
            document.getElementById('route-badge').classList.add('hidden');
        }

        async function hitungJarak() {
            const idA = document.getElementById('jarak-faskes-a').value;
            const idB = document.getElementById('jarak-faskes-b').value;
            const hasil = document.getElementById('hasil-jarak');
            if (!idA || !idB) {
                alert('Pilih kedua faskes!');
                return;
            }
            if (idA === idB) {
                alert('Pilih dua faskes BERBEDA!');
                return;
            }

            hasil.innerHTML = `<div class="flex justify-center py-8"><div class="spinner"></div></div>`;
            clearRoute();

            const featureA = allFeatures.find(f => f.properties.id === parseInt(idA));
            const featureB = allFeatures.find(f => f.properties.id === parseInt(idB));
            if (!featureA?.geometry || !featureB?.geometry) {
                hasil.innerHTML = `<p class="text-center text-red-400 text-sm py-4">Data koordinat tidak lengkap.</p>`;
                return;
            }

            const [lonA, latA] = featureA.geometry.coordinates;
            const [lonB, latB] = featureB.geometry.coordinates;
            const colorA = featureA.properties.warna_marker || '#3b82f6';
            const colorB = featureB.properties.warna_marker || '#ef4444';

            hasil.innerHTML =
                `<div class="text-center py-4 text-xs text-slate-500"><div class="spinner mx-auto mb-2"></div>Menghitung rute via jalur jalan...</div>`;

            const route = await getRoute(latA, lonA, latB, lonB);

            if (!route) {
                hasil.innerHTML =
                    `<p class="text-center text-red-400 text-sm py-4">⚠ Rute tidak ditemukan. Coba lagi.</p>`;
                return;
            }

            // Gambar rute di peta
            routeLayer = L.polyline(route.coords, {
                color: '#2563eb',
                weight: 5,
                opacity: 0.8,
                dashArray: null,
            }).addTo(map);

            // Highlight kedua marker
            Object.values(markerMap).forEach(m => setOpacity(m, 0.15));
            if (markerMap[idA]) setOpacity(markerMap[idA], 1);
            if (markerMap[idB]) setOpacity(markerMap[idB], 1);

            map.fitBounds(routeLayer.getBounds().pad(0.2));

            // Badge di peta
            const badge = document.getElementById('route-badge');
            document.getElementById('route-badge-text').textContent =
                `${formatDistance(route.distance)} · ${formatDuration(route.duration)}`;
            badge.classList.remove('hidden');

            // Hasil di sidebar
            hasil.innerHTML = `
        <div class="space-y-3 result-card">
            <div class="jarak-result rounded-2xl p-4 text-center text-white shadow-xl">
                <p class="text-xs font-semibold opacity-70 uppercase tracking-widest mb-1">🛣 Jarak via Jalur Jalan</p>
                <p class="text-4xl font-extrabold">${formatDistance(route.distance)}</p>
                <p class="text-sm opacity-80 mt-1 font-semibold">⏱ Estimasi ${formatDuration(route.duration)} berkendara</p>
            </div>

            <div class="bg-white rounded-xl border border-slate-100 p-3 shadow-sm">
                <div class="flex items-center gap-2 mb-1">
                    <span class="w-6 h-6 rounded-full text-white text-xs font-extrabold flex items-center justify-center flex-shrink-0" style="background:${colorA};">A</span>
                    <p class="text-sm font-bold text-slate-800 leading-tight">${featureA.properties.nama_faskes}</p>
                </div>
                <p class="text-xs text-slate-400 ml-8">${featureA.properties.alamat || ''}</p>
            </div>

            <div class="flex items-center gap-2 px-2">
                <div class="flex-1 border-t-2 border-dashed border-blue-200"></div>
                <span class="text-xs text-blue-500 font-bold whitespace-nowrap">🛣 ${formatDistance(route.distance)}</span>
                <div class="flex-1 border-t-2 border-dashed border-blue-200"></div>
            </div>

            <div class="bg-white rounded-xl border border-slate-100 p-3 shadow-sm">
                <div class="flex items-center gap-2 mb-1">
                    <span class="w-6 h-6 rounded-full text-white text-xs font-extrabold flex items-center justify-center flex-shrink-0" style="background:${colorB};">B</span>
                    <p class="text-sm font-bold text-slate-800 leading-tight">${featureB.properties.nama_faskes}</p>
                </div>
                <p class="text-xs text-slate-400 ml-8">${featureB.properties.alamat || ''}</p>
            </div>

            <button onclick="resetJarak()" class="w-full py-2 rounded-xl border border-slate-200 text-xs text-slate-500 hover:bg-slate-50 transition-all">🔄 Reset & Pilih Ulang</button>
        </div>`;
        }

        function resetJarak() {
            clearRoute();
            document.getElementById('hasil-jarak').innerHTML = '';
            document.getElementById('jarak-faskes-a').value = '';
            document.getElementById('jarak-faskes-b').value = '';
        }

        // ══════════════════════════════════════
        // AUTO FOCUS DARI HOMEPAGE
        // ══════════════════════════════════════
        function autoFocusDariHomepage() {
            const params = new URLSearchParams(window.location.search);
            const lat = parseFloat(params.get('lat'));
            const lon = parseFloat(params.get('lon'));
            const id = parseInt(params.get('id'));
            const nama = params.get('nama') ? decodeURIComponent(params.get('nama')) : null;
            if (!id || isNaN(lat) || isNaN(lon)) return;

            focusedId = id;
            Object.entries(markerMap).forEach(([mid, m]) => setOpacity(m, parseInt(mid) === id ? 1 : 0.2));
            map.setView([lat, lon], 18, {
                animate: true
            });

            setTimeout(() => {
                const marker = markerMap[id];
                if (marker) {
                    marker.openPopup();
                    highlightCard(id);
                }
                if (nama) {
                    document.getElementById('focus-banner').classList.remove('hidden');
                    document.getElementById('focus-nama').textContent = `📍 ${nama}`;
                    document.getElementById('focus-badge').classList.remove('hidden');
                    document.getElementById('focus-badge-nama').textContent = nama;
                }
            }, 600);
        }

        function clearFocus() {
            focusedId = null;
            Object.values(markerMap).forEach(m => setOpacity(m, 1));
            document.getElementById('focus-banner').classList.add('hidden');
            document.getElementById('focus-badge').classList.add('hidden');
            map.setView(CENTER, 14, {
                animate: true
            });
            if (selectedCard) {
                document.getElementById(`card-${selectedCard}`)?.classList.remove('selected-card');
                selectedCard = null;
            }
            closeDetail();
            window.history.replaceState({}, '', window.location.pathname);
        }


        // ── LEGENDA ──
        let legendOpen = true;

        function toggleLegend() {
            legendOpen = !legendOpen;
            const body = document.getElementById('legend-body');
            const icon = document.getElementById('legend-toggle-icon');
            body.className = legendOpen ? 'expanded' : 'collapsed';
            icon.style.transform = legendOpen ? 'rotate(0deg)' : 'rotate(180deg)';
        }

        function buildLegend() {
            const jenisMap = {};
            allFeatures.forEach(f => {
                const p = f.properties;
                if (!p.nama_jenis) return;
                if (!jenisMap[p.nama_jenis]) {
                    jenisMap[p.nama_jenis] = {
                        color: p.warna_marker || '#3b82f6',
                        ikon: p.ikon || '?',
                        count: 0
                    };
                }
                jenisMap[p.nama_jenis].count++;
            });

            const container = document.getElementById('legend-items');
            container.innerHTML = '';

            Object.entries(jenisMap).forEach(([nama, info]) => {
                const item = document.createElement('div');
                item.className = 'flex items-center gap-2 cursor-pointer hover:opacity-80 transition-opacity';
                item.title = `Filter: ${nama}`;
                item.onclick = () => {
                    filterJenis(nama);
                    switchTab('peta');
                };
                item.innerHTML = `
            <div style="
                width:20px; height:20px;
                border-radius: 50% 50% 50% 0;
                transform: rotate(-45deg);
                background: ${info.color};
                border: 2px solid white;
                box-shadow: 0 2px 6px rgba(0,0,0,0.2);
                flex-shrink: 0;
            "></div>
            <div class="flex-1 min-w-0">
                <span class="text-xs font-semibold text-slate-700">${nama}</span>
                <span class="text-xs text-slate-400 ml-1">(${info.count})</span>
            </div>`;
                container.appendChild(item);
            });
        }

        // ══════════════════════════════════════
        // LOAD & RENDER
        // ══════════════════════════════════════
        function createIcon(color, ikon) {
            const bg = color || '#3b82f6';
            const label = (ikon || '?').substring(0, 2).toUpperCase();
            return L.divIcon({
                className: '',
                html: `<div style="width:34px;height:34px;border-radius:50% 50% 50% 0;transform:rotate(-45deg);background:${bg};border:2.5px solid white;box-shadow:0 3px 10px rgba(0,0,0,0.25);display:flex;align-items:center;justify-content:center;"><span style="transform:rotate(45deg);font-size:10px;font-weight:800;color:white;">${label}</span></div>`,
                iconSize: [34, 34],
                iconAnchor: [17, 34],
                popupAnchor: [0, -36],
            });
        }

        function buildPopup(p) {
            const color = p.warna_marker || '#3b82f6';
            const bpjs = p.bpjs ?
                `<span style="background:#dbeafe;color:#1e40af;padding:1px 7px;border-radius:99px;font-size:10px;font-weight:700;">✓ BPJS</span>` :
                `<span style="background:#fee2e2;color:#991b1b;padding:1px 7px;border-radius:99px;font-size:10px;font-weight:700;">Non BPJS</span>`;
            return `<div style="font-family:'Plus Jakarta Sans',sans-serif;">
        <div style="background:${color};padding:10px 14px 8px;">
            <p style="font-size:12px;font-weight:800;color:white;margin:0 16px 3px 0;line-height:1.3;">${p.nama_faskes}</p>
            <span style="background:white;color:${color};padding:1px 7px;border-radius:99px;font-size:10px;font-weight:700;">${p.nama_jenis||'-'}</span>
        </div>
        <div style="padding:8px 14px;">
            <p style="font-size:11px;color:#64748b;margin-bottom:4px;">📍 ${p.alamat||''}, ${p.kecamatan||''}</p>
            <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;margin-top:6px;">
                ${bpjs}
                <button onclick="openDetailFromPopup(${p.id})"
                    style="background:${color};color:white;border:none;padding:3px 10px;border-radius:99px;font-size:10px;font-weight:700;cursor:pointer;">
                    Detail →
                </button>
            </div>
        </div>
    </div>`;
        }

        function openDetailFromPopup(id) {
            const feature = allFeatures.find(f => f.properties.id === id);
            if (!feature) return;
            openDetail(feature.properties);
        }
        window.openDetailFromPopup = openDetailFromPopup;

        async function loadFaskes() {
            try {
                const res = await fetch(`${BASE_URL}/api/spasial/geojson`);
                const data = await res.json();
                allFeatures = data.features || [];
                buildFilters();
                renderAll(allFeatures);
                populateDropdowns();
                document.getElementById('loading').style.opacity = '0';
                setTimeout(() => document.getElementById('loading').style.display = 'none', 300);
                autoFocusDariHomepage();
                buildLegend();
            } catch (e) {
                document.getElementById('loading').innerHTML =
                    `<p class="text-red-500 font-semibold text-sm">Gagal memuat data.</p>`;
            }
        }

        function populateDropdowns() {
            const selA = document.getElementById('jarak-faskes-a');
            const selB = document.getElementById('jarak-faskes-b');
            const byJenis = {};
            allFeatures.forEach(f => {
                const j = f.properties.nama_jenis || 'Lainnya';
                if (!byJenis[j]) byJenis[j] = [];
                byJenis[j].push(f);
            });
            Object.entries(byJenis).forEach(([jenis, features]) => {
                const ogA = document.createElement('optgroup');
                const ogB = document.createElement('optgroup');
                ogA.label = ogB.label = jenis;
                features.forEach(f => {
                    const opt = document.createElement('option');
                    opt.value = f.properties.id;
                    opt.textContent = f.properties.nama_faskes;
                    ogA.appendChild(opt.cloneNode(true));
                    ogB.appendChild(opt);
                });
                selA.appendChild(ogA);
                selB.appendChild(ogB);
            });
        }

        function buildFilters() {
            const jenisSet = [...new Set(allFeatures.map(f => f.properties.nama_jenis).filter(Boolean))];
            const container = document.getElementById('filter-container');
            jenisSet.forEach(jenis => {
                const color = allFeatures.find(f => f.properties.nama_jenis === jenis)?.properties.warna_marker ||
                    '#3b82f6';
                const count = allFeatures.filter(f => f.properties.nama_jenis === jenis).length;
                const btn = document.createElement('button');
                btn.onclick = () => filterJenis(jenis);
                btn.dataset.jenis = jenis;
                btn.className = 'filter-btn px-2.5 py-1 rounded-full text-xs font-semibold border-2 transition-all';
                btn.style.cssText = `border-color:${color};color:${color};background:white;`;
                btn.textContent = `${jenis} (${count})`;
                container.appendChild(btn);
            });
        }

        function renderAll(features) {
            Object.values(markerMap).forEach(m => map.removeLayer(m));
            markerMap = {};
            const listEl = document.getElementById('faskes-list');
            listEl.innerHTML = '';
            if (!features.length) {
                listEl.innerHTML =
                    `<div class="px-4 py-8 text-center text-slate-400 text-xs">Tidak ada faskes ditemukan.</div>`;
                updateStats(features);
                return;
            }
            features.forEach(feature => {
                const p = feature.properties;
                const geom = feature.geometry;
                if (!geom?.coordinates) return;
                const [lon, lat] = geom.coordinates;
                const color = p.warna_marker || '#3b82f6';

                const marker = L.marker([lat, lon], {
                        icon: createIcon(color, p.ikon)
                    })
                    .bindPopup(buildPopup(p), {
                        maxWidth: 240
                    });

                marker.on('click', () => {
                    highlightCard(p.id);
                    // Buka detail panel saat marker diklik
                    setTimeout(() => openDetail(p), 200);
                });
                marker.addTo(map);
                markerMap[p.id] = marker;

                const card = document.createElement('div');
                card.id = `card-${p.id}`;
                card.className = 'faskes-card px-3 py-2.5';
                card.onclick = () => {
                    marker.openPopup();
                    map.setView([lat, lon], 16, {
                        animate: true
                    });
                    highlightCard(p.id);
                    openDetail(p);
                };
                const bpjs = p.bpjs ?
                    `<span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700">BPJS</span>` :
                    '';
                card.innerHTML = `
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg flex-shrink-0 flex items-center justify-center" style="background:${color}22;">
                    <span style="font-size:10px;font-weight:800;color:${color};">${(p.ikon||'?').substring(0,2).toUpperCase()}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-slate-800 truncate">${p.nama_faskes}</p>
                    <p class="text-xs text-slate-400 truncate">${p.kecamatan}</p>
                    <div class="flex gap-1 mt-0.5">
                        <span class="inline-block px-1.5 py-0.5 rounded-full text-xs font-semibold" style="background:${color}18;color:${color};font-size:10px;">${p.nama_jenis}</span>
                        ${bpjs}
                    </div>
                </div>
                <span class="text-blue-300 text-base">›</span>
            </div>`;
                listEl.appendChild(card);
            });
            updateStats(features);
        }

        function highlightCard(id) {
            if (selectedCard) document.getElementById(`card-${selectedCard}`)?.classList.remove('selected-card');
            selectedCard = id;
            const card = document.getElementById(`card-${id}`);
            if (card) {
                card.classList.add('selected-card');
                card.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
            }
        }

        function filterJenis(jenis) {
            activeJenis = jenis;
            document.querySelectorAll('.filter-btn').forEach(btn => {
                const isActive = (btn.dataset.jenis === jenis) || (jenis === 'semua' && !btn.dataset.jenis);
                const color = allFeatures.find(f => f.properties.nama_jenis === btn.dataset.jenis)?.properties
                    .warna_marker || '#2563eb';
                btn.style.background = isActive ? (jenis === 'semua' ? '#2563eb' : color) : 'white';
                btn.style.color = isActive ? 'white' : color;
            });
            applyFilters();
        }

        document.getElementById('search-input').addEventListener('input', applyFilters);

        function applyFilters() {
            const q = document.getElementById('search-input').value.toLowerCase();
            let r = allFeatures;
            if (activeJenis !== 'semua') r = r.filter(f => f.properties.nama_jenis === activeJenis);
            if (q) r = r.filter(f =>
                f.properties.nama_faskes.toLowerCase().includes(q) ||
                (f.properties.kecamatan || '').toLowerCase().includes(q) ||
                (f.properties.alamat || '').toLowerCase().includes(q));
            renderAll(r);
        }

        function updateStats(features) {
            document.getElementById('stat-total').textContent = allFeatures.length;
            document.getElementById('stat-tampil').textContent = features.length;
            document.getElementById('stat-bpjs').textContent = features.filter(f => f.properties.bpjs).length;
        }

        loadFaskes();
    </script>
</body>

</html>
