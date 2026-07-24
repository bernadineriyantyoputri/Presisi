<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PerangkatDaerah;
use App\Models\ActivityLog;

class VerifikasiController extends Controller
{
    public function index()
    {
        $perangkat = PerangkatDaerah::latest()->get();

        return view('admin.verifikasi.index', compact('perangkat'));
    }
    public function detail($id)
    {
        $perangkat = PerangkatDaerah::findOrFail($id);

        return view('admin.verifikasi.detail', compact('perangkat'));
    }

    public function verifikasi($id)
    {
        $perangkat = PerangkatDaerah::findOrFail($id);

        $perangkat->status_verifikasi = 'Terverifikasi';
        $perangkat->tanggal_verifikasi = now();
        $perangkat->save();

        ActivityLog::akunDiverifikasi($perangkat->nama_perangkat);

        return redirect()->back()
            ->with('success', 'Data berhasil diverifikasi');
    }

    public function tolak($id)
    {
        $perangkat = PerangkatDaerah::findOrFail($id);

        $perangkat->status_verifikasi = 'Ditolak';
        $perangkat->save();

        ActivityLog::akunDitolak($perangkat->nama_perangkat);

        return redirect()->back()
            ->with('success', 'Permohonan berhasil ditolak');
    }

    public function nonaktifkan($id)
    {
        $perangkat = PerangkatDaerah::findOrFail($id);

        $perangkat->is_active = false;
        $perangkat->save();

        ActivityLog::akunDinonaktifkan($perangkat->nama_perangkat);

        return redirect()->back()
            ->with('success', 'Akun berhasil dinonaktifkan');
    }

    public function aktifkan($id)
    {
        $perangkat = PerangkatDaerah::findOrFail($id);

        $perangkat->is_active = true;
        $perangkat->save();

        ActivityLog::akunDiaktifkanKembali($perangkat->nama_perangkat);

        return redirect()->back()
            ->with('success', 'Akun berhasil diaktifkan kembali');
    }

}