<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsenModel extends Model
{
    protected $table = 'absen';
    protected $useTimestamps = false;
    protected $allowedFields = ['id_absen', 'id_anggota', 'id_kelompok', 'absen', 'tanggal', 'jam'];
    protected $primaryKey = 'id_absen';

    public function getAbsen($id = false)
    {
        // jika slug tdk ada, cari semua
        // if ($id == false) {
        return $this->findAll();
        // }
        // //jika slug ada, tampilkan data
        // return $this->where(['id' => $id])->first();
    }
}
