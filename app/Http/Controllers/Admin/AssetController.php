<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Available Assets | JNE'
        ];
        return view('admin.asset.index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Create Asset | JNE'
        ];
        return view('admin.asset.create', $data);
    }
}
