<?php

namespace App\Http\Controllers\Admin;

use App\Models\Asset;
use App\Models\Office;
use Illuminate\Http\Request;
use App\Models\Recommendation;
use App\Models\OfficeOwnership;
use App\Http\Controllers\Controller;

class OfficeOwnershipController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Office Ownership | JNE',
            'officeOwnership' => OfficeOwnership::with(['office', 'asset'])->whereHas('asset', function ($query) {
                $query->where('status', 'In Use');
            })->orderBy('created_at', 'desc')->get(),
            'requestAsset' => OfficeOwnership::with(['office', 'asset'])->whereHas('asset', function ($query) {
                $query->whereNotIn('status', ['In Use', 'Destroy']);
            })->orderBy('created_at', 'desc')->get(),
        ];
        return view('admin.office-ownership.index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Add Office Ownership',
            'offices' => Office::all(),
            'assets' => Asset::where('status', 'Ready')->get(),
            'requests' => Recommendation::with('user')->where('status', 'Approved:Process')->where('category', 'Submission')->where('purpose_of', 'Office')->get(),
        ];
        return view('admin.office-ownership.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'asset' => 'required',
            'request' => 'required'
        ]);

        $recommendation = Recommendation::with('user.joinOffice')->find($request->input('request'));

        // UPDATE STATUS
        Asset::where('id', $request->asset)->update([
            'status' => 'In Use',
            'sent_date' => now(),
        ]);

        // INSERT
        OfficeOwnership::create([
            'id_office' => $recommendation->user->joinOffice->id,
            'id_asset' => $request->asset,
        ]);

        // INSERT ID TO RECOMMENDATION
        Recommendation::find($request->input('request'))->update([
            'id_asset' => $request->asset,
            'completed_at' => now(),
            'status' => 'Completed',
            'message' => $request->message
        ]);

        return redirect()->route('office-ownership')->with('success', 'Office Successfully Added!');
    }

    public function detail($slugOffice, $itemSlug)
    {
        // MENGAMBIL ID DI ASSET
        $asset = Asset::where('slug', $itemSlug)->firstOrFail();

        $data = [
            'title' => 'Detail Office Ownership | JNE',
            'ownership' => OfficeOwnership::with('asset.details')->where('id_asset', $asset->id)->firstOrFail(),
        ];
        return view('admin.office-ownership.detail', $data);
    }

    public function return($id)
    {
        $ownership = OfficeOwnership::where('id_asset', $id)->firstOrFail();
        $ownership->delete();

        Asset::where('id', $id)->update([
            'status' => 'Ready',
            'return_date' => now(),
        ]);

        // UPDATE STATUS DI RECOMMENDATION
        Recommendation::where('id_asset', $id)->where('status', 'Approved:Process')->firstOrFail()->update([
            'status' => 'Completed',
            'completed_at' => now(),
        ]);

        return redirect()->route('office-ownership')->with('success', 'The asset has been successfully sent to destroy');
    }

}
