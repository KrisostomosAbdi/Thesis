<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
use App\Models\KelompokModel;
use App\Models\DetailKelompok;
use App\Models\AbsenModel;
use App\Models\RekapModel;
use App\Models\KegiatanOutdoorModel;
use App\Models\PesertaOutdoorModel;

use \DateTime;
use Phpml\Classification\NaiveBayes;
use Phpml\Classification\NaiveBayesNew;
use Phpml\Dataset\CsvDataset;
use Phpml\Metric\Accuracy;
use Phpml\Metric\ConfusionMatrix;
use Phpml\CrossValidation\StratifiedRandomSplit;
use Phpml\CrossValidation\RandomSplit;
use Phpml\Metric\ClassificationReport;

class NaiveBayesController extends BaseController
{
    protected $AnggotaModel, $KelompokModel, $DetailKelompokModel, $AbsenModel, $KegiatanOutdoorModel, $PesertaOutdoorModel, $RekapModel, $db;


    protected $dtesting = [];
    protected $listlabels = [];
    protected $listlabels2 = [];
    protected $labels = [];

    protected $builder, $builder0, $builder1, $builder2, $builder3, $query, $query0, $query1, $query2, $query3, $query4, $result, $result0, $result1, $result2, $result3, $result4;

    public function __construct()
    {
        $this->AnggotaModel = new AnggotaModel();
        $this->KelompokModel = new KelompokModel();
        $this->DetailKelompokModel = new DetailKelompok();
        $this->AbsenModel = new AbsenModel();
        $this->RekapModel = new RekapModel();
        $this->KegiatanOutdoorModel = new KegiatanOutdoorModel();
        $this->PesertaOutdoorModel = new PesertaOutdoorModel();
        $this->db = db_connect();

        $this->listlabels = ['Durasi Keanggotaan', 'Misa diluar Mingguan', 'Umur', 'Keikutsertaan Kegiatan Outdoor', 'Absen'];
        $this->listlabels2 = ['Durasi Keanggotaan', 'Umur', 'Keikutsertaan Kegiatan Outdoor', 'Absen', 'Misa diluar Mingguan'];

        $this->labels = ['yes', 'no'];

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

    public function viewsimple()
    {
        $anggota = $this->AnggotaModel->findAll();
        $data = [
            'anggota' => $anggota,
            'durasi' => '',
            'misa' => '',
            'umur' => '',
            'outdoor' => '',
            'absen' => '',
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
            'listsampel' => '',
            'dataanggota' => '',
            'id' => ''
        ];
        return view('NaiveBayesView/PrediksiSimple', $data);
    }

    public function getId()
    {
        if ($this->request->isAJAX()) {
            $kode = $this->request->getGet('kode');

            $db = $this->AnggotaModel->where('id_anggota', $kode)->findAll();

            $this->builder->where('anggota.id_anggota', $kode);
            $this->builder0->where('anggota.id_anggota', $kode);
            $this->builder1->where('anggota.id_anggota', $kode);
            $this->builder2->where('anggota.id_anggota', $kode);

            $this->query = $this->builder->get();
            $this->query0 = $this->builder0->get();
            $this->query1 = $this->builder1->get();
            $this->query2 = $this->builder2->get();

            $this->result = $this->query->getResult();
            $this->result0 = $this->query0->getResult();
            $this->result1 = $this->query1->getResult();
            $this->result2 = $this->query2->getResult();
            $absen = $this->result0;
            $anggota = $this->result;
            $misa_khusus = $this->result1;
            $outdoor = $this->result2;
            // d($absen);
            if ($db == NULL) {
                $data = [];
            } else {
                $this->db = db_connect();

                //ABSEN
                if (empty($absen)) {
                    $jml_hadir = 0;
                } else {
                    $jml_hadir = $this->db->table('absen')->like('absen', 'HADIR')->where('id_anggota', $db[0]['id_anggota'])->countAllResults();
                }
                // $jml_minggu = $this->db->table('absen')->like('tanggal')->distinct()->groupBy('tanggal')->countAllResults();
                $Time = new DateTime('now');
                $DBTime = DateTime::createFromFormat('Y-m-d', $db[0]['tanggal_masuk']);
                $diff2 = $Time->diff($DBTime);
                $jmlMinggu = (floor($Time->diff($DBTime)->days / 7)) + 1;
                // if ($jml_hadir == 0) {
                //     $decimal = 0;
                // } else {
                //     $decimal = $jml_bagus / $jml_hadir;
                // }

                $builder4 = $this->db->table("absen");
                $builder4->select('*')->like('id_anggota', $db[0]['id_anggota']);
                $builder4->orderBy('tanggal', 'DESC');
                $query4 = $builder4->get();
                $result4 = $query4->getFirstRow();

                $jmlMingguInactive = 0;
                if ($absen[0]->nama_kelompok != null) {
                    $decimal = $jml_hadir / $jmlMinggu;
                } else {
                    if ($result4 != null) {
                        $DBTimeInactive = DateTime::createFromFormat('Y-m-d', $result4->tanggal);
                        $DBTimeMasuk = DateTime::createFromFormat('Y-m-d', $db[0]['tanggal_masuk']);

                        $jmlMingguInactive = (floor($DBTimeInactive->diff($DBTimeMasuk)->days / 7)) + 1;
                        $decimal = $jml_hadir / $jmlMingguInactive;
                    } else {
                        $decimal = 0;
                    }
                }
                // $decimal = $jml_hadir / $jmlMinggu;

                if ($decimal > 1) {
                    $decimal = 1;
                }
                $percent = round((float)$decimal * 100);

                //MISA KHUSUS
                $jml_tugas_misabesar = $this->db->table('petugas_misa_khusus')->like('id_petugas', $db[0]['id_anggota'])->where('id_petugas', $db[0]['id_anggota'])->countAllResults();

                //OUTDOOR ACTIVITY
                $jml_kegiatan = $this->db->table('peserta_outdoor')->like('id_peserta', $db[0]['id_anggota'])->where('id_peserta', $db[0]['id_anggota'])->countAllResults();


                $durasi_anggota = date_diff(date_create($db[0]['tanggal_masuk']), date_create(date('Y-m-d')))->format('%y');

                $umur = date_diff(date_create($db[0]['tanggal_lahir']), date_create(date('Y-m-d')))->format('%y');
                // $data = [$db];
            }
            $data = [
                'durasi' => $durasi_anggota,
                'umur' => $umur,
                'absen' => $percent,
                'misa_khusus' => $jml_tugas_misabesar,
                'outdoor' => $jml_kegiatan,
                'id' => $kode
            ];
            return $this->response->setJSON($data);
        }
    }
    // public function simpleproses($id)
    // {
    //     # code...
    // }

    public function prediksi()
    {
        $anggota = $this->AnggotaModel->findAll();
        $id_anggota = $this->request->getVar('idanggota');
        $dataanggota = $this->AnggotaModel->where('id_anggota', $id_anggota)->findAll();

        $dtesting[] = $this->request->getVar('durasi_keanggotaan');
        $dtesting[] = $this->request->getVar('misa_diluar_mingguan');
        $dtesting[] = $this->request->getVar('umur');
        $dtesting[] = $this->request->getVar('keikutsertaan_outdoor_activity');
        $absensi = $this->request->getVar('absen');
        // $dec = $absensi / 100.00;
        $dtesting[] = $absensi;

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

            $posteriorkapten = $classifier1->postprob;
            $posteriorpengurus = $classifier2->postprob;
            $posteriorketua = $classifier3->postprob;
            // dd($posteriorkapten, $posteriorpengurus, $posteriorketua);
            if ($id_anggota != null) {
                // $this->AnggotaModel->save([
                //     'id_anggota' => $id_anggota,
                //     'kandidat_kapten' => $hasil_kapten,
                //     'kandidat_pengurus' => $hasil_pengurus,
                //     'kandidat_ketua' => $hasil_ketua,
                // ]);

                $role = array("kapten", "pengurus", "ketua");
                foreach ($role as $value) {
                    $this->builder3 = $this->db->table("rekap_prediksi")->select('*');
                    $this->query3 = $this->builder3->getWhere(['rekap_prediksi.id_anggota' => $id_anggota, 'rekap_prediksi.tipe_dataset' => $value]);
                    $this->result3 = $this->query3->getResult();

                    if ($value == "kapten") {
                        if (count($this->result3) == 0) { //kalo nggak ketemu, save 
                            $this->RekapModel->save([
                                'id_anggota' => $id_anggota,
                                'post_yes' => $posteriorkapten['yes'],
                                'post_no' => $posteriorkapten['no'],
                                'tipe_dataset' => $value,
                            ]);
                        } else {
                            $this->RekapModel->save([
                                'id_data' => $this->result3[0]->id_data,
                                'id_anggota' => $id_anggota,
                                'post_yes' => $posteriorkapten['yes'],
                                'post_no' => $posteriorkapten['no'],
                                'tipe_dataset' => $value,
                            ]);
                        }
                    } else if ($value == "pengurus") {
                        if (count($this->result3) == 0) { //kalo nggak ketemu, save 
                            $this->RekapModel->save([
                                'id_anggota' => $id_anggota,
                                'post_yes' => $posteriorpengurus['yes'],
                                'post_no' => $posteriorpengurus['no'],
                                'tipe_dataset' => $value,
                            ]);
                        } else {
                            $this->RekapModel->save([
                                'id_data' => $this->result3[0]->id_data,
                                'id_anggota' => $id_anggota,
                                'post_yes' => $posteriorpengurus['yes'],
                                'post_no' => $posteriorpengurus['no'],
                                'tipe_dataset' => $value,
                            ]);
                        }
                    } else if ($value == "ketua") {
                        if (count($this->result3) == 0) { //kalo nggak ketemu, save 
                            $this->RekapModel->save([
                                'id_anggota' => $id_anggota,
                                'post_yes' => $posteriorketua['yes'],
                                'post_no' => $posteriorketua['no'],
                                'tipe_dataset' => $value,
                            ]);
                        } else {
                            $this->RekapModel->save([
                                'id_data' => $this->result3[0]->id_data,
                                'id_anggota' => $id_anggota,
                                'post_yes' => $posteriorketua['yes'],
                                'post_no' => $posteriorketua['no'],
                                'tipe_dataset' => $value,
                            ]);
                        }
                    }
                }
            }

            $data = [
                'title' => 'Form ubah data',
                'validation' => \Config\Services::validation(),
                'anggota' => $anggota,
                'hasil_kapten' => $hasil_kapten,
                'hasil_pengurus' => $hasil_pengurus,
                'hasil_ketua' => $hasil_ketua,
                'durasi' => $dtesting[0],
                'misa' => $dtesting[1],
                'umur' => $dtesting[2],
                'outdoor' => $dtesting[3],
                'absen' => $absensi,
                'dataanggota' => $dataanggota,
                'id' => $id_anggota,
                'posteriorkapten' => $posteriorkapten,
                'posteriorpengurus' => $posteriorpengurus,
                'posteriorketua' => $posteriorketua
            ];
        } else {
            $data = [
                'title' => 'FORM',
                'validation' => \Config\Services::validation(),
                'anggota' => $anggota,
                'hasil_kapten' => '',
                'hasil_pengurus' => '',
                'hasil_ketua' => '',
                'durasi' => '',
                'misa' => '',
                'umur' => '',
                'outdoor' => '',
                'absen' => '',
                'dataanggota' => '',
                'id' => ''
            ];
        }
        return view('NaiveBayesView/PrediksiSimple', $data);
        // redirect()->to('NaiveBayesController/viewsimple');
    }

