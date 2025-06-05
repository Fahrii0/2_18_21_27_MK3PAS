<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan semua data peminjaman.
     */
    public function index()
    {
        // Load relasi user dan book
        $data = Peminjaman::with(['user', 'book'])->get();
        return response()->json($data, 200);
    }

    /**
     * Menampilkan detail peminjaman berdasarkan ID.
     */
    public function show($id)
    {
        $peminjaman = Peminjaman::with(['user', 'book'])->find($id);

        if (!$peminjaman) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($peminjaman, 200);
    }

    /**
     * Menyimpan data peminjaman baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',  // Tambahkan validasi exists
            'book_id' => 'required|integer|exists:books,id', // Tambahkan validasi exists
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'status' => 'required|string|in:dipinjam,dikembalikan'
        ]);

        $peminjaman = Peminjaman::create($validated);

        return response()->json($peminjaman, 201);
    }

    /**
     * Memperbarui data peminjaman berdasarkan ID.
     */
    public function update(Request $request, $id)
    {
        $peminjaman = Peminjaman::find($id);

        if (!$peminjaman) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'user_id' => 'sometimes|integer|exists:users,id',
            'book_id' => 'sometimes|integer|exists:books,id',
            'tanggal_pinjam' => 'sometimes|date',
            // Penyesuaian validasi: tanggal_kembali harus after_or_equal tanggal_pinjam jika ada keduanya
            'tanggal_kembali' => 'sometimes|date|after_or_equal:tanggal_pinjam',
            'status' => 'sometimes|string|in:dipinjam,dikembalikan'
        ]);

        $peminjaman->update($validated);

        return response()->json($peminjaman, 200);
    }

    /**
     * Menghapus data peminjaman berdasarkan ID.
     */
    public function destroy($id)
    {
        $peminjaman = Peminjaman::find($id);

        if (!$peminjaman) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $peminjaman->delete();

        return response()->json(['message' => 'Data berhasil dihapus'], 200);
    }
}
