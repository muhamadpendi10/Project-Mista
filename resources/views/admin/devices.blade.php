@extends('layouts.admin')

@section('content')
<div class="container">

    <h2 class="text-xl font-bold mb-4">Pending Devices</h2>

    {{-- alert sukses --}}
    @if (session('success'))
        <div style="color: green; margin-bottom: 12px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- kalau tidak ada device --}}
    @if ($devices->isEmpty())
        <p>Tidak ada device pending.</p>
    @else
        <table border="1" cellpadding="8" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Email User</th>
                    <th>Device</th>
                    <th>IP Address</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($devices as $device)
                    <tr>
                        <td>{{ $device->user->email }}</td>
                        <td>{{ $device->device_name }}</td>
                        <td>{{ $device->ip_address }}</td>
                        <td>{{ $device->status }}</td>
                        <td>
                            <form method="POST" action="{{ url('/admin/devices/'.$device->id.'/approve') }}" style="display:inline">
                                @csrf
                                <button type="submit">Approve</button>
                            </form>

                            <form method="POST" action="{{ url('/admin/devices/'.$device->id.'/reject') }}" style="display:inline">
                                @csrf
                                <button type="submit">Reject</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</div>
@endsection
