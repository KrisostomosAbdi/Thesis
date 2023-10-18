<?php

namespace App\Models;

use CodeIgniter\Model;

class KelompokModel extends Model
{
    protected $table = 'kelompok';
    protected $useTimestamps = false;
    protected $allowedFields = ['id_kelompok', 'nama_kelompok'];
    protected $primaryKey = 'id_kelompok';

    public function getKelompok()
    {
        return $this->findAll();
    }
}
