<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Asset;
use App\Models\Office;
use Illuminate\Support\Str;
use App\Models\Detail_Asset;
use Illuminate\Http\Request;
use App\Exports\AssetsExport;
use App\Models\AssetOwnership;
use App\Models\Recommendation;
use App\Models\OfficeOwnership;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

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
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // UPLAAD GAMBAR
        $imagePath = 'default_image.png';

        if ($request->hasFile('image')) {
            // ambil ke var
            $image = $request->file('image');
            // buat namanya
            $imageName = time() . '_' . $image->getClientOriginalName();
            // pindahin ke folder
            $image->move(public_path('assets/images'), $imageName);
            $imagePath = $imageName;
        }

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
            'status' => 'Ready',
            'image' => $imagePath
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
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' //aman meskipun gada di input form
        ]);

        $dataAsset = Asset::where('id', $id)->first();
        // kalo insert & edit di availabel
        $status = 'Ready';

        // MENANGAN UPDATE GAMBAR
        $imagePath = $dataAsset->image;

        try {
        } catch (Exception $e) {
            echo 'kontol ' . $e->getMessage();
        }

        if ($request->hasFile('image')) {
            // cek ada ga filenya
            if ($dataAsset->image && $dataAsset->image != 'default_image.png' && file_exists(public_path('assets/images/' . $dataAsset->image))) {
                // hapus
                unlink(public_path('assets/images/' . $dataAsset->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('assets/images/'), $imageName);
            $imagePath = $imageName;
        }


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

        // PENANGAN UPDATE DARI PEREMAJAAN (REJUVENATION)
        // MENGECEK URL DI AWALAN NYA ADA /admin/office-ownership
        if (Str::startsWith(url()->previous(), url('/admin/office-ownership')) || Str::startsWith(url()->previous(), url('/admin/asset-ownership'))) {
            $status = 'In Use'; //status di balikin lagi jadi in use dari sebelumnya rejuvenation
            if ($dataAsset->status != 'In Use') {
                // PENANGAN UPDATE COMPLETED DI RECOMMENDATION
                Recommendation::where('id_asset', $dataAsset->id)->where('status', 'Approved:Process')->firstOrFail()->update([
                    'completed_at' => now(),
                    'status' => 'Completed',
                    'message' => $request->message
                ]);
            }
        }

        // UPDATE ASSET
        Asset::where('id', $id)->firstOrFail()->update([
            'name' => $name,
            'slug' => $slug,
            'category' => $request->category,
            'description' => $request->description,
            // di var , pembeda edit yang ready dan in use
            'status' => $status,
            // tidak merubah apa apa kalo dari asset/office ownership
            'image' => $imagePath
        ]);


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


    // SEND DESTROY
    public function sendDestroy($id)
    {
        $asset = Asset::find($id);

        $asset->update([
            'status' => 'Destroy',
            'destroy_date' => now()
        ]);

        return redirect()->route('assets')->with('success', 'The asset has been successfully sent to destroy');
    }

    // VIEW DESTROY
    public function destroy()
    {
        $data = [
            'title' => 'List Destroy | JNE',
            'destroys' => Asset::where('status', 'Destroy')->orderBy('destroy_date', 'desc')->get(),
        ];
        return view('admin.asset.destroy', $data);
    }


    // EXPORT
    public function export(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'month' => 'required|nullable'
        ]);

        $month = $request->month;
        $category = $request->category;

        // INI FILE BLADE, PISAHKAN MASING MASING!

        if ($category == 'employees') {
            $assets = AssetOwnership::with('asset')->orderBy('created_at', 'desc');
        } elseif ($category == 'office') {
            $assets = OfficeOwnership::with('asset')->orderBy('created_at', 'desc');
        } elseif ($category == 'available') {
            $assets = Asset::where('status', 'Ready')
                ->where(function ($query) use ($month) {
                    $query->whereMonth('added_date', '=', date('m', strtotime($month)));
                })
                ->get();
        } else {
            $assets = Asset::where('status', 'Destroy')
                ->where(function ($query) use ($month) {
                    $query->whereMonth('destroy_date', '=', date('m', strtotime($month)));
                })
                ->get();
        }


        // Export ke Excel
        return Excel::download(new AssetsExport($assets), 'assets.xlsx');
    }
}
