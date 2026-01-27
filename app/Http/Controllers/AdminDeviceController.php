<?php

namespace App\Http\Controllers;

use App\Models\UserDevice;

class AdminDeviceController extends Controller
{
    public function index()
    {
        $devices = UserDevice::with('user')
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('admin.devices', compact('devices'));
    }

    public function approve($id)
    {
        UserDevice::where('id', $id)
            ->update(['status' => 'active']);

        return back()->with('success', 'Device approved');
    }

    public function reject($id)
    {
        UserDevice::where('id', $id)
            ->update(['status' => 'revoked']);

        return back()->with('success', 'Device rejected');
    }
}
