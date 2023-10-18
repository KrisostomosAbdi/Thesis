<?php

namespace App\Models;

use CodeIgniter\Model;

class MisaBesarModel extends Model
{
    protected $table = 'misa_khusus';
    protected $useTimestamps = false;
    protected $allowedFields = ['nama_misa'];
    protected $primaryKey = 'id_misa';

    public function getMisaBesar()
    {
        return $this->findAll();
    }
}
