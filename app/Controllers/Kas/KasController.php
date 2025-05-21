<?php

namespace App\Controllers\Kas;

use App\Controllers\BaseController;
use App\Models\UangKasModel;
use App\Models\TransaksiKasModel;

class KasController extends BaseController
{
    protected $uangModel;
    protected $transaksiModel;

    public function __construct()
    {
        $this->uangModel = new UangKasModel();
        $this->transaksiModel = new TransaksiKasModel();
    }
    public function getUangKas()
    {
        $model = new UangKasModel();
        return $this->response->setJSON($model->first());
    }

    public function getPemasukan()
    {
        $model = new TransaksiKasModel();
        return $this->response->setJSON($model->where('jenis', 'pemasukan')->findAll());
    }

    public function getPengeluaran()
    {
        $model = new TransaksiKasModel();
        return $this->response->setJSON($model->where('jenis', 'pengeluaran')->findAll());
    }

    public function getAllTransaksi()
    {
        $model = new TransaksiKasModel();
        return $this->response->setJSON($model->findAll());
    }

    public function tambahKas()
    {
        $userId = session('id');
        $jumlah = (int) $this->request->getPost('jumlah');
        $kategori = $this->request->getPost('kategori') ?? 'pemasukan_umum'; // default kategori
        
        if ($jumlah <= 0) {
            return $this->response->setStatusCode(400)->setJSON(['message' => 'Jumlah harus lebih dari 0']);
        }

        // Ambil saldo saat ini
        $uang = $this->uangModel->first();
        $saldoSekarang = (int) ($uang['jumlah'] ?? 0);
        $saldoBaru = $saldoSekarang + $jumlah;

        // Simpan transaksi
        $this->transaksiModel->insert([
            'kode_kas' => strtoupper(bin2hex(random_bytes(4))),
            'user_id' => $userId,
            'jenis' => 'pemasukan',
            'jumlah' => $jumlah,
            'tanggal' => date('Y-m-d H:i:s'),
            'kategori' => $kategori,
        ]);

        // Update saldo (update semua baris karena tidak ada primary key)
        $this->uangModel->set('jumlah', $saldoBaru);
        $this->uangModel->where('1=1')->update();

        return $this->response->setJSON(['message' => 'Tambah kas berhasil', 'saldo' => $saldoBaru]);
    }

    // Kurang kas (pengeluaran)
    public function kurangKas()
    {
        $userId = session('id');
        $jumlah = (int) $this->request->getPost('jumlah');
        $kategori = $this->request->getPost('kategori') ?? 'pengeluaran_umum'; // default kategori

        if ($jumlah <= 0) {
            return $this->response->setStatusCode(400)->setJSON(['message' => 'Jumlah harus lebih dari 0']);
        }

        // Ambil saldo saat ini
        $uang = $this->uangModel->first();
        $saldoSekarang = (int) ($uang['jumlah'] ?? 0);
        $saldoBaru = $saldoSekarang - $jumlah;

        if ($saldoBaru < 0) {
            return $this->response->setStatusCode(400)->setJSON(['message' => 'Saldo tidak cukup']);
        }

        // Simpan transaksi
        $this->transaksiModel->insert([
            'kode_kas' => strtoupper(bin2hex(random_bytes(4))),
            'user_id' => $userId,
            'jenis' => 'pengeluaran',
            'jumlah' => $jumlah,
            'tanggal' => date('Y-m-d H:i:s'),
            'kategori' => $kategori,
        ]);

        // Update saldo
        $this->uangModel->set('jumlah', $saldoBaru);
        $this->uangModel->where('1=1')->update();

        return $this->response->setJSON(['message' => 'Kurang kas berhasil', 'saldo' => $saldoBaru]);
    }



}
