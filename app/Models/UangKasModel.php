<?php

namespace App\Models;

use CodeIgniter\Model;

class UangKasModel extends Model
{
    protected $table = 'tbl_uang_kas';
    protected $primaryKey = 'id'; // Harus ada
    protected $useAutoIncrement = true;

    protected $allowedFields = ['jumlah'];

    protected $useSoftDeletes = false;
    protected $useTimestamps = false;
}
