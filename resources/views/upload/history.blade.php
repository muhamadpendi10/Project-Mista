@extends($layout)

@section('title', 'History Upload')
@section('page-title', 'History Upload & Download')

@section('content')

<div x-data="{ showToast: false }" class="space-y-8 relative">

    {{-- TOAST --}}
    <div x-show="showToast"
         x-transition:enter="transform ease-out duration-300"
         x-transition:enter-start="-translate-y-10 opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transform ease-in duration-200"
         x-transition:leave-start="translate-y-0 opacity-100"
         x-transition:leave-end="-translate-y-10 opacity-0"
         class="fixed top-6 left-1/2 -translate-x-1/2
                bg-emerald-600 text-white px-6 py-3
                rounded-xl shadow-xl z-50">
        ✔ File berhasil didownload
    </div>

    <div class="bg-white rounded-2xl shadow-xl border-2 border-blue-100">

        {{-- HEADER --}}
        <div class="p-6 border-b-2 border-blue-100">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <div class="border-l-4 border-blue-600 pl-4">
                    <h2 class="text-xl font-semibold text-slate-800">
                        Riwayat Upload
                    </h2>
                    <p class="text-sm text-slate-500 mt-1">
                        Kelola dan download ulang file hasil parsing
                    </p>
                </div>

                <a href="{{ route('upload.index') }}"
                   class="rounded-lg bg-blue-600 px-4 py-2 text-sm text-white
                          hover:bg-blue-500 transition-all duration-200 shadow">
                    + Upload Baru
                </a>
            </div>
        </div>

        {{-- FILTER --}}
        <div class="p-6 border-b-2 border-blue-100 bg-blue-50/40">
            <form method="GET" class="grid md:grid-cols-5 gap-3">

                <select name="filter"
                        class="rounded-lg border border-blue-200 text-sm focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua</option>
                    <option value="today">Hari Ini</option>
                    <option value="yesterday">Kemarin</option>
                    <option value="7days">7 Hari Terakhir</option>
                </select>

                <input type="date" name="start_date"
                       class="rounded-lg border border-blue-200 text-sm focus:ring-2 focus:ring-blue-500">

                <input type="date" name="end_date"
                       class="rounded-lg border border-blue-200 text-sm focus:ring-2 focus:ring-blue-500">

                <input type="text" name="search"
                       placeholder="Cari nama file..."
                       class="rounded-lg border border-blue-200 text-sm focus:ring-2 focus:ring-blue-500">

                <button class="bg-blue-600 text-white rounded-lg px-4 py-2 text-sm
                               hover:bg-blue-500 transition duration-200 shadow">
                    Filter
                </button>
            </form>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="min-w-full text-sm border-t-2 border-b-2 border-blue-200">
                <thead class="bg-blue-100 text-slate-700 uppercase text-xs tracking-wider">
                    <tr class="border-b-2 border-blue-300">
                        <th class="px-4 py-3 text-center border-r border-blue-200">No</th>

                        @if(auth()->user()->role === 'admin')
                            <th class="px-4 py-3 text-left border-r border-blue-200">User</th>
                        @endif

                        <th class="px-4 py-3 text-left border-r border-blue-200">Nama File</th>
                        <th class="px-4 py-3 text-center border-r border-blue-200">Total Data</th>
                        <th class="px-4 py-3 text-center border-r border-blue-200">Tanggal Upload</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($uploads as $i => $upload)
                        <tr class="{{ $i % 2 == 0 ? 'bg-white' : 'bg-blue-50/40' }} hover:bg-blue-100 transition">

                            <td class="px-4 py-3 text-center border-r border-blue-100 font-medium">
                                {{ $uploads->firstItem() + $i }}
                            </td>

                            @if(auth()->user()->role === 'admin')
                                <td class="px-4 py-3 border-r border-blue-100">
                                    {{ $upload->user->name ?? '-' }}
                                </td>
                            @endif

                            <td class="px-4 py-3 border-r border-blue-100 font-medium text-slate-800">
                                {{ $upload->filename }}
                            </td>

                            <td class="px-4 py-3 text-center border-r border-blue-100">
                                {{ $upload->total_rows }}
                            </td>

                            <td class="px-4 py-3 text-center border-r border-blue-100 text-slate-600">
                                {{ $upload->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                                <div class="text-xs text-slate-400">
                                    {{ $upload->created_at->diffForHumans() }}
                                </div>
                            </td>

                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('upload.download', $upload->id) }}"
                                   @click="showToast = true; setTimeout(() => showToast = false, 3000)"
                                   class="inline-flex items-center gap-1 rounded-lg
                                          bg-emerald-600 px-3 py-1.5 text-white
                                          hover:bg-emerald-500 transition shadow">
                                    ⬇ Download
                                </a>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6"
                                class="px-6 py-12 text-center text-slate-400">
                                Belum ada data upload
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

        {{-- PAGINATION --}}
        <div class="p-6 border-t-2 border-blue-100">
            {{ $uploads->links() }}
        </div>

    </div>
</div>

@endsection
    