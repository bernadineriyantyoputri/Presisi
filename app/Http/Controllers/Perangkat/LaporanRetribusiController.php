<?php

namespace App\Http\Controllers\Perangkat;

use App\Http\Controllers\Controller;
use App\Models\JenisRetribusi;
use App\Models\ObjekRetribusi;
use App\Models\RincianRetribusi;
use App\Models\DetailRetribusi;
use App\Models\LaporanRetribusi;
use App\Models\LaporanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanRetribusiController extends Controller
{
    const SESSION_KEY = 'wizard_laporan';

    private array $namaBulan = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    private array $laporanRelations = [
        'details.detailRetribusi.rincian.objek.jenis',
        'details.rincian.objek.jenis',
    ];

    private function getPerangkat()
    {
        $perangkat = Auth::user()->perangkatDaerah;

        if (!$perangkat) {
            abort(403, 'Perangkat Daerah belum terdaftar.');
        }

        return $perangkat;
    }

    public function index()
    {
        return redirect()->route('perangkat.laporan.create');
    }
    public function create()
    {
        session()->forget(self::SESSION_KEY);

        $jenisRetribusi = JenisRetribusi::orderBy('nama_jenis')->get();

        return view('perangkat.laporan.create.jenis', compact('jenisRetribusi'));
    }
    public function pilihJenis(Request $request)
    {
        $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:2099',
            'jenis_retribusi_id' => 'required|exists:jenis_retribusi,id',
        ], [
            'bulan.required' => 'Bulan wajib dipilih.',
            'tahun.required' => 'Tahun wajib dipilih.',
            'jenis_retribusi_id.required' => 'Jenis retribusi wajib dipilih.',
            'jenis_retribusi_id.exists' => 'Jenis retribusi tidak valid.',
        ]);

        session([
            self::SESSION_KEY . '.bulan' => $request->bulan,
            self::SESSION_KEY . '.tahun' => $request->tahun,
            self::SESSION_KEY . '.jenis_retribusi_id' => $request->jenis_retribusi_id,
        ]);

        return redirect()->route('perangkat.laporan.create.objek.show');
    }

    public function showObjek(Request $request)
    {
        $wizard = session(self::SESSION_KEY, []);

        if (empty($wizard['jenis_retribusi_id'])) {
            return redirect()->route('perangkat.laporan.create')
                ->with('error', 'Sesi telah berakhir, silakan mulai dari awal.');
        }

        $jenis = JenisRetribusi::findOrFail($wizard['jenis_retribusi_id']);

        $objekList = ObjekRetribusi::where('jenis_id', $jenis->id)
            ->orderBy('nama_objek')
            ->get();

        $selectedObjekId = $request->query('objek_id');
        $selectedRincianId = $request->query('rincian_id');

        $rincianList = collect();
        $detailList = collect();

        if ($selectedObjekId) {
            $rincianList = RincianRetribusi::where('objek_id', $selectedObjekId)
                ->orderBy('nama_rincian')
                ->get();
        }

        if ($selectedRincianId) {
            $detailList = DetailRetribusi::where('rincian_id', $selectedRincianId)
                ->orderBy('nama_detail')
                ->get();
        }

        return view('perangkat.laporan.create.objek', compact(
            'jenis',
            'objekList',
            'rincianList',
            'detailList',
            'selectedObjekId',
            'selectedRincianId'
        ));
    }


    public function pilihObjek(Request $request)
    {
        // Sama seperti di nominalStore(): normalisasi string kosong jadi null
        // supaya rule 'nullable' bekerja dengan benar.
        $request->merge([
            'detail_retribusi_id' => $request->detail_retribusi_id ?: null,
        ]);

        $request->validate([
            'objek_id' => 'required|exists:objek_retribusi,id',
            'rincian_id' => 'required|exists:rincian_retribusi,id',
            'detail_retribusi_id' => 'nullable|exists:detail_retribusi,id',
        ], [
            'objek_id.required' => 'Objek retribusi wajib dipilih.',
            'rincian_id.required' => 'Rincian objek wajib dipilih.',
            'detail_retribusi_id.exists' => 'Detail objek tidak valid.',
        ]);

        $wizard = session(self::SESSION_KEY, []);

        if (empty($wizard['jenis_retribusi_id'])) {
            return redirect()->route('perangkat.laporan.create')
                ->with('error', 'Sesi telah berakhir, silakan mulai dari awal.');
        }

        if (empty($request->detail_retribusi_id)) {
            $adaDetail = DetailRetribusi::where('rincian_id', $request->rincian_id)->exists();
            if ($adaDetail) {
                return back()
                    ->withInput()
                    ->with('error', 'Detail objek wajib dipilih untuk rincian ini.');
            }
        }

        $wizard['objek_id'] = $request->objek_id;
        $wizard['rincian_id'] = $request->rincian_id;
        $wizard['detail_retribusi_id'] = $request->detail_retribusi_id ?: null;

        session([self::SESSION_KEY => $wizard]);

        return redirect()->route('perangkat.laporan.create.nominal.show');
    }

    public function nominalShow()
    {
        $wizard = session(self::SESSION_KEY, []);

        if (empty($wizard['objek_id']) || empty($wizard['rincian_id'])) {
            return redirect()->route('perangkat.laporan.create.objek.show')
                ->with('error', 'Silakan pilih objek retribusi terlebih dahulu.');
        }

        $objek = ObjekRetribusi::findOrFail($wizard['objek_id']);
        $rincian = RincianRetribusi::findOrFail($wizard['rincian_id']);
        $detail = !empty($wizard['detail_retribusi_id'])
            ? DetailRetribusi::find($wizard['detail_retribusi_id'])
            : null;

        return view('perangkat.laporan.create.nominal', compact('objek', 'rincian', 'detail'));
    }

    public function nominalStore(Request $request)
    {

        $request->merge([
            'detail_retribusi_id' => $request->detail_retribusi_id ?: null,
        ]);

        $request->validate([
            'objek_id' => 'required|exists:objek_retribusi,id',
            'rincian_id' => 'required|exists:rincian_retribusi,id',
            'detail_retribusi_id' => 'nullable|exists:detail_retribusi,id',
            'realisasi_bulan_ini' => 'required|numeric|min:0',
            'konfirmasi' => 'required',
        ], [
            'realisasi_bulan_ini.required' => 'Nominal realisasi wajib diisi.',
            'konfirmasi.required' => 'Anda harus menyatakan kebenaran data.',
        ]);

        $wizard = session(self::SESSION_KEY, []);

        if (empty($wizard['jenis_retribusi_id']) || empty($wizard['rincian_id'])) {
            return redirect()->route('perangkat.laporan.create')
                ->with('error', 'Sesi telah berakhir, silakan mulai dari awal.');
        }

        $wizard['objek_id'] = $request->objek_id;
        $wizard['rincian_id'] = $request->rincian_id;
        $wizard['detail_retribusi_id'] = $request->detail_retribusi_id ?: null;
        $wizard['realisasi_bulan_ini'] = $request->realisasi_bulan_ini;

        session([self::SESSION_KEY => $wizard]);

        $jenis = JenisRetribusi::find($wizard['jenis_retribusi_id']);
        $objek = ObjekRetribusi::find($wizard['objek_id']);
        $rincian = RincianRetribusi::find($wizard['rincian_id']);
        $detail = !empty($wizard['detail_retribusi_id'])
            ? DetailRetribusi::find($wizard['detail_retribusi_id'])
            : null;
        $bulanNama = $this->namaBulan[$wizard['bulan']] ?? '-';

        return view('perangkat.laporan.confirm', compact(
            'wizard',
            'jenis',
            'objek',
            'rincian',
            'detail',
            'bulanNama'
        ));
    }


    public function store(Request $request)
    {
        $isDraft = $request->input('action') === 'draft';
        $wizard = session(self::SESSION_KEY, []);

        if (empty($wizard) || empty($wizard['bulan']) || empty($wizard['rincian_id'])) {
            return redirect()->route('perangkat.laporan.create')
                ->with('error', 'Sesi telah berakhir, silakan mulai dari awal.');
        }

        $rincianId = $wizard['rincian_id'];
        $detailId = $wizard['detail_retribusi_id'] ?? null;

        DB::beginTransaction();

        try {
            $perangkat = $this->getPerangkat();

            // Cek duplikasi: berdasarkan rincian_id, dan detail_retribusi_id kalau ada.
            if (!$isDraft) {
                $exists = LaporanRetribusi::where('perangkat_daerah_id', $perangkat->id)
                    ->where('bulan', $wizard['bulan'])
                    ->where('tahun', $wizard['tahun'])
                    ->whereHas('details', function ($q) use ($rincianId, $detailId) {
                        $q->where('rincian_id', $rincianId);
                        if ($detailId) {
                            $q->where('detail_retribusi_id', $detailId);
                        } else {
                            $q->whereNull('detail_retribusi_id');
                        }
                    })
                    ->whereIn('status', ['draft', 'submit', 'terverifikasi'])
                    ->exists();

                if ($exists) {
                    return back()->with('error', 'Laporan untuk periode dan objek ini sudah ada.');
                }
            }

            $laporan = LaporanRetribusi::create([
                'perangkat_daerah_id' => $perangkat->id,
                'bulan' => $wizard['bulan'],
                'tahun' => $wizard['tahun'],
                'status' => $isDraft ? 'draft' : 'submit',
                'tanggal_submit' => $isDraft ? null : now(),
            ]);

            if (isset($wizard['realisasi_bulan_ini'])) {
                // Total realisasi bulan-bulan sebelumnya, difilter rincian + detail (kalau ada)
                $bulanLalu = LaporanDetail::where('rincian_id', $rincianId)
                    ->when($detailId, function ($q) use ($detailId) {
                        $q->where('detail_retribusi_id', $detailId);
                    }, function ($q) {
                        $q->whereNull('detail_retribusi_id');
                    })
                    ->whereHas('laporan', function ($q) use ($wizard, $perangkat) {
                        $q->where('perangkat_daerah_id', $perangkat->id)
                            ->where('tahun', $wizard['tahun'])
                            ->where('bulan', '<', $wizard['bulan'])
                            ->whereIn('status', ['submit', 'terverifikasi']);
                    })
                    ->sum('realisasi_bulan_ini');

                $bulanIni = (float) $wizard['realisasi_bulan_ini'];
                $total = $bulanLalu + $bulanIni;
                $persentase = $total > 0 ? round(($bulanIni / $total) * 100, 2) : 0;

                LaporanDetail::create([
                    'laporan_id' => $laporan->id,
                    'rincian_id' => $rincianId,
                    'detail_retribusi_id' => $detailId,
                    'realisasi_bulan_lalu' => $bulanLalu,
                    'realisasi_bulan_ini' => $bulanIni,
                    'total_realisasi' => $total,
                    'persentase' => $persentase,
                ]);
            }

            DB::commit();
            session()->forget(self::SESSION_KEY);

            $message = $isDraft
                ? 'Draft laporan berhasil disimpan.'
                : 'Laporan berhasil dikirim ke admin untuk diverifikasi.';

            if ($isDraft) {
                return redirect()
                    ->route('perangkat.riwayat')
                    ->with('success', $message);
            }

            return redirect()
                ->route('perangkat.laporan.selesai', $laporan->id)
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function selesai($id)
    {
        $perangkat = $this->getPerangkat();

        $laporan = LaporanRetribusi::with($this->laporanRelations)
            ->where('perangkat_daerah_id', $perangkat->id)
            ->findOrFail($id);

        return view('perangkat.laporan.success', compact('laporan'));
    }

    public function cetakPdf(Request $request, $id)
    {
        if (auth()->user()->role == 'admin_bapenda') {

            // Admin dapat melihat semua laporan
            $laporan = LaporanRetribusi::with(array_merge(
                $this->laporanRelations,
                ['perangkatDaerah']
            ))
                ->findOrFail($id);

        } else {

            // Perangkat hanya dapat melihat laporannya sendiri
            $perangkat = $this->getPerangkat();

            $laporan = LaporanRetribusi::with(array_merge(
                $this->laporanRelations,
                ['perangkatDaerah']
            ))
                ->where('perangkat_daerah_id', $perangkat->id)
                ->findOrFail($id);
        }

        $bulanNama = $this->namaBulan[$laporan->bulan] ?? '-';

        $pdf = Pdf::loadView('perangkat.laporan.pdf', compact('laporan', 'bulanNama'))
            ->setPaper('a4', 'portrait');

        $filename = 'laporan-retribusi-' . $laporan->id . '.pdf';

        if ($request->query('download')) {
            return $pdf->download($filename);
        }

        return $pdf->stream($filename);
    }
    public function riwayat()
    {
        $perangkat = $this->getPerangkat();

        $laporan = LaporanRetribusi::with($this->laporanRelations)
            ->where('perangkat_daerah_id', $perangkat->id)
            ->latest()
            ->paginate(10);

        return view('perangkat.riwayat.index', compact('laporan'));
    }

    public function show($id)
    {
        $perangkat = $this->getPerangkat();

        $laporan = LaporanRetribusi::with($this->laporanRelations)
            ->where('perangkat_daerah_id', $perangkat->id)
            ->findOrFail($id);

        return view('perangkat.laporan.show', compact('laporan'));
    }

    public function destroy($id)
    {
        $perangkat = $this->getPerangkat();

        $laporan = LaporanRetribusi::where('perangkat_daerah_id', $perangkat->id)
            ->where('status', 'draft')
            ->findOrFail($id);

        DB::beginTransaction();

        try {
            $laporan->details()->delete();
            $laporan->delete();

            DB::commit();

            return redirect()
                ->route('perangkat.laporan.riwayat')
                ->with('success', 'Draft laporan berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }
}