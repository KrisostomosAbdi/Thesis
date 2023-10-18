<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
use App\Models\DatasetModel;
use App\Models\KelompokModel;
use App\Models\DetailKelompok;
use App\Models\AbsenModel;
use App\Models\KegiatanOutdoorModel;
use App\Models\PesertaOutdoorModel;

class KelolaDataset extends BaseController
{
    protected $AnggotaModel, $KelompokModel, $DetailKelompokModel, $AbsenModel, $KegiatanOutdoorModel, $PesertaOutdoorModel, $DatasetModel, $db;
    public function __construct()
    {
        $this->AnggotaModel = new AnggotaModel();
        $this->DatasetModel = new DatasetModel();
        $this->KelompokModel = new KelompokModel();
        $this->DetailKelompokModel = new DetailKelompok();
        $this->AbsenModel = new AbsenModel();
        $this->KegiatanOutdoorModel = new KegiatanOutdoorModel();
        $this->PesertaOutdoorModel = new PesertaOutdoorModel();
        $this->db = db_connect();

        // $this->builder = $this->db->table("anggota");
        // $this->builder->select('*,anggota.id_anggota AS kode_anggota');
        // $this->builder->join('detail_kelompok', 'anggota.id_anggota=detail_kelompok.id_anggota', 'left');
        // $this->builder->join('kelompok', 'detail_kelompok.id_kelompok=kelompok.id_kelompok', 'left');
        // $this->builder->join('absen', 'anggota.id_anggota=absen.id_anggota', 'left');
        // $this->builder->join('petugas_misa_khusus', 'anggota.id_anggota=petugas_misa_khusus.id_petugas', 'left');
        // $this->builder->join('peserta_outdoor', 'anggota.id_anggota=peserta_outdoor.id_peserta', 'left');
    }

    public function uploadDataset($jenis)
    {
        $filesDataset = $this->request->getFile('fileDataset');
        // $fileType = $filesDataset->getMimeType();
        // $uploadedType = $filesDataset->getClientMimeType();
        $csvMimes = array('text/csv', 'application/csv', 'application/excel');

        if (in_array($_FILES['fileDataset']['type'], $csvMimes)) {
            //pindahkan file ke folder img
            //generate nama sampul random
            if ($jenis == 'kapten') {
                $namaDataset = 'datasetkapten.csv'; //rename file
            } elseif ($jenis == 'pengurus') {
                $namaDataset = 'datasetpengurus.csv'; //rename file
            } elseif ($jenis == 'ketuawakil') {
                $namaDataset = 'datasetketuawakil.csv'; //rename file
            }
            $filesDataset->move('dataset', $namaDataset, true);

            $this->DatasetModel->save([
                'nama_file' => $namaDataset,
                'jenis_dataset' => $jenis,
            ]);
            echo "<script type='text/javascript'>alert('The file " . htmlspecialchars(basename($_FILES["fileDataset"]["name"])) . " has been uploaded.');</script>";
            session()->setFlashdata('pesan', 'Your file has been uploaded');
        } else {
            // echo "Invalid File";
            // echo "<script type='text/javascript'>alert('Invalid File');</script>";
            session()->setFlashdata('pesan', 'Invalid File');
        }

        // dd($filesDataset);

        if ($jenis == 'kapten') {
            return redirect()->to('/KelolaDataset/DatasetKapten');
        } elseif ($jenis == 'pengurus') {
            return redirect()->to('/KelolaDataset/DatasetPengurus');
        } elseif ($jenis == 'ketuawakil') {
            return redirect()->to('/KelolaDataset/DatasetKetuaWakil');
        }
    }

