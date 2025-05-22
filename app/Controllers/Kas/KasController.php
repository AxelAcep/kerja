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
        return redirect()->to('/kas/pemasukan');
    }




    // Kurang kas (pengeluaran)
    public function kurangKas()
    {
        $userId = session('id');
        $jumlah = (int) $this->request->getPost('jumlah');
        $kategori = $this->request->getPost('kategori') ?? 'pengeluaran_umum';

        if ($jumlah <= 0) {
            return $this->response->setStatusCode(400)->setJSON(['message' => 'Jumlah harus lebih dari 0']);
        }

        $uang = $this->uangModel->find(1); // asumsi ID = 1
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

        $this->uangModel->update(1, ['jumlah' => $saldoBaru]);

        return $this->response->setJSON(['message' => 'Kurang kas berhasil', 'saldo' => $saldoBaru]);
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

    public function viewKategori()
    {
        $data = [
            'title' => 'site_Kategori',
            'site' => [
                'site_name' => 'MyAppKas',
                'site_title' => 'Kategori',
                'site_description' => 'Halaman kategori kas'
            ]
        ];
        return view('kas/kategori', $data);
    }

    public function viewLaporan()
    {
        $data = [
            'title' => 'site_Laporan',
            'site' => [
                'site_name' => 'MyAppKas',
                'site_title' => 'Laporan',
                'site_description' => 'Halaman laporan kas'
            ]
        ];
        return view('kas/laporan', $data);
    }




}
