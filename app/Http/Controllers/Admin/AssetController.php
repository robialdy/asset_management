<?php

namespace App\Http\Controllers\Admin;

use App\Models\Asset;
use App\Models\Detail_Asset;
use App\Models\Recommendation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssetController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Available Assets | JNE',
            'readAssets' => Asset::where('status', 'Ready')->orderBy('created_at', 'desc')->get(),
        ];
        return view('admin.asset.index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Create Asset | JNE',
            'code_asset' => Asset::generateCodeAsset()
        ];
        return view('admin.asset.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'code_asset' => 'required|unique:assets',
            'description' => 'required'
        ]);

        // MENGATASI DUPLIKAT
        $oriName = $request->name;
        $name = $oriName;
        $slug = Str::slug($oriName, '-');
        $count = 0;

        while (Asset::where('name', $name)->exists()) {
            $count++;
            $name = $oriName . ' (' . $count . ')';
            $slug = Str::slug($name, '-');
        }

        $asset = Asset::create([
            'name' => $name,
            'slug' => $slug,
            'category' => $request->category,
            'code_asset' => $request->code_asset,
            'description' => $request->description,
            'added_date' => now()->format('Y-m-d'),
            'status' => 'Ready'
        ]);
        // dd($request->data);

        // INSET DETAIL
        if ($request->data) {
            foreach ($request->data as $item) {
                Detail_Asset::create([
                    'id_asset' => $asset->id, //id yang baru di simpan di asset
                    'title' => $item['title'],
                    'description' => $item['ddescription'],
                ]);
            }
        }

        return redirect()->route('assets')->with('success', 'Asset Successfully Create!');
    }

    public function edit($slug)
    {
        $asset = Asset::where('slug', $slug)->firstOrFail();

        // PEMBATASAN AGAR URL TIDAK BISA DI EDIT JADI NGACO UNTUK ASSET & ASSET OWNERSHIP
        if ($asset->status == 'Ready') {
            if (!request()->routeIs('asset.edit')) {
                abort(403, 'Unauthorized action. This route is not allowed for assets with "Ready" status.');
            }
        } else {
            if (!request()->routeIs('asset.edit.ownership') && !request()->routeIs('office-ownership.edit')) {
                abort(403, 'Unauthorized action. This route is not allowed for assets without "Ready" status.');
            }
        }

        $detailAsset = Detail_Asset::where('id_asset', $asset->id)->get();

        $data = [
            'title' => 'Edit Asset | JNE',
            'asset' => $asset,
            'detailAsset' => $detailAsset,
        ];
        return view('admin.asset.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'description' => 'required'
        ]);

        $dataAsset = Asset::where('id', $id)->first();

        // MENGATASI DUPLIKAT
        $oriName = $request->name;
        $name = $oriName;
        $slug = Str::slug($oriName, '-');
        $count = 0;

        if ($name != $dataAsset->name) {
            while (Asset::where('name', $name)->exists()) {
                $count++;
                $name = $oriName . ' (' . $count . ')';
                $slug = Str::slug($name, '-');
            }
        }

        Asset::where('id', $id)->firstOrFail()->update([
            'name' => $name,
            'slug' => $slug,
            'category' => $request->category,
            'description' => $request->description,
            'status' => 'In Use'
        ]);

        // PENANGAN UPDATE COMPLETED DI RECOMMENDATION
        Recommendation::where('id_asset', $dataAsset->id)->where('status', 'Approved:Process')->firstOrFail()->update([
            'completed_at' => now(),
            'status' => 'Completed'
        ]);;

        // PENANGANAN EDIT YANG SUDAH ADA
        if ($request->detail) {
            foreach ($request->detail as $detail) {
                Detail_Asset::where('id', $detail['id'])->update([
                    'title' => $detail['title'],
                    'description' => $detail['ddescription'],
                ]);
            }
        }
        // PENANGAN TAMBAH BARU
        if ($request->data) {
            foreach ($request->data as $item) {
                Detail_Asset::create([
                    'id_asset' => $dataAsset->id, //id asset
                    'title' => $item['title'],
                    'description' => $item['ddescription'],
                ]);
            }
        }

        // MENANGANI UPDATE DARI ASSET & ASSET-OWNERSHIP
        if ($dataAsset->status != 'Ready') {
            // MENGECEK URL DI AWALAN NYA ADA /admin/office-ownership
            if (Str::startsWith(url()->previous(), url('/admin/office-ownership'))) {
                return redirect()->route('office-ownership')->with('success', 'Asset Successfuly Updated!');
            } else {
                return redirect()->route('asset-ownership')->with('success', 'Asset Successfuly Updated!');
            }
        } else {
            return redirect()->route('assets')->with('success', 'Assett Successfuly Updated!');
        }
    }

    public function detail($slug)
    {
        // DATA ASSET
        $dataAsset = Asset::where('slug', $slug)->first();
        // DATA DETAIL ASSET
        $dataDetailAsset = Detail_Asset::where('id_asset', $dataAsset->id)->get();

        $data = [
            'title' => 'Detail Asset | JNE',
            'dataAsset' => $dataAsset,
            'dataDetailAsset' => $dataDetailAsset,
        ];
        return view('admin.asset.detail', $data);
    }

    public function destroy()
    {
        $data = [
            'title' => 'List Destroy | JNE',
            'destroys' => Asset::where('status', 'Destroy')->get(),
        ];
        return view('admin.asset.destroy', $data);
    }
}
