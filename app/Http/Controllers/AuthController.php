<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PerangkatDaerah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_perangkat'        => 'required',
            'kepala_perangkat'      => 'required',
            'pangkat_golongan'      => 'required',
            'nip'                   => 'required|min:18|',
            'bendahara_penerimaan'  => 'required',
            'no_hp'                 => 'required',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|min:6|confirmed',
        ]);

        try {

            DB::beginTransaction();

            $user = User::create([
                'name'     => $request->nama_perangkat,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'admin_perangkat',
            ]);

            PerangkatDaerah::create([
                'user_id'                => $user->id,
                'nama_perangkat'         => $request->nama_perangkat,
                'kepala_perangkat'       => $request->kepala_perangkat,
                'pangkat_golongan'       => $request->pangkat_golongan,
                'nip'                    => $request->nip,
                'bendahara_penerimaan'   => $request->bendahara_penerimaan,
                'no_hp'                  => $request->no_hp,
                'email'                  => $request->email,
                'status_verifikasi'      => false,
            ]);

            DB::commit();

            return redirect('/login')
                ->with('success', 'Pendaftaran berhasil, menunggu verifikasi Admin');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (Auth::user()->role == 'admin_perangkat') {
                $perangkat = Auth::user()->perangkatDaerah;
                if (!$perangkat || !$perangkat->status_verifikasi) {
                    Auth::logout();
                    return back()->with(
                        'error',
                        'Akun belum diverifikasi Admin Bapenda'
                    );
                }
                return redirect('/perangkat');
            }
            return redirect('/admin');
        }
        return back()->with(
            'error',
            'Email atau Password salah'
        );
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}