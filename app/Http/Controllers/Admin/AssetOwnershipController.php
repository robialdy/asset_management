<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetOwnership;
use App\Models\Recommendation;
use App\Models\User;
use Illuminate\Http\Request;

class AssetOwnershipController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Asset Ownership | JNE',
            'assetOwnership' => AssetOwnership::with(['user', 'asset'])->whereHas('asset', function ($query) {
                $query->where('status', 'In Use');
            })->orderBy('created_at', 'desc')->get(),
            'requestAsset' => AssetOwnership::with(['user', 'asset'])->whereHas('asset', function ($query) {
                $query->whereNotIn('status', ['In Use', 'Destroy']);
            })->orderBy('created_at', 'desc')->get(),
        ];
        return view('admin.asset-ownership.index', $data);
    }
    public function create()
    {
        $data = [
            'title' => 'Add Ownership | JNE',
            'users' => User::where('role', 'User')->get(),
            'assets' => Asset::where('status', 'Ready')->get(),
            'requests' => Recommendation::with('user')->where('status', 'Approved:Process')->where('category', 'Submission')->get(),
        ];
        return view('admin.asset-ownership.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'asset' => 'required',
            'request' => 'required',
        ]);

        $recommendation = Recommendation::find($request->input('request')); //->request merupakan properti internal laravel


        // UPDATE STATUS
        Asset::where('id', $request->asset)->update([
            'status' => 'In Use',
            'sent_date' => now(),
        ]);
        // INSERT
        $assetOwnership = AssetOwnership::create([
            'id_user' => $recommendation->id_user,
            'id_asset' => $request->asset,
        ]);

        // dd($assetOwnership->id);

        // INSERT ID ASSET TO RECOMMEDATION
        Recommendation::find($request->input('request'))->update([
            'id_asset' => $assetOwnership->id,
            'completed_at' => now(),
            'status' => 'Completed'
        ]);

        return redirect()->route('asset-ownership')->with('success', 'Asset Successfully Added!');
    }

    public function detail($username, $slugAsset)
    {
        // FLEXBILITAS DALAM MENCARI DATA
        $user = User::where('username', $username)->firstOrFail();
        $asset = Asset::where('slug', $slugAsset)->firstOrFail();

        $data = [
            'title' => 'Detail Ownership | JNE',
            'ownership' => AssetOwnership::with(['user.joinOffice', 'asset.details'])->where('id_user', $user->id)->where('id_asset', $asset->id)->firstOrFail(),
        ];
        return view('admin.asset-ownership.detail', $data);
    }

    public function destroy($id)
    {
        $ownership = AssetOwnership::where('id_asset', $id)->firstOrFail();
        $ownership->delete();

        Asset::where('id', $id)->update([
            'status' => 'Destroy',
            'destroy_date' => now()
        ]);

        return redirect()->route('asset-ownership')->with('success', 'The asset has been successfully sent to destroy');
    }
}