    public function viewadvanced()
    {
        $anggota = $this->AnggotaModel->findAll();
        $data = [
            'anggota' => $anggota,
            'durasi' => '',
            'misa' => '',
            'umur' => '',
            'outdoor' => '',
            'absen' => '',
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
            'listsampel' => '',
            'dataanggota' => '',
            'id' => ''
        ];
        return view('NaiveBayesView/PrediksiAdvanced', $data);
    }

    public function viewadvanceduser()
    {
        $anggota = $this->AnggotaModel->findAll();
        $data = [
            'anggota' => $anggota,
            'durasi' => '',
            'misa' => '',
            'umur' => '',
            'outdoor' => '',
            'absen' => '',
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
            'listsampel' => '',
            'dataanggota' => '',
            'id' => ''
        ];
        return view('NaiveBayesView/PrediksiAdvancedUser', $data);
    }

    public function prediksiAdvancedKapten($page)
    {
        $id_anggota = $this->request->getVar('idanggota');
        $dataanggota = $this->AnggotaModel->where('id_anggota', $id_anggota)->findAll();
        $anggota = $this->AnggotaModel->findAll();


        $dtesting[] = $this->request->getVar('durasi_keanggotaan');
        $dtesting[] = $this->request->getVar('misa_diluar_mingguan');
        $dtesting[] = $this->request->getVar('umur');
        $dtesting[] = $this->request->getVar('keikutsertaan_outdoor_activity');
        $absensi = $this->request->getVar('absen');
        // $dec = $absensi / 100.00;
        $dtesting[] = $absensi;

        if ($dtesting[0] != null && $dtesting[1] != null && $dtesting[2] != null && $dtesting[3] != null) {
            $datasetkapten = new CsvDataset('./dataset/datasetkapten.csv', 5, true);

            $sampleskapten = $datasetkapten->getSamples();
            $labelskapten = $datasetkapten->getTargets();

            $classifier1 = new NaiveBayesNew();
            // var_dump($dtesting);

            $classifier1->train($sampleskapten, $labelskapten);

            $hasil_kapten = $classifier1->predict($dtesting);

            // Calculate class frequency in the training data
            $classes = array_unique($labelskapten);
            $classCounts = array_count_values($labelskapten);

            // Calculate prior probabilities for each class
            $priors = [];
            $totalSamples = count($labelskapten);
            foreach ($classCounts as $class => $count) {
                $priors[$class] = $count / $totalSamples;
            }

            // foreach ($priors as $class => $probability) {
            //     echo "Prior probability of class $class: $probability\n <br>";
            // }

            $mean = $classifier1->mean;
            $stddev = $classifier1->std;
            $discrete = $classifier1->labels;
            $priorprob = $classifier1->p;
            $sample = $classifier1->sampleCount;
            $feature = $classifier1->featureCount;
            $gaussian = $classifier1->normaldist;
            $posterior = $classifier1->postprob;
            $label = $classifier1->labels;
            $listsampel = $classifier1->listsampel;
            $listlabel = $this->listlabels;
            $listlabel2 = $this->listlabels2;

            // $f_pointer = fopen("./dataset/anggota.csv", "r"); // file pointer

            // $first_line = "T";

            // while (!feof($f_pointer)) {
            //     $ar = fgetcsv($f_pointer);
            //     if ($first_line <> 'T') {
            //         echo print_r($ar); // print the array 

            //         echo "<br>";
            //     }
            //     $first_line = 'F';
            // }
            // Closing the file
            // fclose($file);

            $datacsv = array_map('str_getcsv', file('./dataset/datasetkapten.csv'));
            // echo '<pre>';
            array_shift($datacsv);
            // $jumlah = count($datacsv);
            // for ($i = 0; $i < $jumlah; $i++) {
            //     unset($datacsv[$i][4]);
            // }
            // print_r($datacsv);
            // echo '</pre>';
            if ($id_anggota != null) {
                $this->AnggotaModel->save([
                    'id_anggota' => $id_anggota,
                    'kandidat_kapten' => $hasil_kapten,
                ]);

                $this->builder3 = $this->db->table("rekap_prediksi")->select('*');
                $this->query3 = $this->builder3->getWhere(['rekap_prediksi.id_anggota' => $id_anggota, 'rekap_prediksi.tipe_dataset' => 'kapten']);
                $this->result3 = $this->query3->getResult();
                // dd($this->result3);

                if (count($this->result3) == 0) { //kalo nggak ketemu, save 
                    $this->RekapModel->save([
                        'id_anggota' => $id_anggota,
                        'post_yes' => $posterior['yes'],
                        'post_no' => $posterior['no'],
                        'tipe_dataset' => 'kapten',
                    ]);

                    // echo 'tidak ada';
                    // echo $namas . '<br>';
                } else {
                    $this->RekapModel->save([
                        'id_data' => $this->result3[0]->id_data,
                        'id_anggota' => $id_anggota,
                        'post_yes' => $posterior['yes'],
                        'post_no' => $posterior['no'],
                        'tipe_dataset' => 'kapten',
                    ]);
                }
            }

            $data = [
                'title' => 'Form ubah data',
                'validation' => \Config\Services::validation(),
                'anggota' => $anggota,
                'hasil_kapten' => $hasil_kapten,
                'hasil_pengurus' => '',
                'hasil_ketua' => '',
                'durasi' => $dtesting[0],
                'misa' => $dtesting[1],
                'umur' => $dtesting[2],
                'outdoor' => $dtesting[3],
                'absen' => $absensi,
                'mean' => $mean,
                'std' => $stddev,
                'discrete' => $discrete,
                'prior' => $priorprob,
                'posterior' => $posterior,
                'sample' => $sample,
                'feature' => $feature,
                'label' => $this->labels,
                'gaussian' => $gaussian,
                'listsampel' => $listsampel,
                'listlabels' => $listlabel,
                'listlabels2' => $listlabel2,
                'datacsv' => $datacsv,
                'dataanggota' => $dataanggota,
                'id' => $id_anggota
            ];
        } else {
            $data = [
                'title' => 'FORM',
                'validation' => \Config\Services::validation(),
                'anggota' => $anggota,
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
                'datacsv' => '',
                'dataanggota' => '',
                'id' => '',
                'listlabels' => '',
                'listlabels2' => '',
            ];
        }
        if ($page == 'user') {
            return view('NaiveBayesView/PrediksiAdvancedUser', $data);
        } else {
            return view('NaiveBayesView/PrediksiAdvanced', $data);
        }
        // redirect()->to('NaiveBayesController/viewsimple');
    }

