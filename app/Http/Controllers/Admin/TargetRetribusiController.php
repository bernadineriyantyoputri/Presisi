<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisRetribusi;
use App\Models\RincianRetribusi;
use App\Models\TargetRetribusi;

class TargetRetribusiController extends Controller
{
    public function index(Request $request)
    {
        // Dropdown "tahun_anggaran" mengirim value gabungan, contoh: "2026|murni" atau "2026|perubahan"
        // Default: tahun berjalan, jenis murni
        $tahunAnggaranRaw = $request->input('tahun_anggaran', now()->year . '|murni');
        [$tahun, $jenisAnggaran] = array_pad(explode('|', $tahunAnggaranRaw), 2, 'murni');

        $tahun = (int) $tahun;
        $jenisAnggaran = in_array($jenisAnggaran, ['murni', 'perubahan']) ? $jenisAnggaran : 'murni';

        $jenisId = $request->jenis_id;
        $search = $request->search;

        $jenisRetribusi = JenisRetribusi::orderBy('nama_jenis')->get();

        $query = RincianRetribusi::with([
            'objek.jenis',
            'detail.target',
            'target',
        ]);

        if ($jenisId) {
            $query->whereHas('objek', function ($q) use ($jenisId) {
                $q->where('jenis_id', $jenisId);
            });
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_rincian', 'like', "%{$search}%")
                    ->orWhereHas('detail', function ($q2) use ($search) {
                        $q2->where('nama_detail', 'like', "%{$search}%");
                    });
            });
        }

        $rincians = $query->get();

        // Semua target pada tahun yang dipilih (untuk kartu statistik)
        $targets = TargetRetribusi::where('tahun', $tahun)->get();

        return view('admin.targetretribusi.index', compact(
            'rincians',
            'targets',
            'tahun',
            'jenisAnggaran',
            'jenisRetribusi',
            'jenisId'
        ));
    }

    /**
     * Simpan / update target (kolom 'target_nominal' untuk Murni, 'target_perubahan' untuk Perubahan)
     * pada baris tahun yang sama.
     */
    public function store(Request $request)
    {
        // Normalisasi "" -> null SEBELUM validasi, supaya rule tidak menolak/salah baca nilai kosong
        $request->merge([
            'rincian_id' => $request->rincian_id ?: null,
            'detail_id' => $request->detail_id ?: null,
        ]);

        $validated = $request->validate([
            'rincian_id' => 'nullable|required_without:detail_id|exists:rincian_retribusi,id',
            'detail_id' => 'nullable|required_without:rincian_id|exists:detail_retribusi,id',
            'tahun' => 'required|integer|min:2000|max:2100',
            'jenis' => 'required|in:murni,perubahan',
            'target_nominal' => 'required|numeric|min:0',
        ]);

        $kolom = $validated['jenis'] === 'perubahan' ? 'target_perubahan' : 'target'; // sesuaikan nama kolom aslinya

        $row = TargetRetribusi::updateOrCreate(
            [
                'rincian_id' => $validated['rincian_id'] ?? null,
                'detail_id' => $validated['detail_id'] ?? null,
                'tahun' => $validated['tahun'],
            ],
            [
                $kolom => $validated['target_nominal'],
            ]
        );

        \Log::info('Target retribusi disimpan', [
            'id' => $row->id,
            'kolom' => $kolom,
            'nilai' => $validated['target_nominal'],
        ]);

        return back()->with('success', 'Target berhasil disimpan.');
    }
}