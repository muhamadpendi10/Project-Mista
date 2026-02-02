@extends('layouts.admin')

@section('content')
<div class="container">
    <h3>Dashboard</h3>

    <ul>
        <li>📅 Hari ini: <b>{{ $today }}</b></li>
        <li>📆 7 hari terakhir: <b>{{ $last7Days }}</b></li>
        <li>🗓️ Bulan ini: <b>{{ $thisMonth }}</b></li>
        <li>📈 Tahun ini: <b>{{ $thisYear }}</b></li>
    </ul>
</div>
@endsection
