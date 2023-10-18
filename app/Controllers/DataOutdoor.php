<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
// use App\Models\KelompokModel;
// use App\Models\DetailKelompok;
use App\Models\KegiatanOutdoorModel;
use App\Models\PesertaOutdoorModel;

class DataOutdoor extends BaseController
{
    protected $AnggotaModel, $KelompokModel, $DetailKelompokModel, $KegiatanOutdoorModel, $PesertaOutdoorModel, $db;

    protected $listanggota, $listkegiatan;

    protected $builder, $builder2, $builderKegiatan, $builderNama, $builderTanggal, $builderTanggal2, $query, $query2, $query1, $queryNama, $queryTanggal, $queryTanggal2, $result, $result0, $result1, $result2, $resultTanggal, $resultTanggal2;

    public function __construct()
    {
        $this->AnggotaModel = new AnggotaModel();
        $this->KegiatanOutdoorModel = new KegiatanOutdoorModel();
        $this->PesertaOutdoorModel = new PesertaOutdoorModel();
        $this->listanggota = $this->AnggotaModel->findAll();
        $this->listkegiatan = $this->KegiatanOutdoorModel->orderBy('tanggal_mulai', 'desc')->findAll();


        $this->db = db_connect();
        $this->builder = $this->db->table("kegiatan_outdoor");
        $this->builder->select('*, kegiatan_outdoor.id_kegiatan AS kode_kegiatan');
        $this->builder->join('peserta_outdoor', 'kegiatan_outdoor.id_kegiatan=peserta_outdoor.id_kegiatan', 'left');
        $this->builder->join('anggota', 'peserta_outdoor.id_peserta=anggota.id_anggota', 'left');

        $this->builderKegiatan = $this->db->table("kegiatan_outdoor");
        $this->builderKegiatan->select('*');
        $this->builderKegiatan->orderBy('tanggal_mulai', 'DESC');

        $this->builderNama = $this->db->table("anggota");
        $this->builderNama->select('*');
        $this->builderNama->orderBy('nama_panggilan', 'ASC');
    }

    public function no_dupes(array $input_array)
    {
        return count($input_array) === count(array_flip($input_array));
    }

    public function no_dupes2(array $input_array)
    {
        return count($input_array) === count(array_flip($input_array));
    }

    public function inputKegiatan()
    {
        $data = [
            'title' => 'Input Peserta'
        ];

        return view('/Outdoor/InputKegiatan', $data);
    }

