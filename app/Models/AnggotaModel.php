<?php

namespace App\Models;

use CodeIgniter\Model;

class AnggotaModel extends Model
{
    protected $table = 'anggota';
    protected $useTimestamps = true;
    protected $allowedFields = ['nama_lengkap', 'nama_panggilan', 'status', 'tanggal_masuk', 'tempat_lahir', 'tanggal_lahir', 'no_telepon', 'nama_ortu', 'no_telepon_ortu', 'alamat', 'paroki', 'wilayah', 'lingkungan', 'motivasi', 'kandidat_kapten', 'kandidat_pengurus', 'kandidat_ketua'];
    protected $primaryKey = 'id_anggota';

    public function getAnggota($id = false)
    {
        // jika slug tdk ada, cari semua
        if ($id == false) {
            return $this->findAll();
        }
        //jika slug ada, tampilkan data
        return $this->where(['id_anggota' => $id])->first();
    }
    public function getNamaAnggota()
    {
        $builder = $this->table('anggota');
        $builder->select('id_anggota, nama_panggilans');
        return $builder;
    }
}
