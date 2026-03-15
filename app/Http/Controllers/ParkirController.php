<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Siswa;
use App\Models\TempatParkir;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ParkirController extends Controller
{
    public function index(Request $request)
    {
        $action = $request->query('action');

        if ($action === 'laporan_kelas') {
            $data = DB::table('tempat_parkir as tp')
                ->join('kendaraan as k', 'tp.kendaraan_id', '=', 'k.id')
                ->join('siswa as s', 'tp.siswa_id', '=', 's.id')
                ->whereNull('tp.jam_keluar')
                ->select('s.kelas', DB::raw('COUNT(*) as jumlah'), DB::raw('GROUP_CONCAT(DISTINCT k.jenis_kendaraan) as jenis'))
                ->groupBy('s.kelas')
                ->orderBy('s.kelas')
                ->get();

            return response()->json(['success' => true, 'data' => $data]);
        }

        if ($action === 'laporan_hari') {
            $tanggal = $request->query('tanggal', now()->toDateString());

            $data = DB::table('tempat_parkir as tp')
                ->join('kendaraan as k', 'tp.kendaraan_id', '=', 'k.id')
                ->whereDate('tp.tanggal_parkir', $tanggal)
                ->whereNull('tp.jam_keluar')
                ->select('k.jenis_kendaraan', DB::raw('COUNT(*) as jumlah'))
                ->groupBy('k.jenis_kendaraan')
                ->get();

            return response()->json(['success' => true, 'data' => $data, 'tanggal' => $tanggal]);
        }

        $orderByParam = $request->query('orderBy', 'jam_masuk');
        $orderByMap = [
            'kelas' => 's.kelas',
            'jenis_kendaraan' => 'k.jenis_kendaraan',
            'jam_masuk' => 'tp.jam_masuk',
            'nama_siswa' => 's.nama_siswa',
        ];
        $orderBy = $orderByMap[$orderByParam] ?? 'tp.jam_masuk';

        $data = DB::table('tempat_parkir as tp')
            ->join('kendaraan as k', 'tp.kendaraan_id', '=', 'k.id')
            ->join('siswa as s', 'tp.siswa_id', '=', 's.id')
            ->select(
                'tp.id',
                's.nama_siswa',
                's.kelas',
                's.jurusan',
                'k.nomor_kendaraan',
                'k.jenis_kendaraan',
                'tp.jam_masuk',
                'tp.jam_keluar',
                'tp.tanggal_parkir'
            )
            ->orderBy($orderBy, 'desc')
            ->get();

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_siswa' => 'required|string|max:100',
            'kelas' => 'required|string|in:X,XI,XII',
            'jurusan' => 'required|string',
            'nomor_kendaraan' => 'required|string|max:20',
            'jenis_kendaraan' => 'required|string|in:Motor,Mobil,Sepeda',
            'jam_masuk' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Semua field harus diisi']);
        }

        $nomorKendaraan = strtoupper(trim($request->input('nomor_kendaraan')));
        $jamMasukInput = $request->input('jam_masuk');
        $jamMasuk = $jamMasukInput ? Carbon::parse($jamMasukInput) : now();
        $tanggalParkir = $jamMasuk->toDateString();

        $aktif = DB::table('kendaraan as k')
            ->join('tempat_parkir as tp', 'k.id', '=', 'tp.kendaraan_id')
            ->where('k.nomor_kendaraan', $nomorKendaraan)
            ->whereNull('tp.jam_keluar')
            ->exists();

        if ($aktif) {
            return response()->json(['success' => false, 'message' => 'Nomor kendaraan masih parkir, silakan keluar dulu']);
        }

        $payload = [
            'nama_siswa' => $request->input('nama_siswa'),
            'kelas' => $request->input('kelas'),
            'jurusan' => $request->input('jurusan'),
            'jenis_kendaraan' => $request->input('jenis_kendaraan'),
        ];

        try {
            $parkir = DB::transaction(function () use ($payload, $nomorKendaraan, $jamMasuk, $tanggalParkir) {
                $siswa = Siswa::where('nama_siswa', $payload['nama_siswa'])
                    ->where('kelas', $payload['kelas'])
                    ->where('jurusan', $payload['jurusan'])
                    ->first();

                if (! $siswa) {
                    $siswa = Siswa::create([
                        'nama_siswa' => $payload['nama_siswa'],
                        'kelas' => $payload['kelas'],
                        'jurusan' => $payload['jurusan'],
                    ]);
                }

                $kendaraan = Kendaraan::where('nomor_kendaraan', $nomorKendaraan)->first();

                if (! $kendaraan) {
                    $kendaraan = Kendaraan::create([
                        'siswa_id' => $siswa->id,
                        'nomor_kendaraan' => $nomorKendaraan,
                        'jenis_kendaraan' => $payload['jenis_kendaraan'],
                    ]);
                }

                return TempatParkir::create([
                    'kendaraan_id' => $kendaraan->id,
                    'siswa_id' => $siswa->id,
                    'jam_masuk' => $jamMasuk->format('Y-m-d H:i:s'),
                    'tanggal_parkir' => $tanggalParkir,
                ]);
            });

            return response()->json(['success' => true, 'message' => 'Data parkir berhasil ditambahkan', 'id' => $parkir->id]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function update(Request $request)
    {
        $id = $request->input('id');

        if (! $id) {
            return response()->json(['success' => false, 'message' => 'ID tidak ditemukan']);
        }

        $jamKeluar = $request->input('jam_keluar') ?: now()->format('Y-m-d H:i:s');

        $updated = TempatParkir::where('id', $id)->update([
            'jam_keluar' => $jamKeluar,
        ]);

        if ($updated) {
            return response()->json(['success' => true, 'message' => 'Kendaraan berhasil keluar']);
        }

        return response()->json(['success' => false, 'message' => 'Gagal mengupdate data']);
    }

    public function destroy(Request $request)
    {
        $id = $request->input('id');

        if (! $id) {
            return response()->json(['success' => false, 'message' => 'ID tidak ditemukan']);
        }

        $deleted = TempatParkir::where('id', $id)->delete();

        if ($deleted) {
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
        }

        return response()->json(['success' => false, 'message' => 'Gagal menghapus data']);
    }
}
