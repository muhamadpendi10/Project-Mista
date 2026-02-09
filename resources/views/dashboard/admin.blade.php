@extends('layouts.admin')

@section('page-title', 'Dashboard Admin')

@section('content')
<div class="space-y-8">

    {{-- ================= HEADER ================= --}}
    <div>
        <h2 class="text-2xl font-semibold text-slate-800">
            Dashboard Admin
        </h2>
        <p class="text-sm text-slate-500">
            Ringkasan aktivitas dan statistik sistem
        </p>
    </div>

    {{-- ================= STAT CARDS ================= --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

        {{-- Total User --}}
        <div class="bg-white rounded-xl shadow p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Total User</p>
                    <h3 class="text-2xl font-bold text-slate-800">
                        {{ $totalUsers }}
                    </h3>
                </div>
                <div class="text-3xl">👥</div>
            </div>
        </div>

        {{-- Upload Hari Ini --}}
        <div class="bg-white rounded-xl shadow p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Upload Hari Ini</p>
                    <h3 class="text-2xl font-bold text-slate-800">
                        {{ number_format($todayUploads) }}
                    </h3>
                </div>
                <div class="text-3xl">📥</div>
            </div>
        </div>

        {{-- Upload Bulan Ini --}}
        <div class="bg-white rounded-xl shadow p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Upload Bulan Ini</p>
                    <h3 class="text-2xl font-bold text-slate-800">
                        {{ number_format($thisMonthUploads) }}
                    </h3>
                </div>
                <div class="text-3xl">📆</div>
            </div>
        </div>

        {{-- Total Upload Sistem --}}
        <div class="bg-white rounded-xl shadow p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Total Upload Sistem</p>
                    <h3 class="text-2xl font-bold text-slate-800">
                        {{ number_format($totalUploads) }}
                    </h3>
                </div>
                <div class="text-3xl">📊</div>
            </div>
        </div>

    </div>

    {{-- ================= CHART ================= --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-1">
            Statistik Upload User
        </h3>
        <p class="text-sm text-slate-500 mb-4">
            Perbandingan total upload antar user
        </p>

        <canvas id="uploadChart" height="100"></canvas>
    </div>

    {{-- ================= TABLE ================= --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">
            Top User Paling Aktif
        </h3>

        <div class="overflow-x-auto">
            <table class="w-full text-sm border border-slate-200 rounded-lg overflow-hidden">
                <thead class="bg-slate-100 text-slate-700">
                    <tr>
                        <th class="px-4 py-2 text-left">#</th>
                        <th class="px-4 py-2 text-left">User</th>
                        <th class="px-4 py-2 text-left">Email</th>
                        <th class="px-4 py-2 text-center">Total Upload</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($topUsers as $index => $row)
                        <tr class="border-t hover:bg-slate-50">
                            <td class="px-4 py-2">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-4 py-2 font-medium">
                                {{ $row->user->name ?? '-' }}
                            </td>
                            <td class="px-4 py-2 text-slate-500">
                                {{ $row->user->email ?? '-' }}
                            </td>
                            <td class="px-4 py-2 text-center font-semibold">
                                {{ number_format($row->total) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-slate-500">
                                Belum ada data
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- ================= CHART JS ================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('uploadChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($topUsers->pluck('user.name')) !!},
            datasets: [{
                label: 'Total Upload',
                data: {!! json_encode($topUsers->pluck('total')) !!},
                backgroundColor: '#2563eb',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
