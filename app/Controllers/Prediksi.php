<?php

namespace App\Controllers;

// require 'vendor/autoload.php';

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

class Prediksi extends BaseController
{
    protected $AnggotaModel, $KelompokModel, $DetailKelompokModel, $AbsenModel, $KegiatanOutdoorModel, $PesertaOutdoorModel, $db;

    protected $builder, $builder0, $builder1, $builder2, $query, $query0, $query1, $query2, $result, $result0, $result1, $result2;

    protected $dtesting = [];
    protected $listlabels = [];
    protected $labels = [];

    public function __construct()
    {
        $this->dtesting;
        $this->listlabels = ['Durasi Keanggotaan', 'Umur', 'Misa diluar Mingguan', 'Keikutsertaan Kegiatan Outdoor', 'absen'];
        $this->labels = ['Yes', 'No'];

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
        // if ($this->dtesting != null) {
        //     $this->dtesting[] = $this->request->getVar('durasi_keanggotaan');
        //     $this->dtesting[] = $this->request->getVar('misa_diluar_mingguan');
        //     $this->dtesting[] = $this->request->getVar('umur');
        //     $this->dtesting[] = $this->request->getVar('keikutsertaan_outdoor_activity');
        // }
    }
    public function index()
    {
        $data = [
            'class_hasil' => '',
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
            'listsampel' => ''
        ];
        return view('Codeigniter', $data);
    }
    // public function PredictKapten($id)
    // {
    //     $this->builder->where('anggota.id_anggota', $id);
    //     $this->builder0->where('anggota.id_anggota', $id);
    //     $this->builder1->where('anggota.id_anggota', $id);
    //     $this->builder2->where('anggota.id_anggota', $id);

    //     $this->query = $this->builder->get();
    //     $this->query0 = $this->builder0->get();
    //     $this->query1 = $this->builder1->get();
    //     $this->query2 = $this->builder2->get();

    //     $this->result = $this->query->getResult();
    //     $this->result0 = $this->query0->getResult();
    //     $this->result1 = $this->query1->getResult();
    //     $this->result2 = $this->query2->getResult();

    //     $dtesting[] = $this->request->getVar('durasi_keanggotaan');
    //     $dtesting[] = $this->request->getVar('misa_diluar_mingguan');
    //     $dtesting[] = $this->request->getVar('umur');
    //     $dtesting[] = $this->request->getVar('keikutsertaan_outdoor_activity');
    //     $absensi = $this->request->getVar('absen');
    //     $dec = $absensi / 100.00;
    //     $dtesting[] = $dec;

    //     if ($dtesting[0] != null && $dtesting[1] != null && $dtesting[2] != null && $dtesting[3] != null) {
    //         $dataset = new CsvDataset('./dataset/anggota.csv', 5, true);
    //         $samples = $dataset->getSamples();
    //         $labels = $dataset->getTargets();

    //         $class_hasil = "";
    //         $classifier = new NaiveBayesNew();
    //         // var_dump($dtesting);

    //         $classifier->train($samples, $labels);
    //         $class_hasil = $classifier->predict($dtesting);
    //         $data = [
    //             'title' => 'Form ubah data',
    //             'validation' => \Config\Services::validation(),
    //             'anggota' => $this->AnggotaModel->getAnggota($id),
    //             'absen' => $this->result0,
    //             'anggota2' => $this->result,
    //             'misa_khusus' => $this->result1,
    //             'outdoor' => $this->result2,
    //             'class_hasil' => $class_hasil,
    //             'durasi' => $dtesting[0],
    //             'misa' => $dtesting[1],
    //             'umur' => $dtesting[2],
    //             'outdoor' => $dtesting[3],
    //             'absen' => $absensi,
    //             'mean' => '',
    //             'std' => '',
    //             'discrete' => '',
    //             'prior' => '',
    //             'posterior' => '',
    //             'sample' => '',
    //             'feature' => '',
    //             'label' => '',
    //             'gaussian' => '',
    //             'listsampel' => '',
    //         ];
    //         // return view('Codeigniter', $data);
    //         // echo $class_hasil . "<br>";

    //         // Calculate class frequency in the training data
    //         // $classes = array_unique($labels);
    //         // $classCounts = array_count_values($labels);

    //         // Calculate prior probabilities for each class
    //         // $priors = [];
    //         // $totalSamples = count($labels);
    //         // foreach ($classCounts as $class => $count) {
    //         //     $priors[$class] = $count / $totalSamples;
    //         // }

    //         // foreach ($priors as $class => $probability) {
    //         //     echo "Prior probability of class $class: $probability\n <br>";
    //         // }

    //         // $mean = $classifier->mean;
    //         // $stddev = $classifier->std;
    //         // $discrete = $classifier->labels;
    //         // $priorprob = $classifier->p;
    //         // $sample = $classifier->sampleCount;
    //         // $feature = $classifier->featureCount;

