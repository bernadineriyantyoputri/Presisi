<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PerangkatDaerah;

class VerifikasiController extends Controller
{
    public function index()
    {
        $perangkat = PerangkatDaerah::latest()->get();

        return view('admin.verifikasi', compact('perangkat'));
    }

    public function verifikasi($id)
{
    $perangkat = PerangkatDaerah::findOrFail($id);

    $perangkat->status_verifikasi = true;
    $perangkat->save();

    return redirect()->back()
        ->with('success', 'Data berhasil diverifikasi');
}
    
}