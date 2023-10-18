<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
use App\Models\KelompokModel;
use App\Models\DetailKelompok;
use App\Models\MisaBesarModel;
use App\Models\PetugasMisaBesarModel;

class DataMisaBesar extends BaseController
{
    protected $AnggotaModel, $KelompokModel, $DetailKelompokModel, $MisaBesarModel, $PetugasMisaBesarModel, $db;

    protected $builder, $builder0, $builder1, $builder2, $query, $query0, $query1, $query2, $result, $result0, $result1, $result2;

    public function __construct()
    {
        $this->AnggotaModel = new AnggotaModel();
        $this->KelompokModel = new KelompokModel();
        $this->DetailKelompokModel = new DetailKelompok();
        $this->MisaBesarModel = new MisaBesarModel();
        $this->PetugasMisaBesarModel = new PetugasMisaBesarModel();

        // $this->AbsenModel = new AbsenModel();
        $this->db = db_connect();

        $this->builder1 = $this->db->table("anggota");
        $this->builder1->select('*,anggota.id_anggota AS kode_anggota');
        $this->builder1->join('petugas_misa_khusus', 'anggota.id_anggota=petugas_misa_khusus.id_petugas', 'left');
        $this->builder1->join('misa_khusus', 'petugas_misa_khusus.id_misa=misa_khusus.id_misa', 'left');


        // $this->builder = $this->db->table("anggota");
        // $this->builder->select('*,anggota.id_anggota AS kode_anggota');
        // $this->builder->join('detail_kelompok', 'anggota.id_anggota=detail_kelompok.id_anggota', 'left');
        // $this->builder->join('kelompok', 'detail_kelompok.id_kelompok=kelompok.id_kelompok', 'left');

        // $this->builder0 = $this->db->table("anggota");
        // $this->builder0->select('*,anggota.id_anggota AS kode_anggota');
        // $this->builder0->join('detail_kelompok', 'anggota.id_anggota=detail_kelompok.id_anggota', 'left');
        // $this->builder0->join('kelompok', 'detail_kelompok.id_kelompok=kelompok.id_kelompok', 'left');
        // $this->builder0->join('absen', 'anggota.id_anggota=absen.id_anggota', 'right');

        // $this->builder = $this->db->table("kelompok");
        // $this->builder->select('*, kelompok.id_kelompok AS kode_kelompok');
        // $this->builder->join('detail_kelompok', 'kelompok.id_kelompok=detail_kelompok.id_kelompok', 'left');
        // $this->builder->join('anggota', 'detail_kelompok.id_anggota=anggota.id_anggota', 'left');
    }

    public function index()
    {
        $petugas = $this->AnggotaModel->findAll();
        $misaBesar = $this->MisaBesarModel->findAll();

        $data = [
            'title' => 'Petugas Misa Besar',
            'petugas' => $petugas,
            'misabesar' => $misaBesar
        ];

        return view('/MisaBesar/index', $data);
    }
}
