<?php

namespace App\Models;

use CodeIgniter\Model;

class PetugasMisaBesarModel extends Model
{
    protected $table = 'petugas_misa_khusus';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_misa', 'id_petugas', 'tanggal', 'jam'];

    public function getPetugas()
    {
        return $this->findAll();
    }
}
