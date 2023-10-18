<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
use App\Models\KelompokModel;
use App\Models\DetailKelompok;
use App\Models\AbsenModel;

class DataAbsen extends BaseController
{
    protected $AnggotaModel, $KelompokModel, $DetailKelompokModel, $AbsenModel, $db;
    protected $builder, $builder0, $builder1, $builder2, $builder4, $query, $query0, $query1, $query2, $query4, $result, $result0, $result1, $result2, $result4;

    public function __construct()
    {
        $this->AnggotaModel = new AnggotaModel();
        $this->KelompokModel = new KelompokModel();
        $this->DetailKelompokModel = new DetailKelompok();
        $this->AbsenModel = new AbsenModel();
        $this->db = db_connect();
    }

    public function getKelompok()
    {
        $kelompok = $this->KelompokModel->findAll(); //read all data from tbl
        return $kelompok;
    }
    public function getAnggota()
    {
        $anggota = $this->AnggotaModel->findAll(); //read all data from tbl
        return $anggota;
    }
    public function index()
    {
        $builder = $this->db->table("absen");
        $builder->select('anggota.id_anggota AS kode_anggota, nama_panggilan, id_absen, absen, tanggal, jam');
        $builder->join('anggota', 'anggota.id_anggota=absen.id_anggota', 'left')->orderBy('id_absen', 'ASC');
        // $builder->join('kelompok', 'detail_kelompok.id_kelompok=kelompok.id_kelompok', 'left');
        // $builder->join('absen', 'anggota.id_anggota=absen.id_anggota', 'left');

        // $builder->groupBy('nama_panggilan');
        $query = $builder->get();

        $result = $query->getResult();

        $data = [
            'title' => 'Daftar Absen',
            'anggota' => $result
        ];
        return view('Absen/DashboardAbsen', $data);
    }

    public function inputAbsen()
    {
        $kelompok = $this->KelompokModel->findAll(); //read all data from tbl
        $anggota = $this->AnggotaModel->orderBy('nama_panggilan', 'asc')->findAll(); //read all data from tbl

        $builder4 = $this->db->table("anggota");
        $builder4->select('*,anggota.id_anggota AS kode_anggota');
        $builder4->join('detail_kelompok', 'anggota.id_anggota=detail_kelompok.id_anggota', 'left');
        $builder4->join('kelompok', 'detail_kelompok.id_kelompok=kelompok.id_kelompok', 'left');
        $builder4->notLike('nama_kelompok', 'null');
        $builder4->groupBy('nama_lengkap');
        $builder4->orderBy('nama_panggilan', 'ASC');
        $query4 = $builder4->get();
        $result4 = $query4->getResult();

        $data = [
            'title' => 'Tambah Absen',
            'kelompok' => $kelompok,
            'anggota' => $result4
        ];
        return view('Absen/InputAbsen', $data);
    }

    public function deleteAbsen()
    {
        $id = $this->request->getVar('id_del');
        $builder1 = $this->db->table("absen");

        // dd($id);
        // if ($id = null) {
        //     session()->setFlashdata('pesan', 'Data gagal dihapus');
        // } else {
        $this->AbsenModel->where('id_absen', $id)->delete();
        // $builder1->delete(['id_absen' => $id]);
        // $db = \Config\Database::connect();
        // $db->simpleQuery('DELETE FROM absen WHERE id_absen =' . $id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        // }
        return redirect()->to('DataAbsen/');
    }

    public function deleteAbsenbatch()
    {
        $id_box = $this->request->getVar('check_value');
        $checked_id = [];
        $builder1 = $this->db->table("absen");
        if (!empty($id_box)) {
            foreach ($id_box as $id) {
                array_push($checked_id, $id);
            }
            $jumlah = count($checked_id);
            foreach ($checked_id as $i) {
                $this->AbsenModel->where('id_absen', $i)->delete();
            }
            // var_dump($id_box);
            // var_dump($checked_id);
            session()->setFlashdata('pesan', $jumlah . ' data berhasil dihapus');
        } else {
            session()->setFlashdata('pesan', 'Please choose at least 1 data');
        }
        // dd($id);

        // $this->AbsenModel->where('id_absen', $id_box)->delete();
        return redirect()->to('DataAbsen/');
    }
    public function no_dupes(array $input_array)
    {
        return count($input_array) === count(array_flip($input_array));
    }

