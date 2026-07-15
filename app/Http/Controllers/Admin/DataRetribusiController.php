<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\JenisRetribusi;
use App\Models\ObjekRetribusi;
use App\Models\RincianRetribusi;
use App\Models\DetailRetribusi;
use App\Models\TargetRetribusi;

class DataRetribusiController extends Controller
{
    public function index()
    {
        $data = JenisRetribusi::withCount('objekRetribusi')
            ->orderBy('nama_jenis')
            ->get();

        return view('admin.dataretribusi.index', compact('data'));
    }

    public function showJenis(Request $request, $id)
    {
        $jenis = JenisRetribusi::with('objekRetribusi')
            ->findOrFail($id);

        // hanya tampilkan objek yang masih punya rincian (Opsi A)
        $objekList = $jenis->objekRetribusi()
            ->whereHas('rincian')
            ->get();

        $selectedObjek = $request->filled('objek')
            ? $objekList->firstWhere('id', $request->objek)
            : $objekList->first();

        // basis-nya rincian, dengan semua detail-nya di-load sekaligus
        $data = $selectedObjek
            ? RincianRetribusi::with('detail', 'objek')
                ->where('objek_id', $selectedObjek->id)
                ->paginate(10)
            : RincianRetribusi::whereRaw('1 = 0')->paginate(10);

        return view(
            'admin.dataretribusi.objek',
            compact('jenis', 'objekList', 'selectedObjek', 'data')
        );
    }

    public function showObjek($id)
    {
        $objek = ObjekRetribusi::with('rincian')
            ->findOrFail($id);

        return view('admin.dataretribusi.rincian', compact('objek'));
    }

    public function showRincian($id)
    {
        $rincian = RincianRetribusi::with('detail')
            ->findOrFail($id);

        return view('admin.dataretribusi.detail', compact('rincian'));
    }

