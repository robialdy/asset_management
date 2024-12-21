<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetOwnership;
use App\Models\User;
use Illuminate\Http\Request;

class AssetOwnershipController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Asset Ownership | JNE',
            'assetOwnership' => AssetOwnership::with(['user', 'asset'])->orderBy('created_at', 'desc')->get(),
        ];
        return view('admin.asset-ownership.index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Add Ownership | JNE',
            'users' => User::where('role', 'User')->get(),
            'assets' => Asset::where('status', 'Ready')->get(),
        ];
        return view('admin.asset-ownership.create',$data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user' => 'required',
            'asset' => 'required'
        ]);

        // UPDATE STATUS
        Asset::where('id', $request->asset)->update([
            'status' => 'In Use',
            'sent_date' => now(),
        ]);
        // INSERT
        AssetOwnership::create([
            'id_user' => $request->user,
            'id_asset' => $request->asset,
        ]);

        return redirect()->route('asset-ownership')->with('success', 'Office Successfully Added!');
    }

    public function detail($username, $itemSlug)
    {
        $user = User::where('username', $username)->firstOrFail();
        $asset = Asset::where('slug', $itemSlug)->firstOrFail();

        $data = [
            'title' => 'Detail Ownership | JNE',
            'ownership' => AssetOwnership::with(['user.joinOffice','asset.details'])->where('id_user', $user->id)->where('id_asset', $asset->id)->firstOrFail(),
        ];
        return view('admin.asset-ownership.detail', $data);
    }

}