    public function savedata()
    {
        $nama = $this->request->getVar('nama');
        // $kelompok = $this->request->getVar('kelompok');
        $absen = $this->request->getVar('absensi');
        $tanggal = $this->request->getVar('tanggal');
        $jam = $this->request->getVar('jam');

        // dd($nama, $absen, $tanggal, $jam);
        $date_now = time(); //current timestamp

        if ($this->no_dupes($nama)) {
            // echo "aman";
            foreach ($nama as $index => $namas) {
                $s_nama = $namas;
                $s_kelompok = '1';
                $s_absen = $absen[$index];
                $s_jam = $jam[0];
                // $s_tanggal = $tanggal[$index];
                $s_tanggal = $tanggal[0];

                if (strtotime($s_tanggal) > strtotime('now')) {
                    session()->setFlashdata('pesan', 'Tanggal harus lebih kecil dari tanggal hari ini');

                    return redirect()->to('/DataAbsen/InputAbsen');
                } else {
                    $this->builder2 = $this->db->table("anggota")->select('id_anggota, nama_lengkap, tanggal_masuk');
                    $this->query2 = $this->builder2->getWhere(['anggota.id_anggota' => $s_nama]);;
                    $this->result2 = $this->query2->getResult();
                    // dd($this->result2);
                    if (strtotime($this->result2[0]->tanggal_masuk) > strtotime($s_tanggal)) { //tgl absen tdk boleh < tgl masuk
                    } else {
                        $this->builder0 = $this->db->table("absen")->select('*');
                        $this->query0 = $this->builder0->getWhere(['absen.id_anggota' => $s_nama, 'absen.absen' => $s_absen, 'absen.tanggal' => $s_tanggal, 'absen.jam' => $s_jam]);;
                        $this->result0 = $this->query0->getResult();

                        if (count($this->result0) == 0) { //kalo nggak ketemu, save 
                            $this->AbsenModel->save([
                                'id_anggota' => $s_nama,
                                'id_kelompok' => $s_kelompok,
                                'absen' => $s_absen,
                                'tanggal' => $s_tanggal,
                                'jam' => $s_jam
                            ]);
                            // echo 'tidak ada';
                            // echo $namas . '<br>';
                        } else {
                        }
                    }

                    // $s_otherfiled = $empid[$index];
                    // $query = "INSERT INTO absen_new (kd_absen,kode_anggota,kode_kelompok,absen,tanggal,jam) VALUES ('','$s_nama','$s_kelompok','$s_absen','$s_tanggal','$s_jam')";
                    // $query_run = mysqli_query($con, $query);
                }
            }
            session()->setFlashdata('pesan', 'Data berhasil ditambahkan');
            return redirect()->to('/DataAbsen/InputAbsen');
            // return redirect()->to('/DataAbsen');
        } else {
            // echo "duplikat";
            array_values(array_unique($nama));
            foreach ($nama as $index => $namas) {
                $s_nama = $namas;
                $s_kelompok = '1';
                $s_absen = $absen[$index];
                $s_jam = $jam[0];
                // $s_tanggal = $tanggal[$index];
                $s_tanggal = $tanggal[0];

                if (strtotime($s_tanggal) > strtotime('now')) {
                    session()->setFlashdata('pesan', 'Tanggal harus lebih kecil dari tanggal hari ini');

                    return redirect()->to('/DataAbsen/InputAbsen');
                } else {
                    $this->builder0 = $this->db->table("absen")->select('*');
                    $this->query0 = $this->builder0->getWhere(['absen.id_anggota' => $s_nama, 'absen.absen' => $s_absen, 'absen.tanggal' => $s_tanggal, 'absen.jam' => $s_jam]);
                    $this->result0 = $this->query0->getResult();

                    if (count($this->result0) == 0) { //kalo nggak ketemu, save 
                        $this->AbsenModel->save([
                            'id_anggota' => $s_nama,
                            'id_kelompok' => $s_kelompok,
                            'absen' => $s_absen,
                            'tanggal' => $s_tanggal,
                            'jam' => $s_jam
                        ]);
                        // echo 'tidak ada';
                        // echo $namas . '<br>';
                    } else {
                    }
                    // $s_otherfiled = $empid[$index];
                    // $query = "INSERT INTO absen_new (kd_absen,kode_anggota,kode_kelompok,absen,tanggal,jam) VALUES ('','$s_nama','$s_kelompok','$s_absen','$s_tanggal','$s_jam')";
                    // $query_run = mysqli_query($con, $query);
                }
            }
            session()->setFlashdata('pesan', 'Data berhasil ditambahkan');
            return redirect()->to('/DataAbsen/InputAbsen');
            // session()->setFlashdata('pesan', 'Terdapat duplikat data nama');

            // return redirect()->to('/DataAbsen/InputAbsen/InputAbsen');
        };

        // session()->setFlashdata('pesan', 'Data berhasil ditambahkan');

        // return redirect()->to('/DataAbsen');
    }

