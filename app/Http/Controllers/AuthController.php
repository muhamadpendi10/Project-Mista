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

        // generate device id
        $deviceId = DeviceHelper::generate($request);

        // cek device
        $device = UserDevice::where('user_id', $user->id)
            ->where('device_id', $deviceId)
            ->first();

        // simpan device pertama
        if (!$device) {
            UserDevice::create([
                'user_id'     => $user->id,
                'device_id'   => $deviceId,
                'device_name' => $request->userAgent(),
                'ip_address'  => $request->ip(),
                'status'      => 'active',
            ]);
        }
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
