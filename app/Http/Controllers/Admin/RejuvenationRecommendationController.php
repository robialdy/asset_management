<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Recommendation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RejuvenationRecommendationController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Rejuvenation Request | JNE',
            'requests' => Recommendation::with('user.JoinOffice', 'admin', 'asset')->whereNotIn('status', ['Completed', 'Rejected'])->where('category', 'Rejuvenation')->orderBy('created_at', 'desc')->get(),
        ];
        return view('admin.request.rejuvenation.index', $data);
    }

    public function modal(Request $request)
    {
        $data = [
            'recommendation' => Recommendation::find($request->id),
        ];

        $html = view('admin.request.rejuvenation.modal', $data)->render();

        return response()->json([
            'html' => $html
        ]);
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'admin_reply' => 'required',
            'status' => 'required',
        ]);

        // FILTER DI TOLAK / TERIMA
        if ($request->status == 'Approved:Process') {
            // BIKIN PESAN
            $message = 'Reply Approved has been sent!';

            Recommendation::find($id)->update([
                'admin_reply' => $request->admin_reply,
                'status' => $request->status,
                'approved_at' => now(),
                'id_admin' => Auth::user()->id,
            ]);
        } else {
            // BIKIN PESAN
            $message = 'Reply Rejected has been sent!';

            Recommendation::find($id)->update([
                'admin_reply' => $request->admin_reply,
                'status' => $request->status,
                'id_admin' => Auth::user()->id,
                'completed_at' => now(),
            ]);
        };

        return redirect()->route('rejuvenation-request')->with('success', $message);
    }
}
