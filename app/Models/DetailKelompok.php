<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailKelompok extends Model
{
    protected $table = 'detail_kelompok';
    protected $useTimestamps = false;
    protected $allowedFields = ['id_kelompok', 'id_anggota'];

    public function getKelompok()
    {
        return $this->findAll();
    }
}
