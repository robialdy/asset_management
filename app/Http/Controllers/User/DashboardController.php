<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AssetOwnership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard User',
            'count' => [
                'urAsset' => DB::table('asset_ownership')->where('id_user', Auth::user()->id)->count(),
                'urOffice' => DB::table('office_ownership')->where('id_office', Auth::user()->id_office)->count(),
            ],
            'ownerships' => AssetOwnership::with('asset')->where('id_user', Auth::user()->id)->get(),
        ];
        return view('user.dashboard.index', $data);
    }
}
