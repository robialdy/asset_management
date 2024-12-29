<?php

namespace App\Http\Controllers\user;

use App\Models\Asset;
use Illuminate\Http\Request;
use App\Models\AssetOwnership;
use App\Models\Recommendation;
use App\Models\OfficeOwnership;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReturnRecommendationController extends Controller
{
    public function index()
    {
        // $recommendations = Recommendation::with('user.joinOffice', 'admin', 'asset')->where('id_user', Auth::user()->id)->where('category', 'Destroy')->where(function ($query) {
        //     $query->where('status', '!=', 'Completed')->orWhere(function ($query) {
        //         $query->where('status', 'Completed')->whereDate('completed_at', '>=', now());
        //     });
        // })->orderBy('created_at', 'desc')->get();

        $data = [
            'title' => 'Return Asset | JNE',
            'recommendations' =>
            Recommendation::with('user.joinOffice', 'admin', 'asset')->where('id_user', Auth::user()->id)->where('category', 'Return')->whereNotIn('status', ['Completed', 'Rejected'])->orderBy('created_at', 'desc')->get(),
        ];
        return view('user.recommendation.return.index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Request | JNE',
            'ownerships' => AssetOwnership::with('user', 'asset')->whereHas('asset', function ($query) {
                $query->where('status', 'In Use');
            })->where('id_user', Auth::user()->id)->get(),
            'officeOwnerships' => OfficeOwnership::with('office', 'asset')->whereHas('asset', function ($query) {
                $query->where('status', 'In Use');
            })->where('id_office', Auth::user()->id_office)->get(),
        ];
        return view('user.recommendation.return.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'asset' => 'required',
            'description' => 'required|min:50'
        ]);

        // FILTER CEK UNTUK MENCARI BARANG KANTOR OR BUKAN
        if (AssetOwnership::where('id_asset', $request->asset)->first()) {
            $purpose_of = 'Self';
        } else {
            $purpose_of = 'Office';
        }

        Recommendation::create([
            'id_user' => Auth::user()->id,
            'id_asset' => $request->asset, //id_asset
            'description' => $request->description,
            'purpose_of' => $purpose_of,
            'category' => 'Return',
            'status' => 'Under Review'
        ]);

        // // UPDATE JADI REk destroy DI TABLE ASSET OWNERSHIP
        // Asset::find($request->asset)->update([
        //     'status' => 'Req:Destroy',
        // ]);

        return redirect()->route('return-recommendation')->with('success', ' Request Rejuvenation is successful, please wait for an update from the admin!');
    }

    public function modal(Request $request)
    {
        $data = [
            'recommendation' => Recommendation::with('admin')->find($request->id),
        ];
        $html = view('user.recommendation.return.modal', $data)->render();

        return response()->json([
            'html' => $html
        ]);
    }
}