    public function storeJenis(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:255',
        ]);

        JenisRetribusi::create([
            'nama_jenis' => $request->nama_jenis,
        ]);

        return redirect()
            ->route('admin.data.index')
            ->with('success', 'Jenis Retribusi berhasil ditambahkan.');
    }

    public function destroyJenis($id)
    {
        $jenis = JenisRetribusi::findOrFail($id);

        if ($jenis->objekRetribusi()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus, masih ada data terkait di bawahnya.');
        }

        $jenis->delete();

        return back()->with('success', 'Jenis retribusi berhasil dihapus.');
    }

    public function storeObjek(Request $request)
    {
        $request->validate([
            'jenis_id' => 'required|exists:jenis_retribusi,id',
            'nama_objek' => 'required|string|max:255',
        ]);

        ObjekRetribusi::create([
            'jenis_id' => $request->jenis_id,
            'nama_objek' => $request->nama_objek,
        ]);

        return back()->with('success', 'Objek Retribusi berhasil ditambahkan.');
    }

    public function storeRincian(Request $request)
    {
        $request->validate([
            'objek_id' => 'required',
            'nama_rincian' => 'required',
        ]);

        RincianRetribusi::create([
            'objek_id' => $request->objek_id,
            'nama_rincian' => $request->nama_rincian,
        ]);

        return back()->with('success', 'Rincian berhasil ditambahkan');
    }

    public function updateRincian(Request $request, $id)
    {
        $request->validate([
            'nama_rincian' => 'required|string|max:255',
            'nama_detail' => 'nullable|string',
        ]);

        $rincian = RincianRetribusi::with('detail')->findOrFail($id);

        $rincian->update([
            'nama_rincian' => $request->nama_rincian,
        ]);

        if ($request->filled('nama_detail')) {
            $firstDetail = $rincian->detail->first();

            if ($firstDetail) {
                $firstDetail->update(['nama_detail' => $request->nama_detail]);
            } else {
                $rincian->detail()->create(['nama_detail' => $request->nama_detail]);
            }
        }

        return back()->with('success', 'Rincian berhasil diperbarui.');
    }

    public function destroyRincian($id)
    {
        $rincian = RincianRetribusi::with('objek')->findOrFail($id);
        $objek = $rincian->objek;

        // hapus semua detail dulu
        $rincian->detail()->delete();

        // hapus rincian-nya
        $rincian->delete();

        // kalau objek sudah tidak punya rincian lain, hapus juga objeknya
        if ($objek && $objek->rincian()->count() === 0) {
            $objek->delete();
        }

        return back()->with('success', 'Rincian berhasil dihapus.');
    }

    public function bulkDestroyRincian(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'exists:rincian_retribusi,id', // sesuaikan nama tabel jika berbeda
        ]);

        $rincianList = RincianRetribusi::with('objek')->whereIn('id', $request->ids)->get();
        $objekIds = $rincianList->pluck('objek_id')->unique();

        foreach ($rincianList as $rincian) {
            $rincian->detail()->delete();
            $rincian->delete();
        }

        // bersihkan objek yang jadi kosong (tidak punya rincian lagi)
        ObjekRetribusi::whereIn('id', $objekIds)
            ->whereDoesntHave('rincian')
            ->delete();

        return back()->with('success', count($request->ids) . ' data rincian berhasil dihapus.');
    }

    public function storeDetail(Request $request)
    {
        $request->validate([
            'rincian_id' => 'required',
            'nama_detail' => 'required',
        ]);

        DetailRetribusi::create([
            'rincian_id' => $request->rincian_id,
            'nama_detail' => $request->nama_detail,
        ]);

        return back()->with('success', 'Detail berhasil ditambahkan');
    }

    public function updateDetail(Request $request, DetailRetribusi $detail)
    {
        $request->validate([
            'nama_detail' => 'required|string|max:255',
        ]);

        $detail->update([
            'nama_detail' => $request->nama_detail,
        ]);

        return back()->with('success', 'Detail berhasil diperbarui.');
    }

    public function destroyDetail($id)
    {
        $detail = DetailRetribusi::findOrFail($id);
        $detail->delete();

        return back()->with('success', 'Detail berhasil dihapus.');
    }

    public function updateJenis(Request $request, JenisRetribusi $jenis)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $jenis->update([
            'nama_jenis' => $request->nama_jenis,
            'deskripsi' => $request->deskripsi,
        ]);

        return back()->with('success', 'Jenis retribusi berhasil diperbarui.');
    }

    public function storeObjekLengkap(Request $request)
    {
        $request->validate([
            'jenis_id' => 'required|exists:jenis_retribusi,id',
            'nama_objek' => 'required|string|max:255',
            'nama_rincian' => 'required|string|max:255',
            'nama_detail' => 'required|string|max:255',
        ]);

        $objek = ObjekRetribusi::create([
            'jenis_id' => $request->jenis_id,
            'nama_objek' => $request->nama_objek,
        ]);

        $rincian = $objek->rincian()->create([
            'nama_rincian' => $request->nama_rincian,
        ]);

        $rincian->detail()->create([
            'nama_detail' => $request->nama_detail,
        ]);

        return back()->with('success', 'Objek retribusi berhasil ditambahkan.');
    }

    /**
     * Simpan target retribusi untuk SATU PERIODE (per tahun).
     * Skema punya 2 unique constraint terpisah:
     *  - (detail_id, tahun)  -> dipakai kalau rincian punya detail
     *  - (rincian_id, tahun) -> dipakai kalau rincian TIDAK punya detail
     * Karena itu hanya salah satu dari rincian_id/detail_id yang diisi per baris,
     * yang lain harus null supaya tidak bentrok antar constraint.
     */
    public function storeTarget(Request $request)
    {
        $request->validate([
            'rincian_id'     => 'required|exists:rincian_retribusi,id',
            'detail_id'      => 'nullable|exists:detail_retribusi,id',
            'tahun'          => 'required|integer|min:2000|max:2100',
            'target_nominal' => 'required|numeric|min:0',
        ]);

        if ($request->filled('detail_id')) {
            TargetRetribusi::updateOrCreate(
                [
                    'detail_id' => $request->detail_id,
                    'tahun'     => $request->tahun,
                ],
                [
                    'rincian_id'     => null,
                    'target_nominal' => $request->target_nominal,
                ]
            );
        } else {
            TargetRetribusi::updateOrCreate(
                [
                    'rincian_id' => $request->rincian_id,
                    'tahun'      => $request->tahun,
                ],
                [
                    'detail_id'      => null,
                    'target_nominal' => $request->target_nominal,
                ]
            );
        }

        return back()->with('success', 'Target berhasil disimpan.');
    }
}