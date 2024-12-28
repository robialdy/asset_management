<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard Asset Managament | JNE',
            'count' => [
                'assetOwnership' => DB::table('asset_ownership')->count(),
                'officeOwnership' => DB::table('office_ownership')->count(),
                'assets' => DB::table('assets')->where('status', 'Ready')->count(),
                'user' => DB::table('users')->where('role', 'User')->count(),
            ],
        ];
        return view('admin.dashboard.index', $data);
    }
}