    public function DatasetKapten()
    {
        // $anggota = $this->AnggotaModel->select('anggota.*, detail_kelompok.id_kelompok')->join('detail_kelompok', 'anggota.id_anggota=detail_kelompok.id_anggota', 'left');
        // $anggota = $this->AnggotaModel->select('anggota.*, kelompok.nama_kelompok AS nama_kelompok')->join('kelompok', 'detail_kelompok.id_kelompok=kelompok.id_kelompok', 'left')->distinct()->findAll();

        // $anggota = $this->AnggotaModel->select('anggota.*')->join('detail_kelompok', 'anggota.id_anggota=detail_kelompok.id_anggota', 'left');
        // $anggota = $this->AnggotaModel->select('anggota.*, kelompok.nama_kelompok AS nama_kelompok')->join('kelompok', 'detail_kelompok.id_kelompok=kelompok.id_kelompok', 'left')->distinct()->findAll();

        $builder = $this->db->table("anggota");
        $builder->select('anggota.id_anggota AS kode_anggota, tanggal_masuk, tanggal_lahir, kandidat_kapten, kandidat_pengurus, kandidat_ketua, nama_kelompok, id_petugas, id_absen, id_peserta');
        $builder->join('detail_kelompok', 'anggota.id_anggota=detail_kelompok.id_anggota', 'left');
        $builder->join('kelompok', 'detail_kelompok.id_kelompok=kelompok.id_kelompok', 'left');
        $builder->join('absen', 'anggota.id_anggota=absen.id_anggota', 'left');
        $builder->join('petugas_misa_khusus', 'anggota.id_anggota=petugas_misa_khusus.id_petugas', 'left');
        $builder->join('peserta_outdoor', 'anggota.id_anggota=peserta_outdoor.id_peserta', 'left');

        $builder->groupBy('nama_panggilan');
        $query = $builder->get();

        $dataset = $this->DatasetModel->where('jenis_dataset', 'kapten')->orderBy('created_at', 'DESC')->first();

        $result = $query->getResult();

        $data = [
            'title' => 'Daftar komik',
            'anggota' => $result,
            'dataset' => $dataset,
        ];

        //konek manual
        // $db = \Config\Database::connect();
        // $komik = $db->query("SELECT * FROM komik");
        // foreach ($komik->getResultArray() as $row) {
        //     d($row);
        // }

        return view('KelolaDataset/DatasetKapten', $data);
    }

    public function DatasetPengurus()
    {
        $builder = $this->db->table("anggota");
        $builder->select('anggota.id_anggota AS kode_anggota, tanggal_masuk, tanggal_lahir, kandidat_kapten, kandidat_pengurus, kandidat_ketua, nama_kelompok, id_petugas, id_absen, id_peserta');
        $builder->join('detail_kelompok', 'anggota.id_anggota=detail_kelompok.id_anggota', 'left');
        $builder->join('kelompok', 'detail_kelompok.id_kelompok=kelompok.id_kelompok', 'left');
        $builder->join('absen', 'anggota.id_anggota=absen.id_anggota', 'left');
        $builder->join('petugas_misa_khusus', 'anggota.id_anggota=petugas_misa_khusus.id_petugas', 'left');
        $builder->join('peserta_outdoor', 'anggota.id_anggota=peserta_outdoor.id_peserta', 'left');

        $builder->groupBy('nama_panggilan');
        $query = $builder->get();

        $result = $query->getResult();

        $dataset = $this->DatasetModel->where('jenis_dataset', 'pengurus')->orderBy('created_at', 'DESC')->first();


        $data = [
            'title' => 'Daftar komik',
            'anggota' => $result,
            'dataset' => $dataset,
        ];

        //konek manual
        // $db = \Config\Database::connect();
        // $komik = $db->query("SELECT * FROM komik");
        // foreach ($komik->getResultArray() as $row) {
        //     d($row);
        // }

        return view('KelolaDataset/DatasetPengurus', $data);
    }

    public function DatasetKetuaWakil()
    {
        $builder = $this->db->table("anggota");
        $builder->select('anggota.id_anggota AS kode_anggota, tanggal_masuk, tanggal_lahir, kandidat_kapten, kandidat_pengurus, kandidat_ketua, nama_kelompok, id_petugas, id_absen, id_peserta');
        $builder->join('detail_kelompok', 'anggota.id_anggota=detail_kelompok.id_anggota', 'left');
        $builder->join('kelompok', 'detail_kelompok.id_kelompok=kelompok.id_kelompok', 'left');
        $builder->join('absen', 'anggota.id_anggota=absen.id_anggota', 'left');
        $builder->join('petugas_misa_khusus', 'anggota.id_anggota=petugas_misa_khusus.id_petugas', 'left');
        $builder->join('peserta_outdoor', 'anggota.id_anggota=peserta_outdoor.id_peserta', 'left');

        $builder->groupBy('nama_panggilan');
        $query = $builder->get();

        $result = $query->getResult();

        $dataset = $this->DatasetModel->where('jenis_dataset', 'ketuawakil')->orderBy('created_at', 'DESC')->first();

        $data = [
            'title' => 'Daftar komik',
            'anggota' => $result,
            'dataset' => $dataset,
        ];

        //konek manual
        // $db = \Config\Database::connect();
        // $komik = $db->query("SELECT * FROM komik");
        // foreach ($komik->getResultArray() as $row) {
        //     d($row);
        // }

        return view('KelolaDataset/DatasetKetuaWakil', $data);
    }
}
