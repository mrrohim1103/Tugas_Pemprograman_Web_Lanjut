<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Location;
use App\Models\Role;
use App\Models\Room;
use App\Models\GuestCategory;
use App\Models\VisitPurpose;
use App\Models\Blacklist;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MasterController extends Controller
{
    // ==========================================
    // LOCATIONS
    // ==========================================
    public function locations()
    {
        $data = Location::orderBy('nama_lokasi')->get();
        return view('master.locations', compact('data'));
    }

    public function storeLocation(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:100',
            'alamat'      => 'nullable|string',
        ]);
        Location::create([
            'id_location' => Str::uuid()->toString(),
            'nama_lokasi' => $request->nama_lokasi,
            'alamat'      => $request->alamat,
        ]);
        return back()->with('success', 'Lokasi berhasil ditambahkan.');
    }

    public function destroyLocation($id)
    {
        Location::findOrFail($id)->delete();
        return back()->with('success', 'Lokasi berhasil dihapus.');
    }

    // ==========================================
    // DEPARTMENTS
    // ==========================================
    public function departments()
    {
        $data      = Department::with('location')->orderBy('nama_divisi')->get();
        $locations = Location::orderBy('nama_lokasi')->get();
        return view('master.departments', compact('data', 'locations'));
    }

    public function storeDepartment(Request $request)
    {
        $request->validate([
            'nama_divisi' => 'required|string|max:100',
            'id_location' => 'nullable|exists:locations,id_location',
        ]);
        Department::create([
            'id_department' => Str::uuid()->toString(),
            'nama_divisi'   => $request->nama_divisi,
            'id_location'   => $request->id_location,
        ]);
        return back()->with('success', 'Departemen berhasil ditambahkan.');
    }

    public function destroyDepartment($id)
    {
        Department::findOrFail($id)->delete();
        return back()->with('success', 'Departemen berhasil dihapus.');
    }

    // ==========================================
    // ROLES
    // ==========================================
    public function roles()
    {
        $data = Role::orderBy('nama_role')->get();
        return view('master.roles', compact('data'));
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'nama_role'  => 'required|string|max:100',
            'deskripsi'  => 'nullable|string',
        ]);
        Role::create([
            'id_role'   => Str::uuid()->toString(),
            'nama_role' => $request->nama_role,
            'deskripsi' => $request->deskripsi,
        ]);
        return back()->with('success', 'Role berhasil ditambahkan.');
    }

    public function destroyRole($id)
    {
        Role::findOrFail($id)->delete();
        return back()->with('success', 'Role berhasil dihapus.');
    }

    // ==========================================
    // ROOMS
    // ==========================================
    public function rooms()
    {
        $data      = Room::with('location')->orderBy('nama_ruangan')->get();
        $locations = Location::orderBy('nama_lokasi')->get();
        return view('master.rooms', compact('data', 'locations'));
    }

    public function storeRoom(Request $request)
    {
        $request->validate([
            'nama_ruangan' => 'required|string|max:100',
            'id_location'  => 'nullable|exists:locations,id_location',
            'kapasitas'    => 'nullable|integer|min:1',
        ]);
        Room::create([
            'id_room'      => Str::uuid()->toString(),
            'nama_ruangan' => $request->nama_ruangan,
            'id_location'  => $request->id_location,
            'kapasitas'    => $request->kapasitas,
        ]);
        return back()->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function destroyRoom($id)
    {
        Room::findOrFail($id)->delete();
        return back()->with('success', 'Ruangan berhasil dihapus.');
    }

    // ==========================================
    // GUEST CATEGORIES
    // ==========================================
    public function guestCategories()
    {
        $data = GuestCategory::orderBy('nama_kategori')->get();
        return view('master.guest-categories', compact('data'));
    }

    public function storeGuestCategory(Request $request)
    {
        $request->validate([
            'nama_kategori'      => 'required|string|max:100',
            'butuh_pendampingan' => 'nullable|boolean',
        ]);
        GuestCategory::create([
            'id_category'        => Str::uuid()->toString(),
            'nama_kategori'      => $request->nama_kategori,
            'butuh_pendampingan' => $request->boolean('butuh_pendampingan'),
        ]);
        return back()->with('success', 'Kategori tamu berhasil ditambahkan.');
    }

    public function destroyGuestCategory($id)
    {
        GuestCategory::findOrFail($id)->delete();
        return back()->with('success', 'Kategori tamu berhasil dihapus.');
    }

    // ==========================================
    // VISIT PURPOSES
    // ==========================================
    public function visitPurposes()
    {
        $data = VisitPurpose::orderBy('nama_keperluan')->get();
        return view('master.visit-purposes', compact('data'));
    }

    public function storeVisitPurpose(Request $request)
    {
        $request->validate([
            'nama_keperluan' => 'required|string|max:100',
            'deskripsi'      => 'nullable|string',
        ]);
        VisitPurpose::create([
            'id_purpose'     => Str::uuid()->toString(),
            'nama_keperluan' => $request->nama_keperluan,
            'deskripsi'      => $request->deskripsi,
        ]);
        return back()->with('success', 'Keperluan kunjungan berhasil ditambahkan.');
    }

    public function destroyVisitPurpose($id)
    {
        VisitPurpose::findOrFail($id)->delete();
        return back()->with('success', 'Keperluan kunjungan berhasil dihapus.');
    }

    // ==========================================
    // BLACKLIST
    // ==========================================
    public function blacklist()
    {
        $data = Blacklist::with('reportedBy')->orderBy('created_at', 'desc')->get();
        return view('master.blacklist', compact('data'));
    }

    public function storeBlacklist(Request $request)
    {
        $request->validate([
            'nama_tamu'  => 'required|string|max:100',
            'perusahaan' => 'nullable|string|max:100',
            'alasan'     => 'required|string',
        ]);
        Blacklist::create([
            'id_blacklist'    => Str::uuid()->toString(),
            'nama_tamu'       => $request->nama_tamu,
            'perusahaan'      => $request->perusahaan,
            'alasan'          => $request->alasan,
            'dilaporkan_oleh' => Auth::user()->id_user,
        ]);
        return back()->with('success', 'Tamu berhasil dimasukkan ke daftar hitam.');
    }

    public function destroyBlacklist($id)
    {
        Blacklist::findOrFail($id)->delete();
        return back()->with('success', 'Data blacklist berhasil dihapus.');
    }
}
