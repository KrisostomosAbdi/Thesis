<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<main id="main" class="main">
    <?php $this->db = db_connect();

    //ABSEN
    if (empty($absen)) {
        $jml_hadir = 0;
        $lastTugas = "-";
    } else {
        $jml_hadir = $this->db->table('absen')->like('absen', 'HADIR')->where('id_anggota', $absen['0']->kode_anggota)->countAllResults();
        // $lastTugas = $this->db->table('absen')->like('absen', 'HADIR')->where('id_anggota', $absen['0']->kode_anggota)->orderBy('tanggal', 'DESC')->getFirstResult();
        $builder4 = $this->db->table("absen");
        $builder4->select('*')->like('absen', 'HADIR');
        $builder4->where('id_anggota', $absen['0']->kode_anggota)->orderBy('tanggal', 'DESC');
        $query4 = $builder4->get();
        $lastTugas = $query4->getFirstRow();
        if ($lastTugas != null) {
            $lastTugas = date("d-m-Y", strtotime($lastTugas->tanggal));
        } else {
            $lastTugas = "-";
        }
    }
    // $jml_minggu = $this->db->table('absen')->like('tanggal')->distinct()->groupBy('tanggal')->countAllResults();
    $jmlMinggu = 0;

    $jml_hadir = $this->db->table('absen')->like('absen', 'HADIR')->where('id_anggota', $anggota['0']->kode_anggota)->countAllResults();
    $Time = new DateTime('now');
    $DBTime = DateTime::createFromFormat('Y-m-d', $anggota['0']->tanggal_masuk);
    // $Interval = floor($DBTime->diff($Time)->format('%d') + 1);
    $diff2 = $Time->diff($DBTime);
    $jmlMinggu = (floor($Time->diff($DBTime)->days / 7)) + 1;
    // if ($jml_hadir == 0) {
    //     $decimal = 0;
    // } else {
    //     $decimal = $jml_bagus / $jml_hadir;
    // }

    $builder4 = $this->db->table("absen");
    $builder4->select('*')->like('id_anggota', $anggota['0']->kode_anggota);
    $builder4->orderBy('tanggal', 'DESC');
    $query4 = $builder4->get();
    $result4 = $query4->getFirstRow();

    // d($result4);

    // d($result4->tanggal);
    $jmlMingguInactive = 0;
    if ($anggota['0']->nama_kelompok != null) {
        $decimal = $jml_hadir / $jmlMinggu;
    } else {
        if ($result4 != null) {
            $DBTimeInactive = DateTime::createFromFormat('Y-m-d', $result4->tanggal);
            $DBTimeMasuk = DateTime::createFromFormat('Y-m-d', $anggota['0']->tanggal_masuk);

            $jmlMingguInactive = (floor($DBTimeInactive->diff($DBTimeMasuk)->days / 7)) + 1;
            $decimal = $jml_hadir / $jmlMingguInactive;
        } else {
            $decimal = 0;
        }
    }

    // $decimal = $jml_hadir / $jmlMinggu;
    // $decimal = 1.00001;
    if ($decimal > 1) {
        $decimal = 1;
    }
    $percent = round((float)$decimal * 100);

    //MISA KHUSUS
    if ($misa_khusus['0']->id_petugas == null) {
        $jml_tugas_misabesar = 0;
    } else {
        $jml_tugas_misabesar = $this->db->table('petugas_misa_khusus')->like('id_petugas', $misa_khusus['0']->kode_anggota)->where('id_petugas', $anggota['0']->kode_anggota)->countAllResults();
    };

    //OUTDOOR ACTIVITY
    if ($outdoor['0']->id_peserta == null) {
        $jml_kegiatan = 0;
    } else {
        $jml_kegiatan = $this->db->table('peserta_outdoor')->like('id_peserta', $outdoor['0']->kode_anggota)->where('id_peserta', $outdoor['0']->kode_anggota)->countAllResults();
    };
    ?>

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Recent Sales -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body table-responsive">
                                <!-- <?php d($anggota); ?> -->
                                <!-- <?php d($misa_khusus); ?> -->
                                <!-- <?php d($outdoor); ?> -->
                                <!-- <?php d($absen);  ?> -->
                                <!-- <h1 class="card-title text-center">DATA ANGGOTA </h1> -->
                                <h3 class="fw-bold text-center" style="margin-top:15px;color: #444441;">DATA ANGGOTA</h3>

                                <div class="justify-content-center text-center" style="margin-bottom:15px; margin-top:-5px;">
                                    <!-- <a href=" /DataAnggota/edit/<?= $anggota['0']->kode_anggota; ?>" class="btn btn-warning">Edit</a> -->

                                    <!-- text FORM-->
                                    <form style="display: inline;" action="/DataAnggota/viewUpdate/<?= $anggota['0']->kode_anggota; ?>" id="predictform" method="post" enctype="multipart/form-data">
                                        <div style="display:none">


                                            <input type="text" name="durasi_keanggotaan" value="<?= ($diff = date_diff(date_create($anggota['0']->tanggal_masuk), date_create(date('Y-m-d')))->format('%y')); ?>" id="" required> <br>

                                            <input type="text" name="misa_diluar_mingguan" value="<?= $jml_tugas_misabesar; ?>" id="" required> <br>

                                            <input type="text" name="umur" value="<?= ($diff = date_diff(date_create($anggota['0']->tanggal_lahir), date_create(date('Y-m-d')))->format('%y')); ?>" id="" required> <br>

                                            <input type="text" name="absen" value="<?= $percent; ?>" id="" required> <br>

                                            <input type="text" name="keikutsertaan_outdoor_activity" value="<?= $jml_kegiatan; ?>" id="" required> <br>

                                        </div>
                                        <!-- <button type="btn" name="proses" class="predictbutton">Proses</button> -->
                                        <button class="btn btn-success" name="proses" class="predictbutton" type="submit" value="PROSES">EDIT</button>
                                    </form>

                                    <!-- <form action="/DataAnggota/hapus/<?= $anggota['0']->kode_anggota; ?>" method="post" class="d-inline">
                                        <?= csrf_field(); ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('apakah anda yakin?');">DELETE</button>
                                    </form> -->

                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        DELETE
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
                                                    <br>
                                                    <form action="/DataAnggota/hapus/<?= $anggota['0']->kode_anggota; ?>" method="post" class="d-inline">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="btn btn-danger">YES</button>
                                                    </form>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">NO</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- <a href="/komik/delete/<?= $anggota['0']->kode_anggota; ?>" class="btn btn-danger">Delete</a> -->
                                    <a href="/DataAnggota" class="btn btn-primary">BACK</a>
                                </div>


                                <table class="table table-bordered text-center table-striped  overflow-auto">
                                    <tr>
                                        <td scope="col" colspan="2" class="text-center fw-bold">IDENTITAS</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">NAMA LENGKAP</th>
                                        <td><?= $anggota['0']->nama_lengkap; ?></td>

                                    </tr>
                                    <tr>
                                        <th scope="col">NAMA</th>
                                        <td><?= $anggota['0']->nama_panggilan; ?></td>
                                    </tr>
                                    <!-- <tr>
                                        <th scope="col">STATUS KEANGGOTAAN</th>
                                        <td>
                                            <?php if ($anggota['0']->nama_kelompok == null) {
                                                echo "PARSIAL";
                                            } else {
                                                echo "AKTIF";
                                            }; ?>
                                        </td>
                                    </tr> -->
                                    <tr>
                                        <th scope="col">TERAKHIR BERTUGAS <i class="bi bi-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Data ini dapat digunakan untuk menentukan apakah anggota ini masih aktif atau tidak"></i></th>
                                        <td>
                                            <?= $lastTugas; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="col">KELOMPOK</th>
                                        <td><?= $anggota['0']->nama_kelompok ? $anggota['0']->nama_kelompok : '-'; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="col">JABATAN</th>
                                        <td><?= $anggota['0']->status ? $anggota['0']->status : '-'; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="col">DURASI ANGGOTA</th>
                                        <td>&#177; <?= ($diff = date_diff(date_create($anggota['0']->tanggal_masuk), date_create(date("Y-m-d")))->format('%y')); ?> Tahun</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">OUTDOOR ACTIVITY</th>
                                        <td><?= $jml_kegiatan; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="col">ABSEN</th>
                                        <td><?= $percent; ?>%</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">MISA BESAR</th>
                                        <td><?= $jml_tugas_misabesar; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="col">UMUR</th>
                                        <td><?= ($diff = date_diff(date_create($anggota['0']->tanggal_lahir), date_create(date("Y-m-d")))->format('%y')); ?> Tahun</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">TEMPAT LAHIR</th>
                                        <td><?= ($anggota['0']->tempat_lahir) ? ($anggota['0']->tempat_lahir) : '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="col">TANGGAL LAHIR</th>
                                        <td><?= ($newDate = date("d-m-Y", strtotime($anggota['0']->tanggal_lahir))) ? ($newDate = date("d-m-Y", strtotime($anggota['0']->tanggal_lahir))) : '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="col">NOMOR TELEPON</th>
                                        <td><?= ($anggota['0']->no_telepon) ? ($anggota['0']->no_telepon) : '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="col">NAMA ORANG TUA</th>
                                        <td><?= ($anggota['0']->nama_ortu) ? ($anggota['0']->nama_ortu) : '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="col">NOMOR TELEPON ORANG TUA</th>
                                        <td><?= ($anggota['0']->no_telepon_ortu) ? ($anggota['0']->no_telepon_ortu) : '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="col">ALAMAT</th>
                                        <td><?= ($anggota['0']->alamat) ? ($anggota['0']->alamat) : '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="col">PAROKI</th>
                                        <td><?= ($anggota['0']->paroki) ? ($anggota['0']->paroki) : '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="col">WILAYAH</th>
                                        <td><?= ($anggota['0']->wilayah) ? ($anggota['0']->wilayah) : '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="col">LINGKUNGAN</th>
                                        <td><?= ($anggota['0']->lingkungan) ? ($anggota['0']->lingkungan) : '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="col">MOTIVASI MENJADI MISDINAR</th>
                                        <td><?= ($anggota['0']->motivasi) ? ($anggota['0']->motivasi) : '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Kandidat Kapten</th>
                                        <td><?= $anggota['0']->kandidat_kapten ? $anggota['0']->kandidat_kapten : 'no'; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Kandidat Pengurus</th>
                                        <td><?= $anggota['0']->kandidat_pengurus ? $anggota['0']->kandidat_pengurus : 'no'; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Kandidat Ketua/Wakil</th>
                                        <td><?= $anggota['0']->kandidat_ketua ? $anggota['0']->kandidat_ketua : 'no'; ?></td>
                                    </tr>
                                </table>
                                <table class="table table-bordered text-center table-striped  overflow-auto">

                                    <tr>
                                        <th scope="col" colspan="4" class="text-center fw-bold">MISA BESAR</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">NAMA MISA</th>
                                        <th scope="col">TANGGAL</th>
                                        <th scope="col">JAM</th>
                                    </tr>
                                    <?php
                                    if ($misa_khusus[0]->id_misa == null) : ?>
                                        <tr>
                                            <td colspan="3">
                                                No Data
                                            </td>
                                        </tr>
                                    <?php else : ?>
                                        <?php $i = 1;
                                        // d($misa_khusus);
                                        foreach ($misa_khusus as $m) : ?>
                                            <tr>
                                                <td><?= $m->nama_misa; ?></td>
                                                <td><?= $newDate = date("d-m-Y", strtotime($m->tanggal)); ?></td>
                                                <td><?= $m->jam; ?></td>
                                            </tr>
                                        <?php
                                            $i++;
                                        endforeach; ?>
                                    <?php endif; ?>
                                </table>
                                <table class="table table-bordered text-center table-striped  overflow-auto">
                                    <tr>
                                        <th scope="col" colspan="4" class="text-center fw-bold">KEGIATAN OUTDOOR</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">NAMA</th>
                                        <th scope="col">LOKASI</th>
                                        <th scope="col">TANGGAL MULAI</th>
                                        <th scope="col">TANGGAL SELESAI</th>

                                    </tr>
                                    <?php
                                    // d($outdoor);
                                    if ($outdoor[0]->id_kegiatan == null) : ?>
                                        <tr>
                                            <td colspan="4">
                                                No Data
                                            </td>
                                        </tr>
                                    <?php else : ?>
                                        <?php $i = 1;
                                        foreach ($outdoor as $o) : ?>

                                            <tr>
                                                <td><?= $o->nama_kegiatan; ?></td>
                                                <td><?= $o->lokasi_kegiatan; ?></td>
                                                <td><?= $newDate = date("d-m-Y", strtotime($o->tanggal_mulai)); ?></td>
                                                <td><?= $newDate = date("d-m-Y", strtotime($o->tanggal_selesai)); ?></td>
                                            </tr>

                                        <?php
                                            $i++;
                                        endforeach; ?>
                                    <?php endif; ?>

                                    <!-- <tr> -->
                                    <!-- <td><?= $jml_hadir; ?></td>
                                                <td><?= $jmlMinggu; ?></td> -->
                                    <!-- <td colspan="4">
                                            <a href="/DataAnggota" class="btn btn-success">BACK</a>
                                        </td> -->
                                    <!-- </tr> -->
                                </table>
                            </div>
                        </div>
                    </div><!-- End Recent Sales -->
                </div>
            </div>
        </div>
        <!-- End Left side columns -->

        </div>
    </section>

</main>
<?= $this->endSection(); ?>