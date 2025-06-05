<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="API Peminjaman",
 *     description="Dokumentasi API untuk fitur peminjaman buku",
 *     @OA\Contact(
 *         email="admin@example.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="API Server"
 * )
 *
 * @OA\Tag(
 *     name="Peminjaman",
 *     description="Operasi terkait data peminjaman"
 * )
 *
 * @OA\Schema(
 *     schema="Peminjaman",
 *     type="object",
 *     title="Peminjaman",
 *     required={"user_id","book_id","tanggal_pinjam","tanggal_kembali","status"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=1),
 *     @OA\Property(property="book_id", type="integer", example=2),
 *     @OA\Property(property="tanggal_pinjam", type="string", format="date", example="2025-05-20"),
 *     @OA\Property(property="tanggal_kembali", type="string", format="date", example="2025-05-27"),
 *     @OA\Property(property="status", type="string", example="dipinjam"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class PeminjamanSwaggerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/peminjaman",
     *     tags={"Peminjaman"},
     *     summary="Ambil semua data peminjaman",
     *     @OA\Response(
     *         response=200,
     *         description="Data berhasil diambil",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Peminjaman")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Peminjaman::all(), 200);
    }

    /**
     * @OA\Get(
     *     path="/api/peminjaman/{id}",
     *     tags={"Peminjaman"},
     *     summary="Ambil data peminjaman berdasarkan ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data ditemukan",
     *         @OA\JsonContent(ref="#/components/schemas/Peminjaman")
     *     ),
     *     @OA\Response(response=404, description="Data tidak ditemukan")
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
     *             required={"user_id","book_id","tanggal_pinjam","tanggal_kembali","status"},
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="book_id", type="integer", example=2),
     *             @OA\Property(property="tanggal_pinjam", type="string", format="date", example="2025-05-20"),
     *             @OA\Property(property="tanggal_kembali", type="string", format="date", example="2025-05-27"),
     *             @OA\Property(property="status", type="string", example="dipinjam")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Data berhasil ditambahkan",
     *         @OA\JsonContent(ref="#/components/schemas/Peminjaman")
     *     ),
     *     @OA\Response(response=422, description="Validasi gagal")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'book_id' => 'required|integer',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'status' => 'required|string|in:dipinjam,dikembalikan'
        ]);

        $data = Peminjaman::create($validated);
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
     *             @OA\Property(property="book_id", type="integer", example=2),
     *             @OA\Property(property="tanggal_pinjam", type="string", format="date", example="2025-05-20"),
     *             @OA\Property(property="tanggal_kembali", type="string", format="date", example="2025-05-27"),
     *             @OA\Property(property="status", type="string", example="dikembalikan")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data berhasil diupdate",
     *         @OA\JsonContent(ref="#/components/schemas/Peminjaman")
     *     ),
     *     @OA\Response(response=404, description="Data tidak ditemukan")
     * )
     */
    public function update(Request $request, $id)
    {
        $data = Peminjaman::find($id);
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $rules = [
            'user_id' => 'sometimes|integer',
            'book_id' => 'sometimes|integer',
            'tanggal_pinjam' => 'sometimes|date',
            'tanggal_kembali' => 'sometimes|date',
            'status' => 'sometimes|string|in:dipinjam,dikembalikan'
        ];

        $validated = $request->validate($rules);

        // Validasi manual tanggal_kembali setelah tanggal_pinjam
        if (isset($validated['tanggal_kembali'])) {
            // ambil tanggal_pinjam dari input atau data lama
            $tanggal_pinjam = $validated['tanggal_pinjam'] ?? $data->tanggal_pinjam;

            if (strtotime($validated['tanggal_kembali']) < strtotime($tanggal_pinjam)) {
                return response()->json([
                    'message' => 'tanggal_kembali harus sama atau setelah tanggal_pinjam'
                ], 422);
            }
        }

        $data->update($validated);
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
     *     @OA\Response(response=204, description="Data berhasil dihapus"),
     *     @OA\Response(response=404, description="Data tidak ditemukan")
     * )
     */
    public function destroy($id)
    {
        $data = Peminjaman::find($id);
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $data->delete();
        return response()->json(null, 204);
    }
}