    public function prediksiAdvancedPengurus($page)
    {
        $anggota = $this->AnggotaModel->findAll();
        $id_anggota = $this->request->getVar('idanggota');
        // dd($id_anggota);
        $dataanggota = $this->AnggotaModel->where('id_anggota', $id_anggota)->findAll();

        $dtesting[] = $this->request->getVar('durasi_keanggotaan');
        $dtesting[] = $this->request->getVar('misa_diluar_mingguan');
        $dtesting[] = $this->request->getVar('umur');
        $dtesting[] = $this->request->getVar('keikutsertaan_outdoor_activity');
        $absensi = $this->request->getVar('absen');
        $dec = $absensi / 100.00;
        $dtesting[] = $absensi;

        if ($dtesting[0] != null && $dtesting[1] != null && $dtesting[2] != null && $dtesting[3] != null) {
            $datasetpengurus = new CsvDataset('./dataset/datasetpengurus.csv', 5, true);

            $samplespengurus = $datasetpengurus->getSamples();
            $labelspengurus = $datasetpengurus->getTargets();

            $classifier2 = new NaiveBayesNew();
            // var_dump($dtesting);

            $classifier2->train($samplespengurus, $labelspengurus);

            $hasil_pengurus = $classifier2->predict($dtesting);

            // Calculate class frequency in the training data
            $classes = array_unique($labelspengurus);
            $classCounts = array_count_values($labelspengurus);

            // Calculate prior probabilities for each class
            $priors = [];
            $totalSamples = count($labelspengurus);
            foreach ($classCounts as $class => $count) {
                $priors[$class] = $count / $totalSamples;
            }

            // foreach ($priors as $class => $probability) {
            //     echo "Prior probability of class $class: $probability\n <br>";
            // }

            $mean = $classifier2->mean;
            $stddev = $classifier2->std;
            $discrete = $classifier2->labels;
            $priorprob = $classifier2->p;
            $sample = $classifier2->sampleCount;
            $feature = $classifier2->featureCount;
            $gaussian = $classifier2->normaldist;
            $posterior = $classifier2->postprob;
            $label = $classifier2->labels;
            $listsampel = $classifier2->listsampel;
            $listlabel = $this->listlabels;
            $listlabel2 = $this->listlabels2;

            // $f_pointer = fopen("./dataset/anggota.csv", "r"); // file pointer

            // $first_line = "T";

            // while (!feof($f_pointer)) {
            //     $ar = fgetcsv($f_pointer);
            //     if ($first_line <> 'T') {
            //         echo print_r($ar); // print the array 

            //         echo "<br>";
            //     }
            //     $first_line = 'F';
            // }
            // Closing the file
            // fclose($file);

            $datacsv = array_map('str_getcsv', file('./dataset/datasetpengurus.csv'));
            // echo '<pre>';
            array_shift($datacsv);
            // $jumlah = count($datacsv);
            // for ($i = 0; $i < $jumlah; $i++) {
            //     unset($datacsv[$i][4]);
            // }
            // print_r($datacsv);
            // echo '</pre>';

            if ($id_anggota != null) {
                $this->AnggotaModel->save([
                    'id_anggota' => $id_anggota,
                    'kandidat_pengurus' => $hasil_pengurus,
                ]);

                $this->builder3 = $this->db->table("rekap_prediksi")->select('*');
                $this->query3 = $this->builder3->getWhere(['rekap_prediksi.id_anggota' => $id_anggota, 'rekap_prediksi.tipe_dataset' => 'pengurus']);
                $this->result3 = $this->query3->getResult();
                // dd($this->result3);

                if (count($this->result3) == 0) { //kalo nggak ketemu, save 
                    $this->RekapModel->save([
                        'id_anggota' => $id_anggota,
                        'post_yes' => $posterior['yes'],
                        'post_no' => $posterior['no'],
                        'tipe_dataset' => 'pengurus',
                    ]);
                    // echo 'tidak ada';
                    // echo $namas . '<br>';
                } else {
                    $this->RekapModel->save([
                        'id_data' => $this->result3[0]->id_data,
                        'id_anggota' => $id_anggota,
                        'post_yes' => $posterior['yes'],
                        'post_no' => $posterior['no'],
                        'tipe_dataset' => 'pengurus',
                    ]);
                }
            }

            $data = [
                'title' => 'Form ubah data',
                'validation' => \Config\Services::validation(),
                'anggota' => $anggota,
                'hasil_kapten' => '',
                'hasil_pengurus' => $hasil_pengurus,
                'hasil_ketua' => '',
                'durasi' => $dtesting[0],
                'misa' => $dtesting[1],
                'umur' => $dtesting[2],
                'outdoor' => $dtesting[3],
                'absen' => $absensi,
                'mean' => $mean,
                'std' => $stddev,
                'discrete' => $discrete,
                'prior' => $priorprob,
                'posterior' => $posterior,
                'sample' => $sample,
                'feature' => $feature,
                'label' => $this->labels,
                'gaussian' => $gaussian,
                'listsampel' => $listsampel,
                'listlabels' => $listlabel,
                'listlabels2' => $listlabel2,
                'datacsv' => $datacsv,
                'dataanggota' => $dataanggota,
                'id' => $id_anggota
            ];
        } else {
            $data = [
                'title' => 'FORM',
                'validation' => \Config\Services::validation(),
                'anggota' => $anggota,
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
                'datacsv' => '',
                'dataanggota' => '',
                'id' => '',
                'listlabels' => '',
                'listlabels2' => ''
            ];
        }
        if ($page == 'user') {
            return view('NaiveBayesView/PrediksiAdvancedUser', $data);
        } else {
            return view('NaiveBayesView/PrediksiAdvanced', $data);
        }
        // redirect()->to('NaiveBayesController/viewsimple');
    }

