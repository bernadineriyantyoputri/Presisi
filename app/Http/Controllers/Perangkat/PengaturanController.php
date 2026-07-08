<?php

namespace App\Http\Controllers\Perangkat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PengaturanController extends Controller
{
    public function profil()
    {
        $user = Auth::user();
        $perangkat = $user->perangkatDaerah;

        return view('perangkat.pengaturan.profile', compact('user', 'perangkat'));
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'kepala_perangkat' => 'required|max:255',
            'pangkat_golongan' => 'required|max:100',
            'nip' => 'required|max:30',
            'bendahara_penerimaan' => 'required|max:255',
            'no_hp' => 'required|max:20',
        ]);

        $perangkat = Auth::user()->perangkatDaerah;

        $perangkat->update([
            'kepala_perangkat' => $request->kepala_perangkat,
            'pangkat_golongan' => $request->pangkat_golongan,
            'nip' => $request->nip,
            'bendahara_penerimaan' => $request->bendahara_penerimaan,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()
            ->route('perangkat.pengaturan.profil')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function password()
    {
        return view('perangkat.pengaturan.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->withErrors([
                'password_lama' => 'Password lama salah.'
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password_baru)
        ]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }
}