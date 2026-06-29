<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Guest;
use App\Models\Department;
use App\Models\VisitPurpose;
use App\Models\GuestCategory;
use App\Models\Room;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

class GuestVisitController extends Controller
{
    // Tampilkan form mandiri untuk tamu
    public function showForm()
    {
        $departments    = Department::orderBy('nama_divisi')->get();
        $purposes       = VisitPurpose::orderBy('nama_keperluan')->get();
        $categories     = GuestCategory::orderBy('nama_kategori')->get();
        $rooms          = Room::orderBy('nama_ruangan')->get();

        return view('guest.form', compact('departments', 'purposes', 'categories', 'rooms'));
    }

    // Simpan data kunjungan dari tamu
    public function store(Request $request)
    {
        $request->validate([
            'nama_tamu'     => 'required|string|regex:/^[a-zA-Z\s\.\,\-]+$/|max:100',
            'perusahaan'    => 'required|string|max:100',
            'no_hp'         => 'required|digits_between:8,15',
            'email'         => 'nullable|email|max:100',
            'id_category'   => 'nullable|exists:guest_categories,id_category',
            'id_department' => 'required|exists:departments,id_department',
            'id_purpose'    => 'required|exists:visit_purposes,id_purpose',
            'id_room'       => 'nullable|exists:rooms,id_room',
            'catatan'       => 'nullable|string|max:500',
            // Kendaraan (opsional)
            'plat_nomor'        => 'nullable|string|max:20',
            'jenis_kendaraan'   => 'nullable|string|max:50',
        ], [
            'nama_tamu.required'     => 'Nama lengkap wajib diisi.',
            'nama_tamu.regex'        => 'Nama lengkap tidak boleh mengandung angka.',
            'perusahaan.required'    => 'Perusahaan / instansi wajib diisi.',
            'no_hp.required'         => 'Nomor HP wajib diisi.',
            'no_hp.digits_between'   => 'Nomor HP harus berupa angka 8-15 digit.',
            'email.email'            => 'Format email tidak valid.',
            'id_department.required' => 'Divisi tujuan wajib dipilih.',
            'id_purpose.required'    => 'Keperluan kunjungan wajib dipilih.',
        ]);

        // Simpan atau update data tamu berdasarkan nomor HP
        $guest = Guest::updateOrCreate(
            ['no_hp' => $request->no_hp],
            [
                'nama_tamu'   => $request->nama_tamu,
                'perusahaan'  => $request->perusahaan,
                'email'       => $request->email,
                'id_category' => $request->id_category,
            ]
        );

        // Simpan kunjungan
        $visit = Visit::create([
            'id_guest'      => $guest->id_guest,
            'id_department' => $request->id_department,
            'id_purpose'    => $request->id_purpose,
            'id_room'       => $request->id_room,
            'status'        => 'Masuk',
            'catatan'       => $request->catatan,
        ]);

        // Simpan data kendaraan jika diisi
        if ($request->filled('plat_nomor')) {
            Vehicle::create([
                'id_vehicle'      => Str::uuid()->toString(),
                'id_visit'        => $visit->id_visit,
                'plat_nomor'      => strtoupper($request->plat_nomor),
                'jenis_kendaraan' => $request->jenis_kendaraan,
            ]);
        }

        return redirect()->route('tamu.sukses', ['id' => $visit->id_visit]);
    }

    // Halaman konfirmasi sukses + form feedback
    public function sukses($id)
    {
        $visit = Visit::with(['guest', 'department', 'purpose', 'room', 'vehicles'])->findOrFail($id);
        return view('guest.sukses', compact('visit'));
    }

    // Simpan feedback dari tamu
    public function storeFeedback(Request $request, $id)
    {
        $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:500',
        ]);

        $visit = Visit::findOrFail($id);

        // Cegah double feedback
        if ($visit->feedback) {
            return redirect()->route('tamu.sukses', $id)->with('info', 'Feedback sudah pernah dikirim.');
        }

        \App\Models\Feedback::create([
            'id_feedback' => Str::uuid()->toString(),
            'id_visit'    => $visit->id_visit,
            'rating'      => $request->rating,
            'komentar'    => $request->komentar,
        ]);

        return redirect()->route('tamu.sukses', $id)->with('success', 'Terima kasih atas feedback Anda!');
    }
}
