<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (! Auth::attempt($credentials)) {
            return back()->withErrors([
                'username' => 'Username atau password salah.',
            ])->onlyInput('username');
        }

        $request->session()->regenerate();

        if (Auth::user()->isAdmin()) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended(route('user.dashboard'));
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:50', Rule::unique('users', 'username')],
            'name' => ['required', 'string', 'max:150'],
            'kelas' => ['required', 'string', Rule::in(['X', 'XI', 'XII'])],
            'jurusan' => ['required', 'string', Rule::in([
                'Rekayasa Perangkat Lunak',
                'Kecantikan',
                'Tata Boga',
                'Seni Musik',
                'Usaha Layanan Wisata',
                'Busana',
                'Perhotelan',
            ])],
            'nomor_kendaraan' => ['required', 'string', 'max:20', Rule::unique('users', 'nomor_kendaraan')],
            'jenis_kendaraan' => ['required', 'string', Rule::in(['Motor', 'Mobil', 'Sepeda'])],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.max' => 'Username maksimal 50 karakter.',
            'username.unique' => 'Username sudah terdaftar.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.max' => 'Nama maksimal 150 karakter.',
            'kelas.required' => 'Kelas wajib dipilih.',
            'jurusan.required' => 'Jurusan wajib dipilih.',
            'jurusan.in' => 'Jurusan yang dipilih tidak valid.',
            'nomor_kendaraan.required' => 'Nomor kendaraan wajib diisi.',
            'nomor_kendaraan.max' => 'Nomor kendaraan maksimal 20 karakter.',
            'nomor_kendaraan.unique' => 'Nomor kendaraan sudah terdaftar.',
            'jenis_kendaraan.required' => 'Jenis kendaraan wajib dipilih.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $validated['role'] = 'user';
        $validated['qr_token'] = (string) Str::uuid();

        $user = User::create($validated);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('user.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
