<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AssetOwnership;
use App\Models\Recommendation;
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
            'notifs' => Recommendation::with('admin', 'asset')->where('id_user', Auth::user()->id)->orderBy('updated_at', 'desc')->paginate(3),
        ];
        return view('user.dashboard.index', $data);
    }
}
