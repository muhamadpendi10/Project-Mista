@extends($layout)
@section('title', 'Upload Data')
@section('page-title', 'Upload Data WhatsApp (.txt)')

@section('content')

<style>
.card {
    background: #fff;
    border-radius: 14px;
    padding: 24px;
    box-shadow: 0 10px 25px rgba(0,0,0,.05);
}

.card-format-1 {
    border-left: 5px solid #22c55e;
}

.card-format-2 {
    border-left: 5px solid #3b82f6;
}

.badge-green {
    background: #dcfce7;
    color: #166534;
}

.badge-blue {
    background: #dbeafe;
    color: #1e40af;
}

.btn-loading {
    opacity: .7;
    pointer-events: none;
}

.toast {
    position: fixed;
    top: 24px;
    left: 50%;
    transform: translateX(-50%) translateY(-10px);
    background: #16a34a;
    color: white;
    padding: 12px 20px;
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0,0,0,.2);
    opacity: 0;
    transition: all .3s ease;
    z-index: 9999;
}

.toast.show {
    opacity: 1;
    transform: translateX(-50%) translateY(0);
}
</style>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-5xl">

    {{-- ===================== --}}
    {{-- FORMAT 1 --}}
    {{-- ===================== --}}
    <div class="card card-format-1">
        <div class="flex items-center justify-between mb-2">
            <h2 class="text-lg font-semibold text-slate-800">Upload Format 1</h2>
            <span class="text-xs px-3 py-1 rounded-full badge-green">Tanpa Label</span>
        </div>

        <p class="text-sm text-slate-500 mb-4">
            Data diawali langsung dengan <b>NIK</b> dan urutan baris harus konsisten.
        </p>

        <details class="mb-4 rounded-md border border-slate-200 bg-slate-50 p-3">
            <summary class="cursor-pointer text-sm font-medium text-green-700">
                Lihat contoh format
            </summary>
            <textarea readonly rows="12"
                class="mt-3 w-full rounded-md border border-slate-300 bg-white
                p-3 text-xs font-mono text-slate-700 resize-none focus:outline-none">
                31/01/26 17.34 - +62xxx: 7371080201870001
                DENNY IBNU DARMAWAN
                12017419719
                02-01-1987
                email@gmail.com
...
            </textarea>
        </details>

        <form class="upload-form space-y-4" action="/upload" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="format_type" value="format_1">

            <input type="file" name="file" accept=".txt" required
                class="block w-full text-sm file:mr-4 file:rounded-md file:border-0
                file:bg-slate-200 file:px-4 file:py-2 file:text-slate-700 hover:file:bg-slate-300">

            <button type="submit"
                class="w-full rounded-md bg-blue-600 py-2 text-white hover:bg-blue-500 transition">
                Upload & Proses
            </button>

            <p class="text-xs text-slate-400 text-center">
                ⏳ Data besar? proses bisa beberapa detik
            </p>
        </form>
    </div>

    {{-- ===================== --}}
    {{-- FORMAT 2 --}}
    {{-- ===================== --}}
    <div class="card card-format-2">
        <div class="flex items-center justify-between mb-2">
            <h2 class="text-lg font-semibold text-slate-800">Upload Format 2</h2>
            <span class="text-xs px-3 py-1 rounded-full badge-blue">Dengan Label</span>
        </div>

        <p class="text-sm text-slate-500 mb-4">
            Format menggunakan label seperti <b>Nama, NIK, KPJ</b>.
        </p>

        <details class="mb-4 rounded-md border border-slate-200 bg-slate-50 p-3">
            <summary class="cursor-pointer text-sm font-medium text-blue-700">
                Lihat contoh format
            </summary>
            <textarea readonly rows="12"
                class="mt-3 w-full rounded-md border border-slate-300 bg-white
                p-3 text-xs font-mono text-slate-700 resize-none focus:outline-none">
                Nama : FINA
                NIK  : 9103015109730006
                KPJ  : 12037657165
                ...
            </textarea>
        </details>

        <form class="upload-form space-y-4" action="/upload" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="format_type" value="format_2">

            <input type="file" name="file" accept=".txt" required
                class="block w-full text-sm file:mr-4 file:rounded-md file:border-0
                file:bg-slate-200 file:px-4 file:py-2 file:text-slate-700 hover:file:bg-slate-300">

            <button type="submit"
                class="w-full rounded-md bg-blue-600 py-2 text-white hover:bg-blue-500 transition">
                Upload & Proses
            </button>

            <p class="text-xs text-slate-400 text-center">
                ⏳ Data besar? proses bisa beberapa detik
            </p>
        </form>
    </div>

</div>

{{-- TOAST --}}
<div id="toast" class="toast">
    File berhasil diproses & di-download
</div>

<script>
document.querySelectorAll('.upload-form').forEach(form => {
    form.addEventListener('submit', () => {
        const btn = form.querySelector('button');
        btn.classList.add('btn-loading');
        btn.innerText = 'Memproses...';

        setTimeout(() => {
            btn.classList.remove('btn-loading');
            btn.innerText = 'Upload & Proses';

            const toast = document.getElementById('toast');
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        }, 1200);
    });
});
</script>

@endsection
