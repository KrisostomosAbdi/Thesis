<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
use App\Models\MisaBesarModel;
use App\Models\PetugasMisaBesarModel;

class DataPetugasMisaBesar extends BaseController
{
    protected $AnggotaModel, $MisaBesarModel, $PetugasMisaBesarModel;
    protected $db, $builder, $builder0, $builder1, $builder2, $query, $query0, $query1, $query2, $result, $result0, $result1, $result2;

    public function __construct()
    {
        $this->AnggotaModel = new AnggotaModel();
        $this->MisaBesarModel = new MisaBesarModel();
        $this->PetugasMisaBesarModel = new PetugasMisaBesarModel();
        $this->db = db_connect();

        $this->builder = $this->db->table("misa_khusus");
        $this->builder->select('*, misa_khusus.id_misa AS kode_misa');
        $this->builder->join('petugas_misa_khusus', 'misa_khusus.id_misa=petugas_misa_khusus.id_misa', 'left');
        $this->builder->join('anggota', 'petugas_misa_khusus.id_petugas=anggota.id_anggota', 'left');
    }

    public function no_dupes(array $input_array)
    {
        return count($input_array) === count(array_flip($input_array));
    }

    public function savedata()
    {
        $nama = $this->request->getVar('nama');
        $misabesar = $this->request->getVar('misabesar');
        $tanggal = $this->request->getVar('tanggal');
        $jam = $this->request->getVar('jam');

        $this->builder1 = $this->db->table("petugas_misa_khusus")->select('*');

        // dd($nama, $misabesar, $tanggal, $jam, array_values(array_unique($nama)));
        $no_dupe = array();
        $nama_check = array();
        $date_now = time(); //current timestamp

        //cek duplikat input
        if ($this->no_dupes($nama)) { //tidak terdapat duplikat pada data input
            // echo "aman";
            foreach ($nama as $index => $namas) {
                $s_nama = $namas;
                $s_misabesar = $misabesar[0];
                $s_jam = $jam[0];
                // $s_tanggal = $tanggal[$index];
                $s_tanggal = $tanggal[0];
                // dd($s_nama, $s_lokasi, $s_tglmulai, $s_tglselesai);

                $this->builder0 = $this->db->table("anggota")->select('id_anggota, nama_lengkap, tanggal_masuk');
                $this->query0 = $this->builder0->getWhere(['anggota.id_anggota' => $s_nama]);;
                $this->result0 = $this->query0->getResult();
                if (strtotime($this->result0[0]->tanggal_masuk) > strtotime($s_tanggal)) {
                    //tgl absen tdk boleh < tgl masuk
                } else {
                    //cek kalau data input sudah ada di db
                    $this->query1 = $this->builder1->getWhere(['id_misa' => $s_misabesar, 'id_petugas' => $s_nama, 'tanggal' => $s_tanggal, 'jam' => $s_jam]);;
                    $this->result1 = $this->query1->getResult();

                    if (count($this->result1) == 0) { //tambah data nama yg clear (blm ada di db)
                        // array_push($no_dupe, 'yes');
                        // array_push($nama_check, $s_nama);
                        $this->PetugasMisaBesarModel->save([
                            'id_petugas' => $s_nama,
                            'id_misa' => $s_misabesar,
                            'tanggal' => $s_tanggal,
                            'jam' => $s_jam
                        ]);
                    } else {
                        array_push($no_dupe, 'no');
                    }
                }
            }
            // if (count($nama_check) == count($nama)) { //kalau jumlah nilai di nama_check = nilai di nama
            //     foreach ($nama as $index => $namas) {
            //         $s_nama = $namas;
            //         $s_misabesar = $misabesar[0];
            //         $s_jam = $jam[0];
            //         // $s_tanggal = $tanggal[$index];
            //         $s_tanggal = $tanggal[0];

            //         $this->PetugasMisaBesarModel->save([
            //             'id_petugas' => $s_nama,
            //             'id_misa' => $s_misabesar,
            //             'tanggal' => $s_tanggal,
            //             'jam' => $s_jam
            //         ]);
            //     }
            session()->setFlashdata('pesan', 'Data berhasil ditambahkan');

            return redirect()->to('/DataPetugasMisaBesar/index');
            // } else { //kalau nilai di nama_check != nilai di nama
            //     $different = array_diff($nama, $nama_check);
            //     dd($nama, $nama_check, array_values($different)[0]);
            //     $this->builder->where(['misa_khusus.id_misa' => $s_misabesar, 'id_petugas' => array_values($different)[0], 'tanggal' => $s_tanggal, 'jam' => $s_jam]);
            //     $this->query2 = $this->builder->get();
            //     $this->result2 = $this->query2->getResult();
            //     // dd($this->result2);
            //     session()->setFlashdata('pesan', 'Data Petugas ' . $this->result2[0]->nama_panggilan . ' pada misa di tanggal tersebut sudah ada');
            //     // session()->setFlashdata('pesan', 'Data duplikat');
            //     return redirect()->to('/DataPetugasMisaBesar/index');
            // }
        } else { //ada duplikat data input
            // // echo "duplikat";
            // $dupes = array_diff_assoc($nama, array_unique($nama));
            // // dd($dupes);
            // if (count($dupes) == 1) {
            //     $this->builder->where(['id_petugas' => $dupes]);
            //     $this->query2 = $this->builder->get();
            //     $this->result2 = $this->query2->getResult();
            //     session()->setFlashdata('pesan', 'Terdapat duplikat pada data ' . $this->result2[0]->nama_panggilan);
            // } else {
            //     foreach ($dupes as $d) {
            //         $this->builder2 = $this->db->table("anggota");
            //         $this->builder2->select('*');
            //         $this->builder2->where(['id_anggota' => $d]);
            //         $this->query2 = $this->builder2->get();
            //         $this->result2 = $this->query2->getResult();

            //         // session()->setFlashdata('pesan', 'Terdapat duplikat pada data ' . $this->result2[0]->nama_panggilan);
            //     }
            //     dd($dupes, $this->result2);
            // }
            array_values(array_unique($nama));
            foreach ($nama as $index => $namas) {
                $s_nama = $namas;
                $s_misabesar = $misabesar[0];
                $s_jam = $jam[0];
                // $s_tanggal = $tanggal[$index];
                $s_tanggal = $tanggal[0];
                // dd($s_nama, $s_lokasi, $s_tglmulai, $s_tglselesai);

                $this->builder0 = $this->db->table("anggota")->select('id_anggota, nama_lengkap, tanggal_masuk');
                $this->query0 = $this->builder0->getWhere(['anggota.id_anggota' => $s_nama]);;
                $this->result0 = $this->query0->getResult();

                if (strtotime($this->result0[0]->tanggal_masuk) > strtotime($s_tanggal)) {
                    //tgl absen tdk boleh < tgl masuk
                } else {
                    //cek kalau data input sudah ada di db
                    $this->query1 = $this->builder1->getWhere(['id_misa' => $s_misabesar, 'id_petugas' => $s_nama, 'tanggal' => $s_tanggal, 'jam' => $s_jam]);;
                    $this->result1 = $this->query1->getResult();

                    if (count($this->result1) == 0) { //tambah data nama yg clear (blm ada di db)
                        // array_push($no_dupe, 'yes');
                        // array_push($nama_check, $s_nama);
                        $this->PetugasMisaBesarModel->save([
                            'id_petugas' => $s_nama,
                            'id_misa' => $s_misabesar,
                            'tanggal' => $s_tanggal,
                            'jam' => $s_jam
                        ]);
                    } else {
                        array_push($no_dupe, 'no');
                    }
                }
            }
            session()->setFlashdata('pesan', 'Data berhasil ditambahkan');

            return redirect()->to('/DataPetugasMisaBesar/index');
        }
    }

