<?php

namespace App\Http\Controllers\admin;

use App\Models\Asset;
use Illuminate\Http\Request;
use App\Models\Recommendation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReturnRecommendationController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Return Request | JNE',
            'requests' => Recommendation::with('user.JoinOffice', 'admin', 'asset')->whereNotIn('status', ['Completed', 'Rejected'])->where('category', 'Return')->orderBy('created_at', 'desc')->get(),
        ];
        return view('admin.request.return.index', $data);
    }

    public function modal(Request $request)
    {
        $data = [
            'recommendation' => Recommendation::find($request->id),
        ];

        $html = view('admin.request.return.modal', $data)->render();

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

        $recommendation = Recommendation::find($id);

        // FILTER DI TOLAK / TERIMA
        if ($request->status == 'Approved:Process') {
            // BIKIN PESAN
            $message = 'Reply Approved has been sent!';

            $recommendation->update([
                'admin_reply' => $request->admin_reply,
                'status' => $request->status,
                'approved_at' => now(),
                'id_admin' => Auth::user()->id,
            ]);

            // UPDATE JADI REk destroy DI TABLE ASSET OWNERSHIP
            Asset::find($recommendation->id_asset)->update([
                'status' => 'Return',
            ]);
        } else {
            // BIKIN PESAN
            $message = 'Reply Rejected has been sent!';

            $recommendation->update([
                'admin_reply' => $request->admin_reply,
                'status' => $request->status,
                'id_admin' => Auth::user()->id,
                'completed_at' => now(),
            ]);
        };

        return redirect()->route('return-request')->with('success', $message);
    }
}
