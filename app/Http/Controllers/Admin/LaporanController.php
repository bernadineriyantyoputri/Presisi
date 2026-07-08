<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanRetribusi;

class LaporanController extends Controller
{
    public function index()
    {
        $laporan = LaporanRetribusi::with('perangkatDaerah')
            ->latest()
            ->paginate(10);

        return view('admin.laporan.index', compact('laporan'));
    }

    public function detail($id)
    {
        $laporan = LaporanRetribusi::findOrFail($id);

        return view('admin.laporan.detail', compact('laporan'));
    }
}