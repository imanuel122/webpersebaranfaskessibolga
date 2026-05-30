<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data Faskes — Sibolga</title>
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

        .table-row:hover td {
            background: #eff6ff;
        }

        .badge-negeri {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-swasta {
            background: #fce7f3;
            color: #9d174d;
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

    @include('components.navbar')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Breadcrumb --}}
        <div class="flex flex-wrap items-center gap-2 text-xs text-slate-400 mb-6">
            <a href="{{ route('homepage') }}" class="hover:text-blue-600 transition-colors">Beranda</a>
            <span>›</span>
            <span class="text-slate-600 font-semibold">Data Faskes</span>
        </div>

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-slate-800">Data Fasilitas Kesehatan</h1>
                <p class="text-slate-500 text-sm mt-1">Kelola seluruh data faskes di Kota Sibolga</p>
            </div>
            <div
                class="flex flex-col min-[420px]:flex-row items-stretch min-[420px]:items-center gap-2 w-full md:w-auto">
                <a href="{{ route('peta') }}"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-blue-200 text-blue-600 text-sm font-semibold hover:bg-blue-50 transition-colors">
                    🗺 Lihat Peta
                </a>
                <a href="{{ route('faskes.create') }}"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-bold shadow hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Faskes
                </a>
            </div>
        </div>

        {{-- Stat mini --}}
        <div class="grid grid-cols-1 min-[420px]:grid-cols-3 gap-3 mb-6">
            <a href="{{ route('faskes.index') }}"
                class="bg-white rounded-2xl border border-slate-100 p-4 shadow-sm hover:shadow-md transition-all {{ !request()->hasAny(['status', 'bpjs']) ? 'ring-2 ring-blue-400' : '' }}">
                <p class="text-2xl font-extrabold text-blue-700">{{ number_format($totalFaskes) }}</p>
                <p class="text-xs text-slate-500 mt-0.5">Total Faskes</p>
            </a>
            <a href="{{ route('faskes.index') }}?status=Aktif"
                class="bg-white rounded-2xl border border-slate-100 p-4 shadow-sm hover:shadow-md transition-all {{ request('status') === 'Aktif' ? 'ring-2 ring-emerald-400' : '' }}">
                <p class="text-2xl font-extrabold text-emerald-600">{{ number_format($totalAktif) }}</p>
                <p class="text-xs text-slate-500 mt-0.5">Faskes Aktif</p>
            </a>
            <a href="{{ route('faskes.index') }}?bpjs=1"
                class="bg-white rounded-2xl border border-slate-100 p-4 shadow-sm hover:shadow-md transition-all {{ request('bpjs') ? 'ring-2 ring-indigo-400' : '' }}">
                <p class="text-2xl font-extrabold text-indigo-600">{{ number_format($totalBpjs) }}</p>
                <p class="text-xs text-slate-500 mt-0.5">Melayani BPJS</p>
            </a>
        </div>

        {{-- Filter & Search --}}
        <form method="GET" action="{{ route('faskes.index') }}"
            class="bg-white rounded-2xl border border-slate-100 p-4 shadow-sm mb-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-end">

            {{-- Search --}}
            <div class="sm:col-span-2 lg:col-span-4">
                <label class="text-xs font-semibold text-slate-500 block mb-1.5">Cari Faskes</label>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Nama, alamat, kecamatan..."
                        class="w-full pl-9 pr-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-400 transition-colors" />
                </div>
            </div>

            {{-- Filter Jenis --}}
            <div class="lg:col-span-2">
                <label class="text-xs font-semibold text-slate-500 block mb-1.5">Jenis Faskes</label>
                <select name="jenis"
                    class="w-full py-2.5 px-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-400 bg-white">
                    <option value="">Semua Jenis</option>
                    @foreach ($jenisFasilitas as $j)
                        <option value="{{ $j->id }}" {{ request('jenis') == $j->id ? 'selected' : '' }}>
                            {{ $j->nama_jenis }} ({{ $j->fasilitas_kesehatan_count }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Status --}}
            <div class="lg:col-span-2">
                <label class="text-xs font-semibold text-slate-500 block mb-1.5">Status</label>
                <select name="status"
                    class="w-full py-2.5 px-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-400 bg-white">
                    <option value="">Semua Status</option>
                    <option value="Aktif" {{ request('status') === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Tidak Aktif" {{ request('status') === 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif
                    </option>
                </select>
            </div>

            {{-- Filter BPJS --}}
            <div class="lg:col-span-2">
                <label class="text-xs font-semibold text-slate-500 block mb-1.5">BPJS</label>
                <select name="bpjs"
                    class="w-full py-2.5 px-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-400 bg-white">
                    <option value="">Semua</option>
                    <option value="1" {{ request('bpjs') === '1' ? 'selected' : '' }}>Melayani BPJS</option>
                    <option value="0" {{ request('bpjs') === '0' ? 'selected' : '' }}>Non BPJS</option>
                </select>
            </div>

            {{-- Buttons --}}
            <div class="flex gap-2 sm:col-span-2 lg:col-span-2">
                <button type="submit"
                    class="flex-1 px-5 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-bold hover:bg-blue-700 transition-colors">
                    Filter
                </button>
                <a href="{{ route('faskes.index') }}"
                    class="flex-1 text-center px-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-500 hover:bg-slate-50 transition-colors">
                    Reset
                </a>
            </div>
        </form>

        {{-- Jenis Faskes chips --}}
        @if ($jenisFasilitas->count())
            <div class="flex flex-wrap gap-2 mb-5">
                <a href="{{ route('faskes.index') }}"
                    class="px-3 py-1.5 rounded-full text-xs font-semibold transition-all {{ !request('jenis') ? 'bg-blue-600 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:border-blue-400 hover:text-blue-600' }}">
                    Semua
                </a>
                @foreach ($jenisFasilitas as $j)
                    <a href="{{ route('faskes.index') }}?jenis={{ $j->id }}"
                        class="px-3 py-1.5 rounded-full text-xs font-semibold transition-all border-2 {{ request('jenis') == $j->id ? 'text-white' : 'bg-white text-slate-600 hover:opacity-80' }}"
                        style="{{ request('jenis') == $j->id ? 'background:' . $j->warna_marker . ';border-color:' . $j->warna_marker : 'border-color:' . ($j->warna_marker ?? '#cbd5e1') . ';color:' . ($j->warna_marker ?? '#64748b') }}">
                        {{ $j->ikon }} {{ $j->nama_jenis }} ({{ $j->fasilitas_kesehatan_count }})
                    </a>
                @endforeach
            </div>
        @endif

        {{-- Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

            {{-- Info hasil filter --}}
            @if (request()->hasAny(['search', 'jenis', 'status', 'bpjs']))
                <div
                    class="px-4 sm:px-5 py-3 bg-blue-50 border-b border-blue-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <p class="text-xs text-blue-700 font-semibold leading-relaxed">
                        Menampilkan {{ $faskes->total() }} hasil filter
                        @if (request('search'))
                            · Pencarian: "{{ request('search') }}"
                        @endif
                        @if (request('status'))
                            · Status: {{ request('status') }}
                        @endif
                        @if (request('bpjs') !== null && request('bpjs') !== '')
                            · BPJS: {{ request('bpjs') ? 'Ya' : 'Tidak' }}
                        @endif
                    </p>
                    <a href="{{ route('faskes.index') }}"
                        class="text-xs text-blue-600 font-semibold hover:underline">Hapus filter</a>
                </div>
            @endif

            {{-- Tabel Desktop --}}
            <div class="hidden lg:block overflow-x-auto">
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
                            <th class="text-center px-5 py-4 font-semibold text-xs uppercase tracking-wider">Status
                            </th>
                            <th class="text-center px-5 py-4 font-semibold text-xs uppercase tracking-wider">BPJS</th>
                            <th class="text-center px-5 py-4 font-semibold text-xs uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($faskes as $index => $item)
                            <tr class="table-row transition-colors">
                                <td class="px-5 py-4 text-slate-400 font-medium text-xs">
                                    {{ $faskes->firstItem() + $index }}</td>
                                <td class="px-5 py-4">
                                    <p class="font-semibold text-slate-800">{{ $item->nama_faskes }}</p>
                                    <p class="text-xs text-slate-400 mt-0.5 truncate max-w-xs">{{ $item->alamat }}</p>
                                </td>
                                <td class="px-5 py-4">
                                    <span
                                        class="inline-block px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700">
                                        {{ $item->jenisFasilitas->nama_jenis ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-slate-600 text-xs">{{ $item->kecamatan }}</td>
                                <td class="px-5 py-4">
                                    @php $kep = strtolower($item->status_kepemilikan ?? ''); @endphp
                                    @if (str_contains($kep, 'negeri') || str_contains($kep, 'pemerintah'))
                                        <span
                                            class="badge-negeri inline-block px-2.5 py-1 rounded-full text-xs font-semibold">{{ $item->status_kepemilikan }}</span>
                                    @else
                                        <span
                                            class="badge-swasta inline-block px-2.5 py-1 rounded-full text-xs font-semibold">{{ $item->status_kepemilikan ?? '-' }}</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-center">
                                    @if ($item->status === 'Aktif')
                                        <span
                                            class="inline-block px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">●
                                            Aktif</span>
                                    @else
                                        <span
                                            class="inline-block px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-500">●
                                            Tidak Aktif</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-center">
                                    @if ($item->bpjs)
                                        <span
                                            class="inline-block px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700">✓
                                            BPJS</span>
                                    @else
                                        <span
                                            class="inline-block px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-600">Non
                                            BPJS</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="{{ route('faskes.show', $item->id) }}"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition-colors">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Detail
                                        </a>
                                        <a href="{{ route('faskes.edit', $item->id) }}"
                                            class="inline-flex items-center px-2.5 py-1.5 rounded-lg border border-slate-200 text-slate-500 text-xs hover:bg-amber-50 hover:border-amber-300 hover:text-amber-600 transition-colors">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('faskes.destroy', $item->id) }}" method="POST"
                                            class="form-delete inline" data-nama="{{ $item->nama_faskes }}">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center px-2.5 py-1.5 rounded-lg border border-slate-200 text-slate-500 text-xs hover:bg-red-50 hover:border-red-300 hover:text-red-600 transition-colors">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-5 py-14 text-center text-slate-400">
                                    <div class="text-4xl mb-3">🏥</div>
                                    <p class="font-semibold text-slate-600 mb-1">Tidak ada data faskes</p>
                                    <p class="text-xs mb-4">
                                        @if (request()->hasAny(['search', 'jenis', 'status', 'bpjs']))
                                            Coba ubah filter pencarian
                                        @else
                                            Belum ada data fasilitas kesehatan
                                        @endif
                                    </p>
                                    <a href="{{ route('faskes.create') }}"
                                        class="px-4 py-2 rounded-xl bg-blue-600 text-white text-xs font-bold hover:bg-blue-700 transition-colors">
                                        + Tambah Faskes
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Card Mobile & Tablet --}}
            <div class="lg:hidden divide-y divide-slate-100">
                @forelse($faskes as $index => $item)
                    <div class="p-4 sm:p-5 bg-white">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2 mb-2">
                                    <span
                                        class="w-7 h-7 rounded-full bg-blue-50 text-blue-700 text-xs font-bold flex items-center justify-center">
                                        {{ $faskes->firstItem() + $index }}
                                    </span>

                                    <span
                                        class="inline-block px-2.5 py-1 rounded-full text-[11px] font-semibold bg-blue-50 text-blue-700">
                                        {{ $item->jenisFasilitas->nama_jenis ?? '-' }}
                                    </span>

                                    @if ($item->status === 'Aktif')
                                        <span
                                            class="inline-block px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700">
                                            ● Aktif
                                        </span>
                                    @else
                                        <span
                                            class="inline-block px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-500">
                                            ● Tidak Aktif
                                        </span>
                                    @endif
                                </div>

                                <h3 class="font-extrabold text-slate-800 text-sm sm:text-base leading-snug">
                                    {{ $item->nama_faskes }}
                                </h3>

                                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                    {{ $item->alamat }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                            <div class="rounded-xl bg-slate-50 border border-slate-100 p-3">
                                <p class="text-slate-400 mb-1">Kecamatan</p>
                                <p class="font-semibold text-slate-700">{{ $item->kecamatan ?? '-' }}</p>
                            </div>

                            <div class="rounded-xl bg-slate-50 border border-slate-100 p-3">
                                <p class="text-slate-400 mb-1">Kepemilikan</p>
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
                            </div>
                        </div>

                        <div
                            class="mt-4 flex flex-col min-[420px]:flex-row min-[420px]:items-center justify-between gap-3">
                            <div>
                                @if ($item->bpjs)
                                    <span
                                        class="inline-block px-3 py-1.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700">
                                        ✓ Melayani BPJS
                                    </span>
                                @else
                                    <span
                                        class="inline-block px-3 py-1.5 rounded-full text-xs font-bold bg-rose-50 text-rose-600">
                                        Non BPJS
                                    </span>
                                @endif
                            </div>

                            <div class="flex items-center gap-2">
                                <a href="{{ route('faskes.show', $item->id) }}"
                                    class="flex-1 min-[420px]:flex-none inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl bg-blue-600 text-white text-xs font-bold hover:bg-blue-700 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Detail
                                </a>

                                <a href="{{ route('faskes.edit', $item->id) }}"
                                    class="inline-flex items-center justify-center w-9 h-9 rounded-xl border border-slate-200 text-slate-500 hover:bg-amber-50 hover:border-amber-300 hover:text-amber-600 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                <form action="{{ route('faskes.destroy', $item->id) }}" method="POST"
                                    class="form-delete inline" data-nama="{{ $item->nama_faskes }}">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center justify-center w-9 h-9 rounded-xl border border-slate-200 text-slate-500 hover:bg-red-50 hover:border-red-300 hover:text-red-600 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-5 py-14 text-center text-slate-400">
                        <div class="text-4xl mb-3">🏥</div>
                        <p class="font-semibold text-slate-600 mb-1">Tidak ada data faskes</p>
                        <p class="text-xs mb-4">
                            @if (request()->hasAny(['search', 'jenis', 'status', 'bpjs']))
                                Coba ubah filter pencarian
                            @else
                                Belum ada data fasilitas kesehatan
                            @endif
                        </p>
                        <a href="{{ route('faskes.create') }}"
                            class="px-4 py-2 rounded-xl bg-blue-600 text-white text-xs font-bold hover:bg-blue-700 transition-colors">
                            + Tambah Faskes
                        </a>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if ($faskes->hasPages())
                <div
                    class="px-4 sm:px-5 py-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <p class="text-xs text-slate-400 text-center sm:text-left">
                        Menampilkan {{ $faskes->firstItem() }}–{{ $faskes->lastItem() }} dari {{ $faskes->total() }}
                        faskes
                    </p>
                    <div class="flex items-center justify-center gap-1 flex-wrap">
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
        </div>
    </div>

    {{-- Modal konfirmasi hapus --}}
    <div id="delete-modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm px-4">
        <div class="bg-white rounded-2xl shadow-2xl p-5 sm:p-6 max-w-sm w-full animate-slideIn">
            <div class="w-14 h-14 rounded-2xl bg-red-100 flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>
            <h3 class="text-base font-extrabold text-slate-800 text-center mb-1">Hapus Faskes?</h3>
            <p class="text-sm text-slate-500 text-center mb-1">Apakah kamu yakin ingin menghapus:</p>
            <p id="delete-name" class="text-sm font-bold text-slate-800 text-center mb-5 px-4"></p>
            <p class="text-xs text-red-500 text-center mb-5">Data yang dihapus tidak dapat dikembalikan.</p>
            <div class="flex gap-3">
                <button onclick="cancelDelete()"
                    class="flex-1 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-colors">
                    Batal
                </button>
                <button id="confirm-delete-btn"
                    class="flex-1 py-2.5 rounded-xl bg-red-600 text-white text-sm font-bold hover:bg-red-700 transition-colors">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>

    <script>
        let pendingForm = null;

        // Tangkap semua form delete
        document.querySelectorAll('.form-delete').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                pendingForm = this;
                const nama = this.dataset.nama;
                document.getElementById('delete-name').textContent = '"' + nama + '"';
                document.getElementById('delete-modal').classList.remove('hidden');
            });
        });

        document.getElementById('confirm-delete-btn').addEventListener('click', function() {
            if (pendingForm) {
                pendingForm.submit();
            }
        });

        function cancelDelete() {
            document.getElementById('delete-modal').classList.add('hidden');
            pendingForm = null;
        }
    </script>

</body>

</html>
