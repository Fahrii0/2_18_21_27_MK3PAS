<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;

class PeminjamanController extends Controller
{
    // GET /peminjaman - ambil semua data
    public function index()
    {
        $data = Peminjaman::all();
        return response()->json($data, 200);
    }

    // GET /peminjaman/{id} - ambil 1 data berdasarkan ID
    public function show($id)
    {
        $data = Peminjaman::find($id);
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
        return response()->json($data, 200);
    }

    // POST /peminjaman - tambah data baru
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'item_id' => 'required|integer',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date',
            'status' => 'required|string|in:dipinjam,dikembalikan'
        ]);

        $data = Peminjaman::create($request->all());
        return response()->json($data, 201);
    }

    // PUT /peminjaman/{id} - update data
    public function update(Request $request, $id)
    {
        $data = Peminjaman::find($id);
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $request->validate([
            'user_id' => 'integer',
            'item_id' => 'integer',
            'tanggal_pinjam' => 'date',
            'tanggal_kembali' => 'date',
            'status' => 'string|in:dipinjam,dikembalikan'
        ]);

        $data->update($request->all());
        return response()->json($data, 200);
    }

    // DELETE /peminjaman/{id} - hapus data
    public function destroy($id)
    {
        $data = Peminjaman::find($id);
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $data->delete();
        return response()->json(['message' => 'Data berhasil dihapus'], 204);
    }
}