    //         // // Output mean and standard deviation values for each feature
    //         // $data = [
    //         //     'class_hasil' => $class_hasil,
    //         //     'mean' => $mean,
    //         //     'std' => $stddev,
    //         //     'discrete' => $discrete,
    //         //     'prior' => $priorprob,
    //         //     'sample' => $sample,
    //         //     'feature' => $feature
    //         // ];
    //         // return view('Codeigniter', $data);
    //         // $this->index();
    //     } else {
    //         $data = [
    //             'title' => 'Form ubah data',
    //             'validation' => \Config\Services::validation(),
    //             'anggota' => $this->AnggotaModel->getAnggota($id),
    //             'absen' => $this->result0,
    //             'anggota2' => $this->result,
    //             'misa_khusus' => $this->result1,
    //             'outdoor' => $this->result2,
    //             'class_hasil' => '',
    //             'durasi' => '',
    //             'misa' => '',
    //             'umur' => '',
    //             'outdoor' => '',
    //             'absen' => '',
    //             'mean' => '',
    //             'std' => '',
    //             'discrete' => '',
    //             'prior' => '',
    //             'posterior' => '',
    //             'sample' => '',
    //             'feature' => '',
    //             'label' => '',
    //             'gaussian' => '',
    //             'listsampel' => ''
    //         ];
    //     }
    //     return view('KelolaData/Edit', $data);
    // }
    public function predict2()
    {
        $dtesting[] = $this->request->getVar('durasi_keanggotaan');
        $dtesting[] = $this->request->getVar('misa_diluar_mingguan');
        $dtesting[] = $this->request->getVar('umur');
        $dtesting[] = $this->request->getVar('keikutsertaan_outdoor_activity');
        $absensi = $this->request->getVar('absen');
        $dec = $absensi / 100.00;
        $dtesting[] = $dec;

        if ($dtesting[0] != null && $dtesting[1] != null && $dtesting[2] != null && $dtesting[3] != null) {
            $dataset = new CsvDataset('./dataset/anggota.csv', 5, true);
            $samples = $dataset->getSamples();
            $labels = $dataset->getTargets();

            $class_hasil = "";

            $classifier = new NaiveBayesNew();

            $classifier->train($samples, $labels);
            $class_hasil = $classifier->predict($dtesting);

            // echo $class_hasil . "<br>";
            // Calculate class frequency in the training data
            $classes = array_unique($labels);
            $classCounts = array_count_values($labels);

            // Calculate prior probabilities for each class
            $priors = [];
            $totalSamples = count($labels);
            foreach ($classCounts as $class => $count) {
                $priors[$class] = $count / $totalSamples;
            }

            // foreach ($priors as $class => $probability) {
            //     echo "Prior probability of class $class: $probability\n <br>";
            // }

            $mean = $classifier->mean;
            $stddev = $classifier->std;
            $discrete = $classifier->labels;
            $priorprob = $classifier->p;
            $sample = $classifier->sampleCount;
            $feature = $classifier->featureCount;
            $gaussian = $classifier->normaldist;
            $posterior = $classifier->postprob;
            $label = $classifier->labels;
            $listsampel = $classifier->listsampel;
            $listlabel = $this->listlabels;

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

            $datacsv = array_map('str_getcsv', file('./dataset/anggota.csv'));
            // echo '<pre>';
            array_shift($datacsv);
            // $jumlah = count($datacsv);
            // for ($i = 0; $i < $jumlah; $i++) {
            //     unset($datacsv[$i][4]);
            // }
            // print_r($datacsv);
            // echo '</pre>';


            // Output mean and standard deviation values for each feature
            $data = [
                'class_hasil' => $class_hasil,
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
                'datacsv' => $datacsv

            ];
        } else {
            $data = [
                'class_hasil' => '',
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
                'datacsv' => ''
            ];
            return view('Codeigniter', $data);
        }
        return view('Codeigniter', $data);
    }
    public function accuracy()
    {
        return view('Accuracy');
    }

    public function accuracyResult()
    {
        $target_file = "dataset/anggota.csv";
        $testdata = $this->request->getVar('testdata');

        // if (isset($_POST['proses'])) {
        if ($testdata == null) {
            return redirect()->to('Home/Accuracy');
        } else {
            if (!file_exists($target_file)) {
                $message = "File dataset tidak ditemukan. Harap download dataset dari halaman kelola anggota dan upload dataset tersebut di halaman ini";
                echo "<script type='text/javascript'>alert('$message');</script>";
            } else {
                $algo = 'bayes';

                // $dataset = new CsvDataset(dirname(__FILE__) . '/dataset/anggota.csv', 4, true); //(file, jml atribut, header?)
                $dataset = new CsvDataset('./dataset/anggota.csv', 5, true);

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
                $presisipercent = round((float)$presisi["No"] * 100) . '%';
                $nilaipresisi = $presisi["No"];
                // echo "<br/> Recall: ";
                $recall = $report->getRecall();
                // echo $recall["No"];
                // echo "<br/> F1: ";
                $F1 = $report->getF1score();
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
                ];
            }
        }

        return view('Accuracy', $data);
    }
}
