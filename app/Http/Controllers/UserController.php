<?php

namespace App\Http\Controllers;

use App\DataTables\UserDataTable;
use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('pages.user.index');
    }

    public function create()
    {
        return view('pages.user.create');
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        
        User::create($data);
        Alert::success('Berhasil', 'Data pengguna berhasil ditambahkan');
        return redirect()->route('user.index');
    }

    public function edit(User $user)
    {
        return view('pages.user.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        Alert::success('Berhasil', 'Data pengguna berhasil diperbarui');
        return redirect()->route('user.index');
    }

    public function destroy(User $user)
    {
        $user->delete();
        Alert::success('Berhasil', 'Data pengguna berhasil dihapus');
        return redirect()->route('user.index');
    }

    public function showUpdatePasswordForm(User $user)
    {
        return view('pages.user.updatePassword', compact('user'));
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'new_password' => 'required|min:6|confirmed',
        ], [
            'new_password.required' => 'Password baru wajib diisi',
            'new_password.min' => 'Password minimal 6 karakter',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        Alert::success('Berhasil', 'Password pengguna berhasil diubah');
        return redirect()->route('user.index');
    }
}