    public function simpandatakegiatan()
    {
        $namakegiatan = $this->request->getVar('nama_kegiatan');
        $lokasi = $this->request->getVar('lokasi');
        $tgl_mulai = $this->request->getVar('tgl_mulai');
        $tgl_selesai = $this->request->getVar('tgl_selesai');

        // dd($namakegiatan, $this->no_dupes2($namakegiatan), $lokasi, $tgl_mulai, $this->no_dupes2($tgl_mulai), $tgl_selesai, $this->no_dupes2($tgl_selesai));
        // if(count($namakegiatan)>1){}
        // if ($this->no_dupes2($namakegiatan) && $this->no_dupes2($lokasi) && $this->no_dupes2($tgl_mulai) && $this->no_dupes2($tgl_selesai)) {
        // echo "aman";
        foreach ($namakegiatan as $index => $namas) {
            $s_nama = $namas;
            $s_lokasi = $lokasi[$index];
            $s_tglmulai = $tgl_mulai[$index];
            $s_tglselesai = $tgl_selesai[$index];

            $mulai = strtotime($s_tglmulai);
            $selesai = strtotime($s_tglselesai);

            if ($mulai > $selesai) {
                session()->setFlashdata('pesan', 'Tanggal selesai harus lebih kecil daripada tanggal mulai');

                return redirect()->to('DataOutdoor/inputKegiatan');
            } else {
                $this->builder2 = $this->db->table("kegiatan_outdoor")->select('*');
                $this->query2 = $this->builder2->getWhere(['nama_kegiatan' => $namas, 'lokasi_kegiatan' => $s_lokasi, 'tanggal_mulai' => $s_tglmulai, 'tanggal_selesai' => $s_tglselesai]);;
                $this->result2 = $this->query2->getResult();

                if (count($this->result2) == 0) {
                    // dd($s_nama, $s_lokasi, $s_tglmulai, $s_tglselesai);

                    $this->KegiatanOutdoorModel->save([
                        'nama_kegiatan' => $s_nama,
                        'lokasi_kegiatan' => $s_lokasi,
                        'tanggal_mulai' => $s_tglmulai,
                        'tanggal_selesai' => $s_tglselesai,
                    ]);
                } else {
                    //kalo nggak ketemu, save 

                    // dd($this->result2);
                    // session()->setFlashdata('pesan', 'Data Kegiatan ' . $s_nama . ' di ' . $s_lokasi . ' tanggal ' . $s_tglmulai . ' sampai ' . $s_tglselesai . ' sudah ada');
                    // return redirect()->to('DataOutdoor/inputKegiatan');
                    // echo 'tidak ada';
                    // echo $namas . '<br>';
                }
            }
        }
        session()->setFlashdata('pesan', 'Data ditambahkan');

        return redirect()->to('DataOutdoor/index');
        // } else {
        //     // echo "duplikat";
        //     session()->setFlashdata('pesan', 'Terdapat duplikat data nama');

        //     return redirect()->to('DataOutdoor/inputKegiatan');
        // };

        // session()->setFlashdata('pesan', 'Data berhasil ditambahkan');
        // $data = [
        //     'title' => 'Detail Kelompok',
        //     'kelompok' => $this->KelompokModel->find($id),
        //     'anggota' => $this->AnggotaModel->findAll()
        // ];
        // JIKA KOMIK TDK ADA
        // if (empty($data['kelompok'])) {
        //     throw new \CodeIgniter\Exceptions\PageNotFoundException('Kelompok ' . $id . ' tidak ketemu');
        // }
        // d($this->result);
        // return redirect()->to('DataKelompok/index');
        // return view('KelolaDataKelompok/index', $data);
    }

    public function deletekegiatan()
    {
        //cari gambar berdasarkan id
        $id = $this->request->getVar('id_del');

        $anggota = $this->KegiatanOutdoorModel->find($id);
        //cek jika file gambar default
        // if ($anggota['sampul'] != 'default.png') {
        //     //hapus gambar
        //     unlink('img/' . $anggota['sampul']);
        // }

        $this->KegiatanOutdoorModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('DataOutdoor/index');
    }

    public function editkegiatan($id)
    {
        $this->builderKegiatan->where('kegiatan_outdoor.id_kegiatan', $id);
        $this->query = $this->builderKegiatan->get();
        $this->result = $this->query->getResult();

        $data = [
            'title' => 'Input Peserta',
            'detailkegiatan' => $this->result
        ];

        return view('/Outdoor/EditKegiatan', $data);
    }
    public function editprosesKegiatan($id)
    {
        $namakegiatan = $this->request->getVar('nama_kegiatan');
        $lokasi = $this->request->getVar('lokasi');
        $tgl_mulai = $this->request->getVar('tgl_mulai');
        $tgl_selesai = $this->request->getVar('tgl_selesai');

        $this->builder2 = $this->db->table("kegiatan_outdoor")->select('*');
        $this->query2 = $this->builder2->getWhere(['nama_kegiatan' => $namakegiatan, 'lokasi_kegiatan' => $lokasi, 'tanggal_mulai' => $tgl_mulai, 'tanggal_selesai' => $tgl_selesai]);;
        $this->result2 = $this->query2->getResult();

        if (count($this->result2) == 0) {
            // dd($s_nama, $s_lokasi, $s_tglmulai, $s_tglselesai);

            $this->KegiatanOutdoorModel->save([
                'id_kegiatan' => $id,
                'nama_kegiatan' => $namakegiatan,
                'lokasi_kegiatan' => $lokasi,
                'tanggal_mulai' => $tgl_mulai,
                'tanggal_selesai' => $tgl_selesai,
            ]);
            session()->setFlashdata('pesan', 'Data berhasil diupdate');
        } else {
            //kalo nggak ketemu, save 

            // dd($this->result2);
            session()->setFlashdata('pesan', 'Data Kegiatan ' . $namakegiatan . ' di ' . $lokasi . ' tanggal ' . $tgl_mulai . ' sampai ' . $tgl_selesai . ' sudah ada');
            return redirect()->to('DataOutdoor/editkegiatan/' . $id);
            // echo 'tidak ada';
            // echo $namas . '<br>';
        }


        return redirect()->to('DataOutdoor/index');
    }