    public function prediksiAdvancedKetua($page)
    {
        $anggota = $this->AnggotaModel->findAll();
        $id_anggota = $this->request->getVar('idanggota');
        $dataanggota = $this->AnggotaModel->where('id_anggota', $id_anggota)->findAll();

        $dtesting[] = $this->request->getVar('durasi_keanggotaan');
        $dtesting[] = $this->request->getVar('misa_diluar_mingguan');
        $dtesting[] = $this->request->getVar('umur');
        $dtesting[] = $this->request->getVar('keikutsertaan_outdoor_activity');
        $absensi = $this->request->getVar('absen');
        $dec = $absensi / 100.00;
        $dtesting[] = $absensi;

        if ($dtesting[0] != null && $dtesting[1] != null && $dtesting[2] != null && $dtesting[3] != null) {
            $datasetketua = new CsvDataset('./dataset/datasetketuawakil.csv', 5, true);

            $samplesketua = $datasetketua->getSamples();
            $labelsketua = $datasetketua->getTargets();

            $classifier3 = new NaiveBayesNew();
            // var_dump($dtesting);

            $classifier3->train($samplesketua, $labelsketua);

            $hasil_ketua = $classifier3->predict($dtesting);

            // Calculate class frequency in the training data
            $classes = array_unique($labelsketua);
            $classCounts = array_count_values($labelsketua);

            // Calculate prior probabilities for each class
            $priors = [];
            $totalSamples = count($labelsketua);
            foreach ($classCounts as $class => $count) {
                $priors[$class] = $count / $totalSamples;
            }

            // foreach ($priors as $class => $probability) {
            //     echo "Prior probability of class $class: $probability\n <br>";
            // }

            $mean = $classifier3->mean;
            $stddev = $classifier3->std;
            $discrete = $classifier3->labels;
            $priorprob = $classifier3->p;
            $sample = $classifier3->sampleCount;
            $feature = $classifier3->featureCount;
            $gaussian = $classifier3->normaldist;
            $posterior = $classifier3->postprob;
            $label = $classifier3->labels;
            $listsampel = $classifier3->listsampel;
            $listlabel = $this->listlabels;
            $listlabel2 = $this->listlabels2;

            // $f_pointer = fopen("./dataset/anggota.csv", "r"); // file pointer

            // $first_line = "T";

            // while (!feof($f_pointer)) {
            //     $ar = fgetcsv($f_pointer);
            //     if ($first_line <> 'T') {
            //         echo print_r($ar); // print the array 

            //         echo "<br>";
            //     }
            //     $first_line = 'F';
            // }
            // Closing the file
            // fclose($file);

            $datacsv = array_map('str_getcsv', file('./dataset/datasetketuawakil.csv'));
            // echo '<pre>';
            array_shift($datacsv);
            // $jumlah = count($datacsv);
            // for ($i = 0; $i < $jumlah; $i++) {
            //     unset($datacsv[$i][4]);
            // }
            // print_r($datacsv);
            // echo '</pre>';
            if ($id_anggota != null) {
                $this->AnggotaModel->save([
                    'id_anggota' => $id_anggota,
                    'kandidat_ketua' => $hasil_ketua,
                ]);

                $this->builder3 = $this->db->table("rekap_prediksi")->select('*');
                $this->query3 = $this->builder3->getWhere(['rekap_prediksi.id_anggota' => $id_anggota, 'rekap_prediksi.tipe_dataset' => 'ketua']);
                $this->result3 = $this->query3->getResult();
                // dd($this->result3);

                if (count($this->result3) == 0) { //kalo nggak ketemu, save 
                    $this->RekapModel->save([
                        'id_anggota' => $id_anggota,
                        'post_yes' => $posterior['yes'],
                        'post_no' => $posterior['no'],
                        'tipe_dataset' => 'ketua',
                    ]);

                    // echo 'tidak ada';
                    // echo $namas . '<br>';
                } else {
                    $this->RekapModel->save([
                        'id_data' => $this->result3[0]->id_data,
                        'id_anggota' => $id_anggota,
                        'post_yes' => $posterior['yes'],
                        'post_no' => $posterior['no'],
                        'tipe_dataset' => 'ketua',
                    ]);
                }
            }

            $data = [
                'title' => 'Form ubah data',
                'validation' => \Config\Services::validation(),
                'anggota' => $anggota,
                'hasil_kapten' => '',
                'hasil_pengurus' => '',
                'hasil_ketua' => $hasil_ketua,
                'durasi' => $dtesting[0],
                'misa' => $dtesting[1],
                'umur' => $dtesting[2],
                'outdoor' => $dtesting[3],
                'absen' => $absensi,
                'mean' => $mean,
                'std' => $stddev,
                'discrete' => $discrete,
                'prior' => $priorprob,
                'posterior' => $posterior,
                'sample' => $sample,
                'feature' => $feature,
                'label' => $this->labels,
                'gaussian' => $gaussian,
                'listsampel' => $listsampel,
                'listlabels' => $listlabel,
                'listlabels2' => $listlabel2,
                'dataanggota' => $dataanggota,
                'datacsv' => $datacsv,
                'id' => $id_anggota

            ];
        } else {
            $data = [
                'title' => 'FORM',
                'validation' => \Config\Services::validation(),
                'anggota' => $anggota,
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
                'dataanggota' => '',
                'datacsv' => '',
                'id' => '',
                'listlabels' => '',
                'listlabels2' => ''
            ];
        }
        if ($page == 'user') {
            return view('NaiveBayesView/PrediksiAdvancedUser', $data);
        } else {
            return view('NaiveBayesView/PrediksiAdvanced', $data);
        }        // redirect()->to('NaiveBayesController/viewsimple');
    }

