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

    {{-- ===================== FORMAT 1 ===================== --}}
    <div class="card card-format-1">
        <div class="flex items-center justify-between mb-2">
            <h2 class="text-lg font-semibold text-slate-800">Upload Format 1</h2>
            <span class="text-xs px-3 py-1 rounded-full badge-green">Tanpa Label</span>
        </div>

        <p class="text-sm text-slate-500 mb-4">
            Data diawali langsung dengan <b>NIK</b> dan urutan baris harus konsisten.
        </p>

        <form class="upload-form" action="/upload" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="format_type" value="format_1">

            <div class="relative border rounded-xl bg-white shadow-sm p-3">

                <textarea name="text_input"
                    rows="6"
                    placeholder="Tempel data WhatsApp di sini..."
                    class="w-full resize-none border-0 focus:ring-0 text-sm outline-none"></textarea>

                <div class="flex items-center justify-between mt-2">

                    {{-- FILE SECTION --}}
                    <div class="flex items-center gap-2">
                        <label class="cursor-pointer text-slate-500 hover:text-green-600 text-xl">
                            +
                            <input type="file" name="file" accept=".txt" class="hidden file-input">
                        </label>

                        <span class="text-xs text-slate-500 hidden file-name"></span>

                        <button type="button"
                            class="text-red-500 text-xs hidden remove-file">
                            ✕
                        </button>
                    </div>

                    <button type="submit"
                        class="bg-green-600 text-white px-4 py-1.5 rounded-lg text-sm hover:bg-green-500 transition">
                        Proses
                    </button>

                </div>
            </div>
        </form>
    </div>

    {{-- ===================== FORMAT 2 ===================== --}}
    <div class="card card-format-2">
        <div class="flex items-center justify-between mb-2">
            <h2 class="text-lg font-semibold text-slate-800">Upload Format 2</h2>
            <span class="text-xs px-3 py-1 rounded-full badge-blue">Dengan Label</span>
        </div>

        <p class="text-sm text-slate-500 mb-4">
            Format menggunakan label seperti <b>Nama, NIK, KPJ</b>.
        </p>

        <form class="upload-form" action="/upload" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="format_type" value="format_2">

            <div class="relative border rounded-xl bg-white shadow-sm p-3">

                <textarea name="text_input"
                    rows="6"
                    placeholder="Tempel data WhatsApp di sini..."
                    class="w-full resize-none border-0 focus:ring-0 text-sm outline-none"></textarea>

                <div class="flex items-center justify-between mt-2">

                    <div class="flex items-center gap-2">
                        <label class="cursor-pointer text-slate-500 hover:text-blue-600 text-xl">
                            +
                            <input type="file" name="file" accept=".txt" class="hidden file-input">
                        </label>

                        <span class="text-xs text-slate-500 hidden file-name"></span>

                        <button type="button"
                            class="text-red-500 text-xs hidden remove-file">
                            ✕
                        </button>
                    </div>

                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-1.5 rounded-lg text-sm hover:bg-blue-500 transition">
                        Proses
                    </button>

                </div>
            </div>
        </form>
    </div>

</div>

{{-- TOAST --}}
<div id="toast" class="toast">
    File berhasil diproses & di-download
</div>

<script>
document.querySelectorAll('.upload-form').forEach(form => {

    const fileInput = form.querySelector('.file-input');
    const fileName = form.querySelector('.file-name');
    const removeBtn = form.querySelector('.remove-file');
    const submitBtn = form.querySelector('button[type="submit"]');
    const textarea = form.querySelector('textarea[name="text_input"]');

    // Tampilkan nama file
    fileInput.addEventListener('change', function () {
        if (this.files.length > 0) {
            fileName.textContent = this.files[0].name;
            fileName.classList.remove('hidden');
            removeBtn.classList.remove('hidden');
        }
    });

    // Hapus file
    removeBtn.addEventListener('click', function () {
        fileInput.value = '';
        fileName.textContent = '';
        fileName.classList.add('hidden');
        removeBtn.classList.add('hidden');
    });

    // Submit
    form.addEventListener('submit', function () {

        submitBtn.classList.add('btn-loading');
        submitBtn.innerText = 'Memproses...';

        setTimeout(() => {

            submitBtn.classList.remove('btn-loading');
            submitBtn.innerText = 'Proses';

            // RESET TEXTAREA
            textarea.value = '';

            // Reset file
            fileInput.value = '';
            fileName.textContent = '';
            fileName.classList.add('hidden');
            removeBtn.classList.add('hidden');

            const toast = document.getElementById('toast');
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);

        }, 1200);

    });

});
</script>


@endsection
