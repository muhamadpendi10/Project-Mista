<?php

namespace App\Http\Controllers;

use App\Helpers\DeviceHelper;
use App\Models\UserDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Login gagal'
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        //ADMIN LANGSUNG MASUK
        if ($user->role === 'admin') {
            return redirect('/admin/devices');
        }

        $deviceId = DeviceHelper::generate($request);

        // ambil nama device terakhir milik user (jika ada)
        $lastDeviceName = UserDevice::where('user_id', $user->id)
        ->where('status', 'active')
        ->latest()
        ->value('device_name');

        $device = UserDevice::where('user_id', $user->id)
        ->where('device_id', $deviceId)
        ->latest()
        ->first();

        // BELUM PERNAH ADA → BUAT PENDING
        if (!$device) {
            UserDevice::create([
                'user_id'     => $user->id,
                'device_id'   => $deviceId,
                'device_name' => $lastDeviceName ?? 'Device Baru',
                'ip_address'  => $request->ip(),
                'status'      => 'pending',
            ]);

            Auth::logout();

            return redirect('/login')
                ->withErrors([
                    'email' => 'Device menunggu persetujuan admin'
                ]);
        }

        // ADA TAPI BELUM AKTIF → JANGAN BUAT DATA BARU
        if ($device->status === 'pending') {
            Auth::logout();

            return redirect('/login')
                ->withErrors([
                    'email' => 'Device menunggu persetujuan admin'
                ]);
        }

        // ADA TAPI DI-REVOKE → BUAT PENDING BARU
        if ($device->status === 'revoked') {
        $device->update([
            'status'      => 'pending',
            'device_name' => $lastDeviceName ?? $device->device_name,
            'ip_address'  => $request->ip(),
        ]);

        Auth::logout();

        return redirect('/login')
            ->withErrors([
                'email' => 'Device menunggu persetujuan admin'
            ]);
        }
        // Device aktif → boleh masuk
        return redirect('/upload'); 
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
