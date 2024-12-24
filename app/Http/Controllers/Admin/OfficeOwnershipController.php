<?php

namespace App\Http\Controllers\Admin;

use App\Models\Asset;
use App\Models\OfficeOwnership;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Office;

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
        ];
        return view('admin.office-ownership.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'office' => 'required',
            'asset' => 'required'
        ]);

        // UPDATE STATUS
        Asset::where('id', $request->asset)->update([
            'status' => 'In Use',
            'sent_date' => now(),
        ]);

        // INSERT
        OfficeOwnership::create([
            'id_office' => $request->office,
            'id_asset' => $request->asset,
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

    public function destroy($id)
    {
        $ownership = OfficeOwnership::where('id_asset', $id)->firstOrFail();
        $ownership->delete();

        Asset::where('id', $id)->update([
            'status' => 'Destroy',
            'destroy_date' => now()
        ]);
        return redirect()->route('office-ownership')->with('success', 'The asset has been successfully sent to destroy');
    }

}
