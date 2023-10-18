<?php

namespace App\Models;

use CodeIgniter\Model;

class RekapModel extends Model
{
    protected $table = 'rekap_prediksi';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_data', 'id_anggota', 'post_yes', 'post_no', 'tipe_dataset'];
    protected $primaryKey = 'id_data';
}