    public function akurasi()
    {
        return view('NaiveBayesView/Akurasi');
    }

    public function akurasiresult()
    {
        $filedataset = $this->request->getVar('dataset');
        $testdata = $this->request->getVar('testdata');

        // if (isset($_POST['proses'])) {
        if ($testdata == null or $filedataset == null) {
            return redirect()->to('NaiveBayesController/akurasi');
        } else {
            if ($filedataset == 'kapten') {
                $target_file = "./dataset/datasetkapten.csv";
            } elseif ($filedataset == 'pengurus') {
                $target_file = "./dataset/datasetpengurus.csv";
            } elseif ($filedataset == 'ketua') {
                $target_file = "./dataset/datasetketuawakil.csv";
            } else {
                return redirect()->to('NaiveBayesController/akurasi');
            }
            if (!file_exists($target_file)) {
                $message = "File dataset tidak ditemukan. Harap download dataset dari halaman kelola anggota dan upload dataset tersebut di halaman ini";
                echo "<script type='text/javascript'>alert('$message');</script>";
            } else {
                $algo = 'bayes';

                // $dataset = new CsvDataset(dirname(__FILE__) . '/dataset/anggota.csv', 4, true); //(file, jml atribut, header?)
                if ($filedataset == 'kapten') {
                    // $target_file = "./dataset/datasetkapten.csv";
                    $dataset = new CsvDataset('./dataset/datasetkapten.csv', 5, true);
                } elseif ($filedataset == 'pengurus') {
                    // $target_file = "./dataset/datasetpengurus.csv";
                    $dataset = new CsvDataset('./dataset/datasetpengurus.csv', 5, true);
                } elseif ($filedataset == 'ketua') {
                    // $target_file = "./dataset/datasetketuawakil.csv";
                    $dataset = new CsvDataset('./dataset/datasetketuawakil.csv', 5, true);
                } else {
                    return redirect()->to('NaiveBayesController/akurasi');
                }
                $row = 1;
                /*
            dataset ada 13 atribut dan 1 label kelas
            
            label = terlambat (2) / tepat (1)
            */

                // $splits = new RandomSplit($dataset, 0.6); //(dataset, %test data)
                $splits = new StratifiedRandomSplit($dataset, $testdata); //(dataset, %test data)

                // train group
                $train_samples = $splits->getTrainSamples();
                $train_labels = $splits->getTrainLabels();

                // test group
                $test_samples = $splits->getTestSamples();
                $test_labels = $splits->getTestLabels();

                //echo "<pre>"; print_r($train_samples); echo "</pre>";
                // $i = 0;
                // $j = 0;
                // foreach ($train_samples as $row) {
                //     $j = 0;
                //     foreach ($row as $col) {
                //         $train_samples[$i][$j++] = floatval($col);
                //     }
                //     $i++;
                // }

                // $i = 0;
                // $j = 0;
                // foreach ($test_samples as $row) {
                //     $j = 0;
                //     foreach ($row as $col) {
                //         $test_samples[$i][$j++] = floatval($col);
                //     }
                //     $i++;
                // }

                // if ($algo == 'bayes') {

                $classifier = new NaiveBayes();
                //train every labels
                $classifier->train($train_samples, $train_labels);
                $class_hasil = $classifier->predict($test_samples);

                $confusionMatrix = ConfusionMatrix::compute($test_labels, $class_hasil);
                $Akurasi = Accuracy::score($test_labels, $class_hasil); //(actual, predicted)
                // echo " Precision: ";
                $report = new ClassificationReport($test_labels, $class_hasil);
                $presisi = $report->getPrecision();
                $presisipercent = round((float)$presisi["yes"] * 100) . '%';
                $nilaipresisi = $presisi["no"];
                // echo "<br/> Recall: ";
                $recall = $report->getRecall();
                // echo $recall["No"];
                // echo "<br/> F1: ";
                $F1 = $report->getF1score();
                $TP = $report->truePositive;
                $FP = $report->falsePositive;
                $FN = $report->falseNegative;
                // echo $F1["No"];
                // echo "<br/> Support: ";
                // var_dump($report->getSupport());
                // echo "<br/> Average: ";
                // var_dump($report->getAverage());
                // echo "<br/>";
                // }
                // d($train_samples);
                // d($train_labels);
                // d($test_samples);
                // d($test_labels);

                $data = [
                    'filedataset' => $filedataset,
                    'confusionMatrix' => $confusionMatrix,
                    'akurasi' => $Akurasi,
                    'presisipercent' => $presisipercent,
                    'presisi' => $presisi,
                    'recall' => $recall,
                    'F1' => $F1,
                    'train_sample' => $train_samples,
                    'train_labels' => $train_labels,
                    'test_sample' => $test_samples,
                    'test_labels' => $test_labels,
                    'testdata' => $testdata,
                    'TP' => $TP,
                    'FP' => $FP,
                    'FN' => $FN
                ];
            }
        }

        return view('NaiveBayesView/AkurasiResult', $data);
    }

