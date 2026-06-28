<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Guest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB; // Wajib ditambahkan untuk query grafik database

class VisitController extends Controller
{
    // 1. Menampilkan Dashboard Utama beserta Grafik dan Filter
    public function index(Request $request)
    {
        // Atur Default Tanggal (7 Hari Terakhir s/d Hari Ini)
        $tgl_awal = $request->get('tgl_awal', Carbon::now()->subDays(7)->format('Y-m-d'));
        $tgl_akhir = $request->get('tgl_akhir', Carbon::now()->format('Y-m-d'));

        // QUERY GRAFIK (Menggunakan casting ::date khusus PostgreSQL/Supabase)
        $chartData = Visit::select(
                DB::raw("waktu_masuk::date as tanggal"),
                DB::raw("count(*) as total")
            )
            ->whereRaw("waktu_masuk::date BETWEEN ? AND ?", [$tgl_awal, $tgl_akhir])
            ->groupBy(DB::raw("waktu_masuk::date"))
            ->orderBy('tanggal', 'asc')
            ->get();

        // Siapkan array data untuk Chart.js
        $label_tgl = [];
        $data_visitor = [];

        foreach ($chartData as $row) {
            $label_tgl[] = Carbon::parse($row->tanggal)->format('d M Y');
            $data_visitor[] = $row->total;
        }

        // QUERY TABEL DATA (Disinkronkan dengan filter rentang tanggal)
        $visits = Visit::with('guest')
            ->whereRaw("waktu_masuk::date BETWEEN ? AND ?", [$tgl_awal, $tgl_akhir])
            ->orderBy('waktu_masuk', 'desc')
            ->get();

        // Kirim semua variabel ke dalam View
        return view('visits.index', compact('visits', 'tgl_awal', 'tgl_akhir', 'label_tgl', 'data_visitor'));
    }

    // 2. Menampilkan Form Input Tamu
    public function create()
    {
        return view('visits.create');
    }

    // 3. Menyimpan Data Tamu dan Kunjungan
    public function store(Request $request)
    {
        $request->validate([
            'nama_tamu' => 'required|string|max:100',
            'perusahaan' => 'required|string|max:100',
            'no_hp' => 'required|numeric',
            'divisi_tujuan' => 'required|string|max:100',
            'keperluan' => 'required|string'
        ]);

        // PERBAIKAN: Baris 'jenis_tamu' sudah dihapus secara permanen di sini
        $guest = Guest::updateOrCreate(
            ['no_hp' => $request->no_hp],
            [
                'nama_tamu' => $request->nama_tamu,
                'perusahaan' => $request->perusahaan
            ]
        );

        Visit::create([
            'id_guest' => $guest->id_guest,
            'status' => 'Masuk',
            // Baris 'keperluan' dihapus, dan digabung ke dalam 'catatan'
            'catatan' => 'Keperluan: ' . $request->keperluan . ' | Tujuan Divisi: ' . $request->divisi_tujuan
        ]);

        return redirect()->route('kunjungan.index')->with('success', 'Data kunjungan berhasil dicatat!');
    }

    // 4. Proses Mengakhiri Kunjungan (Checkout)
    public function checkout($id)
    {
        $visit = Visit::findOrFail($id);
        $visit->update([
            'status' => 'Keluar',
            'waktu_keluar' => Carbon::now()
        ]);

        return redirect()->back()->with('success', 'Kunjungan berhasil diselesaikan.');
    }
}
