<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Ambil user + relasi role
        $user = User::with('role')->where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {

            // Simpan ke session
            session([
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'role' => $user->role->roles_name,
                ]
            ]);

            // Redirect berdasarkan role
            if ($user->role->roles_name == 'Admin') {
                return redirect('/admin/dashboard');
            }
            elseif ($user->role->roles_name == 'Operator') {
                return redirect('/operator/dashboard');
            }
            else {
                return redirect('/pimpinan/laporan');
            }
        }

        return back()->with('error', 'Email atau password salah');
    }

    // Logout
    public function logout()
    {
        session()->flush();
        return redirect('/login');
    }
}