    public function akurasiSimple()
    {
        $data = [
            'filedataset' => '',
            'confusionMatrix' => '',
            'akurasi' => '',
            'presisipercent' => '',
            'presisi' => '',
            'recall' => '',
            'F1' => '',
            'train_sample' => '',
            'train_labels' => '',
            'test_sample' => '',
            'test_labels' => '',
            // 'testdata' => '',
            'TP' => '',
            'FP' => '',
            'FN' => ''
        ];
        return view('NaiveBayesView/AkurasiSimple', $data);
    }

    public function akurasiSimpleProses()
    {
        $filedataset = $this->request->getVar('dataset');
        // $testdata = $this->request->getVar('testdata');

        // if (isset($_POST['proses'])) {
        if ($filedataset == null) {
            return redirect()->to('NaiveBayesController/akurasi');
        } else {
            if ($filedataset == 'kapten') {
                $target_file = "./dataset/datasetkapten.csv";
            } elseif ($filedataset == 'pengurus') {
                $target_file = "./dataset/datasetpengurus.csv";
            } elseif ($filedataset == 'ketua') {
                $target_file = "./dataset/datasetketuawakil.csv";
            } else {
                return redirect()->to('NaiveBayesController/akurasi');
            }
            if (!file_exists($target_file)) {
                $message = "File dataset tidak ditemukan. Harap download dataset dari halaman kelola anggota dan upload dataset tersebut di halaman ini";
                echo "<script type='text/javascript'>alert('$message');</script>";
            } else {
                $algo = 'bayes';

                // $dataset = new CsvDataset(dirname(__FILE__) . '/dataset/anggota.csv', 4, true); //(file, jml atribut, header?)
                if ($filedataset == 'kapten') {
                    // $target_file = "./dataset/datasetkapten.csv";
                    $dataset = new CsvDataset('./dataset/datasetkapten.csv', 5, true);
                } elseif ($filedataset == 'pengurus') {
                    // $target_file = "./dataset/datasetpengurus.csv";
                    $dataset = new CsvDataset('./dataset/datasetpengurus.csv', 5, true);
                } elseif ($filedataset == 'ketua') {
                    // $target_file = "./dataset/datasetketuawakil.csv";
                    $dataset = new CsvDataset('./dataset/datasetketuawakil.csv', 5, true);
                } else {
                    return redirect()->to('NaiveBayesController/akurasi');
                }
                $row = 1;
                /*
            dataset ada 13 atribut dan 1 label kelas
            
            label = terlambat (2) / tepat (1)
            */

                // $splits = new RandomSplit($dataset, 0.6); //(dataset, %test data)
                $splits = new StratifiedRandomSplit($dataset); //(dataset, %test data (default 0.3))

                // train group
                $train_samples = $splits->getTrainSamples();
                $train_labels = $splits->getTrainLabels();

                // test group
                $test_samples = $splits->getTestSamples();
                $test_labels = $splits->getTestLabels();

                //echo "<pre>"; print_r($train_samples); echo "</pre>";
                // $i = 0;
                // $j = 0;
                // foreach ($train_samples as $row) {
                //     $j = 0;
                //     foreach ($row as $col) {
                //         $train_samples[$i][$j++] = floatval($col);
                //     }
                //     $i++;
                // }

                // $i = 0;
                // $j = 0;
                // foreach ($test_samples as $row) {
                //     $j = 0;
                //     foreach ($row as $col) {
                //         $test_samples[$i][$j++] = floatval($col);
                //     }
                //     $i++;
                // }

                // if ($algo == 'bayes') {

                $classifier = new NaiveBayes();
                //train every labels
                $classifier->train($train_samples, $train_labels);
                $class_hasil = $classifier->predict($test_samples);

                $confusionMatrix = ConfusionMatrix::compute($test_labels, $class_hasil);
                $Akurasi = Accuracy::score($test_labels, $class_hasil); //(actual, predicted)
                // echo " Precision: ";
                $report = new ClassificationReport($test_labels, $class_hasil);
                $presisi = $report->getPrecision();
                $presisipercent = round((float)$presisi["yes"] * 100) . '%';
                $nilaipresisi = $presisi["no"];
                // echo "<br/> Recall: ";
                $recall = $report->getRecall();
                // echo $recall["No"];
                // echo "<br/> F1: ";
                $F1 = $report->getF1score();
                $TP = $report->truePositive;
                $FP = $report->falsePositive;
                $FN = $report->falseNegative;
                // echo $F1["No"];
                // echo "<br/> Support: ";
                // var_dump($report->getSupport());
                // echo "<br/> Average: ";
                // var_dump($report->getAverage());
                // echo "<br/>";
                // }
                // d($train_samples);
                // d($train_labels);
                // d($test_samples);
                // d($test_labels);

                $data = [
                    'filedataset' => $filedataset,
                    'confusionMatrix' => $confusionMatrix,
                    'akurasi' => $Akurasi,
                    'presisipercent' => $presisipercent,
                    'presisi' => $presisi,
                    'recall' => $recall,
                    'F1' => $F1,
                    'train_sample' => $train_samples,
                    'train_labels' => $train_labels,
                    'test_sample' => $test_samples,
                    'test_labels' => $test_labels,
                    // 'testdata' => $testdata,
                    'TP' => $TP,
                    'FP' => $FP,
                    'FN' => $FN
                ];
            }
        }

        return view('NaiveBayesView/AkurasiSimple', $data);
    }

