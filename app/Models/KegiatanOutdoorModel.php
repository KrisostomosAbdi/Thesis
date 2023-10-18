<?php

namespace App\Models;

use CodeIgniter\Model;

class KegiatanOutdoorModel extends Model
{
    protected $table = 'kegiatan_outdoor';
    protected $useTimestamps = false;
    protected $allowedFields = ['id_kegiatan', 'nama_kegiatan', 'lokasi_kegiatan', 'tanggal_mulai', 'tanggal_selesai'];
    protected $primaryKey = 'id_kegiatan';

    public function getKegiatan()
    {
        return $this->findAll();
    }
}
