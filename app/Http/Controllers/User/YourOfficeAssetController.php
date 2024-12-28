<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\OfficeOwnership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class YourOfficeAssetController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Your Office Asset | JNE',
            'ownerships' => OfficeOwnership::with('asset', 'office')->where('id_office', Auth::user()->id_office)->orderBy('created_at', 'desc')->get(),
        ];
        return view('user.yourOfficeAsset.index', $data);
    }
}