    public function viewDataKapten()
    {
        $datakelayakan = $this->RekapModel->where('tipe_dataset', "kapten")->first();
        $builder5 = $this->db->table("anggota");
        $builder5->select('*,anggota.id_anggota AS kode_anggota');
        $builder5->join('rekap_prediksi', 'anggota.id_anggota=rekap_prediksi.id_anggota', 'left');
        // $builder5->join('kelompok', 'detail_kelompok.id_kelompok=kelompok.id_kelompok', 'left');
        $builder5->where('tipe_dataset', "kapten");
        $query5 = $builder5->get();
        $result5 = $query5->getResult();
        $data = [
            'data_kelayakan' => $result5,
        ];
        return view('RekapKelayakan/kapten', $data);
    }

    public function viewDataPengurus()
    {
        $datakelayakan = $this->RekapModel->where('tipe_dataset', "kapten")->first();
        $builder5 = $this->db->table("anggota");
        $builder5->select('*,anggota.id_anggota AS kode_anggota');
        $builder5->join('rekap_prediksi', 'anggota.id_anggota=rekap_prediksi.id_anggota', 'left');
        // $builder5->join('kelompok', 'detail_kelompok.id_kelompok=kelompok.id_kelompok', 'left');
        $builder5->where('tipe_dataset', "pengurus");
        $query5 = $builder5->get();
        $result5 = $query5->getResult();
        $data = [
            'data_kelayakan' => $result5,
        ];
        return view('RekapKelayakan/pengurus', $data);
    }

    public function viewDataKetua()
    {
        $datakelayakan = $this->RekapModel->where('tipe_dataset', "kapten")->first();
        $builder5 = $this->db->table("anggota");
        $builder5->select('*,anggota.id_anggota AS kode_anggota');
        $builder5->join('rekap_prediksi', 'anggota.id_anggota=rekap_prediksi.id_anggota', 'left');
        // $builder5->join('kelompok', 'detail_kelompok.id_kelompok=kelompok.id_kelompok', 'left');
        $builder5->where('tipe_dataset', "ketua");
        $query5 = $builder5->get();
        $result5 = $query5->getResult();
        $data = [
            'data_kelayakan' => $result5,
        ];
        return view('RekapKelayakan/ketua', $data);
    }
}
