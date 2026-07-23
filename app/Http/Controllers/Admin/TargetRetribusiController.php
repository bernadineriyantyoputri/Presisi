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
        // Dropdown "Tahun Anggaran" sekarang cukup kirim tahun saja (mis. "2026")
        $tahun = (int) $request->input('tahun', now()->year);

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
            'jenisRetribusi',
            'jenisId'
        ));
    }

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
            'target_nominal' => 'nullable|required_without:target_perubahan|numeric|min:0',
            'target_perubahan' => 'nullable|required_without:target_nominal|numeric|min:0',
            'target_aktif' => 'nullable|in:murni,perubahan',
        ]);

        $dataUpdate = [];

        if ($request->filled('target_nominal')) {
            $dataUpdate['target_nominal'] = $validated['target_nominal'];
        }

        if ($request->filled('target_perubahan')) {
            $dataUpdate['target_perubahan'] = $validated['target_perubahan'];
        }

        if (!empty($validated['target_aktif'])) {
            $dataUpdate['target_aktif'] = $validated['target_aktif'];
        }

        $row = TargetRetribusi::updateOrCreate(
            [
                'rincian_id' => $validated['rincian_id'] ?? null,
                'detail_id' => $validated['detail_id'] ?? null,
                'tahun' => $validated['tahun'],
            ],
            $dataUpdate
        );

        \Log::info('Target retribusi disimpan', [
            'id' => $row->id,
            'data' => $dataUpdate,
        ]);

        return back()->with('success', 'Target berhasil disimpan.');
    }

    public function aktifkanPerubahan(TargetRetribusi $target)
    {
        $target->update([
            'target_aktif' => 'perubahan',
        ]);

        return back()->with('success', 'Target Perubahan berhasil diaktifkan.');
    }

    public function aktifkanMurni(TargetRetribusi $target)
    {
        $target->update([
            'target_aktif' => 'murni',
        ]);

        return back()->with('success', 'Target Murni berhasil diaktifkan.');
    }
}