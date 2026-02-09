@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- ================= STAT CARD ================= --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow p-4 text-center">
            <p class="text-sm text-slate-500">Hari Ini</p>
            <p class="text-2xl font-bold text-blue-600">{{ $today }}</p>
        </div>

        <div class="bg-white rounded-xl shadow p-4 text-center">
            <p class="text-sm text-slate-500">7 Hari</p>
            <p class="text-2xl font-bold text-green-600">{{ $last7Days }}</p>
        </div>

        <div class="bg-white rounded-xl shadow p-4 text-center">
            <p class="text-sm text-slate-500">Bulan Ini</p>
            <p class="text-2xl font-bold text-indigo-600">{{ $thisMonth }}</p>
        </div>

        <div class="bg-white rounded-xl shadow p-4 text-center">
            <p class="text-sm text-slate-500">Tahun Ini</p>
            <p class="text-2xl font-bold text-purple-600">{{ $thisYear }}</p>
        </div>
    </div>

    {{-- ================= CHART ================= --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-semibold mb-4">
            Grafik Upload 7 Hari Terakhir
        </h3>

        <canvas id="uploadChart" height="120"></canvas>
    </div>

</div>

{{-- ================= CHART JS ================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('uploadChart').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: [
                'H-6','H-5','H-4','H-3','H-2','Kemarin','Hari Ini'
            ],
            datasets: [{
                label: 'Total Data',
                data: [
                    {{ max(0, $last7Days - $today) / 6 }},
                    {{ max(0, $last7Days - $today) / 6 }},
                    {{ max(0, $last7Days - $today) / 6 }},
                    {{ max(0, $last7Days - $today) / 6 }},
                    {{ max(0, $last7Days - $today) / 6 }},
                    {{ max(0, $last7Days - $today) / 6 }},
                    {{ $today }}
                ],
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                backgroundColor: 'rgba(59, 130, 246, 0.15)',
                borderColor: 'rgb(59, 130, 246)',
                pointRadius: 4,
                pointBackgroundColor: 'rgb(59, 130, 246)',
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
            },
            animation: {
                duration: 1200,
                easing: 'easeOutQuart'
            }
        }
    });
</script>
@endsection
