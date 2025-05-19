<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;

/**
 *
 * @OA\Tag(
 *     name="Peminjaman",
 *     description="Operasi terkait data peminjaman"
 * )
 */
class PeminjamanController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/peminjaman",
     *     tags={"Peminjaman"},
     *     summary="Ambil semua data peminjaman",
     *     @OA\Response(
     *         response=200,
     *         description="Data berhasil diambil"
     *     )
     * )
     */
    public function index()
    {
        $data = Peminjaman::all();
        return response()->json($data, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/peminjaman/{id}",
     *     tags={"Peminjaman"},
     *     summary="Ambil satu data peminjaman berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data ditemukan"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data tidak ditemukan"
     *     )
     * )
     */
    public function show($id)
    {
        $data = Peminjaman::find($id);
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
        return response()->json($data, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/peminjaman",
     *     tags={"Peminjaman"},
     *     summary="Tambah data peminjaman baru",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id","item_id","tanggal_pinjam","tanggal_kembali","status"},
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="item_id", type="integer", example=2),
     *             @OA\Property(property="tanggal_pinjam", type="string", format="date", example="2025-05-20"),
     *             @OA\Property(property="tanggal_kembali", type="string", format="date", example="2025-05-27"),
     *             @OA\Property(property="status", type="string", example="dipinjam")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Data berhasil ditambahkan"
     *     )
     * )
     */
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

    /**
     * @OA\Put(
     *     path="/api/peminjaman/{id}",
     *     tags={"Peminjaman"},
     *     summary="Update data peminjaman berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="item_id", type="integer", example=2),
     *             @OA\Property(property="tanggal_pinjam", type="string", format="date", example="2025-05-20"),
     *             @OA\Property(property="tanggal_kembali", type="string", format="date", example="2025-05-27"),
     *             @OA\Property(property="status", type="string", example="dikembalikan")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data berhasil diupdate"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data tidak ditemukan"
     *     )
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/peminjaman/{id}",
     *     tags={"Peminjaman"},
     *     summary="Hapus data peminjaman berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Data berhasil dihapus"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data tidak ditemukan"
     *     )
     * )
     */
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
