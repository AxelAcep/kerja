<?php

namespace App\Controllers\Kas;

use App\Controllers\BaseController;
use App\Models\UangKasModel;
use App\Models\TransaksiKasModel;
use App\Models\CategoryModel;
use App\Models\CommentModel;
use App\Models\InboxModel;
use App\Models\PostModel;
use App\Models\TagModel;

class KasController extends BaseController
{
    protected $uangModel;
    protected $transaksiModel;

    public function __construct()
    {
        $this->uangModel = new UangKasModel();
        $this->transaksiModel = new TransaksiKasModel();
        
         $this->inboxModel = new InboxModel();
        $this->commentModel = new CommentModel();

        $this->postModel = new PostModel();
        $this->categoryModel = new CategoryModel();
        $this->tagModel = new TagModel();
    }

    public function editKas($kode_kas)
    {
        $newKategori = $this->request->getPost('kategori');
        $newJumlah = (int) $this->request->getPost('jumlah');

        if ($newJumlah <= 0) {
            return redirect()->back()->with('error', 'Jumlah harus lebih dari 0');
        }

        // Ambil data transaksi lama
        $transaksiLama = $this->transaksiModel->where('kode_kas', $kode_kas)->first();

        if (!$transaksiLama) {
            return redirect()->back()->with('error', 'Data transaksi tidak ditemukan');
        }

        $jumlahLama = (int) $transaksiLama['jumlah'];
        $jenisLama = $transaksiLama['jenis'];

        // Hitung ulang saldo
        $uang = $this->uangModel->find(1);
        $saldoSekarang = (int) ($uang['jumlah'] ?? 0);

        if ($jenisLama === 'pemasukan') {
            $saldoBaru = $saldoSekarang - $jumlahLama; // rollback pemasukan lama
        } else {
            $saldoBaru = $saldoSekarang + $jumlahLama; // rollback pengeluaran lama
        }

        // Cek jenis baru dari kategori (bisa kamu sesuaikan logika jika kategori tidak menentukan jenis)
        $jenisBaru = $transaksiLama['jenis']; // diasumsikan jenis tidak berubah (jika kamu ingin bisa diedit juga, tambahkan input 'jenis')

        // Terapkan perubahan baru
        if ($jenisBaru === 'pemasukan') {
            $saldoBaru += $newJumlah;
        } else {
            $saldoBaru -= $newJumlah;
        }

        if ($saldoBaru < 0) {
            return redirect()->back()->with('error', 'Saldo tidak cukup untuk perubahan ini');
        }

        // Update transaksi
        $this->transaksiModel->where('kode_kas', $kode_kas)->set([
            'kategori' => $newKategori,
            'jumlah' => $newJumlah
        ])->update();

        // Update saldo kas
        $this->uangModel->update(1, ['jumlah' => $saldoBaru]);

        return redirect()->back()->with('success', 'Data berhasil diubah');
    }

    public function deleteKas($kode_kas)
    {
        // Ambil data terlebih dahulu
        $kas = $this->transaksiModel->find($kode_kas);

        if ($kas && $kas['jenis'] == 'pemasukan') {
            // Update uang kas
            $this->uangModel->update(1, [
                'jumlah' => $this->uangModel->first()['jumlah'] - $kas['jumlah']
            ]);

            // Hapus dari transaksi
            $this->transaksiModel->delete($kode_kas);
        }

        return redirect()->back()->with('success', 'Data berhasil dihapus');
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
        $jumlah = (int) $this->request->getPost('jumlah');
        $kategori = $this->request->getPost('kategori');
        $userId = session('id'); // disamakan dengan kurangKas()

        if ($jumlah <= 0) {
            return $this->response->setStatusCode(400)->setJSON(['message' => 'Jumlah harus lebih dari 0']);
        }

        // Simpan transaksi sebagai pemasukan
        $this->transaksiModel->insert([
            'kode_kas' => strtoupper(bin2hex(random_bytes(4))),
            'user_id' => $userId,
            'jenis' => 'pemasukan',
            'jumlah' => $jumlah,
            'tanggal' => date('Y-m-d H:i:s'),
            'kategori' => $kategori
        ]);

        // Update total uang kas
        $uang = $this->uangModel->find(1);
        $saldoSekarang = (int) ($uang['jumlah'] ?? 0);
        $saldoBaru = $saldoSekarang + $jumlah;

        $this->uangModel->update(1, ['jumlah' => $saldoBaru]);

        // Ambil ulang data view pemasukan
        $data = [
            'akun' => $this->akun,
            'title' => 'Pemasukan Kas',
            'active' => 'kas',
            'total_inbox' => $this->inboxModel->where('inbox_status', 0)->countAllResults(),
            'inboxs' => $this->inboxModel->where('inbox_status', 0)->findAll(),
            'total_comment' => $this->commentModel->where('comment_status', 0)->countAllResults(),
            'comments' => $this->commentModel->where('comment_status', 0)->findAll(6),
            'helper_text' => helper('text'),
            'breadcrumbs' => $this->request->getUri()->getSegments(),
            'posts' => $this->postModel->get_all_post()->getResultArray(),
            'kas_pemasukan' => $this->transaksiModel->where('jenis', 'pemasukan')->findAll(),
        ];

        if ($this->request->isAJAX()) {
            $html = view('kas/pemasukan', $data);
            return $this->response->setJSON([
                'success' => true,
                'html' => $html
            ]);
        }
        session()->setFlashdata('success', 'Pemasukan kas berhasil ditambahkan.');
        return redirect()->to('/kas/pemasukan');
    }


