<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

class GuestVisitController extends Controller
{
    // Tampilkan form mandiri untuk tamu
    public function showForm()
    {
        return view('guest.form');
    }

    // Simpan data kunjungan dari tamu
    public function store(Request $request)
    {
        $request->validate([
            'nama_tamu'    => 'required|string|regex:/^[a-zA-Z\s\.\,\-]+$/|max:100',
            'perusahaan'   => 'required|string|max:100',
            'no_hp'        => 'required|digits_between:8,15',
            'divisi_tujuan'=> 'required|string|max:100',
            'keperluan'    => 'required|string|max:500',
        ], [
            'nama_tamu.required'     => 'Nama lengkap wajib diisi.',
            'nama_tamu.regex'        => 'Nama lengkap tidak boleh mengandung angka.',
            'perusahaan.required'    => 'Perusahaan / instansi wajib diisi.',
            'no_hp.required'         => 'Nomor HP wajib diisi.',
            'no_hp.digits_between'   => 'Nomor HP harus berupa angka 8-15 digit.',
            'divisi_tujuan.required' => 'Divisi tujuan wajib diisi.',
            'keperluan.required'     => 'Keperluan kunjungan wajib diisi.',
        ]);

        // Simpan atau update data tamu berdasarkan nomor HP
        $guest = Guest::updateOrCreate(
            ['no_hp' => $request->no_hp],
            [
                'nama_tamu'  => $request->nama_tamu,
                'perusahaan' => $request->perusahaan,
            ]
        );

        $visit = Visit::create([
            'id_guest' => $guest->id_guest,
            'status'   => 'Masuk',
            'catatan'  => 'Keperluan: ' . $request->keperluan . ' | Tujuan Divisi: ' . $request->divisi_tujuan,
        ]);

        // Kirim ke halaman sukses dengan data kunjungan
        return redirect()->route('tamu.sukses', ['id' => $visit->id_visit]);
    }

    // Halaman konfirmasi sukses
    public function sukses($id)
    {
        $visit = Visit::with('guest')->findOrFail($id);
        return view('guest.sukses', compact('visit'));
    }
}
