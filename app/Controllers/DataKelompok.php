<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
use App\Models\KelompokModel;
use App\Models\DetailKelompok;
use App\Models\AbsenModel;
use App\Models\KegiatanOutdoorModel;
use App\Models\PesertaOutdoorModel;

class DataKelompok extends BaseController
{
    protected $AnggotaModel, $KelompokModel, $DetailKelompokModel, $AbsenModel, $KegiatanOutdoorModel, $PesertaOutdoorModel, $db;

    protected $builder, $builder0, $builder1, $builder2, $query, $query0, $query1, $query2, $result, $result0, $result1, $result2;

    public function __construct()
    {
        $this->AnggotaModel = new AnggotaModel();
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

        // $this->builder0 = $this->db->table("anggota");
        // $this->builder0->select('*,anggota.id_anggota AS kode_anggota');
        // $this->builder0->join('detail_kelompok', 'anggota.id_anggota=detail_kelompok.id_anggota', 'left');
        // $this->builder0->join('kelompok', 'detail_kelompok.id_kelompok=kelompok.id_kelompok', 'left');
        // $this->builder0->join('absen', 'anggota.id_anggota=absen.id_anggota', 'right');

        $this->builder = $this->db->table("kelompok");
        $this->builder->select('*, kelompok.id_kelompok AS kode_kelompok');
        $this->builder->join('detail_kelompok', 'kelompok.id_kelompok=detail_kelompok.id_kelompok', 'left');
        $this->builder->join('anggota', 'detail_kelompok.id_anggota=anggota.id_anggota', 'left');
    }

    public function index()
    {

        $data = [
            'title' => 'Daftar Kelompok',
            'kelompok' => $this->KelompokModel->findAll(),
        ];
        return view('KelolaDataKelompok/index', $data);
    }

    public function detail($id)
    {
        $this->builder->where('kelompok.id_kelompok', $id);
        $this->query = $this->builder->get();
        $this->result = $this->query->getResult();

        $data = [
            'title' => 'Detail Kelompok',
            'detailkelompok' => $this->result,
            'kelompok' => $this->KelompokModel->find($id),
            'anggota' => $this->AnggotaModel->findAll()
        ];
        // JIKA KOMIK TDK ADA
        // if (empty($data['kelompok'])) {
        //     throw new \CodeIgniter\Exceptions\PageNotFoundException('Kelompok ' . $id . ' tidak ketemu');
        // }
        // d($this->result);
        return view('KelolaDataKelompok/DetailKelompok', $data);
    }

    public function tambah($id)
    {
        if ($id != null) {
            $kelompok = $this->KelompokModel->find($id);
        }

        if ($kelompok != null) {
            $data = [
                'title' => 'Detail Kelompok',
                'kelompok' => $this->KelompokModel->find($id),
                'anggota' => $this->AnggotaModel->findAll()
            ];
            return view('KelolaDataKelompok/TambahAnggota', $data);
        } else {
            $data = [
                'title' => 'Daftar Kelompok',
                'kelompok' => $this->KelompokModel->findAll(),
            ];
            session()->setFlashdata('pesan', 'Kelompok tidak ditemukan');

            return redirect()->to('DataKelompok/index/');
        }
        // d($data);
        // JIKA KOMIK TDK ADA
        // if (empty($data['kelompok'])) {
        //     throw new \CodeIgniter\Exceptions\PageNotFoundException('Kelompok ' . $id . ' tidak ketemu');
        // }
        // d($this->result);
    }

    public function no_dupes(array $input_array)
    {
        return count($input_array) === count(array_flip($input_array));
    }

