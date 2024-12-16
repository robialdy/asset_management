<?php

namespace App\Http\Controllers\Admin; //*

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller; //*
use App\Models\Office;

class UsersController extends Controller
{
    // KELOLA USER
    public function userView()
    {
        $data = [
            'title' => 'User Manage | JNE',
            'readUser' => User::where('role', 'User')->with(['joinOffice'])->orderBy('created_at', 'desc')->get(),
        ];
        return view('admin.user.index', $data);
    }

    // CRUD
    public function userCreate()
    {
        $data = [
            'title' => 'User Create | JNE',
            'offices' => Office::all(),
        ];
        return view('admin.user.create', $data);
    }

    public function userStore(Request $request)
    {
        // VALIDASI
        $request->validate([
            'id_office' => 'required',
            'full_name' => 'required|string|max:255',
            'username' => 'required|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'department' => 'required',
            'phone' => 'required|numeric',
            'password' => 'required|min:8',
        ]);


        User::create([
            'id_office' => $request->id_office,
            'full_name' => $request->full_name,
            'username' => $request->username,
            'email' => $request->email,
            'department' => $request->department,
            'phone' => $request->phone,
            'role' => 'User',
            'password' => Hash::make($request->password),
        ]);
        return redirect()->route('admin.user.view')->with('success', 'User berhasil dibuat.');
    }

    public function userDelete($id)
    {
        $data = User::findOrFail($id);
        $data->delete();

        return redirect()->route('admin.user.view')->with('success', 'Data Berhasil Dihapus!');
    }

    public function userEdit($username)
    {
        $data = [
            'title' => 'Edit User | JNE',
            'user' => User::where('username', $username)->firstOrFail(),
            'offices' => Office::all(),
        ];
        return view('admin.user.edit', $data);
    }

    public function userUpdate(Request $request, $username)
    {
        // VALIDASI
        $request->validate([
            'id_office' => 'required',
            'full_name' => 'required|string|max:255',
            'username' => [
                'required',
                'max:255',
                Rule::unique('users', 'username')->ignore($username, 'username')
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($username, 'username')
            ],
            'department' => 'required',
            'phone' => 'required|numeric',
        ]);

        User::where('username', $username)->firstOrFail()->update([
            'id_office' => $request->input('id_office'),
            'full_name' => $request->input('full_name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'department' => $request->input('department'),
            'phone' => $request->input('phone'),
        ]);

        return redirect()->route('admin.user.view')->with('success', 'Data Berhasil Diupdate!');
    }

    // RESET PASSWORD
    public function resetPassword($id)
    {
        $user = User::find($id);
        $newPassword = 'user' . rand(10000, 99999);

        // UPDATE PASSWORD
        $user->password = Hash::make($newPassword);
        $user->save();

        // NOTIF KE WHATSAPP
        $this->sendWhatsappNotification($user->phone, $newPassword);

        return redirect()->route('admin.view')->with('success', 'Password Berhasil Direset, Notifikasi Telah Dikirm!!');
    }

    private function sendWhatsappNotification($phoneNumber, $newPassword)
    {
        // belum ada
    }

    // KELOLA ADMIN
    public function adminView()
    {
        $data = [
            'title' => 'User Admin Manage | JNE',
            'readAdmin' => User::where('role', 'Admin')->orderBy('created_at', 'desc')->get(),
        ];
        return view('admin.userAdmin.index', $data);
    }

    public function adminCreate()
    {
        $data = [
            'title' => 'User Admin Create | JNE',
        ];
        return view('admin.userAdmin.create', $data);
    }

    public function adminStore(Request $request)
    {
        // VALIDASI
        $request->validate([
            'full_name' => 'required|string|max:255',
            'username' => 'required|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'phone' => 'required|numeric',
            'password' => 'required|min:8',
        ]);

        User::create([
            'full_name' => $request->full_name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => 'Admin',
            'password' => Hash::make($request->password),
        ]);
        return redirect()->route('admin.view')->with('success', 'User Admin berhasil dibuat.');
    }

    public function adminEdit($username)
    {
        $data = [
            'title' => 'Edit User Admin | JNE',
            'admin' => User::where('username', $username)->firstOrFail(),
        ];
        return view('admin.userAdmin.edit', $data);
    }

    public function adminUpdate(Request $request, $username)
    {
        // VALIDASI
        $request->validate([
            'full_name' => 'required|string|max:255',
            'username' => [
                'required',
                'max:255',
                Rule::unique('users', 'username')->ignore($username, 'username')
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($username, 'username')
            ],
            'phone' => 'required|numeric',
        ]);

        User::where('username', $username)->firstOrFail()->update([
            'full_name' => $request->input('full_name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
        ]);

        return redirect()->route('admin.view')->with('success', 'Data Berhasil Diupdate!');
    }

    public function adminDelete($id)
    {
        $data = User::findOrFail($id);
        $data->delete();

        return redirect()->route('admin.view')->with('success', 'Data Berhasil Dihapus!');
    }
}
