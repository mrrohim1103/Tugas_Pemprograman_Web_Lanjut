<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // ==========================================
    // SETUP - Buat akun admin pertama
    // Hanya bisa diakses jika tabel users kosong
    // ==========================================
    public function showSetup()
    {
        if (User::count() > 0) {
            abort(403, 'Setup sudah selesai. Akses tidak diizinkan.');
        }
        return view('auth.setup');
    }

    public function setup(Request $request)
    {
        if (User::count() > 0) {
            abort(403, 'Setup sudah selesai. Akses tidak diizinkan.');
        }

        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'username'     => 'required|string|max:50',
            'email'        => 'required|email',
            'password'     => 'required|string|min:6|confirmed',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'username.required'     => 'Username wajib diisi.',
            'email.required'        => 'Email wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
            'password.required'     => 'Password wajib diisi.',
            'password.min'          => 'Password minimal 6 karakter.',
            'password.confirmed'    => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'id_user'      => Str::uuid()->toString(),
            'nama_lengkap' => $request->nama_lengkap,
            'username'     => $request->username,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('kunjungan.index')
            ->with('success', 'Akun admin pertama berhasil dibuat! Selamat datang, ' . $user->nama_lengkap . '.');
    }

    // ==========================================
    // LOGIN & LOGOUT
    // ==========================================
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('kunjungan.index');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('kunjungan.index'))
                ->with('success', 'Selamat datang, ' . Auth::user()->nama_lengkap . '!');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Email atau password salah.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda telah berhasil keluar.');
    }

    // ==========================================
    // KELOLA AKUN ADMIN (harus login)
    // ==========================================
    public function showTambahAkun()
    {
        return view('auth.tambah-akun');
    }

    public function tambahAkun(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'username'     => 'required|string|max:50|unique:users,username',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|string|min:6|confirmed',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'username.required'     => 'Username wajib diisi.',
            'username.unique'       => 'Username sudah digunakan.',
            'email.required'        => 'Email wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
            'email.unique'          => 'Email sudah terdaftar.',
            'password.required'     => 'Password wajib diisi.',
            'password.min'          => 'Password minimal 6 karakter.',
            'password.confirmed'    => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'id_user'      => Str::uuid()->toString(),
            'nama_lengkap' => $request->nama_lengkap,
            'username'     => $request->username,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
        ]);

        return redirect()->route('admin.tambah-akun')
            ->with('success', 'Akun admin "' . $request->nama_lengkap . '" berhasil ditambahkan.');
    }

    public function kelolaAkun()
    {
        $admins = User::orderBy('created_at', 'desc')->get();
        return view('auth.kelola-akun', compact('admins'));
    }

    public function hapusAkun($id)
    {
        if ($id === Auth::user()->id_user) {
            return back()->withErrors(['hapus' => 'Anda tidak dapat menghapus akun Anda sendiri.']);
        }

        $user = User::findOrFail($id);
        $nama = $user->nama_lengkap;
        $user->delete();

        return redirect()->route('admin.kelola-akun')
            ->with('success', 'Akun "' . $nama . '" berhasil dihapus.');
    }
}
