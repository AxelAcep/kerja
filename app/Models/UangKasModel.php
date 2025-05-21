<?php

namespace App\Models;

use CodeIgniter\Model;

class UangKasModel extends Model
{
    protected $table = 'tbl_uang_kas';

    // Tidak ada primary key di tabel ini
    protected $primaryKey = null;

    // Jangan pakai auto increment
    protected $useAutoIncrement = false;

    // Kolom yang boleh diisi
    protected $allowedFields = ['jumlah'];

    // Karena tanpa primary key, disable fitur soft delete, timestamps, dll.
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;
}
