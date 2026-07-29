<?php

namespace App\Http\Controllers\Perangkat;

use App\Http\Controllers\Controller;
use App\Models\JenisRetribusi;
use App\Models\ObjekRetribusi;
use App\Models\RincianRetribusi;
use App\Models\DetailRetribusi;
use App\Models\LaporanRetribusi;
use App\Models\LaporanDetail;
use App\Models\TargetRetribusi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanRetribusiController extends Controller
{
    const SESSION_KEY = 'wizard_laporan';       // draft uraian yg sedang diisi
    const SESSION_LIST_KEY = 'wizard_uraian_list'; // keranjang uraian yg sudah selesai

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
        // Titik mulai laporan baru dari nol -> reset kedua session
        session()->forget(self::SESSION_KEY);
        session()->forget(self::SESSION_LIST_KEY);

        $jenisRetribusi = JenisRetribusi::orderBy('nama_jenis')->get();

        return view('perangkat.laporan.create.jenis', compact('jenisRetribusi'));
    }

    // Dipanggil dari halaman confirmList saat user klik "Tambah Uraian Lagi"
    // Bulan/tahun dikunci ke uraian pertama, jenis tetap bisa dipilih ulang.
    public function tambahUraian()
{
    $uraianList = session(self::SESSION_LIST_KEY, []);

    if (empty($uraianList)) {
        return redirect()->route('perangkat.laporan.create');
    }

    session([self::SESSION_KEY => [
        'bulan' => $uraianList[0]['bulan'],
        'tahun' => $uraianList[0]['tahun'],
    ]]);

    $jenisRetribusi = JenisRetribusi::orderBy('nama_jenis')->get();
    $bulanTerkunci = true;
    $bulanNama = $this->namaBulan[$uraianList[0]['bulan']] ?? '-';   // ⬅️ tambahan
    $tahunTerkunci = $uraianList[0]['tahun'];                          // ⬅️ tambahan

    return view('perangkat.laporan.create.jenis', compact(
        'jenisRetribusi', 'bulanTerkunci', 'bulanNama', 'tahunTerkunci'   // ⬅️ tambahkan ke compact
    ));
}
    public function pilihJenis(Request $request)
    {
        $uraianList = session(self::SESSION_LIST_KEY, []);

        $rules = [
            'jenis_retribusi_id' => 'required|exists:jenis_retribusi,id',
        ];

        // Kalau ini uraian pertama, bulan/tahun wajib diisi dari form.
        // Kalau uraian ke-2 dst, bulan/tahun sudah ada di session (terkunci), tidak wajib dari input.
        if (empty($uraianList)) {
            $rules['bulan'] = 'required|integer|min:1|max:12';
            $rules['tahun'] = 'required|integer|min:2000|max:2099';
        }

        $request->validate($rules, [
            'bulan.required' => 'Bulan wajib dipilih.',
            'tahun.required' => 'Tahun wajib dipilih.',
            'jenis_retribusi_id.required' => 'Jenis retribusi wajib dipilih.',
            'jenis_retribusi_id.exists' => 'Jenis retribusi tidak valid.',
        ]);

        $wizard = session(self::SESSION_KEY, []);

        session([
            self::SESSION_KEY . '.bulan' => $wizard['bulan'] ?? $request->bulan,
            self::SESSION_KEY . '.tahun' => $wizard['tahun'] ?? $request->tahun,
            self::SESSION_KEY . '.jenis_retribusi_id' => $request->jenis_retribusi_id,
        ]);

        return redirect()->route('perangkat.laporan.create.objek.show');
    }

    //step 2 show objek
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
            'jenis', 'objekList', 'rincianList', 'detailList',
            'selectedObjekId', 'selectedRincianId'
        ));
    }

    public function pilihObjek(Request $request)
    {
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
                return back()->withInput()
                    ->with('error', 'Detail objek wajib dipilih untuk rincian ini.');
            }
        }

        $wizard['objek_id'] = $request->objek_id;
        $wizard['rincian_id'] = $request->rincian_id;
        $wizard['detail_retribusi_id'] = $request->detail_retribusi_id ?: null;

        session([self::SESSION_KEY => $wizard]);

        return redirect()->route('perangkat.laporan.create.nominal.show');
    }

    // step 3 isi nominal

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

        // Cek duplikat rincian/detail dalam keranjang (tidak boleh input objek yang sama 2x)
        $uraianList = session(self::SESSION_LIST_KEY, []);
        $rincianId = $request->rincian_id;
        $detailId = $request->detail_retribusi_id ?: null;

        $duplikat = collect($uraianList)->contains(function ($u) use ($rincianId, $detailId) {
            return $u['rincian_id'] == $rincianId && $u['detail_retribusi_id'] == $detailId;
        });

        if ($duplikat) {
            return back()->withInput()
                ->with('error', 'Objek retribusi ini sudah ditambahkan ke laporan. Silakan pilih objek lain atau hapus dulu dari daftar.');
        }

        // Simpan uraian lengkap ke draft
        $wizard['objek_id'] = $request->objek_id;
        $wizard['rincian_id'] = $request->rincian_id;
        $wizard['detail_retribusi_id'] = $detailId;
        $wizard['realisasi_bulan_ini'] = $request->realisasi_bulan_ini;

        // Push draft ke keranjang
        $uraianList[] = $wizard;
        session([self::SESSION_LIST_KEY => $uraianList]);

        // Reset draft per-uraian, tapi bulan/tahun tetap dipertahankan
        session([self::SESSION_KEY => [
            'bulan' => $wizard['bulan'],
            'tahun' => $wizard['tahun'],
        ]]);

        return redirect()->route('perangkat.laporan.create.confirm.list');
    }

    // daftar uraian

    public function confirmList()
    {
        $uraianList = session(self::SESSION_LIST_KEY, []);

        if (empty($uraianList)) {
            return redirect()->route('perangkat.laporan.create')
                ->with('error', 'Belum ada uraian yang ditambahkan.');
        }

        $bulanNama = $this->namaBulan[$uraianList[0]['bulan']] ?? '-';
        $tahun = $uraianList[0]['tahun'];

        // Lengkapi tiap item dengan data relasi untuk ditampilkan (nama objek, rincian, dll)
        $items = collect($uraianList)->map(function ($u, $i) {
            return [
                'index' => $i,
                'jenis' => JenisRetribusi::find($u['jenis_retribusi_id']),
                'objek' => ObjekRetribusi::find($u['objek_id']),
                'rincian' => RincianRetribusi::find($u['rincian_id']),
                'detail' => !empty($u['detail_retribusi_id']) ? DetailRetribusi::find($u['detail_retribusi_id']) : null,
                'nominal' => $u['realisasi_bulan_ini'],
            ];
        });

        $total = $items->sum('nominal');

        return view('perangkat.laporan.confirmlist', compact('items', 'bulanNama', 'tahun', 'total'));
    }

    public function hapusUraian($index)
    {
        $uraianList = session(self::SESSION_LIST_KEY, []);

        if (!isset($uraianList[$index])) {
            return back()->with('error', 'Uraian tidak ditemukan.');
        }

        unset($uraianList[$index]);
        $uraianList = array_values($uraianList); // reindex

        session([self::SESSION_LIST_KEY => $uraianList]);

        // Kalau habis semua, balik ke awal
        if (empty($uraianList)) {
            session()->forget(self::SESSION_KEY);
            session()->forget(self::SESSION_LIST_KEY);
            return redirect()->route('perangkat.laporan.create')
                ->with('success', 'Uraian dihapus. Semua uraian sudah kosong, silakan mulai lagi.');
        }

        return back()->with('success', 'Uraian berhasil dihapus.');
    }
    // ringkasan akhir sebelum submit (Step 4)
    public function ringkasanShow()
    {
        $uraianList = session(self::SESSION_LIST_KEY, []);

        if (empty($uraianList)) {
            return redirect()->route('perangkat.laporan.create')
                ->with('error', 'Belum ada uraian yang ditambahkan.');
        }

        $bulanNama = $this->namaBulan[$uraianList[0]['bulan']] ?? '-';
        $tahun = $uraianList[0]['tahun'];

        $items = collect($uraianList)->map(function ($u) {
            return [
                'jenis' => JenisRetribusi::find($u['jenis_retribusi_id']),
                'objek' => ObjekRetribusi::find($u['objek_id']),
                'rincian' => RincianRetribusi::find($u['rincian_id']),
                'detail' => !empty($u['detail_retribusi_id']) ? DetailRetribusi::find($u['detail_retribusi_id']) : null,
                'nominal' => $u['realisasi_bulan_ini'],
            ];
        });

        $total = $items->sum('nominal');

        return view('perangkat.laporan.confirm', compact('items', 'bulanNama', 'tahun', 'total'));
    }

    // ============ STORE FINAL — loop semua uraian ============

    public function store(Request $request)
    {
        $isDraft = $request->input('action') === 'draft';
        $uraianList = session(self::SESSION_LIST_KEY, []);

        if (empty($uraianList)) {
            return redirect()->route('perangkat.laporan.create')
                ->with('error', 'Sesi telah berakhir, silakan mulai dari awal.');
        }

        $bulan = $uraianList[0]['bulan'];
        $tahun = $uraianList[0]['tahun'];

        DB::beginTransaction();

        try {
            $perangkat = $this->getPerangkat();

            // Cek duplikasi ke DB untuk SEMUA uraian dulu, sebelum insert apapun
            if (!$isDraft) {
                foreach ($uraianList as $u) {
                    $exists = LaporanRetribusi::where('perangkat_daerah_id', $perangkat->id)
                        ->where('bulan', $bulan)
                        ->where('tahun', $tahun)
                        ->whereHas('details', function ($q) use ($u) {
                            $q->where('rincian_id', $u['rincian_id']);
                            if (!empty($u['detail_retribusi_id'])) {
                                $q->where('detail_retribusi_id', $u['detail_retribusi_id']);
                            } else {
                                $q->whereNull('detail_retribusi_id');
                            }
                        })
                        ->whereIn('status', ['draft', 'submit', 'terverifikasi'])
                        ->exists();

                    if ($exists) {
                        DB::rollBack();
                        return redirect()
                            ->route('perangkat.laporan.create.confirm.list')
                            ->with('error', 'Salah satu objek retribusi yang Anda tambahkan sudah pernah dilaporkan pada periode ini.');
                    }
                }
            }

            // Buat 1 header laporan
            $laporan = LaporanRetribusi::create([
                'perangkat_daerah_id' => $perangkat->id,
                'bulan' => $bulan,
                'tahun' => $tahun,
                'status' => $isDraft ? 'draft' : 'submit',
                'tanggal_submit' => $isDraft ? null : now(),
            ]);

            // Loop, buat 1 LaporanDetail per uraian
            foreach ($uraianList as $u) {
                $this->buatLaporanDetail($laporan, $u, $perangkat);
            }

            DB::commit();
            session()->forget(self::SESSION_KEY);
            session()->forget(self::SESSION_LIST_KEY);

            $message = $isDraft
                ? 'Draft laporan berhasil disimpan.'
                : 'Laporan berhasil dikirim ke admin untuk diverifikasi.';

            if ($isDraft) {
                return redirect()->route('perangkat.riwayat')->with('success', $message);
            }

            return redirect()->route('perangkat.laporan.selesai', $laporan->id)->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('perangkat.laporan.create.confirm.list')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Logic hitung realisasi_bulan_lalu, target_snapshot, persentase
    // dipindah ke sini dari store() lama, supaya bisa dipanggil berulang dalam loop.
    private function buatLaporanDetail(LaporanRetribusi $laporan, array $u, $perangkat)
    {
        $rincianId = $u['rincian_id'];
        $detailId = $u['detail_retribusi_id'] ?? null;

        $bulanLalu = LaporanDetail::where('rincian_id', $rincianId)
            ->when($detailId, function ($q) use ($detailId) {
                $q->where('detail_retribusi_id', $detailId);
            }, function ($q) {
                $q->whereNull('detail_retribusi_id');
            })
            ->whereHas('laporan', function ($q) use ($laporan, $perangkat) {
                $q->where('perangkat_daerah_id', $perangkat->id)
                    ->where('tahun', $laporan->tahun)
                    ->where('bulan', '<', $laporan->bulan)
                    ->whereIn('status', ['submit', 'terverifikasi']);
            })
            ->sum('realisasi_bulan_ini');

        $bulanIni = (float) $u['realisasi_bulan_ini'];
        $total = $bulanLalu + $bulanIni;

        $targetRow = TargetRetribusi::where('tahun', $laporan->tahun)
            ->when($detailId, function ($q) use ($detailId) {
                $q->where('detail_id', $detailId);
            }, function ($q) use ($rincianId) {
                $q->where('rincian_id', $rincianId)->whereNull('detail_id');
            })
            ->first();

        $targetNominal = $targetRow && $targetRow->target_aktif == 'perubahan'
            ? ($targetRow->target_perubahan ?? 0)
            : ($targetRow->target_nominal ?? 0);

        $persentase = $targetNominal > 0
            ? round(($total / $targetNominal) * 100, 2)
            : 0;

        return LaporanDetail::create([
            'laporan_id' => $laporan->id,
            'rincian_id' => $rincianId,
            'detail_retribusi_id' => $detailId,
            'realisasi_bulan_lalu' => $bulanLalu,
            'realisasi_bulan_ini' => $bulanIni,
            'total_realisasi' => $total,
            'persentase' => $persentase,
            'target_snapshot' => $targetNominal,
            'target_aktif_snapshot' => $targetRow->target_aktif ?? null,
        ]);
    }

    // ============ SISANYA TIDAK BERUBAH ============

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
            $laporan = LaporanRetribusi::with(array_merge($this->laporanRelations, ['perangkatDaerah']))
                ->findOrFail($id);
        } else {
            $perangkat = $this->getPerangkat();
            $laporan = LaporanRetribusi::with(array_merge($this->laporanRelations, ['perangkatDaerah']))
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
            return redirect()->route('perangkat.laporan.riwayat')
                ->with('success', 'Draft laporan berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }
}