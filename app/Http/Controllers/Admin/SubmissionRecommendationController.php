<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Recommendation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionRecommendationController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Submission Request | JNE',
            'requests' => Recommendation::with('user.joinOffice', 'admin')->whereNotIn('status', ['Completed', 'Rejected'])->where('category', 'Submission')->orderBy('created_at', 'desc')->get()
        ];
        return view('admin.request.submission.index', $data);
    }

    // modal untuk form rekomendasiin
    public function modal(Request $request)
    {
        $data = [
            'recommendation' => Recommendation::find($request->id), //untuk membalas ke rek id mana
        ];

        $html = view('admin.request.submission.modal', $data)->render();

        return response()->json([
            'html' => $html
        ]);
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'reply_admin' => 'required',
            'status' => 'required'
        ]);

        // FILTER DI TOLAK / TERIMA
        if ($request->status == 'Approved:Process') {
            // BIKIN PESAN
            $message = 'Reply Approved has been sent!';

            Recommendation::find($id)->update([
                'admin_reply' => $request->reply_admin,
                'status' => $request->status,
                'approved_at' => now(),
                'id_admin' => Auth::user()->id
            ]);
        } else {
            // BIKIN PESAN
            $message = 'Reply Rejected has been sent!';

            Recommendation::find($id)->update([
                'admin_reply' => $request->reply_admin,
                'status' => $request->status, //Rejected
                'id_admin' => Auth::user()->id,
                'completed_at' => now()
            ]);
        }

        return redirect()->route('submission-request')->with('success', $message);
    }
}
