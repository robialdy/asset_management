<?php

namespace App\Http\Controllers\Admin;

use App\Models\Office;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OfficeController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Office | JNE',
            'readOffice' => Office::orderBy('created_at', 'desc')->get(),
        ];
        return view('admin.office.index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Create Office | JNE',
        ];
        return view('admin.office.create', $data);
    }

    public function store(Request $request)
    {
        // VALIDASI
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'status' => 'required',
            'address' => 'required',
        ]);

        // BUAT SLUG
        $slug = Str::slug($request->name, '-');

        Office::create([
            'name' => $request->name,
            'slug' => $slug,
            'category' => $request->category,
            'status' => $request->status,
            'address' => $request->address,
        ]);

        return redirect()->route('office')->with('success', 'Office Successfully Added!');
    }

    public function edit($slug)
    {
        $data = [
            'title' => 'Edit Office | JNE',
            'office' => Office::where('slug', $slug)->firstOrFail(),
        ];
        return view('admin.office.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'status' => 'required',
            'address' => 'required',
        ]);

        // UPDATE SLUG
        $slug = Str::slug($request->name, '-');

        Office::where('id', $id)->firstOrFail()->update([
            'name' => $request->name,
            'slug' => $slug,
            'category' => $request->category,
            'status' => $request->status,
            'address' => $request->address,
        ]);

        return redirect()->route('office')->with('success', 'Office Successfully Updated!');
    }
}
