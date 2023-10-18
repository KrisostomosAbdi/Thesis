<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
use App\Models\KelompokModel;
use App\Models\DetailKelompok;
use App\Models\AbsenModel;
use App\Models\KegiatanOutdoorModel;
use App\Models\PesertaOutdoorModel;

use Phpml\Classification\NaiveBayes;
use Phpml\Classification\NaiveBayesNew;
use Phpml\Dataset\CsvDataset;
use Phpml\Metric\Accuracy;
use Phpml\Metric\ConfusionMatrix;
use Phpml\CrossValidation\StratifiedRandomSplit;
use Phpml\CrossValidation\RandomSplit;

use Phpml\Metric\ClassificationReport;

class DataAnggota extends BaseController
{
    protected $AnggotaModel, $KelompokModel, $DetailKelompokModel, $AbsenModel, $KegiatanOutdoorModel, $PesertaOutdoorModel, $db;

    protected $dtesting = [];
    protected $listlabels = [];
    protected $labels = [];

    protected $builder, $builder0, $builder1, $builder2, $builder3, $builder4, $builder5, $query, $query0, $query1, $query2, $query3, $query4, $query5, $result, $result0, $result1, $result2, $result3, $result4, $result5;

    public function __construct()
    {
        $this->AnggotaModel = new AnggotaModel();
        $this->KelompokModel = new KelompokModel();
        $this->DetailKelompokModel = new DetailKelompok();
        $this->AbsenModel = new AbsenModel();
        $this->KegiatanOutdoorModel = new KegiatanOutdoorModel();
        $this->PesertaOutdoorModel = new PesertaOutdoorModel();
        $this->db = db_connect();

        $this->builder = $this->db->table("anggota");
        $this->builder->select('*,anggota.id_anggota AS kode_anggota');
        $this->builder->join('detail_kelompok', 'anggota.id_anggota=detail_kelompok.id_anggota', 'left');
        $this->builder->join('kelompok', 'detail_kelompok.id_kelompok=kelompok.id_kelompok', 'left');

        $this->builder0 = $this->db->table("anggota");
        $this->builder0->select('*,anggota.id_anggota AS kode_anggota');
        $this->builder0->join('detail_kelompok', 'anggota.id_anggota=detail_kelompok.id_anggota', 'left');
        $this->builder0->join('kelompok', 'detail_kelompok.id_kelompok=kelompok.id_kelompok', 'left');
        $this->builder0->join('absen', 'anggota.id_anggota=absen.id_anggota', 'right');

        $this->builder1 = $this->db->table("anggota");
        $this->builder1->select('*,anggota.id_anggota AS kode_anggota');
        $this->builder1->join('petugas_misa_khusus', 'anggota.id_anggota=petugas_misa_khusus.id_petugas', 'left');
        $this->builder1->join('misa_khusus', 'petugas_misa_khusus.id_misa=misa_khusus.id_misa', 'left');

        $this->builder2 = $this->db->table("anggota");
        $this->builder2->select('*,anggota.id_anggota AS kode_anggota');
        $this->builder2->join('peserta_outdoor', 'anggota.id_anggota=peserta_outdoor.id_peserta', 'left');
        $this->builder2->join('kegiatan_outdoor', 'peserta_outdoor.id_kegiatan=kegiatan_outdoor.id_kegiatan', 'left');
    }


    // public function getKelompok()
    // {
    //     $kelompok = $this->KelompokModel->findAll(); //read all data from tbl

    // }

    // public function getDetailKelompok()
    // {
    //     $Detailkelompok = $this->DetailKelompokModel->findAll(); //read all data from tbl

    // }

    // function get_all_anggota()
    // {

    //     $this->DetailKelompokModel->select('*');
    //     $this->DetailKelompokModel->from('detail_kelompok AS D');
    //     $this->DetailKelompokModel->join('anggota AS A', 'A.id_anggota=D.id_anggota', 'inner');
    //     // $this->AnggotaModel->join('kelompok', 'kelompok.id_kelompok = detail_kelompok.id_kelompok', 'left');
    //     $this->DetailKelompokModel->distinct();

    //     $anggota = $this->AnggotaModel->select('anggota.*, detail_kelompok.id_kelompok AS kelompok')->join('detail_kelompok', 'anggota.id_anggota=detail_kelompok.id_anggota', 'left');
    //     $anggota = $this->AnggotaModel->select('anggota.*, kelompok.nama_kelompok AS nama_kelompok')->join('kelompok', 'detail_kelompok.id_kelompok=kelompok.id_kelompok', 'left')->distinct()->findAll();
    //     // $query = $this->DetailKelompokModel->findAll();
    //     return $anggota;
    // }

