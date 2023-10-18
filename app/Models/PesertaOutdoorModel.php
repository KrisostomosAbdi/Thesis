<?php

namespace App\Models;

use CodeIgniter\Model;

class PesertaOutdoorModel extends Model
{
    protected $table = 'peserta_outdoor';
    protected $useTimestamps = false;
    protected $allowedFields = ['id_kegiatan', 'id_peserta'];

    public function getPeserta()
    {
        return $this->findAll();
    }
}