    // Kurang kas (pengeluaran)
    public function kurangKas()
    {
        $jumlah = (int) $this->request->getPost('jumlah');
        $kategori = $this->request->getPost('kategori') ?? 'pengeluaran_umum';
        $userId = session('id'); // disamakan dengan tambahKas()

        if ($jumlah <= 0) {
            return $this->response->setStatusCode(400)->setJSON(['message' => 'Jumlah harus lebih dari 0']);
        }

        // Ambil data saldo saat ini
        $uang = $this->uangModel->find(1);
        $saldoSekarang = (int) ($uang['jumlah'] ?? 0);
        $saldoBaru = $saldoSekarang - $jumlah;

        if ($saldoBaru < 0) {
            return $this->response->setStatusCode(400)->setJSON(['message' => 'Saldo tidak cukup']);
        }

        // Simpan transaksi sebagai pengeluaran
        $this->transaksiModel->insert([
            'kode_kas' => strtoupper(bin2hex(random_bytes(4))),
            'user_id' => $userId,
            'jenis' => 'pengeluaran',
            'jumlah' => $jumlah,
            'tanggal' => date('Y-m-d H:i:s'),
            'kategori' => $kategori
        ]);

        // Update total uang kas
        $this->uangModel->update(1, ['jumlah' => $saldoBaru]);

        // Ambil ulang data view pengeluaran
        $data = [
            'akun' => $this->akun,
            'title' => 'Pengeluaran Kas',
            'active' => 'kas',
            'total_inbox' => $this->inboxModel->where('inbox_status', 0)->countAllResults(),
            'inboxs' => $this->inboxModel->where('inbox_status', 0)->findAll(),
            'total_comment' => $this->commentModel->where('comment_status', 0)->countAllResults(),
            'comments' => $this->commentModel->where('comment_status', 0)->findAll(6),
            'helper_text' => helper('text'),
            'breadcrumbs' => $this->request->getUri()->getSegments(),
            'posts' => $this->postModel->get_all_post()->getResultArray(),
            'kas_pengeluaran' => $this->transaksiModel->where('jenis', 'pengeluaran')->findAll(),
        ];

        if ($this->request->isAJAX()) {
            $html = view('kas/pengeluaran', $data);
            return $this->response->setJSON([
                'success' => true,
                'html' => $html
            ]);
        }

        session()->setFlashdata('success', 'Pengeluaran kas berhasil dikurangkan.');
        return redirect()->to('/kas/pengeluaran');
    }


    public function viewPemasukan()
    {
        $data = [
            'akun' => $this->akun,
            'title' => 'All Post',
            'active' => 'kas', // ← ini yang ditambahkan
            'total_inbox' => $this->inboxModel->where('inbox_status', 0)->get()->getNumRows(),
            'inboxs' => $this->inboxModel->where('inbox_status', 0)->findAll(),
            'total_comment' => $this->commentModel->where('comment_status', 0)->get()->getNumRows(),
            'comments' => $this->commentModel->where('comment_status', 0)->findAll(6),
            'helper_text' => helper('text'),
            'breadcrumbs' => $this->request->getUri()->getSegments(),
            'posts' => $this->postModel->get_all_post()->getResultArray(),
            'kas_pemasukan' => $this->transaksiModel->where('jenis', 'pemasukan')->findAll(),
        ];

        return view('kas/pemasukan', $data);
    }


    public function viewPengeluaran()
    {
        $data = [
            'akun' => $this->akun,
            'title' => 'All Post',
            'active' => 'kas', // ← ini yang ditambahkan
            'total_inbox' => $this->inboxModel->where('inbox_status', 0)->get()->getNumRows(),
            'inboxs' => $this->inboxModel->where('inbox_status', 0)->findAll(),
            'total_comment' => $this->commentModel->where('comment_status', 0)->get()->getNumRows(),
            'comments' => $this->commentModel->where('comment_status', 0)->findAll(6),
            'helper_text' => helper('text'),
            'breadcrumbs' => $this->request->getUri()->getSegments(),
            'posts' => $this->postModel->get_all_post()->getResultArray(),
            'kas_pemasukan' => $this->transaksiModel->where('jenis', 'pengeluaran')->findAll(),
        ];

        return view('kas/pengeluaran', $data);
    }


    public function viewLaporan()
    {
        $data = [
            'akun' => $this->akun,
            'title' => 'All Post',
            'active' => 'kas', // ← ini yang ditambahkan
            'total_inbox' => $this->inboxModel->where('inbox_status', 0)->get()->getNumRows(),
            'inboxs' => $this->inboxModel->where('inbox_status', 0)->findAll(),
            'total_comment' => $this->commentModel->where('comment_status', 0)->get()->getNumRows(),
            'comments' => $this->commentModel->where('comment_status', 0)->findAll(6),
            'helper_text' => helper('text'),
            'breadcrumbs' => $this->request->getUri()->getSegments(),
        ];
        return view('kas/laporan', $data);
    }




}
