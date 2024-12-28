<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\AssetOwnership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class YourAssetController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Your Assets | JNE',
            'ownerships' => AssetOwnership::with('asset')->where('id_user', Auth::user()->id)->orderBy('created_at', 'desc')->get(),
        ];
        return view('user.yourAssets.index', $data);
    }
}
