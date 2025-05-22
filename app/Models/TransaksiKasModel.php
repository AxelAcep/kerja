<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiKasModel extends Model
{
    protected $table = 'tbl_transaksi_kas';
    protected $allowedFields = ['kode_kas', 'user_id', 'jenis', 'jumlah', 'tanggal', 'kategori'];
    public $useTimestamps = false;
}
