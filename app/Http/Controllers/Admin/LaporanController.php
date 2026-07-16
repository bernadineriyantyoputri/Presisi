<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanRetribusi;
use App\Models\PerangkatDaerah;
use App\Models\JenisRetribusi;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $perangkatDaerahList = PerangkatDaerah::orderBy('nama_perangkat')->get();
        $jenisRetribusiList = JenisRetribusi::orderBy('nama_jenis')->get();

        $query = LaporanRetribusi::with([
            'perangkatDaerah',
            'laporanDetail.rincian.objek.jenis',
        ]);

        if ($request->filled('search')) {
            $query->whereHas('perangkatDaerah', function ($q) use ($request) {
                $q->where('nama_perangkat', 'ilike', '%' . $request->search . '%');
            });
        }

        if ($request->filled('jenis_retribusi')) {
            $jenisId = $request->jenis_retribusi;
            $query->whereHas('laporanDetail.rincian.objek', function ($q) use ($jenisId) {
                $q->where('jenis_id', $jenisId);
            });
        }

        if ($request->filled('bulan')) {
            $query->where('bulan', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        $laporan = $query->latest()->paginate(10)->withQueryString();

        return view('admin.laporan.index', compact('laporan', 'jenisRetribusiList', 'perangkatDaerahList'));
    }

    public function detail($id)
    {
        $laporan = LaporanRetribusi::with('laporanDetail.rincian.objek.jenis')->findOrFail($id);

        return view('admin.laporan.detail', compact('laporan'));
    }
}