    public function savedata($id)
    {
        $nama = $this->request->getVar('nama');
        $kelompok = $id;

        // dd($nama, $kelompok);

        if ($this->no_dupes($nama)) {
            // echo "aman";
            foreach ($nama as $index => $namas) {
                $s_nama = $namas;
                $s_kelompok = $kelompok;

                $this->builder2 = $this->db->table("detail_kelompok")->select('*');
                $this->query2 = $this->builder2->getWhere(['id_anggota' => $namas]);;
                $this->result2 = $this->query2->getResult();

                // $s_otherfiled = $empid[$index];
                // $query = "INSERT INTO absen_new (kd_absen,kode_anggota,kode_kelompok,absen,tanggal,jam) VALUES ('','$s_nama','$s_kelompok','$s_absen','$s_tanggal','$s_jam')";
                // $query_run = mysqli_query($con, $query);
                if (count($this->result2) == 0) { //kalo nggak ketemu, save 
                    $this->DetailKelompokModel->save([
                        'id_anggota' => $s_nama,
                        'id_kelompok' => $s_kelompok,
                    ]);
                    echo 'tidak ada';
                    echo $namas . '<br>';
                } else {
                    // echo "ada"; 
                    $db = \Config\Database::connect(); //kalau ketemu, dihapus dulu trus tambah
                    $db->simpleQuery('DELETE FROM detail_kelompok WHERE id_anggota = ' . $namas);
                    if ($db->simpleQuery('DELETE FROM detail_kelompok WHERE id_anggota = ' . $namas)) {
                        $this->DetailKelompokModel->save([
                            'id_anggota' => $s_nama,
                            'id_kelompok' => $s_kelompok,
                        ]);
                        echo 'Success!';
                        echo $namas . '<br>';
                    } else {
                        echo 'Query failed!';
                    }
                }
            }
            return redirect()->to('DataKelompok/detail/' . $id);
        } else {
            // echo "duplikat";
            session()->setFlashdata('pesan', 'Terdapat duplikat data nama');

            return redirect()->to('DataKelompok/tambah/' . $id);
        };

        // session()->setFlashdata('pesan', 'Data berhasil ditambahkan');
        $data = [
            'title' => 'Detail Kelompok',
            'kelompok' => $this->KelompokModel->find($id),
            'anggota' => $this->AnggotaModel->findAll()
        ];
        // JIKA KOMIK TDK ADA
        // if (empty($data['kelompok'])) {
        //     throw new \CodeIgniter\Exceptions\PageNotFoundException('Kelompok ' . $id . ' tidak ketemu');
        // }
        // d($this->result);
        // return redirect()->to('DataKelompok/index');
        // return view('KelolaDataKelompok/index', $data);
    }

    // public function Edit($id)
    // {

    //     $this->builder->where('kelompok.id_kelompok', $id);
    //     $this->query = $this->builder->get();
    //     $this->result = $this->query->getResult();
    //     $data = [
    //         'title' => 'Detail Kelompok',
    //         // 'absen' => $this->result0,
    //         'detailkelompok' => $this->result,
    //         'anggota' => $this->AnggotaModel->findAll()
    //     ];
    //     return view('KelolaDataKelompok/EditNew', $data);
    // }