    public function savedatatemp()
    {
        $nama = $this->request->getVar('nama');
        // $kelompok = $this->request->getVar('kelompok');
        $absen = $this->request->getVar('absensi');
        $tanggal = $this->request->getVar('tanggal');
        $jam = $this->request->getVar('jam');

        // dd($nama, $absen, $tanggal, $jam);
        $date_now = time(); //current timestamp

        // if ($this->no_dupes($nama)) {
        // echo "aman";
        for ($x = 0; $x <= 40; $x++) {
            shuffle($nama);
            shuffle($tanggal);
            shuffle($jam);
            foreach ($nama as $index => $namas) {
                $s_nama = $namas;
                $s_kelompok = '1';
                $s_absen = $absen[$index];
                $s_jam = $jam[$index];
                // $s_tanggal = $tanggal[$index];
                $s_tanggal = $tanggal[$index];

                if (strtotime($s_tanggal) > strtotime('now')) {
                    session()->setFlashdata('pesan', 'Tanggal harus lebih kecil dari tanggal hari ini');

                    return redirect()->to('/DataAbsen/InputAbsen');
                } else {
                    // $this->builder0 = $this->db->table("absen")->select('*');
                    // $this->query0 = $this->builder0->getWhere(['absen.id_anggota' => $s_nama, 'absen.absen' => $s_absen, 'absen.tanggal' => $s_tanggal, 'absen.jam' => $s_jam]);;
                    // $this->result0 = $this->query0->getResult();

                    // if (count($this->result0) == 0) { //kalo nggak ketemu, save 
                    $this->AbsenModel->save([
                        'id_anggota' => $s_nama,
                        'id_kelompok' => $s_kelompok,
                        'absen' => $s_absen,
                        'tanggal' => $s_tanggal,
                        'jam' => $s_jam
                    ]);
                    // echo 'tidak ada';
                    // echo $namas . '<br>';
                    // } else {
                    // }
                    // $s_otherfiled = $empid[$index];
                    // $query = "INSERT INTO absen_new (kd_absen,kode_anggota,kode_kelompok,absen,tanggal,jam) VALUES ('','$s_nama','$s_kelompok','$s_absen','$s_tanggal','$s_jam')";
                    // $query_run = mysqli_query($con, $query);
                }
            }
            // return redirect()->to('/DataAbsen');
            // } else {
            //     // echo "duplikat";
            //     array_values(array_unique($nama));
            //     foreach ($nama as $index => $namas) {
            //         $s_nama = $namas;
            //         $s_kelompok = '1';
            //         $s_absen = $absen[$index];
            //         $s_jam = $jam[0];
            //         // $s_tanggal = $tanggal[$index];
            //         $s_tanggal = $tanggal[0];

            //         if (strtotime($s_tanggal) > strtotime('now')) {
            //             session()->setFlashdata('pesan', 'Tanggal harus lebih kecil dari tanggal hari ini');

            //             return redirect()->to('/DataAbsen/InputAbsen');
            //         } else {
            //             $this->builder0 = $this->db->table("absen")->select('*');
            //             $this->query0 = $this->builder0->getWhere(['absen.id_anggota' => $s_nama, 'absen.absen' => $s_absen, 'absen.tanggal' => $s_tanggal, 'absen.jam' => $s_jam]);;
            //             $this->result0 = $this->query0->getResult();

            //             if (count($this->result0) == 0) { //kalo nggak ketemu, save 
            //                 $this->AbsenModel->save([
            //                     'id_anggota' => $s_nama,
            //                     'id_kelompok' => $s_kelompok,
            //                     'absen' => $s_absen,
            //                     'tanggal' => $s_tanggal,
            //                     'jam' => $s_jam
            //                 ]);
            //                 // echo 'tidak ada';
            //                 // echo $namas . '<br>';
            //             } else {
            //             }
            //             // $s_otherfiled = $empid[$index];
            //             // $query = "INSERT INTO absen_new (kd_absen,kode_anggota,kode_kelompok,absen,tanggal,jam) VALUES ('','$s_nama','$s_kelompok','$s_absen','$s_tanggal','$s_jam')";
            //             // $query_run = mysqli_query($con, $query);
            //         }
            //     }
            //     session()->setFlashdata('pesan', 'Data berhasil ditambahkan');
            //     return redirect()->to('/DataAbsen/InputAbsen');
            //     // session()->setFlashdata('pesan', 'Terdapat duplikat data nama');

            //     // return redirect()->to('/DataAbsen/InputAbsen/InputAbsen');
            // };
        }
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');
        return redirect()->to('/DataAbsen/InputAbsen');
        // session()->setFlashdata('pesan', 'Data berhasil ditambahkan');

        // return redirect()->to('/DataAbsen');
    }
}
