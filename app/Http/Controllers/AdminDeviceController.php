<?php

// namespace App\Http\Controllers;

// use App\Models\UserDevice;
// use Request;

// class AdminDeviceController extends Controller
// {
//     public function index(Request $request)
//     {
//         $status = $request->query('status', 'pending'); // default pending

//         $devices = UserDevice::with('user')
//             ->where('status', $status)
//             ->latest()
//             ->get();

//         return view('admin.devices', compact('devices'));
//     }

//     public function approve($id)
//     {
//         UserDevice::where('id', $id)
//             ->update(['status' => 'active']);

//         return back()->with('success', 'Device approved');
//     }

//     public function reject($id)
//     {
//         UserDevice::where('id', $id)
//             ->update(['status' => 'revoked']);

//         return back()->with('success', 'Device rejected');
//     }
// } -->
namespace App\Http\Controllers;

use App\Models\UserDevice;
use Illuminate\Http\Request;

class AdminDeviceController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending');

        // validasi status biar aman
        if (!in_array($status, ['pending', 'active', 'revoked'])) {
            $status = 'pending';
        }

        $devices = UserDevice::with('user')
            ->where('status', $status)
            ->latest()
            ->get();

        return view('admin.devices', compact('devices', 'status'));
    }

    public function approve($id)
    {
        UserDevice::where('id', $id)
            ->update(['status' => 'active']);

        return redirect('/admin/devices?status=pending')
            ->with('success', 'Device berhasil di-approve');
    }

    public function reject($id)
    {
        UserDevice::where('id', $id)
            ->update(['status' => 'revoked']);

        return redirect('/admin/devices?status=pending')
            ->with('success', 'Device berhasil di-revoke');
    }
}
