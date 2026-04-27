<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Services\BarangService;
use App\Http\Requests\StoreBarangRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- 1. BARU: Wajib ditambah agar fungsi Auth bisa jalan

class BarangController extends Controller {
    protected $service;

    public function __construct(BarangService $service) {
        $this->service = $service; 
    }

    // <-- 2. BARU: Fungsi Login ditaruh di sini (Autentikasi)
    public function login(Request $request) {
        // Proses verifikasi identitas (Autentikasi) [cite: 150, 151]
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            // Membuat token untuk akses API 
            $token = $user->createToken('BarangToken')->plainTextToken;
            return response()->json([
                'success' => true, 
                'message' => 'Login Berhasil', 
                'token' => $token
            ], 200);
        }
        
        // Response jika gagal [cite: 63, 64, 69]
        return response()->json([
            'success' => false, 
            'message' => 'Email atau Password salah'
        ], 401);
    }

    // 1. Tampilkan Data
    public function index() {
        return response()->json($this->service->ambilSemua());
    }

    // 2. Tambah Data
    public function store(StoreBarangRequest $request) {
        try {
            $hasil = $this->service->tambahBarang($request->validated()); 
            return response()->json(['status' => true, 'data' => $hasil], 201);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Gagal simpan data'], 500);
        }
    }

    // 3. Ubah Data
    public function update(Request $request, $id) {
        try {
            $hasil = $this->service->ubahBarang($id, $request->all());
            return response()->json(['status' => true, 'data' => $hasil]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan'], 404);
        }
    }

    // 4. Hapus Data
    public function destroy($id) {
        try {
            $this->service->hapusBarang($id);
            return response()->json(['status' => true, 'message' => 'Berhasil hapus!']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Gagal hapus data'], 500);
        }
    }
}