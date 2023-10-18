<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<link href="<?= base_url('/css/dataset.css'); ?>" rel="stylesheet">

<main id="main" class="main">

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Recent Sales -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body table-responsive text-center ">
                                <h3 class="fw-bold text-center" style="margin-top:15px;color: #444441;">DATASET PENGURUS</h3>
                                <p style="display:inline;">last update: <?php if ($dataset != null) : ?>
                                        <?= $dataset['created_at']; ?>
                                    <?php else : ?>
                                        <?= '-'; ?>
                                    <?php endif;; ?></p>
                                <i class="bi bi-info-circle-fill showinfo"></i>
                                <div class="hide">For updating dataset, please use our website client</div>
                                <!-- <?php d($dataset) ?> -->

                                <form style="display: none" class="text-center" action="/KelolaDataset/uploadDataset/<?= $jenis = "pengurus"; ?>" id="updateform" method="post" enctype="multipart/form-data">
                                    <!-- <div style="display:none"> -->

                                    <input type="file" name="fileDataset" id="fileDataset" class="fileDataset" value="" required> <br>
                                    <button style="margin-top:10px;" class="btn btn-success" name="proses" class="predictbutton" type="submit" value="PROSES">SAVE</button>

                                </form>
                                <div class="operatorbtn" style="margin-top:5px;margin-bottom: 10px;">
                                    <button class="btn btn-success" id="updatetoggle" class="predictbutton" value="PROSES">UPDATE DATASET</button>

                                    <button type="button" class="btn btn-success"><a class="text-decoration-none" style="color: white; background-color: transparent; text-decoration: none;" download="datasetpengurus.csv" href="#" onclick="return ExcellentExport.csv(this, 'tabeldata');">Export to CSV</a></button>
                                </div>

                                <!-- <h2 class=" card-title text-center">DATASET PENGURUS</h2> -->
                                <!-- Button trigger modal -->

                                <!-- <?php d($anggota) ?> -->
                                <!-- <p>Add <code>.table-bordered</code> for borders on all sides of the table and cells.</p> -->
                                <!-- Bordered Table -->

                                <table id="tabeldata" class="table table-bordered text-center table-striped  overflow-auto">
                                    <thead>
                                        <tr>
                                            <!-- <th scope="col">#</th>
                                            <th scope="col">NAMA</th>
                                            <th scope="col">KELOMPOK</th>
                                            <th scope="col">STATUS</th> -->
                                            <th scope="col">durasi_keanggotaan</th>
                                            <th scope="col">umur</th>
                                            <th scope="col">keikutsertaan_outdoor_activity</th>
                                            <th scope="col">absen</th>
                                            <th scope="col">misa_diluar_mingguan</th>
                                            <!-- <th scope="col">kandidat_kapten</th> -->
                                            <th scope="col">kandidat_pengurus</th>
                                            <!-- <th scope="col">Kandidat Ketua/Wakil</th>
                                            <th scope="col" colspan="2">ACTION</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        ?>
                                        <?php foreach ($anggota as $a) : ?>
                                            <!-- RUMUS ABSENSI -->
                                            <!-- jumlah hadir/jumlah week dari current date sampai tanggal masuk misdinar +1 untuk menghindari pembagian 0 dan agar perhitungan weeknya tdk lompat-lompat (minggu 1 ke minggu 2 = 2-1 = 1 harusnya udah 2 minggu) -->
                                            <!-- dibagi jumlah week karena misdinar tugasnya seminggu sekali -->
                                            <?php $this->db = db_connect();
                                            $jml_hadir = $this->db->table('absen')->like('absen', 'HADIR')->where('id_anggota', $a->kode_anggota)->countAllResults();
                                            // $jml_minggu = $this->db->table('absen')->like('tanggal')->distinct()->groupBy('tanggal')->countAllResults();
                                            $Time = new DateTime('now');
                                            $DBTime = DateTime::createFromFormat('Y-m-d', $a->tanggal_masuk);
                                            $diff2 = $Time->diff($DBTime);
                                            $jmlMinggu = (floor($Time->diff($DBTime)->days / 7)) + 1;
                                            // $Interval = floor($DBTime->diff($Time)->format('%d') + 1);
                                            // if ($jml_hadir == 0) {
                                            //     $decimal = 0;
                                            // } else {
                                            //     $decimal = $jml_bagus / $jml_hadir;
                                            // }
                                            $builder4 = $this->db->table("absen");
                                            $builder4->select('*')->like('id_anggota', $a->kode_anggota);
                                            $builder4->orderBy('tanggal', 'DESC');
                                            $query4 = $builder4->get();
                                            $result4 = $query4->getFirstRow();

                                            if ($a->nama_kelompok != null) {
                                                $decimal = $jml_hadir / $jmlMinggu;
                                            } else {
                                                if ($result4 != null) {
                                                    $DBTimeInactive = DateTime::createFromFormat('Y-m-d', $result4->tanggal);
                                                    $DBTimeMasuk = DateTime::createFromFormat('Y-m-d', $a->tanggal_masuk);

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

                                            if ($a->id_petugas == null) {
                                                $jml_tugas_misabesar = 0;
                                            } else {
                                                $jml_tugas_misabesar = $this->db->table('petugas_misa_khusus')->like('id_petugas', $a->kode_anggota)->where('id_petugas', $a->kode_anggota)->countAllResults();
                                            };

                                            if ($a->id_peserta == null) {
                                                $jml_kegiatan = 0;
                                            } else {
                                                $jml_kegiatan = $this->db->table('peserta_outdoor')->like('id_peserta', $a->kode_anggota)->where('id_peserta', $a->kode_anggota)->countAllResults();
                                            };

                                            ?>
                                            <tr>
                                                <td><?= ($diff = date_diff(date_create($a->tanggal_masuk), date_create(date("Y-m-d")))->format('%y')); ?></td>
                                                <td><?= ($diff = date_diff(date_create($a->tanggal_lahir), date_create(date("Y-m-d")))->format('%y')); ?></td>
                                                <td><?= $jml_kegiatan; ?></td>
                                                <td><?= $percent; ?></td>
                                                <!-- <td><?= $jml_hadir; ?></td>
                                                <td><?= $jmlMinggu; ?></td> -->
                                                <td><?= $jml_tugas_misabesar; ?></td>
                                                <td><?= $a->kandidat_pengurus ? $a->kandidat_pengurus : 'no'; ?></td>
                                            </tr>

                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <!-- End Bordered Table -->
                            </div>
                        </div>
                    </div><!-- End Recent Sales -->

                </div>
            </div>
            <!-- End Left side columns -->

        </div>
    </section>

</main>

<script src="<?= base_url('/js/dataanggota.js'); ?>"></script>

<script>
    $("#updatetoggle").click(function() {
        $("#updateform").toggle();
    });
</script>
<?= $this->endSection(); ?>