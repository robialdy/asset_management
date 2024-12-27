<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetOwnership;
use App\Models\Recommendation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RejuvenationRecommendationController extends Controller
{
    public function index()
    {
        $recommendations = Recommendation::with('user.joinOffice', 'admin', 'asset')->where('id_user', Auth::user()->id)->where('category', 'Rejuvenation')->where(function ($query) {$query->where('status', '!=', 'Completed')->orWhere(function ($query) {
                $query->where('status', 'Completed')->whereDate('completed_at', '>=', now());
            });
        })->orderBy('created_at', 'desc')->get();


        // Recommendation::with('user.joinOffice', 'admin', 'asset')->where('id_user', Auth::user()->id)->where('category', 'Rejuvenation')->orderBy('created_at', 'desc')->get()

        $data = [
            'title' => 'Rejuvenation Asset | JNE',
            'recommendations' => $recommendations,
        ];
        return view('user.recommendation.rejuvenation.index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Request | JNE',
            'ownerships' => AssetOwnership::with('user', 'asset')->whereHas('asset', function($query){
                $query->where('status', 'In Use');
            })->where('id_user', Auth::user()->id)->get(),
        ];
        return view('user.recommendation.rejuvenation.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'asset' => 'required',
            'description' => 'required|min:50'
        ]);

        Recommendation::create([
            'id_user' => Auth::user()->id,
            'id_asset' => $request->asset, //id asset
            'description' => $request->description,
            'category' => 'Rejuvenation',
            'status' => 'Under Review',
        ]);

        // UPDATE JADI REKOMENDASI DI TABLE ASSET OWNERSHIP
        Asset::find($request->asset)->update([
            'status' => 'Recommendation',
        ]);

        return redirect()->route('rejuvenation-recommendation')->with('success', 'Rejuvenation is successful, please wait for an update from the admin!');
    }

    public function modal(Request $request)
    {
        $data = [
            'recommendation' => Recommendation::with('admin')->find($request->id),
        ];

        $html = view('user.recommendation.rejuvenation.modal', $data)->render();

        return response()->json([
            'html' => $html
        ]);
    }
}
