@extends('layouts.admin')
@section('title', 'Upload Data')
@section('page-title', 'Upload Data TXT')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-5xl">

        {{-- ===================== --}}
        {{-- FORM FORMAT 1 --}}
        {{-- ===================== --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold text-slate-800 mb-2">
                Upload Format 1
            </h2>

            <p class="text-sm text-slate-500 mb-4">
                Format data diawali langsung dengan <b>NIK</b> (tanpa label).
            </p>

            {{-- Toggle Contoh Data --}}
            <details class="mb-4 rounded-md border border-slate-200 bg-slate-50 p-3">
                <summary class="cursor-pointer text-sm font-medium text-blue-600">
                    Lihat contoh format data
                </summary>

                <textarea readonly rows="14" class="mt-3 w-full rounded-md border border-slate-300 bg-white
                    p-3 text-xs font-mono text-slate-700 resize-none focus:outline-none">31/01/26 17.34 - +62 896-3774-5762: 7371080201870001
                    DENNY IBNU DARMAWAN
                    12017419719
                    02-01-1987
                    rajamuda872+dennyibnudarmawan21@gmail.com
                    2821823
                    SENSOR 2
                    09** 14**
                    SUMBER KARYA KLIN
                    IURAN TERAKHIR
                    AUG 2013
                    Lokasi:
                    GOWA
                    PALLANGGA
                    PARANGBANOA
                    LANJUT_JMO
                </textarea>

                <p class="mt-1 text-xs text-slate-500">
                    ⚠️ Urutan baris harus konsisten dan diawali NIK.
                </p>
            </details>

            <form action="/upload" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <input type="hidden" name="format_type" value="format_1">

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        File TXT (Format 1)
                    </label>

                    <input type="file" name="file" accept=".txt" required class="block w-full text-sm text-slate-600
                               file:mr-4 file:rounded-md file:border-0
                               file:bg-slate-200 file:px-4 file:py-2
                               file:text-slate-700 hover:file:bg-slate-300">
                </div>

                <button type="submit" class="w-full rounded-md bg-blue-600 py-2 text-white
                           hover:bg-blue-500 transition">
                    Upload Format 1
                </button>
            </form>
        </div>

        {{-- ===================== --}}
        {{-- FORM FORMAT 2 --}}
        {{-- ===================== --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold text-slate-800 mb-2">
                Upload Format 2
            </h2>

            <p class="text-sm text-slate-500 mb-4">
                Format data menggunakan <b>label</b> (Nama, NIK, KPJ, TTL, dll).
            </p>

            {{-- Toggle Contoh Data --}}
            <details class="mb-4 rounded-md border border-slate-200 bg-slate-50 p-3">
                <summary class="cursor-pointer text-sm font-medium text-blue-600">
                    Lihat contoh format data
                </summary>

                <textarea readonly rows="12" class="mt-3 w-full rounded-md border border-slate-300 bg-white
                    p-3 text-xs font-mono text-slate-700 resize-none focus:outline-none">
                    31/01/26 17.37 - +62 896-3774-5762: Nama       : FINA
                    NIK        : 9103015109730006
                    KPJ        : 12037657165
                    TTL        : WA***A, 11-09-1973
                    fina739@ccmail.uk
                    1615192
                    SOE MAKMUR RESOURCES
                    IURAN TERAKHIR
                    APR 2014
                    Kelurahan  : SENTANI KOTA
                    Kecamatan  : SENTANI
                    Kota       : JAYAPURA
                </textarea>

                <p class="mt-1 text-xs text-slate-500">
                    ⚠️ Label harus lengkap dan konsisten.
                </p>
            </details>

            <form action="/upload" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <input type="hidden" name="format_type" value="format_2">

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        File TXT (Format 2)
                    </label>

                    <input type="file" name="file" accept=".txt" required class="block w-full text-sm text-slate-600
                               file:mr-4 file:rounded-md file:border-0
                               file:bg-slate-200 file:px-4 file:py-2
                               file:text-slate-700 hover:file:bg-slate-300">
                </div>

                <button type="submit" class="w-full rounded-md bg-blue-600 py-2 text-white
                           hover:bg-blue-500 transition">
                    Upload Format 2
                </button>
            </form>
        </div>

    </div>
@endsection
