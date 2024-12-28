<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Models\Recommendation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HistoryRecommendationController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'History Recommendations',
            'recommendations' => Recommendation::with('asset', 'user.joinOffice', 'admin')->whereIn('status', ['Completed', 'Rejected'])->where('id_user', Auth::user()->id)->orderBy('created_at', 'desc')->get(),
        ];
        return view('user.historyrecommendation.index', $data);
    }

    public function modal(Request $request)
    {
        $data = [
            'detail' => Recommendation::with('user.joinOffice', 'admin', 'asset')->where('id', $request->id)->where('id_user', Auth::user()->id)->first(),
        ];

        $html = view('user.historyRecommendation.modal', $data)->render();

        return response()->json([
            'html' => $html
        ]);
    }
}