    public function inputPeserta()
    {
        $query1 = $this->builderKegiatan->get();
        $result1 = $query1->getResult();

        $queryNama = $this->builderNama->orderBy('nama_panggilan', 'ASC')->get();
        $result2 = $queryNama->getResult();

        $data = [
            'title' => 'Input Peserta',
            'anggota' => $result2,
            'kegiatan' => $result1
        ];

        return view('/Outdoor/InputPeserta', $data);
    }

    public function deletepeserta($id_kegiatan)
    {
        $id = $this->request->getVar('id_del');
        $db = \Config\Database::connect(); //kalau ketemu, dihapus dulu trus tambah
        $db->simpleQuery('DELETE FROM peserta_outdoor WHERE id_peserta = ' . $id . ' AND id_kegiatan =' . $id_kegiatan);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');

        return redirect()->to('DataOutdoor/detail/' . $id_kegiatan);
    }

    public function savedata()
    {
        $nama = $this->request->getVar('namapeserta');
        $kegiatan = $this->request->getVar('namakegiatan');
        $list_dupes = array();
        $nama_nondupes = array();

        // dd($nama, $kegiatan);

        if ($this->no_dupes($nama)) {
            // echo "aman";
            foreach ($nama as $index => $namas) {
                $s_nama = $namas;
                $s_kegiatan = $kegiatan;

                $this->builderTanggal = $this->db->table("anggota")->select('id_anggota, nama_lengkap, tanggal_masuk');
                $this->queryTanggal = $this->builderTanggal->getWhere(['anggota.id_anggota' => $s_nama]);;
                $this->resultTanggal = $this->queryTanggal->getResult();

                $this->builderTanggal2 = $this->db->table("kegiatan_outdoor")->select('nama_kegiatan, tanggal_mulai, tanggal_selesai');
                $this->queryTanggal2 = $this->builderTanggal2->getWhere(['kegiatan_outdoor.id_kegiatan' => $s_kegiatan]);;
                $this->resultTanggal2 = $this->queryTanggal2->getResult();

                // dd($this->resultTanggal, $this->resultTanggal2);
                if (strtotime($this->resultTanggal[0]->tanggal_masuk) > strtotime($this->resultTanggal2[0]->tanggal_selesai)) {
                    //tgl kegiatan tdk boleh < tgl masuk
                } else {
                    $this->builder2 = $this->db->table("peserta_outdoor")->select('*');
                    $this->query2 = $this->builder2->getWhere(['peserta_outdoor.id_peserta' => $s_nama, 'peserta_outdoor.id_kegiatan' => $s_kegiatan]);;
                    $this->result2 = $this->query2->getResult();

                    if (count($this->result2) == 0) { //kalo nggak ketemu, save 
                        // array_push($nama_nondupes, $s_nama);
                        $this->PesertaOutdoorModel->save([
                            'id_peserta' => $s_nama,
                            'id_kegiatan' => $s_kegiatan,
                        ]);
                        // echo 'tidak ada';
                        // echo $namas . '<br>';
                    } else {
                        array_push($list_dupes, $this->result2);
                    }
                }
                // $s_otherfiled = $empid[$index];
                // $query = "INSERT INTO absen_new (kd_absen,kode_anggota,kode_kelompok,absen,tanggal,jam) VALUES ('','$s_nama','$s_kelompok','$s_absen','$s_tanggal','$s_jam')";
                // $query_run = mysqli_query($con, $query);
            }
            // if (empty($list_dupes)) {
            //     foreach ($nama as $index => $namas) {
            //         $s_nama = $namas;
            //         $s_kegiatan = $kegiatan;

            //         $this->PesertaOutdoorModel->save([
            //             'id_peserta' => $s_nama,
            //             'id_kegiatan' => $s_kegiatan,
            //         ]);
            //     }
            // } else {
            //     dd($list_dupes, $nama_nondupes);
            // }
            session()->setFlashdata('pesan', 'Data berhasil ditambahkan');

            return redirect()->to('/DataOutdoor/index');
        } else {
            // echo "duplikat";
            array_values(array_unique($nama));
            foreach ($nama as $index => $namas) {
                $s_nama = $namas;
                $s_kegiatan = $kegiatan;

                $this->builderTanggal = $this->db->table("anggota")->select('id_anggota, nama_lengkap, tanggal_masuk');
                $this->queryTanggal = $this->builderTanggal->getWhere(['anggota.id_anggota' => $s_nama]);;
                $this->resultTanggal = $this->queryTanggal->getResult();

                $this->builderTanggal2 = $this->db->table("kegiatan_outdoor")->select('nama_kegiatan, tanggal_mulai, tanggal_selesai');
                $this->queryTanggal2 = $this->builderTanggal2->getWhere(['kegiatan_outdoor.id_kegiatan' => $s_kegiatan]);;
                $this->resultTanggal2 = $this->queryTanggal2->getResult();

                // dd($this->resultTanggal, $this->resultTanggal2);
                if (strtotime($this->resultTanggal[0]->tanggal_masuk) > strtotime($this->resultTanggal2[0]->tanggal_selesai)) {
                    //tgl kegiatan tdk boleh < tgl masuk
                } else {
                    $this->builder2 = $this->db->table("peserta_outdoor")->select('*');
                    $this->query2 = $this->builder2->getWhere(['peserta_outdoor.id_peserta' => $s_nama, 'peserta_outdoor.id_kegiatan' => $s_kegiatan]);;
                    $this->result2 = $this->query2->getResult();

                    if (count($this->result2) == 0) { //kalo nggak ketemu, save 
                        // array_push($nama_nondupes, $s_nama);
                        $this->PesertaOutdoorModel->save([
                            'id_peserta' => $s_nama,
                            'id_kegiatan' => $s_kegiatan,
                        ]);
                        // echo 'tidak ada';
                        // echo $namas . '<br>';
                    } else {
                        array_push($list_dupes, $this->result2);
                    }
                }
                // $s_otherfiled = $empid[$index];
                // $query = "INSERT INTO absen_new (kd_absen,kode_anggota,kode_kelompok,absen,tanggal,jam) VALUES ('','$s_nama','$s_kelompok','$s_absen','$s_tanggal','$s_jam')";
                // $query_run = mysqli_query($con, $query);
            }

            session()->setFlashdata('pesan', 'Data berhasil ditambahkan');

            return redirect()->to('/DataOutdoor/index');
        };
    }

    public function detail($id)
    {
        $this->builder->where('kegiatan_outdoor.id_kegiatan', $id);
        $this->query = $this->builder->get();
        $this->result = $this->query->getResult();

        $data = [
            'title' => 'Detail Kegiatan',
            'detailkegiatan' => $this->result,
            'kegiatan' => $this->KegiatanOutdoorModel->find($id),
            'anggota' => $this->AnggotaModel->findAll()
        ];
        // JIKA KOMIK TDK ADA
        // if (empty($data['kelompok'])) {
        //     throw new \CodeIgniter\Exceptions\PageNotFoundException('Kelompok ' . $id . ' tidak ketemu');
        // }
        // d($this->result);
        return view('/Outdoor/DetailKegiatan', $data);
    }

    public function index()
    {
        $data = [
            'title' => 'Data Kegiatan Outdoor',
            'anggota' => $this->listanggota,
            'kegiatan' => $this->listkegiatan
        ];

        return view('/Outdoor/index', $data);
    }
}
