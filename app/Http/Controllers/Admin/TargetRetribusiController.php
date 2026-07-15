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
        $tahun = now()->year;

        $jenisId = $request->jenis_id;

        $jenisRetribusi = JenisRetribusi::orderBy('nama_jenis')->get();

        $query = RincianRetribusi::with([
            'objek.jenis',
            'detail.target',
            'target'
        ]);

        if ($jenisId) {
            $query->whereHas('objek', function ($q) use ($jenisId) {
                $q->where('jenis_id', $jenisId);
            });
        }

        $rincians = $query->get();

        $targets = TargetRetribusi::where('tahun', $tahun)->get();

        return view('admin.targetretribusi.index', compact(
            'rincians',
            'targets',
            'tahun',
            'jenisRetribusi',
            'jenisId'
        ));
    }
}