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

            return view('dashboard.index', compact(
                'today',
                'last7Days',
                'thisMonth',
                'thisYear'
            ));
        }

        // =====================
        // DASHBOARD ADMIN
        // =====================

        // total user
        $totalUsers = User::count();

        // total upload hari ini
        $todayUploads = WaUpload::whereDate('created_at', today())
            ->sum('total_rows');

        // total upload bulan ini
        $thisMonthUploads = WaUpload::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_rows');

        // total upload keseluruhan
        $totalUploads = WaUpload::sum('total_rows');

        // top 5 user paling aktif
        $topUsers = WaUpload::selectRaw('user_id, SUM(total_rows) as total')
            ->groupBy('user_id')
            ->orderByDesc('total')
            ->with('user')
            ->limit(5)
            ->get();

        return view('dashboard.admin', compact(
            'totalUsers',
            'todayUploads',
            'thisMonthUploads',
            'totalUploads',
            'topUsers'
        ));
    }
}
