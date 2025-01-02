<?php

namespace App\Http\Controllers\Admin;

use App\Models\Recommendation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $monthlyData = Recommendation::whereYear('created_at', now()->year)
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total'))
            ->groupBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        // isi data untuk bulan yang kosong dengan 0
        $chartData = collect(range(1, 12))->map(function ($month) use ($monthlyData) {
            return $monthlyData[$month] ?? 0;
        })->values()->toArray();



        $data = [
            'title' => 'Dashboard Asset Managament | JNE',
            'count' => [
                'assetOwnership' => DB::table('asset_ownership')->count(),
                'officeOwnership' => DB::table('office_ownership')->count(),
                'assets' => DB::table('assets')->where('status', 'Ready')->count(),
                'user' => DB::table('users')->where('role', 'User')->count(),
                'request' => DB::table('recommendation')->where('status', 'Under Review')->count(),
            ],
            'data' => $chartData
        ];
        return view('admin.dashboard.index', $data);
    }
}
