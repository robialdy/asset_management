<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Models\Recommendation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SubmissionRecommendationController extends Controller
{
    public function index()
    {

        // $recommendations = Recommendation::with('user.joinOffice', 'admin', 'asset')->where('id_user', Auth::user()->id)->where('category', 'Submission')->where(function ($query) {
        //     $query->where('status', '!=', 'Completed')->orWhere(function ($query) {
        //         $query->where('status', 'Completed')->whereDate('completed_at', '>=', now());
        //     });
        // })->orderBy('created_at', 'desc')->get();


        $data = [
            'title' => 'Submission Recommendation | JNE',
            'recommendations' => Recommendation::with('user.joinOffice', 'admin', 'asset.details')->where('id_user', Auth::user()->id)->where('category', 'Submission')->whereNotIn('status', ['Completed', 'Rejected'])->orderBy('created_at', 'desc')->get(),
        ];
        return view('user.recommendation.submission.index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Request | JNE'
        ];
        return view('user.recommendation.submission.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'required_item' => 'required',
            'description' => 'required|min:50',
            'purpose_of' => 'required',
        ]);

        // INSERT
        Recommendation::create([
            'id_user' => Auth::user()->id,
            'required_item' => $request->required_item,
            'description' => $request->description,
            'category' => 'Submission',
            'status' => 'Under Review',
            'purpose_of' => $request->purpose_of
        ]);

        return redirect()->route('submission-recommendation')->with('success', 'Submission is successful, please wait for an update from the admin!');
    }

    public function modal(Request $request)
    {
        $data = [
            'recommendation' => Recommendation::with('admin')->find($request->id),
        ];

        $html = view('user.recommendation.submission.modal', $data)->render();

        return response()->json([
            'html' => $html
        ]);
    }

    public function attachment($slug)
    {

        $data = [
            'title' => 'Attachment | JNE',
            'attachment' => Recommendation::with('user.joinOffice', 'admin', 'asset')->whereHas('asset', function ($query) use ($slug) {
                $query->where('slug', $slug);
            })->firstOrFail(),
        ];

        return view('attachment.attachment', $data);


    }
}