    public function detail($id)
    {
        $this->builder->where('misa_khusus.id_misa', $id)->orderBy("tanggal DESC, jam ASC");
        $this->query = $this->builder->get();
        $this->result = $this->query->getResult();

        $data = [
            'title' => 'Detail Misa',
            'detailmisa' => $this->result,
            'misa' => $this->MisaBesarModel->find($id),
            'anggota' => $this->AnggotaModel->findAll()
        ];
        // JIKA KOMIK TDK ADA
        // if (empty($data['kelompok'])) {
        //     throw new \CodeIgniter\Exceptions\PageNotFoundException('Kelompok ' . $id . ' tidak ketemu');
        // }
        // d($this->result);
        return view('MisaBesar/detailMisa', $data);
    }

    public function delete()
    {
        $id = $this->request->getVar('id_del');
        $id_misa = $this->request->getVar('misa_del');
        $tanggal = $this->request->getVar('tanggal_del');
        $jam = $this->request->getVar('jam_del');

        $db = \Config\Database::connect(); //kalau ketemu, dihapus dulu trus tambah
        $deletequery = "DELETE FROM petugas_misa_khusus WHERE id_petugas = " . $id . " AND id_misa= " . $id_misa . " AND tanggal = " . "'" . $tanggal . "'" . " AND jam = " . "'" . $jam . "'";
        // echo $deletequery;
        $db->simpleQuery($deletequery);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/DataPetugasMisaBesar/detail/' . $id_misa);
        // return view('/DataKelompok/detail/$kode_kelompok');
        // $this->detail($kode_kelompok);

        // $this->detail($kode_kelompok);
    }