    public function delete($kode_kelompok)
    {
        $id = $this->request->getVar('id_del');

        $db = \Config\Database::connect(); //kalau ketemu, dihapus dulu trus tambah
        $db->simpleQuery('DELETE FROM detail_kelompok WHERE id_anggota = ' . $id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        // return redirect()->to('DataAnggota/');
        // return view('/DataKelompok/detail/$kode_kelompok');
        // $this->detail($kode_kelompok);

        return redirect()->to('DataKelompok/detail/' . $kode_kelompok);
    }


    // public function Update($id)
    // {

    //     // d($this->result2);

    //     // if (preg_match('/^\d{1,2}$/', $string)) {
    //     //     // it's one or two digits
    //     // }
    //     // $this->builder->where('kelompok.id_kelompok', $id);
    //     // $this->query = $this->builder->get();
    //     // $this->result = $this->query->getResult();


    //     $nama = $this->request->getVar('nama_anggota');
    //     $status = $this->request->getVar('status');
    //     d($nama);

    //     if ($this->no_dupes($nama)) {
    //         foreach ($nama as $namas) {
    //             $s_nama = $namas;
    //             // $this->db = db_connect();
    //             // $jml_hadir = $this->db->table('detail_kelompok')->like('id_anggota', $s_nama);
    //             // $this->query2 = $this->builder2->get();
    //             // $this->result2 = $this->query2->getResult();
    //             // d($this->result2);
    //             $this->builder2 = $this->db->table("detail_kelompok")->select('*');
    //             $this->query2 = $this->builder2->getWhere(['id_anggota' => $namas]);;
    //             $this->result2 = $this->query2->getResult();
    //             // echo $namas;
    //             // echo "index" . $index;
    //             // d($this->result2);

    //             if (count($this->result2) == 0) { //kalo nggak ketemu, save 
    //                 $this->DetailKelompokModel->save([
    //                     'id_anggota' => $namas,
    //                     'id_kelompok' => $id
    //                 ]);
    //                 echo 'tidak ada';
    //                 echo $namas . '<br>';
    //             } else {
    //                 // echo "ada"; 
    //                 $db = \Config\Database::connect(); //kalau ketemu, dihapus dulu trus tambah
    //                 $db->simpleQuery('DELETE FROM detail_kelompok WHERE id_anggota = ' . $namas);
    //                 // if ($db->simpleQuery('DELETE FROM detail_kelompok WHERE id_anggota = ' . $namas)) {
    //                 $this->DetailKelompokModel->save([
    //                     'id_anggota' => $namas,
    //                     'id_kelompok' => $id
    //                 ]);
    //                 echo 'Success!';
    //                 echo $namas . '<br>';
    //                 // } else {
    //                 //     echo 'Query failed!';
    //                 // }
    //             }
    //         }
    //     } else {
    //         session()->setFlashdata('pesan', 'Terdapat duplikat data nama');

    //         // return redirect()->to('KelolaDataKelompok/EditKelompok');
    //     };

    //     // $data = [
    //     //     'title' => 'Detail Kelompok',
    //     //     // 'absen' => $this->result0,
    //     //     'detailkelompok' => $this->result,
    //     //     'anggota' => $this->AnggotaModel->findAll()
    //     // ];
    //     // // session()->setFlashdata('pesan', 'Data berhasil ditambahkan');
    //     // return view('KelolaDataKelompok/DetailKelompok', $data);
    //     // return redirect()->to('/DataKelompok/index');
    // }

    public function UpdateNama() //editnama
    {
        // $this->builder->where('kelompok.id_kelompok', $id);
        // $this->query = $this->builder->get();
        // $this->result = $this->query->getResult();
        $data = [
            'title' => 'Detail Kelompok',
            // 'absen' => $this->result0,
            'kelompok' => $this->KelompokModel->findAll(),
            // 'anggota' => $this->AnggotaModel->findAll()
        ];
        return view('KelolaDataKelompok/EditNama', $data);
    }

    public function UpdateNamaProses() //editnama
    {
        $id = $this->request->getVar('idkelompok');
        $nama = $this->request->getVar('namakelompok');

        if ($this->no_dupes($nama)) {
            // echo "aman";
            foreach ($id as $index => $ids) {
                $s_id = $ids;
                $s_nama = $nama[$index];

                d($s_nama);
                // d($s_id);
                $this->KelompokModel->save([
                    'id_kelompok' => $s_id,
                    'nama_kelompok' => $s_nama,
                ]);
            }
        } else {
            // echo "duplikat";
            session()->setFlashdata('pesan', 'Terdapat duplikat data nama');

            $data = [
                'title' => 'Detail Kelompok',
                // 'absen' => $this->result0,
                'kelompok' => $this->KelompokModel->findAll(),
                // 'anggota' => $this->AnggotaModel->findAll()
            ];
            return redirect()->to('DataKelompok/UpdateNama');
        };
        return redirect()->to('DataKelompok/index');
    }
}
