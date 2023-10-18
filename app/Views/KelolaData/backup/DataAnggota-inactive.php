<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<!-- <link href="<?= base_url('/css/dataanggota.css'); ?>" rel="stylesheet"> -->

<main id="main" class="main">

    <!-- <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div> -->
    <!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Recent Sales -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body table-responsive text-center">

                                <!-- <h2 class="card-title text-center">DATA ANGGOTA</h2> -->
                                <h3 class="fw-bold text-center" style="margin-top:15px;margin-bottom:5px;color: #444441;">DATA ANGGOTA</h3>
                                <hr>
                                <a class="btn btn-success" style="margin-top: 5px;" href="/DataAnggota/create">TAMBAH DATA</a>
                                <!-- <?php d($anggota) ?> -->
                                <!-- <?php d($list_absen) ?> -->

                                <!-- <p>Add <code>.table-bordered</code> for borders on all sides of the table and cells.</p> -->
                                <!-- Bordered Table -->
                                <center>
                                    <table id="table" class="table table-hover  text-center table-striped text-center overflow-auto" style="width:100%" data-search="true" data-show-columns="true" data-show-multi-sort="true" data-toggle="table" data-show-columns-toggle-all="true" data-pagination="true" data-show-fullscreen="true">
                                        <thead>
                                            <tr class="text-center">
                                                <th scope="col" rowspan="2" class="align-middle text-center">#</th>
                                                <th scope="col" rowspan="2" class="align-middle text-center" data-sortable="true">NAMA</th>
                                                <th scope="col" rowspan="2" class="align-middle text-center" data-sortable="true">KELOMPOK</th>
                                                <th scope="col" rowspan="2" class="align-middle text-center" data-sortable="true">STATUS</th>
                                                <!-- <th scope="col" rowspan="2" class="align-middle text-center">DURASI <br>KEANGGOTAAN</th> -->
                                                <th scope="col" rowspan="2" class="align-middle text-center" data-sortable="true">UMUR</th>
                                                <!-- <th scope="col" rowspan="2" class="text-center">OUTDOOR</th> -->
                                                <th scope="col" rowspan="2" class="align-middle text-center">ABSEN</th>
                                                <!-- <th scope="col" rowspan="2" class="text-center">MISA BESAR</th> -->
                                                <th scope="col" colspan="3" class="text-center">KANDIDAT</th>
                                                <th scope="col" rowspan="2" class="align-middle text-center">ACTION</th>
                                            </tr>
                                            <tr class="align-middle">
                                                <th scope="col" data-sortable="true">KAPTEN</th>
                                                <th scope="col" data-sortable="true">PENGURUS</th>
                                                <th scope="col" data-sortable="true">KETUA</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1;
                                            // d($anggota);
                                            ?>
                                            <?php foreach ($anggota as $a) : ?>

                                                <!-- RUMUS ABSENSI -->
                                                <!-- jumlah hadir/jumlah week dari current date sampai tanggal masuk misdinar +1 untuk menghindari pembagian 0 dan agar perhitungan weeknya tdk lompat-lompat (minggu 1 ke minggu 2 = 2-1 = 1 harusnya udah 2 minggu) -->
                                                <!-- dibagi jumlah week karena misdinar tugasnya seminggu sekali -->
                                                <?php $this->db = db_connect();

                                                // HITUNG ABSEN
                                                // $list_hadir = $this->db->table('absen')->like('absen', 'HADIR')->where('id_anggota', $a->kode_anggota);
                                                // $query = $list_hadir->get();
                                                // d($query);


                                                $jml_hadir = $this->db->table('absen')->like('absen', 'HADIR')->where('id_anggota', $a->kode_anggota)->countAllResults();
                                                $Time = new DateTime('now');
                                                $DBTime = DateTime::createFromFormat('Y-m-d', $a->tanggal_masuk);
                                                $diff2 = $Time->diff($DBTime);
                                                $jmlMinggu = (floor($Time->diff($DBTime)->days / 7)) + 1;
                                                // $jml_minggu = $this->db->table('absen')->like('tanggal')->distinct()->groupBy('tanggal')->countAllResults();
                                                // $numberOfWeeks = floor($diff2->days / 7);
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

                                                // d($result4);

                                                // d($$result4->tanggal);

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
                                                // $decimal = 1.00001;
                                                if ($decimal > 1) {
                                                    $decimal = 1;
                                                }
                                                $percent = round((float)$decimal * 100) . '%';

                                                //HITUNG JUMLAH MISA BESAR
                                                if ($a->id_petugas == null) {
                                                    $jml_tugas_misabesar = 0;
                                                } else {
                                                    $jml_tugas_misabesar = $this->db->table('petugas_misa_khusus')->like('id_petugas', $a->kode_anggota)->where('id_petugas', $a->kode_anggota)->countAllResults();
                                                };

                                                //HITUNG JUMLAH KEGIATAN OUTDOOR
                                                if ($a->id_peserta == null) {
                                                    $jml_kegiatan = 0;
                                                } else {
                                                    $jml_kegiatan = $this->db->table('peserta_outdoor')->like('id_peserta', $a->kode_anggota)->where('id_peserta', $a->kode_anggota)->countAllResults();
                                                };

                                                ?>
                                                <tr>
                                                    <th scope="row"><?= $i++; ?></th>
                                                    <td><?= $a->nama_panggilan; ?></td>
                                                    <td><?= $a->nama_kelompok ? $a->nama_kelompok : '-'; ?></td>
                                                    <td><?= $a->status ? $a->status : '-'; ?></td>
                                                    <!-- <td><?= ($diff = date_diff(date_create($a->tanggal_masuk), date_create(date("Y-m-d")))->format('%y')); ?></td> -->
                                                    <td><?= ($diff = date_diff(date_create($a->tanggal_lahir), date_create(date("Y-m-d")))->format('%y')); ?></td>
                                                    <!-- <td><?= $jml_kegiatan; ?></td> -->
                                                    <td><?= $percent; ?></td>
                                                    <!-- <td>HADIR <?= $jml_hadir; ?></td> -->
                                                    <!-- <td>INTERVAL <?= $jmlMinggu; ?></td> -->
                                                    <!-- <td>numberOfWeeks <?php d($diff2); ?></td>
                                                    <td>NOW <?php d($Time); ?></td>
                                                    <td>MASUK <?php d($DBTime) ?></td> -->
                                                    <!-- <td><?= floor($Time->diff($DBTime)->days / 7); ?></td> -->
                                                    <!-- <td><?= $jml_tugas_misabesar; ?></td> -->
                                                    <td><?= $a->kandidat_kapten ? $a->kandidat_kapten : 'no'; ?></td>
                                                    <td><?= $a->kandidat_pengurus ? $a->kandidat_pengurus : 'no'; ?></td>
                                                    <td><?= $a->kandidat_ketua ? $a->kandidat_ketua : 'no'; ?></td>
                                                    <td>
                                                        <a href="/DataAnggota/detail/<?= $a->kode_anggota; ?>" class="btn btn-primary btn-sm" style="font-size: 12px;">DETAIL</a>
                                                    </td>
                                                </tr>

                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </center>
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
    $(function() {
        $('#table').bootstrapTable()
    })
</script>
<?= $this->endSection(); ?>