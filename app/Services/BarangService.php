<?php
namespace App\Services;
use App\Models\Barang;

class BarangService {
    public function tambahBarang($data) {
        try {
            return Barang::create($data); // Fungsi Tambah Data [cite: 154]
        } catch (\Exception $e) { throw $e; }
    }

    public function ambilSemua() { return Barang::all(); } // Fungsi Tampilkan Data [cite: 155]

    public function ubahBarang($id, $data) {
        $barang = Barang::findOrFail($id); // Mencari data atau error 404 [cite: 215]
        $barang->update($data); // Fungsi Ubah Data [cite: 156]
        return $barang;
    }

    public function hapusBarang($id) {
        return Barang::destroy($id); // Fungsi Hapus Data [cite: 157]
    }
}