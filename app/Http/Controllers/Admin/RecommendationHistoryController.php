<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Recommendation;
use Illuminate\Http\Request;

class RecommendationHistoryController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Recommendation History | JNE',
            'recommendations' => Recommendation::with('asset', 'user.joinOffice', 'admin')->whereIn('status', ['Completed', 'Rejected'])->orderBy('created_at', 'desc')->get()
        ];
        return view('admin.recommendationHistory.index', $data);
    }

    public function modal(Request $request)
    {
        $data = [
            'detail' => Recommendation::with('user.joinOffice', 'admin', 'asset')->find($request->id)
        ];

        $html = view('admin.recommendationHistory.modal', $data)->render();

        return response()->json([
            'html' => $html
        ]);
    }
}
