<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StorePengunjungRequest;
use App\Http\Resources\PengunjungResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

class KelolaPengunjungController extends Controller
{
    public function index(Request $request)
    {
        $query = User::latest();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $pengunjung = $query->get();
        return view('admin.pengunjung.index', compact('pengunjung'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.pengunjung.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:user,admin',
        ]);

        $user->update($validated);

        return redirect()->route('admin.pengunjung.index')->with('success', 'Data user berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.pengunjung.index')->with('success', 'User berhasil dihapus!');
    }

    // ==========================================
    // FUNGSI CRUD API UNTUK POSTMAN / FRONTEND
    // ==========================================

    // 1. GET ALL + Filtering & Pagination
    public function apiIndex(Request $request)
    {
        $query = User::query();

        // Fitur Filtering berdasarkan nama pengguna
        if ($request->has('nama')) {
            $query->where('name', 'like', '%' . $request->nama . '%');
        }

        // Fitur Filtering Rentang Tanggal
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $pengunjung = $query->paginate(10);
        return PengunjungResource::collection($pengunjung);
    }

    // 2. GET BY ID / NAMA + Error Handling Manual
    public function show($identifier)
    {
        try {
            // Coba cari berdasarkan ID, jika tidak ketemu cari berdasarkan nama
            $pengunjung = User::where('id', $identifier)
                              ->orWhere('name', $identifier)
                              ->firstOrFail();
                              
            return new PengunjungResource($pengunjung);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Resource tidak ditemukan',
                'message' => 'Data pengunjung dengan ID atau Nama "' . $identifier . '" tidak ada di sistem.'
            ], 404);
        }
    }

    // 3. POST (Create) + Form Request Validation
    public function store(StorePengunjungRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']); // Hash password

        $pengunjung = User::create($data);

        return (new PengunjungResource($pengunjung))
            ->additional(['message' => 'Data pengunjung berhasil dicatat'])
            ->response()
            ->setStatusCode(201);
    }

    // 4. UPDATE DATA (API) + Error Handling Manual
    public function apiUpdate(StorePengunjungRequest $request, $identifier)
    {
        try {
            $pengunjung = User::where('id', $identifier)
                              ->orWhere('name', $identifier)
                              ->firstOrFail();
            $data = $request->validated();
            
            if (isset($data['password']) && !empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            $pengunjung->update($data);

            return (new PengunjungResource($pengunjung))
                ->additional(['message' => 'Data pengunjung berhasil diperbarui']);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Resource tidak ditemukan',
                'message' => 'Data pengunjung dengan ID ' . $id . ' tidak ada di sistem.'
            ], 404);
        }
    }

    // 5. DELETE DATA (API) + Error Handling Manual
    public function apiDestroy($identifier)
    {
        try {
            $pengunjung = User::where('id', $identifier)
                              ->orWhere('name', $identifier)
                              ->firstOrFail();
            $pengunjung->delete();

            return response()->json([
                'message' => 'Data pengunjung berhasil dihapus'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Resource tidak ditemukan',
                'message' => 'Data pengunjung dengan ID ' . $id . ' tidak ada di sistem.'
            ], 404);
        }
    }
}
