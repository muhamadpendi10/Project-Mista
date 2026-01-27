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

        // Cek device AKTIF
        $device = UserDevice::where('user_id', $user->id)
            ->where('device_id', $deviceId)
            ->where('status', 'active')
            ->first();

        // Device belum pernah terdaftar → buat pending
        if (!$device) {
            UserDevice::firstOrCreate(
                [
                    'user_id'   => $user->id,
                    'device_id' => $deviceId,
                ],
                [
                    'device_name' => $request->userAgent(),
                    'ip_address'  => $request->ip(),
                    'status'      => 'pending',
                ]
            );

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
