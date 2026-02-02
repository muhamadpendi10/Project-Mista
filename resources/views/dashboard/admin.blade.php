@extends('layouts.admin')

@section('content')
<div class="container">
    <h3>Dashboard Admin</h3>

    <table class="table">
        <thead>
            <tr>
                <th>User</th>
                <th>Email</th>
                <th>Total Data</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($userTotals as $row)
                <tr>
                    <td>{{ $row->user->name ?? '-' }}</td>
                    <td>{{ $row->user->email ?? '-' }}</td>
                    <td>{{ $row->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
