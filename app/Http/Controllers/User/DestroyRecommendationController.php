<?php

namespace App\Http\Controllers\user;

use App\Models\Recommendation;
use Illuminate\Http\Request;
use App\Models\AssetOwnership;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use Illuminate\Support\Facades\Auth;

class DestroyRecommendationController extends Controller
{
    public function index()
    {
        $recommendations = Recommendation::with('user.joinOffice', 'admin', 'asset')->where('id_user', Auth::user()->id)->where('category', 'Destroy')->where(function ($query) {
            $query->where('status', '!=', 'Completed')->orWhere(function ($query) {
                $query->where('status', 'Completed')->whereDate('completed_at', '>=', now());
            });
        })->orderBy('created_at', 'desc')->get();

        $data = [
            'title' => 'Destroy Asset | JNE',
            'recommendations' => $recommendations,
        ];
        return view('user.recommendation.destroy.index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Request | JNE',
            'ownerships' => AssetOwnership::with('user', 'asset')->whereHas('asset', function ($query) {
                $query->where('status', 'In Use');
            })->where('id_user', Auth::user()->id)->get()
        ];
        return view('user.recommendation.destroy.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'asset' => 'required',
            'description' => 'required|min:50'
        ]);

        Recommendation::create([
            'id_user' => Auth::user()->id,
            'id_asset' => $request->asset, //id_asset
            'description' => $request->description,
            'category' => 'Destroy',
            'status' => 'Under Review'
        ]);

        // UPDATE JADI REKOMENDASI DI TABLE ASSET OWNERSHIP
        Asset::find($request->asset)->update([
            'status' => 'Req:Destroy',
        ]);

        return redirect()->route('destroy-recommendation')->with('success', ' Request Rejuvenation is successful, please wait for an update from the admin!');
    }

    public function modal(Request $request)
    {
        $data = [
            'recommendation' => Recommendation::with('admin')->find($request->id),
        ];
        $html = view('user.recommendation.destroy.modal', $data)->render();

        return response()->json([
            'html' => $html
        ]);
    }
}
