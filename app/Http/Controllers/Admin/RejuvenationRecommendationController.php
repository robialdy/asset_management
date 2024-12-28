<?php

namespace App\Http\Controllers\admin;

use App\Models\Asset;
use Illuminate\Http\Request;
use App\Models\Recommendation;
use App\Http\Controllers\Controller;
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

        $recommendation = Recommendation::find($id);

        // FILTER DI TOLAK / TERIMA
        if ($request->status == 'Approved:Process') {
            // BIKIN PESAN
            $message = 'Reply Approved has been sent!';
            // UPDATE
            $recommendation->update([
                'admin_reply' => $request->admin_reply,
                'status' => $request->status,
                'approved_at' => now(),
                'id_admin' => Auth::user()->id,
            ]);

            // Update status pada tabel Asset Ownership
            Asset::find($recommendation->id_asset)->update([
                'status' => 'Recommendation',
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

        return redirect()->route('rejuvenation-request')->with('success', $message);
    }
}