    public function detail($id)
    {
        // $komik = $this->komikModel->where(['slug' => $slug])->first();
        // $komik = $this->komikModel->getKomik($slug);
        // dd($komik);
        // $anggota = $this->AnggotaModel->select('anggota.*')->join('detail_kelompok', 'anggota.id_anggota=detail_kelompok.id_anggota', 'left');
        // $anggota = $this->AnggotaModel->select('anggota.*, kelompok.nama_kelompok AS nama_kelompok')->join('kelompok', 'detail_kelompok.id_kelompok=kelompok.id_kelompok', 'left')->distinct()->findAll();

        $builder = $this->db->table("anggota");
        $builder->select('*,anggota.id_anggota AS kode_anggota');
        $builder->join('detail_kelompok', 'anggota.id_anggota=detail_kelompok.id_anggota', 'left');
        $builder->join('kelompok', 'detail_kelompok.id_kelompok=kelompok.id_kelompok', 'left');
        // $builder->join('absen', 'anggota.id_anggota=absen.id_anggota', 'right');
        // $builder->join('petugas_misa_khusus', 'anggota.id_anggota=petugas_misa_khusus.id_petugas', 'left');
        // $builder->join('misa_khusus', 'petugas_misa_khusus.id_misa=misa_khusus.id_misa', 'left');
        // $builder->join('peserta_outdoor', 'anggota.id_anggota=peserta_outdoor.id_peserta', 'left');
        // $builder->join('kegiatan_outdoor', 'peserta_outdoor.id_kegiatan=kegiatan_outdoor.id_kegiatan', 'left');
        $builder0 = $this->db->table("anggota");
        $builder0->select('*,anggota.id_anggota AS kode_anggota');
        $builder0->join('detail_kelompok', 'anggota.id_anggota=detail_kelompok.id_anggota', 'left');
        $builder0->join('kelompok', 'detail_kelompok.id_kelompok=kelompok.id_kelompok', 'left');
        $builder0->join('absen', 'anggota.id_anggota=absen.id_anggota', 'right');

        $builder1 = $this->db->table("anggota");
        $builder1->select('*,anggota.id_anggota AS kode_anggota');
        $builder1->join('petugas_misa_khusus', 'anggota.id_anggota=petugas_misa_khusus.id_petugas', 'left');
        $builder1->join('misa_khusus', 'petugas_misa_khusus.id_misa=misa_khusus.id_misa', 'left')->orderBy('tanggal', 'DESC');;

        $builder2 = $this->db->table("anggota");
        $builder2->select('*,anggota.id_anggota AS kode_anggota');
        $builder2->join('peserta_outdoor', 'anggota.id_anggota=peserta_outdoor.id_peserta', 'left');
        $builder2->join('kegiatan_outdoor', 'peserta_outdoor.id_kegiatan=kegiatan_outdoor.id_kegiatan', 'left');

        $builder->where('anggota.id_anggota', $id);
        $builder0->where('anggota.id_anggota', $id);
        $builder1->where('anggota.id_anggota', $id);
        $builder2->where('anggota.id_anggota', $id);

        $query = $builder->get();
        $query0 = $builder0->get();
        $query1 = $builder1->get();
        $query2 = $builder2->get();

        $result = $query->getResult();
        $result0 = $query0->getResult();
        $result1 = $query1->getResult();
        $result2 = $query2->getResult();

        $data = [
            'title' => 'Detail Anggota',
            'absen' => $result0,
            'anggota' => $result,
            'misa_khusus' => $result1,
            'outdoor' => $result2,
            'layak' => '',
            'class_hasil' => '',
        ];
        // JIKA KOMIK TDK ADA
        if (empty($data['anggota'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Anggota ' . $id . ' tidak ketemu');
        }

        return view('KelolaData/detail', $data);
    }

    public function viewUpdate($id)
    {
        $dtesting[] = $this->request->getVar('durasi_keanggotaan');
        $dtesting[] = $this->request->getVar('misa_diluar_mingguan');
        $dtesting[] = $this->request->getVar('umur');
        $dtesting[] = $this->request->getVar('keikutsertaan_outdoor_activity');
        $absensi = $this->request->getVar('absen');
        // $dec = $absensi / 100.00;
        $dtesting[] = $absensi;

        $this->builder->where('anggota.id_anggota', $id);
        $this->builder0->where('anggota.id_anggota', $id);
        $this->builder1->where('anggota.id_anggota', $id);
        $this->builder2->where('anggota.id_anggota', $id);

        $this->query = $this->builder->get();
        $this->query0 = $this->builder0->get();
        $this->query1 = $this->builder1->get();
        $this->query2 = $this->builder2->get();

        $this->result = $this->query->getResult();
        $this->result0 = $this->query0->getResult();
        $this->result1 = $this->query1->getResult();
        $this->result2 = $this->query2->getResult();

        if ($dtesting[0] != null && $dtesting[1] != null && $dtesting[2] != null && $dtesting[3] != null) {
            $datasetkapten = new CsvDataset('./dataset/datasetkapten.csv', 5, true);
            $datasetpengurus = new CsvDataset('./dataset/datasetpengurus.csv', 5, true);
            $datasetketua = new CsvDataset('./dataset/datasetketuawakil.csv', 5, true);

            $sampleskapten = $datasetkapten->getSamples();
            $labelskapten = $datasetkapten->getTargets();

            $samplespengurus = $datasetpengurus->getSamples();
            $labelspengurus = $datasetpengurus->getTargets();

            $samplesketua = $datasetketua->getSamples();
            $labelsketua = $datasetketua->getTargets();

            $classifier1 = new NaiveBayesNew();
            $classifier2 = new NaiveBayesNew();
            $classifier3 = new NaiveBayesNew();
            // var_dump($dtesting);

            $classifier1->train($sampleskapten, $labelskapten);
            $classifier2->train($samplespengurus, $labelspengurus);
            $classifier3->train($samplesketua, $labelsketua);

            $hasil_kapten = $classifier1->predict($dtesting);
            $hasil_pengurus = $classifier2->predict($dtesting);
            $hasil_ketua = $classifier3->predict($dtesting);

            $data = [
                'title' => 'Form ubah data',
                'validation' => \Config\Services::validation(),
                'anggota' => $this->AnggotaModel->getAnggota($id),
                'absen' => $this->result0,
                'anggota2' => $this->result,
                'misa_khusus' => $this->result1,
                'outdoor' => $this->result2,
                'layak' => 'kapten',
                'hasil_kapten' => $hasil_kapten,
                'hasil_pengurus' => $hasil_pengurus,
                'hasil_ketua' => $hasil_ketua,
                'durasi' => $dtesting[0],
                'misa' => $dtesting[1],
                'umur' => $dtesting[2],
                'outdoor' => $dtesting[3],
                'absen' => $absensi,
                'mean' => '',
                'std' => '',
                'discrete' => '',
                'prior' => '',
                'posterior' => '',
                'sample' => '',
                'feature' => '',
                'label' => '',
                'gaussian' => '',
                'listsampel' => '',
            ];
        } else {
            $data = [
                'title' => 'FORM',
                'validation' => \Config\Services::validation(),
                'anggota' => $this->AnggotaModel->getAnggota($id),
                'absen' => $this->result0,
                'anggota2' => $this->result,
                'misa_khusus' => $this->result1,
                'outdoor' => $this->result2,
                'layak' => '',
                'hasil_kapten' => '',
                'hasil_pengurus' => '',
                'hasil_ketua' => '',
                'durasi' => '',
                'misa' => '',
                'umur' => '',
                'outdoor' => '',
                'absen' => '',
                'mean' => '',
                'std' => '',
                'discrete' => '',
                'prior' => '',
                'posterior' => '',
                'sample' => '',
                'feature' => '',
                'label' => '',
                'gaussian' => '',
                'listsampel' => '',
            ];
        }
        return view('KelolaData/Edit', $data);
    }

    public function delete($id)
    {
        $anggota = $this->AnggotaModel->find($id);

        $this->AnggotaModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('DataAnggota/');
    }

    public function create()
    {
        $data = [
            'title' => 'Form tambah data',
            'validation' => \Config\Services::validation()
        ];
        return view('KelolaData/TambahDataAnggota', $data);
    }

    public function save()
    {
        $namalengkap = $this->request->getVar('namalengkap');
        $namapanggilan = $this->request->getVar('namapanggilan');
        $status = $this->request->getVar('status');
        $tanggal_masuk = $this->request->getVar('tglmasuk');
        $tanggal_lahir = $this->request->getVar('tgllahir');
        $tempatlahir = $this->request->getVar('tempatlahir');
        $no_telepon = $this->request->getVar('no_telepon');
        $nama_ortu = $this->request->getVar('nama_ortu');
        $no_telepon_ortu = $this->request->getVar('no_telepon_ortu');
        $alamat = $this->request->getVar('alamat');
        $paroki = $this->request->getVar('paroki');
        $wilayah = $this->request->getVar('wilayah');
        $lingkungan = $this->request->getVar('lingkungan');
        $motivasi = $this->request->getVar('motivasi');
        $check_kapten = $this->request->getVar('check_kapten');
        $check_pengurus = $this->request->getVar('check_pengurus');
        $check_ketuawakil = $this->request->getVar('check_ketuawakil');

        // $uname = strtolower(preg_replace('/\s+/', '', $nama));
        $lahir = $this->request->getVar('tgllahir');
        $masuk = $this->request->getVar('tglmasuk');
        // $tahunlahir = date('Y', strtotime($lahir));
        // $bulanlahir = date('m', strtotime($lahir));
        // $tanggallahir = date('d', strtotime($lahir));

        // $username =  $uname . $tahunlahir;
        // $password = 'PA-' . $uname . $tanggallahir . $bulanlahir;

        $tgllahir = strtotime($lahir);
        $tglmasuk = strtotime($masuk);
        $diff = date_diff(date_create($lahir), date_create(date('Y-m-d')))->format('%y');
        // dd($diff);
        if ($tgllahir >= $tglmasuk) {
            session()->setFlashdata('pesan', 'Tanggal lahir harus lebih kecil dari tanggal masuk');
            return redirect()->to('DataAnggota/create')->withInput();
        } else {
            // dd($diff);
            if ($diff >= 9) {
                // dd($namalengkap, $namapanggilan, $status, $tanggal_masuk, $tempatlahir, $tanggal_lahir, $no_telepon, $nama_ortu, $no_telepon_ortu, $alamat, $paroki, $wilayah, $lingkungan, $motivasi, $check_kapten, $check_pengurus, $check_ketuawakil);
                $this->builder5 = $this->db->table("anggota")->select('*');
                $this->query5 = $this->builder5->getWhere([
                    'nama_lengkap' => $namalengkap,
                    'nama_panggilan' => $namapanggilan,
                    'tempat_lahir' => $tempatlahir,
                    'tanggal_lahir' => $tanggal_lahir,
                ]);
                $this->result5 = $this->query5->getResult();
                if (count($this->result5) == 0) { //data blm ada di db
                    $query6 = $this->builder5->getWhere([
                        'nama_panggilan' => $namapanggilan,
                    ]);
                    $result6 = $query6->getResult();
                    if (count($result6) == 0) { //di db blm ada anggota dgn nama panggilan yg sama
                        if ($status == "Anggota") {
                            if ($check_kapten == "kapten_checked") {
                                $this->AnggotaModel->save([
                                    'nama_lengkap' => $namalengkap,
                                    'nama_panggilan' => $namapanggilan,
                                    // 'username' => $username,
                                    'status' => $status,
                                    'tanggal_masuk' => $tanggal_masuk,
                                    'tempat_lahir' => $tempatlahir,
                                    'tanggal_lahir' => $tanggal_lahir,
                                    'no_telepon' => $no_telepon,
                                    'nama_ortu' => $nama_ortu,
                                    'no_telepon_ortu' => $no_telepon_ortu,
                                    'alamat' => $alamat,
                                    'paroki' => $paroki,
                                    'wilayah' => $wilayah,
                                    'lingkungan' => $lingkungan,
                                    'motivasi' => $motivasi,
                                    'kandidat_kapten' => 'yes'
                                ]);
                            } else if ($check_pengurus == "pengurus_checked") {
                                $this->AnggotaModel->save([
                                    'nama_lengkap' => $namalengkap,
                                    'nama_panggilan' => $namapanggilan,
                                    // 'username' => $username,
                                    'status' => $status,
                                    'tanggal_masuk' => $tanggal_masuk,
                                    'tempat_lahir' => $tempatlahir,
                                    'tanggal_lahir' => $tanggal_lahir,
                                    'no_telepon' => $no_telepon,
                                    'nama_ortu' => $nama_ortu,
                                    'no_telepon_ortu' => $no_telepon_ortu,
                                    'alamat' => $alamat,
                                    'paroki' => $paroki,
                                    'wilayah' => $wilayah,
                                    'lingkungan' => $lingkungan,
                                    'motivasi' => $motivasi,
                                    'kandidat_pengurus' => 'yes',
                                    'kandidat_kapten' => 'yes'
                                ]);
                            } elseif ($check_ketuawakil == "ketuawakil_checked") {
                                $this->AnggotaModel->save([
                                    'nama_lengkap' => $namalengkap,
                                    'nama_panggilan' => $namapanggilan,
                                    // 'username' => $username,
                                    'status' => $status,
                                    'tanggal_masuk' => $tanggal_masuk,
                                    'tempat_lahir' => $tempatlahir,
                                    'tanggal_lahir' => $tanggal_lahir,
                                    'no_telepon' => $no_telepon,
                                    'nama_ortu' => $nama_ortu,
                                    'no_telepon_ortu' => $no_telepon_ortu,
                                    'alamat' => $alamat,
                                    'paroki' => $paroki,
                                    'wilayah' => $wilayah,
                                    'lingkungan' => $lingkungan,
                                    'motivasi' => $motivasi,
                                    'kandidat_ketua' => 'yes',
                                    'kandidat_pengurus' => 'yes',
                                    'kandidat_kapten' => 'yes'
                                ]);
                            } else {
                                $this->AnggotaModel->save([
                                    'nama_lengkap' => $namalengkap,
                                    'nama_panggilan' => $namapanggilan,
                                    // 'username' => $username,
                                    'status' => $status,
                                    'tanggal_masuk' => $tanggal_masuk,
                                    'tempat_lahir' => $tempatlahir,
                                    'tanggal_lahir' => $tanggal_lahir,
                                    'no_telepon' => $no_telepon,
                                    'nama_ortu' => $nama_ortu,
                                    'no_telepon_ortu' => $no_telepon_ortu,
                                    'alamat' => $alamat,
                                    'paroki' => $paroki,
                                    'wilayah' => $wilayah,
                                    'lingkungan' => $lingkungan,
                                    'motivasi' => $motivasi
                                ]);
                            }
                        } else if ($status == 'Kapten') {
                            $this->AnggotaModel->save([
                                'nama_lengkap' => $namalengkap,
                                'nama_panggilan' => $namapanggilan,
                                // 'username' => $username,
                                'status' => $status,
                                'tanggal_masuk' => $tanggal_masuk,
                                'tempat_lahir' => $tempatlahir,
                                'tanggal_lahir' => $tanggal_lahir,
                                'no_telepon' => $no_telepon,
                                'nama_ortu' => $nama_ortu,
                                'no_telepon_ortu' => $no_telepon_ortu,
                                'alamat' => $alamat,
                                'paroki' => $paroki,
                                'wilayah' => $wilayah,
                                'lingkungan' => $lingkungan,
                                'motivasi' => $motivasi,
                                'kandidat_kapten' => 'yes'
                            ]);
                        } else if ($status == 'Pengurus') {
                            $this->AnggotaModel->save([
                                'nama_lengkap' => $namalengkap,
                                'nama_panggilan' => $namapanggilan,
                                // 'username' => $username,
                                'status' => $status,
                                'tanggal_masuk' => $tanggal_masuk,
                                'tempat_lahir' => $tempatlahir,
                                'tanggal_lahir' => $tanggal_lahir,
                                'no_telepon' => $no_telepon,
                                'nama_ortu' => $nama_ortu,
                                'no_telepon_ortu' => $no_telepon_ortu,
                                'alamat' => $alamat,
                                'paroki' => $paroki,
                                'wilayah' => $wilayah,
                                'lingkungan' => $lingkungan,
                                'motivasi' => $motivasi,
                                'kandidat_pengurus' => 'yes',
                                'kandidat_kapten' => 'yes'
                            ]);
                        } else if ($status == 'WakilKetua') {
                            $this->builder3 = $this->db->table("anggota")->select('*');
                            $this->query3 = $this->builder3->getWhere(['status' => $status]);;
                            $this->result3 = $this->query3->getResult();

                            if (count($this->result3) == 0) { //kalo nggak ketemu, save 
                                $this->AnggotaModel->save([
                                    'nama_lengkap' => $namalengkap,
                                    'nama_panggilan' => $namapanggilan,
                                    // 'username' => $username,
                                    'status' => $status,
                                    'tanggal_masuk' => $tanggal_masuk,
                                    'tempat_lahir' => $tempatlahir,
                                    'tanggal_lahir' => $tanggal_lahir,
                                    'no_telepon' => $no_telepon,
                                    'nama_ortu' => $nama_ortu,
                                    'no_telepon_ortu' => $no_telepon_ortu,
                                    'alamat' => $alamat,
                                    'paroki' => $paroki,
                                    'wilayah' => $wilayah,
                                    'lingkungan' => $lingkungan,
                                    'motivasi' => $motivasi,
                                    'kandidat_ketua' => 'yes',
                                    'kandidat_pengurus' => 'yes',
                                    'kandidat_kapten' => 'yes'
                                ]);
                            } else {
                                session()->setFlashdata('pesan', 'Wakil Ketua sudah ada');
                                return redirect()->to('DataAnggota/create')->withInput();
                            }
                        } else if ($status == 'Ketua') {
                            $this->builder3 = $this->db->table("anggota")->select('*');
                            $this->query3 = $this->builder3->getWhere(['status' => $status]);;
                            $this->result3 = $this->query3->getResult();

                            if (count($this->result3) == 0) { //kalo nggak ketemu, save 
                                $this->AnggotaModel->save([
                                    'nama_lengkap' => $namalengkap,
                                    'nama_panggilan' => $namapanggilan,
                                    // 'username' => $username,
                                    'status' => $status,
                                    'tanggal_masuk' => $tanggal_masuk,
                                    'tempat_lahir' => $tempatlahir,
                                    'tanggal_lahir' => $tanggal_lahir,
                                    'no_telepon' => $no_telepon,
                                    'nama_ortu' => $nama_ortu,
                                    'no_telepon_ortu' => $no_telepon_ortu,
                                    'alamat' => $alamat,
                                    'paroki' => $paroki,
                                    'wilayah' => $wilayah,
                                    'lingkungan' => $lingkungan,
                                    'motivasi' => $motivasi,
                                    'kandidat_ketua' => 'yes',
                                    'kandidat_pengurus' => 'yes',
                                    'kandidat_kapten' => 'yes'
                                ]);
                            } else {
                                session()->setFlashdata('pesan', 'Ketua sudah ada');
                                return redirect()->to('DataAnggota/create')->withInput();
                            }
                        } else if ($status == 'Pendamping') {
                            $this->AnggotaModel->save([
                                'nama_lengkap' => $namalengkap,
                                'nama_panggilan' => $namapanggilan,
                                // 'username' => $username,
                                'status' => $status,
                                'tanggal_masuk' => $tanggal_masuk,
                                'tempat_lahir' => $tempatlahir,
                                'tanggal_lahir' => $tanggal_lahir,
                                'no_telepon' => $no_telepon,
                                'nama_ortu' => $nama_ortu,
                                'no_telepon_ortu' => $no_telepon_ortu,
                                'alamat' => $alamat,
                                'paroki' => $paroki,
                                'wilayah' => $wilayah,
                                'lingkungan' => $lingkungan,
                                'motivasi' => $motivasi,
                                'kandidat_ketua' => 'yes',
                                'kandidat_pengurus' => 'yes',
                                'kandidat_kapten' => 'yes'
                            ]);
                        }
                    } else {
                        session()->setFlashdata('pesan', 'Anggota dengan nama panggilan ' . $namapanggilan . ' sudah ada');
                        return redirect()->to('DataAnggota/create')->withInput();
                    }
                } else {
                    session()->setFlashdata('pesan', 'Anggota dengan nama ' . $namalengkap . ' sudah ada');
                    return redirect()->to('DataAnggota/create')->withInput();
                }
            } else {
                session()->setFlashdata('pesan', 'Belum memenuhi usia minimum untuk menjadi Putra Altar');
                return redirect()->to('DataAnggota/create')->withInput();
            }
        }
        // d($nama);
        // d($username);
        // d($password);

        // d($this->request->getVar('editnama'));
        // d($this->request->getVar('editstatus'));
        // d($this->request->getVar('edittglmasuk'));
        // d($this->request->getVar('edittgllahir'));

        // d($this->request->getVar('layakketua'));
        // d($this->request->getVar('layakkapten'));
        // d($this->request->getVar('layakpengurus'));

        // ]);
        // $data = [
        //     'nama' => $this->request->getVar('editnama'),
        //     // 'status' => $this->request->getVar('editstatus'),
        //     'tanggal_masuk' => $this->request->getVar('edittglmasuk'),
        //     'tanggal_lahir' => $this->request->getVar('edittgllahir'),
        //     'kandidat_kapten' => $this->request->getVar('layakkapten'),
        //     'kandidat_pengurus' => $this->request->getVar('layakpengurus'),
        //     'kandidat_ketua' => $this->request->getVar('layakketua'),
        // ];

        // $this->AnggotaModel->update($id, $data);
        // session()->setFlashdata('pesan', 'Data berhasil diubah');

        return redirect()->to('DataAnggota/');
    }

    public function update($id)
    {
        $namalengkap = $this->request->getVar('editnamalengkap');
        $namapanggilan = $this->request->getVar('editnama');
        $status = $this->request->getVar('editstatus');
        $tanggal_masuk = $this->request->getVar('edittglmasuk');
        $tanggal_lahir = $this->request->getVar('edittgllahir');
        $tempatlahir = $this->request->getVar('edittempatlahir');
        $no_telepon = $this->request->getVar('editno_telepon');
        $nama_ortu = $this->request->getVar('editnama_ortu');
        $no_telepon_ortu = $this->request->getVar('editno_telepon_ortu');
        $alamat = $this->request->getVar('editalamat');
        $paroki = $this->request->getVar('editparoki');
        $wilayah = $this->request->getVar('editwilayah');
        $lingkungan = $this->request->getVar('editlingkungan');
        $motivasi = $this->request->getVar('editmotivasi');
        // dd($no_telepon, $no_telepon_ortu);
        $lahir = $this->request->getVar('edittgllahir');
        $masuk = $this->request->getVar('edittglmasuk');

        $tgllahir = strtotime($lahir);
        $tglmasuk = strtotime($masuk);
        $diff = date_diff(date_create($lahir), date_create(date('Y-m-d')))->format('%y');
        // dd($diff);

        $dtesting[] = $this->request->getVar('durasi_keanggotaan');
        $dtesting[] = $this->request->getVar('misa_diluar_mingguan');
        $dtesting[] = $this->request->getVar('umur');
        $dtesting[] = $this->request->getVar('keikutsertaan_outdoor_activity');
        $absensi = $this->request->getVar('absen');
        $dec = $absensi / 100.00;
        $dtesting[] = $dec;

        $this->builder->where('anggota.id_anggota', $id);
        $this->builder0->where('anggota.id_anggota', $id);
        $this->builder1->where('anggota.id_anggota', $id);
        $this->builder2->where('anggota.id_anggota', $id);

        $this->query = $this->builder->get();
        $this->query0 = $this->builder0->get();
        $this->query1 = $this->builder1->get();
        $this->query2 = $this->builder2->get();

        $this->result = $this->query->getResult();
        $this->result0 = $this->query0->getResult();
        $this->result1 = $this->query1->getResult();
        $this->result2 = $this->query2->getResult();

        if ($dtesting[0] != null && $dtesting[1] != null && $dtesting[2] != null && $dtesting[3] != null) {
            $datasetkapten = new CsvDataset('./dataset/datasetkapten.csv', 5, true);
            $datasetpengurus = new CsvDataset('./dataset/datasetpengurus.csv', 5, true);
            $datasetketua = new CsvDataset('./dataset/datasetketuawakil.csv', 5, true);

            $sampleskapten = $datasetkapten->getSamples();
            $labelskapten = $datasetkapten->getTargets();

            $samplespengurus = $datasetpengurus->getSamples();
            $labelspengurus = $datasetpengurus->getTargets();

            $samplesketua = $datasetketua->getSamples();
            $labelsketua = $datasetketua->getTargets();

            $classifier1 = new NaiveBayesNew();
            $classifier2 = new NaiveBayesNew();
            $classifier3 = new NaiveBayesNew();
            // var_dump($dtesting);

            $classifier1->train($sampleskapten, $labelskapten);
            $classifier2->train($samplespengurus, $labelspengurus);
            $classifier3->train($samplesketua, $labelsketua);

            $hasil_kapten = $classifier1->predict($dtesting);
            $hasil_pengurus = $classifier2->predict($dtesting);
            $hasil_ketua = $classifier3->predict($dtesting);

            $data = [
                'title' => 'Form ubah data',
                'validation' => \Config\Services::validation(),
                'anggota' => $this->AnggotaModel->getAnggota($id),
                'absen' => $this->result0,
                'anggota2' => $this->result,
                'misa_khusus' => $this->result1,
                'outdoor' => $this->result2,
                'layak' => 'kapten',
                'hasil_kapten' => $hasil_kapten,
                'hasil_pengurus' => $hasil_pengurus,
                'hasil_ketua' => $hasil_ketua,
                'durasi' => $dtesting[0],
                'misa' => $dtesting[1],
                'umur' => $dtesting[2],
                'outdoor' => $dtesting[3],
                'absen' => $absensi,
                'mean' => '',
                'std' => '',
                'discrete' => '',
                'prior' => '',
                'posterior' => '',
                'sample' => '',
                'feature' => '',
                'label' => '',
                'gaussian' => '',
                'listsampel' => '',
            ];
        } else {
            $data = [
                'title' => 'FORM',
                'validation' => \Config\Services::validation(),
                'anggota' => $this->AnggotaModel->getAnggota($id),
                'absen' => $this->result0,
                'anggota2' => $this->result,
                'misa_khusus' => $this->result1,
                'outdoor' => $this->result2,
                'layak' => '',
                'hasil_kapten' => '',
                'hasil_pengurus' => '',
                'hasil_ketua' => '',
                'mean' => '',
                'std' => '',
                'discrete' => '',
                'prior' => '',
                'posterior' => '',
                'sample' => '',
                'feature' => '',
                'label' => '',
                'gaussian' => '',
                'listsampel' => ''
            ];
        }

        if ($tgllahir >= $tglmasuk) {
            // dd($tgllahir, $tglmasuk);
            session()->setFlashdata('pesan', 'Tanggal lahir harus lebih kecil dari tanggal masuk');
            return view('KelolaData/Edit', $data);
            // return redirect()->to('DataAnggota/viewUpdate/' . $id);
        } else {
            // dd($diff);
            if ($diff >= 9) {
                // dd($namalengkap, $namapanggilan, $status, $tanggal_masuk, $tempatlahir, $tanggal_lahir, $no_telepon, $nama_ortu, $no_telepon_ortu, $alamat, $paroki, $wilayah, $lingkungan, $motivasi);

                $this->AnggotaModel->save([
                    'id_anggota' => $id,
                    'nama_lengkap' => $namalengkap,
                    'nama_panggilan' => $namapanggilan,
                    'status' => $status,
                    'tanggal_masuk' => $tanggal_masuk,
                    'tempat_lahir' => $tempatlahir,
                    'tanggal_lahir' => $tanggal_lahir,
                    'no_telepon' => $no_telepon,
                    'nama_ortu' => $nama_ortu,
                    'no_telepon_ortu' => $no_telepon_ortu,
                    'alamat' => $alamat,
                    'paroki' => $paroki,
                    'wilayah' => $wilayah,
                    'lingkungan' => $lingkungan,
                    'motivasi' => $motivasi,
                    'kandidat_kapten' => $this->request->getVar('layakkapten'),
                    'kandidat_pengurus' => $this->request->getVar('layakpengurus'),
                    'kandidat_ketua' => $this->request->getVar('layakketua'),
                ]);
            } else {
                session()->setFlashdata('pesan', 'Belum memenuhi usia minimum untuk menjadi Putra Altar');
                return view('KelolaData/Edit', $data);
                // return redirect()->to('DataAnggota/viewUpdate/' . $id);
            }
        }

        // d($this->request->getVar('editnama'));
        // d($this->request->getVar('editstatus'));
        // d($this->request->getVar('edittglmasuk'));
        // d($this->request->getVar('edittgllahir'));

        // d($this->request->getVar('layakketua'));
        // d($this->request->getVar('layakkapten'));
        // d($this->request->getVar('layakpengurus'));

        // ]);
        // $data = [
        //     'nama' => $this->request->getVar('editnama'),
        //     // 'status' => $this->request->getVar('editstatus'),
        //     'tanggal_masuk' => $this->request->getVar('edittglmasuk'),
        //     'tanggal_lahir' => $this->request->getVar('edittgllahir'),
        //     'kandidat_kapten' => $this->request->getVar('layakkapten'),
        //     'kandidat_pengurus' => $this->request->getVar('layakpengurus'),
        //     'kandidat_ketua' => $this->request->getVar('layakketua'),
        // ];

        // $this->AnggotaModel->update($id, $data);
        session()->setFlashdata('pesan', 'Data berhasil diubah');

        return redirect()->to('DataAnggota/');
    }

    public function index()
    {
        // $anggota = $this->AnggotaModel->select('anggota.*, detail_kelompok.id_kelompok')->join('detail_kelompok', 'anggota.id_anggota=detail_kelompok.id_anggota', 'left');
        // $anggota = $this->AnggotaModel->select('anggota.*, kelompok.nama_kelompok AS nama_kelompok')->join('kelompok', 'detail_kelompok.id_kelompok=kelompok.id_kelompok', 'left')->distinct()->findAll();

        $anggota = $this->AnggotaModel->select('anggota.*')->join('detail_kelompok', 'anggota.id_anggota=detail_kelompok.id_anggota', 'left');
        $anggota = $this->AnggotaModel->select('anggota.*, kelompok.nama_kelompok AS nama_kelompok')->join('kelompok', 'detail_kelompok.id_kelompok=kelompok.id_kelompok', 'left')->distinct()->findAll();

        $builder = $this->db->table("anggota");
        $builder->select('*,anggota.id_anggota AS kode_anggota');
        $builder->join('detail_kelompok', 'anggota.id_anggota=detail_kelompok.id_anggota', 'left');
        $builder->join('kelompok', 'detail_kelompok.id_kelompok=kelompok.id_kelompok', 'left');
        // $builder->join('absen', 'anggota.id_anggota=absen.id_anggota', 'left');
        // $builder->join('petugas_misa_khusus', 'anggota.id_anggota=petugas_misa_khusus.id_petugas', 'left');
        // $builder->join('peserta_outdoor', 'anggota.id_anggota=peserta_outdoor.id_peserta', 'left');

        $builder->groupBy('nama_lengkap');
        $builder->orderBy('nama_panggilan', 'ASC');
        $query = $builder->get();

        // $builder4 = $this->db->table("absen");
        // $builder4->select('*');
        // $builder4->orderBy('tanggal', 'DESC');
        // $query4 = $builder4->get();

        // $dataset->orderBy('created_at', 'DESC')->first();

        $result = $query->getResult();
        // $result4 = $query4->getResult();

        $data = [
            'title' => 'Daftar komik',
            'anggota' => $result,
            // 'list_absen' => $result4
        ];

        //konek manual
        // $db = \Config\Database::connect();
        // $komik = $db->query("SELECT * FROM komik");
        // foreach ($komik->getResultArray() as $row) {
        //     d($row);
        // }

        return view('KelolaData/DataAnggota', $data);
    }
}
