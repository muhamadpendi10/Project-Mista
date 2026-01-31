<?php

namespace App\Http\Controllers;

use App\Models\UserDevice;
use Illuminate\Http\Request;

class AdminDeviceController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending');

        // validasi status
        if (!in_array($status, ['pending', 'active', 'revoked'])) {
            $status = 'pending';
        }

        $devices = UserDevice::with('user')
            ->where('status', $status)
            ->latest()
            ->get();

        return view('admin.devices', compact('devices', 'status'));
    }

    /**
     * APPROVE DEVICE (pending → active + rename)
     */
    public function approve(Request $request, $id)
    {
        $request->validate([
            'device_name' => 'required|string|max:255',
        ]);

        UserDevice::where('id', $id)
            ->where('status', 'pending')
            ->update([
                'status'      => 'active',
                'device_name' => $request->device_name,
            ]);

        return redirect('/admin/devices?status=pending')
            ->with('success', 'Device berhasil di-approve');
    }

    /**
     * REJECT DEVICE (pending → revoked)
     */
    public function reject($id)
    {
        UserDevice::where('id', $id)
            ->where('status', 'pending')
            ->update([
                'status' => 'revoked'
            ]);

        return redirect('/admin/devices?status=pending')
            ->with('success', 'Device berhasil di-revoke');
    }

    /**
     * RENAME DEVICE (ONLY ACTIVE)
     */
    public function rename(Request $request, $id)
    {
        $request->validate([
            'device_name' => 'required|string|max:255',
        ]);

        $device = UserDevice::findOrFail($id);

        // hanya boleh rename device ACTIVE
        if ($device->status !== 'active') {
            return back()->with('error', 'Device tidak aktif');
        }

        $device->update([
            'device_name' => $request->device_name,
        ]);

        return back()->with('success', 'Nama device berhasil diubah');
    }
}
