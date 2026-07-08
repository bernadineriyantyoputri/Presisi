<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\JenisRetribusi;
use App\Models\ObjekRetribusi;
use App\Models\RincianRetribusi;
use App\Models\DetailRetribusi;


class DataRetribusiController extends Controller
{
    public function index()
    {
        $data = JenisRetribusi::withCount('objekRetribusi')
            ->orderBy('nama_jenis')
            ->get();

        return view('admin.dataretribusi.index', compact('data'));
    }

    public function showJenis($id)
{
    $jenis = JenisRetribusi::with('objekRetribusi')
        ->findOrFail($id);

    return view(
        'admin.dataretribusi.objek',
        compact('jenis')
    );
}

    public function showObjek($id)
    {
        $objek = ObjekRetribusi::with('rincian')
            ->findOrFail($id);

        return view(
            'admin.dataretribusi.rincian',
            compact('objek')
        );
    }
    public function showRincian($id)
    {
        $rincian = RincianRetribusi::with('detail')
            ->findOrFail($id);

        return view(
            'admin.dataretribusi.detail',
            compact('rincian')
        );
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

public function storeObjek(Request $request)
{
    $request->validate([
        'jenis_id'   => 'required|exists:jenis_retribusi,id',
        'nama_objek' => 'required|string|max:255',
    ]);

    ObjekRetribusi::create([
        'jenis_id'   => $request->jenis_id,
        'nama_objek' => $request->nama_objek,
    ]);

    return back()->with('success', 'Objek Retribusi berhasil ditambahkan.');
}

    public function storeRincian(Request $request)
    {
        $request->validate([

            'objek_id' => 'required',
            'nama_rincian' => 'required'
        ]);
        RincianRetribusi::create([

            'objek_id' => $request->objek_id,
            'nama_rincian' => $request->nama_rincian
        ]);
        return back()->with('success', 'Rincian berhasil ditambahkan');
    }
    public function storeDetail(Request $request)
    {
        $request->validate([
            'rincian_id' => 'required',
            'nama_detail' => 'required'
        ]);
        DetailRetribusi::create([
            'rincian_id' => $request->rincian_id,
            'nama_detail' => $request->nama_detail
        ]);
        return back()->with('success', 'Detail berhasil ditambahkan');
    }
}