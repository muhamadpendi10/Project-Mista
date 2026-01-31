@extends('layouts.admin')

@section('content')
@php
    $status = $status ?? 'pending';
@endphp

{{-- ===== FLOATING ALERT ===== --}}
@if (session('success') || session('error'))
    <div
        id="toast-alert"
        style="
            position:fixed;
            top:30px;
            left:50%;
            transform:translateX(-50%) translateY(-20px);
            min-width:320px;
            max-width:420px;
            padding:14px 18px;
            border-radius:10px;
            text-align:center;
            font-weight:500;
            opacity:0;
            z-index:9999;
            transition:all .4s ease;
            {{ session('success')
                ? 'background:#16a34a;color:white;'
                : 'background:#dc2626;color:white;' }}
        "
    >
        {{ session('success') ?? session('error') }}
    </div>
@endif
{{-- ========================== --}}

<div class="container">

    {{-- FILTER STATUS --}}
    <div style="margin-bottom:20px; display:flex; gap:8px;">
        @php
            $btn = fn($s) => $status === $s
                ? 'background:#2563eb;color:white;'
                : 'background:#e5e7eb;';
        @endphp

        <a href="/admin/devices?status=pending">
            <button style="padding:6px 12px;border-radius:6px;{{ $btn('pending') }}">Pending</button>
        </a>

        <a href="/admin/devices?status=active">
            <button style="padding:6px 12px;border-radius:6px;{{ $btn('active') }}">Active</button>
        </a>

        <a href="/admin/devices?status=revoked">
            <button style="padding:6px 12px;border-radius:6px;{{ $btn('revoked') }}">Revoked</button>
        </a>
    </div>

    {{-- TABLE --}}
    @if ($devices->isEmpty())
        <p style="color:#6b7280;">Tidak ada device.</p>
    @else
        <table width="100%" cellpadding="10" cellspacing="0" style="border-collapse:collapse;">

            <thead style="background:linear-gradient(90deg,#2563eb,#16a34a); color:white;">
                <tr>
                    <th width="40">No</th>
                    <th align="left">User</th>
                    <th align="left">Device</th>
                    <th align="left">IP</th>
                    <th>Status</th>
                    <th width="220">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($devices as $device)
                <tr
                    style="
                        border-bottom:1px solid #e5e7eb;
                        background: {{ $loop->even ? '#f9fafb' : 'white' }};
                        {{ $device->status === 'active' ? 'box-shadow: inset 4px 0 #22c55e;' : '' }}
                    "
                >
                    <td align="center">{{ $loop->iteration }}</td>
                    <td>{{ $device->user->email }}</td>
                    <td>{{ $device->device_name }}</td>
                    <td>{{ $device->ip_address }}</td>

                    <td align="center">
                        @if ($device->status === 'pending')
                            <span style="background:#fde68a;padding:4px 10px;border-radius:999px;">Pending</span>
                        @elseif ($device->status === 'active')
                            <span style="background:#bbf7d0;padding:4px 10px;border-radius:999px;">Active</span>
                        @else
                            <span style="background:#fecaca;padding:4px 10px;border-radius:999px;">Revoked</span>
                        @endif
                    </td>

                    <td>
                        {{-- PENDING --}}
                        @if ($device->status === 'pending')
                            <form method="POST" action="{{ url('/admin/devices/'.$device->id.'/approve') }}" style="display:flex; gap:6px;">
                                @csrf
                                <input
                                    type="text"
                                    name="device_name"
                                    value="{{ $device->device_name }}"
                                    style="padding:4px 6px;border:1px solid #d1d5db;border-radius:6px;width:120px;"
                                    required
                                >
                                <button style="background:#16a34a;color:white;padding:4px 10px;border-radius:6px;">
                                    Approve
                                </button>
                            </form>

                            <form method="POST" action="{{ url('/admin/devices/'.$device->id.'/reject') }}" style="margin-top:6px;">
                                @csrf
                                <button style="background:#dc2626;color:white;padding:4px 10px;border-radius:6px;">
                                    Reject
                                </button>
                            </form>

                        {{-- ACTIVE --}}
                        @elseif ($device->status === 'active')
                            <form method="POST" action="{{ url('/admin/devices/'.$device->id.'/rename') }}" style="display:flex; gap:6px;">
                                @csrf
                                <input
                                    type="text"
                                    name="device_name"
                                    value="{{ $device->device_name }}"
                                    style="padding:4px 6px;border:1px solid #d1d5db;border-radius:6px;width:120px;"
                                >
                                <button style="background:#2563eb;color:white;padding:4px 10px;border-radius:6px;">
                                    Rename
                                </button>
                            </form>

                        {{-- REVOKED --}}
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

{{-- ===== TOAST SCRIPT ===== --}}
@if (session('success') || session('error'))
<script>
document.addEventListener('DOMContentLoaded', () => {
    const toast = document.getElementById('toast-alert');
    if (!toast) return;

    setTimeout(() => {
        toast.style.opacity = '1';
        toast.style.transform = 'translateX(-50%) translateY(0)';
    }, 100);

    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(-50%) translateY(-20px)';
    }, 3000);

    setTimeout(() => {
        toast.remove();
    }, 3500);
});
</script>
@endif
@endsection
