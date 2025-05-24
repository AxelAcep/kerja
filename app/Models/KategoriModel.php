<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id'; // Ganti primary key jadi 'id'
    protected $useAutoIncrement = true; // Karena 'id' adalah auto increment

    protected $allowedFields = ['nama_kategori']; // Kolom yang boleh diisi

    protected $useSoftDeletes = false;
    protected $useTimestamps = false;
}