    public function UpdateNama() //editnama
    {
        // $this->builder->where('kelompok.id_kelompok', $id);
        // $this->query = $this->builder->get();
        // $this->result = $this->query->getResult();
        $data = [
            'title' => 'Detail Misa',
            // 'absen' => $this->result0,
            'misabesar' => $this->MisaBesarModel->findAll(),
            // 'anggota' => $this->AnggotaModel->findAll()
        ];
        return view('MisaBesar/UpdateMisa', $data);
    }

    public function UpdateNamaProses() //editnama
    {
        $id = $this->request->getVar('idmisa');
        $nama = $this->request->getVar('namamisa');

        if ($this->no_dupes($nama)) {
            // echo "aman";
            foreach ($id as $index => $ids) {
                $s_id = $ids;
                $s_nama = $nama[$index];

                // d($s_nama);
                // d($s_id);
                $this->MisaBesarModel->save([
                    'id_misa' => $s_id,
                    'nama_misa' => $s_nama,
                ]);
            }
        } else {
            // echo "duplikat";
            session()->setFlashdata('pesan', 'Terdapat duplikat data nama');

            $data = [
                'title' => 'Detail Kelompok',
                // 'absen' => $this->result0,
                'misabesar' => $this->MisaBesarModel->findAll(),
                // 'anggota' => $this->AnggotaModel->findAll()
            ];
            return redirect()->to('DataPetugasMisaBesar/UpdateNama');
        };
        return redirect()->to('DataPetugasMisaBesar/home');
    }

    public function TambahMisa()
    {
        $data = [
            'title' => 'Detail Kelompok',
        ];
        // JIKA KOMIK TDK ADA
        // if (empty($data['kelompok'])) {
        //     throw new \CodeIgniter\Exceptions\PageNotFoundException('Kelompok ' . $id . ' tidak ketemu');
        // }
        // d($this->result);
        return view('/MisaBesar/TambahMisa', $data);
    }

    public function hapusdatamisa()
    {
        //cari gambar berdasarkan id
        // $anggota = $this->MisaBesarModel->find($id);
        //cek jika file gambar default
        // if ($anggota['sampul'] != 'default.png') {
        //     //hapus gambar
        //     unlink('img/' . $anggota['sampul']);
        // }
        $id = $this->request->getVar('id_del');
        $this->MisaBesarModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('DataPetugasMisaBesar/home');
    }

    public function simpandatamisa()
    {
        $nama = $this->request->getVar('namamisa');
        // d($nama);

        if ($this->no_dupes($nama)) {
            // echo "aman";
            foreach ($nama as $index => $namas) {
                $s_nama = $namas;
                // $s_kelompok = $kelompok;

                $this->builder2 = $this->db->table("misa_khusus")->select('*');
                $this->query2 = $this->builder2->getWhere(['nama_misa' => $namas]);;
                $this->result2 = $this->query2->getResult();

                if (count($this->result2) == 0) { //kalo nggak ketemu, save 
                    $this->MisaBesarModel->save([
                        'nama_misa' => $s_nama,
                        // 'id_kelompok' => $s_kelompok,
                    ]);
                    // echo 'tidak ada';
                    // echo $namas . '<br>';

                } else {
                    session()->setFlashdata('pesan', 'Misa ' . $namas . 'sudah ada');

                    return redirect()->to('DataPetugasMisaBesar/TambahMisa');
                }
            }
            return redirect()->to('DataPetugasMisaBesar/home');
        } else {
            // echo "duplikat";
            session()->setFlashdata('pesan', 'Terdapat duplikat data nama');

            return redirect()->to('DataPetugasMisaBesar/TambahMisa');
        };

        // session()->setFlashdata('pesan', 'Data berhasil ditambahkan');
        // JIKA KOMIK TDK ADA
        // if (empty($data['kelompok'])) {
        //     throw new \CodeIgniter\Exceptions\PageNotFoundException('Kelompok ' . $id . ' tidak ketemu');
        // }
        // d($this->result);
        // return redirect()->to('DataKelompok/index');
        // return view('KelolaDataKelompok/index', $data);
    }

    public function home()
    {
        $petugas = $this->AnggotaModel->findAll();
        $misaBesar = $this->MisaBesarModel->findAll();

        $data = [
            'title' => 'Petugas Misa Besar',
            'petugas' => $petugas,
            'misabesar' => $misaBesar
        ];

        return view('/MisaBesar/home', $data);
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

        return view('/MisaBesar/InputPetugas', $data);
    }
}
