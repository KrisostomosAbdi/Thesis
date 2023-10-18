<?php

namespace App\Models;

use CodeIgniter\Model;

class DatasetModel extends Model
{
    protected $table = 'dataset';
    protected $useTimestamps = true;
    protected $allowedFields = ['nama_file', 'jenis_dataset', 'created_at', 'updated_at'];
    protected $primaryKey = 'id_dataset';

    public function getDataset($id = false)
    {
        // jika slug tdk ada, cari semua
        // if ($id == false) {
        return $this->findAll();
        // }
        // //jika slug ada, tampilkan data
        // return $this->where(['id' => $id])->first();
    }
}
