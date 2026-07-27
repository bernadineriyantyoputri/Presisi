<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\ActivityLog;
use App\Models\PengaturanSistem;


class PengaturanController extends Controller
{
    public function profil()
    {
        $user = Auth::user();

        return view('admin.pengaturan.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'jabatan'     => 'nullable|string|max:255',
            'no_telepon'  => 'nullable|string|max:20',
            'foto'        => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $validated['foto'] = $request->file('foto')->store('profil', 'public');
        }

        $user->update($validated);

        ActivityLog::create([
            'aktivitas'  => 'Update Profil Admin',
            'deskripsi'  => 'Profil admin ' . $user->name . ' berhasil diperbarui.',
        ]);

        return redirect()
            ->route('admin.pengaturan.profil')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function password()
    {
        $user = Auth::user();

        return view('admin.pengaturan.password', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:8|confirmed',
        ], [
            'password_lama.required'          => 'Password saat ini wajib diisi.',
            'password_baru.required'          => 'Password baru wajib diisi.',
            'password_baru.min'               => 'Password baru minimal 8 karakter.',
            'password_baru.confirmed'         => 'Konfirmasi password tidak cocok.',
        ]);

        if (!Hash::check($validated['password_lama'], $user->password)) {
            return back()
                ->withErrors(['password_lama' => 'Password saat ini tidak sesuai.'])
                ->withInput();
        }

        $user->update([
            'password' => Hash::make($validated['password_baru']),
        ]);

        ActivityLog::create([
            'aktivitas'  => 'Ganti Password Admin',
            'deskripsi'  => 'Password admin ' . $user->name . ' berhasil diubah.',
        ]);

        return redirect()
            ->route('admin.pengaturan.password')
            ->with('success', 'Password berhasil diubah.');
    }

    public function sistem()
    {
        $user = Auth::user();
        $pengaturan = PengaturanSistem::current();

        $namaSistem          = $pengaturan->nama_sistem;
        $tahunAnggaranAktif  = $pengaturan->tahun_anggaran_aktif;
        $teksFooter          = $pengaturan->teks_footer;
        $logoSistem          = $pengaturan->logo_sistem;
        $logoBapenda         = $pengaturan->logo_bapenda;

        return view('admin.pengaturan.sistem', compact(
            'user', 'namaSistem', 'tahunAnggaranAktif', 'teksFooter', 'logoSistem', 'logoBapenda'
        ));
    }

    public function updateSistem(Request $request)
    {
        $validated = $request->validate([
            'nama_sistem'           => 'required|string|max:255',
            'tahun_anggaran_aktif'  => 'nullable|string|max:10',
            'teks_footer'           => 'nullable|string',
            'logo_sistem'           => 'nullable|image|max:2048',
            'logo_bapenda'          => 'nullable|image|max:2048',
        ]);

        $pengaturan = PengaturanSistem::current();

        if ($request->hasFile('logo_sistem')) {
            if ($pengaturan->logo_sistem) {
                Storage::disk('public')->delete($pengaturan->logo_sistem);
            }
            $validated['logo_sistem'] = $request->file('logo_sistem')->store('logo', 'public');
        }

        if ($request->hasFile('logo_bapenda')) {
            if ($pengaturan->logo_bapenda) {
                Storage::disk('public')->delete($pengaturan->logo_bapenda);
            }
            $validated['logo_bapenda'] = $request->file('logo_bapenda')->store('logo', 'public');
        }

        $pengaturan->update($validated);

        ActivityLog::create([
            'aktivitas' => 'Update Konfigurasi Sistem',
            'deskripsi' => 'Konfigurasi sistem PRESISI berhasil diperbarui.',
        ]);

        return redirect()
            ->route('admin.pengaturan.sistem')
            ->with('success', 'Konfigurasi sistem berhasil disimpan.');
    }

    public function tentang()
    {
        $user = Auth::user();

        return view('admin.pengaturan.tentang', compact('user'));
    }

    public function notifikasi()
    {
        $user = Auth::user();
        $pengaturan = PengaturanSistem::current();
    
        $notifikasi = [
            'laporan_masuk'         => $pengaturan->notif_laporan_masuk,
            'target_belum_tercapai' => $pengaturan->notif_target_belum_tercapai,
            'perubahan_data'        => $pengaturan->notif_perubahan_data,
            'pengingat_laporan'     => $pengaturan->notif_pengingat_laporan,
        ];
    
        return view('admin.pengaturan.notifikasi', compact('user', 'notifikasi'));
    }
    
    public function updateNotifikasi(Request $request)
    {
        $pengaturan = PengaturanSistem::current();
    
        $pengaturan->update([
            'notif_laporan_masuk'         => $request->has('laporan_masuk'),
            'notif_target_belum_tercapai' => $request->has('target_belum_tercapai'),
            'notif_perubahan_data'        => $request->has('perubahan_data'),
            'notif_pengingat_laporan'     => $request->has('pengingat_laporan'),
        ]);
    
        ActivityLog::create([
            'aktivitas' => 'Update Pengaturan Notifikasi',
            'deskripsi' => 'Pengaturan notifikasi berhasil diperbarui.',
        ]);
    
        return redirect()
            ->route('admin.pengaturan.notifikasi')
            ->with('success', 'Pengaturan notifikasi berhasil disimpan.');
    }
}