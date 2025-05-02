<?php

namespace App\Models;

use CodeIgniter\Model;

class TeamModel extends Model
{
    protected $table            = 'tbl_Team';
    protected $primaryKey       = 'Team_id';
    protected $allowedFields    = ['Team_name', 'Team_jabatan', 'Team_image', 'Team_twitter', 'Team_facebook', 'Team_instagram', 'Team_linked'];
}
