<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\WaUpload;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // =====================
        // DASHBOARD USER
        // =====================
        if ($user->role === 'user') {
            $today = WaUpload::where('user_id', $user->id)
                ->whereDate('created_at', today())
                ->sum('total_rows');

            $last7Days = WaUpload::where('user_id', $user->id)
                ->whereBetween('created_at', [
                    now()->subDays(6)->startOfDay(),
                    now()->endOfDay()
                ])->sum('total_rows');

            $thisMonth = WaUpload::where('user_id', $user->id)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total_rows');

            $thisYear = WaUpload::where('user_id', $user->id)
                ->whereYear('created_at', now()->year)
                ->sum('total_rows');

            return view('dashboard.user', compact(
                'today',
                'last7Days',
                'thisMonth',
                'thisYear'
            ));
        }

        // =====================
        // DASHBOARD ADMIN
        // =====================
        $userTotals = WaUpload::selectRaw('user_id, SUM(total_rows) as total')
            ->groupBy('user_id')
            ->with('user')
            ->get();

        return view('dashboard.admin', compact('userTotals'));
    }
}

// namespace App\Http\Controllers;

// use Illuminate\Support\Facades\Auth;
// use App\Models\WaUpload;

// class DashboardController extends Controller
// {
//     public function index()
//     {
//         $userId = Auth::id();

//         // =====================
//         // STATISTIK USER LOGIN
//         // =====================

//         $today = WaUpload::where('user_id', $userId)
//             ->whereDate('created_at', today())
//             ->sum('total_rows');

//         $last7Days = WaUpload::where('user_id', $userId)
//             ->whereBetween('created_at', [
//                 now()->subDays(6)->startOfDay(),
//                 now()->endOfDay()
//             ])->sum('total_rows');

//         $thisMonth = WaUpload::where('user_id', $userId)
//             ->whereMonth('created_at', now()->month)
//             ->whereYear('created_at', now()->year)
//             ->sum('total_rows');

//         $thisYear = WaUpload::where('user_id', $userId)
//             ->whereYear('created_at', now()->year)
//             ->sum('total_rows');

//         return view('dashboard.index', compact(
//             'today',
//             'last7Days',
//             'thisMonth',
//             'thisYear'
//         ));
//     }
// }
