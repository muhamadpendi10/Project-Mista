@extends('layouts.admin')

@section('content')
    <div class="container">

        {{-- alert sukses --}}
        @if (session('success'))
            <div style="color: green; margin-bottom: 12px;">
                {{ session('success') }}
            </div>
        @endif

        {{-- filter status --}}
        <div style="margin-bottom: 16px;">
            <a href="/admin/devices?status=pending">
                <button {{ $status === 'pending' ? 'disabled' : '' }}>Pending</button>
            </a>

            <a href="/admin/devices?status=active">
                <button {{ $status === 'active' ? 'disabled' : '' }}>Active</button>
            </a>

            <a href="/admin/devices?status=revoked">
                <button {{ $status === 'revoked' ? 'disabled' : '' }}>Revoked</button>
            </a>
        </div>

        @if ($devices->isEmpty())
            <p>Tidak ada device.</p>
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
                                @if ($device->status === 'pending')
                                    <form method="POST" action="{{ url('/admin/devices/'.$device->id.'/approve') }}" style="display:inline">
                                        @csrf
                                        <button type="submit">Approve</button>
                                    </form>

                                    <form method="POST" action="{{ url('/admin/devices/'.$device->id.'/reject') }}" style="display:inline">
                                        @csrf
                                        <button type="submit">Reject</button>
                                    </form>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>
@endsection
