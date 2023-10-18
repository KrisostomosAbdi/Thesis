<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<main id="main" class="main">


    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">
                    <!-- Recent Sales -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <?php $this->db = db_connect();

                                //ABSEN
                                // if (empty($absen)) {
                                //     $jml_hadir = 0;
                                // } else {
                                $jml_hadir = $this->db->table('absen')->like('absen', 'HADIR')->where('id_anggota', $anggota['id_anggota'])->countAllResults();
                                // }
                                // $jml_minggu = $this->db->table('absen')->like('tanggal')->distinct()->groupBy('tanggal')->countAllResults();
                                $Time = new DateTime('now');
                                $DBTime = DateTime::createFromFormat('Y-m-d', $anggota['tanggal_masuk']);
                                $diff2 = $Time->diff($DBTime);
                                $jmlMinggu = (floor($Time->diff($DBTime)->days / 7)) + 1;
                                // $Interval = floor($DBTime->diff($Time)->format('%d') + 1);
                                // if ($jml_hadir == 0) {
                                //     $decimal = 0;
                                // } else {
                                //     $decimal = $jml_bagus / $jml_hadir;
                                // }
                                $decimal = $jml_hadir / $jmlMinggu;
                                // $decimal = 1.00001;
                                if ($decimal > 1) {
                                    $decimal = 1;
                                }
                                $percent = round((float)$decimal * 100);
                                // $jml_tugas_misabesar = 0;
                                // $jml_kegiatan = 0;

                                //MISA KHUSUS
                                // if ($misa_khusus == null) {
                                //     $jml_tugas_misabesar = 0;
                                // } else {
                                $jml_tugas_misabesar = $this->db->table('petugas_misa_khusus')->like('id_petugas', $anggota['id_anggota'])->where('id_petugas', $anggota['id_anggota'])->countAllResults();
                                // };

                                //OUTDOOR ACTIVITY
                                // if ($outdoor == null) {
                                //     $jml_kegiatan = 0;
                                // } else {
                                $jml_kegiatan = $this->db->table('peserta_outdoor')->like('id_peserta', $anggota['id_anggota'])->where('id_peserta', $anggota['id_anggota'])->countAllResults();
                                // };
                                ?>

                                <!-- <h5 class="card-title">EDIT DATA</h5> -->
                                <h3 class="fw-bold text-center" style="margin-top:15px;color: #444441;">EDIT DATA</h3>
                                <?php if (session()->getFlashdata('pesan')) : ?>
                                    <div class="alert alert-primary" role="alert">
                                        <?= session()->getFlashdata('pesan'); ?>
                                    </div>
                                <?php endif; ?>
                                <!-- <?php d($anggota) ?> -->
                                <!-- Vertical Form -->
                                <form class="row g-3" action="/DataAnggota/update/<?= $anggota['id_anggota']; ?>" id="predictform" method="post" enctype="multipart/form-data">
                                    <div class="col-12">
                                        <label for="inputNanme4" class="form-label">Nama Lengkap</label>
                                        <input type="text" name="editnamalengkap" class="form-control" id="inputNanme4" value="<?= $anggota['nama_lengkap']; ?>">
                                    </div>
                                    <div class="col-12">
                                        <label for="inputNanme4" class="form-label">Nama Panggilan</label>
                                        <input type="text" name="editnama" class="form-control" id="inputNanme4" value="<?= $anggota['nama_panggilan']; ?>">
                                    </div>
                                    <!-- <div class="col-12"> -->
                                    <div class="col-12">
                                        <label for="inputNanme4" class="form-label">Jabatan</label>
                                        <!-- <input type="text" name="editstatus" class="form-control" id="inputNanme4" value="<?= $anggota['status']; ?>"> -->
                                        <select class="form-select" name="editstatus" id="inputNanme4" required style="<?= (in_groups('pendamping') or in_groups('admin')) ? '' : 'pointer-events: none' ?>">
                                            <option value="<?= $anggota['status']; ?>" selected><?= $anggota['status']; ?> (current)</option>
                                            <option value="Anggota">Anggota</option>
                                            <option value="Kapten">Kapten</option>
                                            <option value="Pengurus">Pengurus</option>
                                            <option value="WakilKetua">Wakil Ketua</option>
                                            <option value="Ketua">Ketua</option>
                                            <option value="Pendamping">Pendamping</option>
                                        </select>
                                    </div>
                                    <div class=" col-12">
                                        <label for="inputNanme4" class="form-label">Tanggal Masuk</label>
                                        <input type="date" name="edittglmasuk" class="form-control" id="inputNanme4" value="<?= $anggota['tanggal_masuk']; ?>">
                                    </div>
                                    <div class=" col-12">
                                        <label for="inputNanme4" class="form-label">Tempat Lahir</label>
                                        <input type="text" name="edittempatlahir" class="form-control" id="inputNanme4" value="<?= $anggota['tempat_lahir']; ?>">
                                    </div>
                                    <div class=" col-12">
                                        <label for="inputNanme4" class="form-label">Tanggal Lahir</label>
                                        <input type="date" name="edittgllahir" class="form-control" id="inputNanme4" value="<?= $anggota['tanggal_lahir']; ?>">
                                    </div>
                                    <div class="col-12">
                                        <label for="inputNanme4" class="form-label">Nomor telepon</label>
                                        <input type="number" name="editno_telepon" class="form-control" id="inputNanme4" value="<?= $anggota['no_telepon']; ?>" maxlength="14" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="inputNanme4" class="form-label">Nama Orang Tua</label>
                                        <input type="text" name="editnama_ortu" class="form-control" id="inputNanme4" value="<?= $anggota['nama_ortu']; ?>" maxlength="255" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="inputNanme4" class="form-label">Nomor Telepon Orang Tua</label>
                                        <input type="number" name="editno_telepon_ortu" class="form-control" id="inputNanme4" value="<?= $anggota['no_telepon_ortu']; ?>" maxlength="14" minlength="12">
                                    </div>
                                    <div class="col-12">
                                        <label for="inputNanme4" class="form-label">Alamat</label>
                                        <input type="text" name="editalamat" class="form-control" id="inputNanme4" value="<?= $anggota['alamat']; ?>" maxlength="255" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="paroki" class="form-label">Paroki</label>
                                        <select class="form-select selectadd" name="editparoki" id="paroki" required>
                                            <!-- <option disabled>Jika nama paroki anda tidak ada, anda dapat menginputkannya dan menekan enter</option> -->
                                            <option value="-">-</option>
                                            <option value="<?= $anggota['paroki']; ?>" selected><?= $anggota['paroki']; ?></option>
                                            <option disabled>Jika nama paroki anda tidak ada, anda dapat menginputkannya dan menekan enter</option>
                                            <option value="St Perawan Maria Ratu Rosario Suci (Katedral), Randusari, Semarang">St Perawan Maria Ratu Rosario Suci (Katedral), Randusari, Semarang</option>
                                            <option value="St Yusuf, Gedangan, Semarang">St Yusuf, Gedangan, Semarang </option>
                                            <option value="Keluarga Kudus, Atmodirono, Semarang">Keluarga Kudus, Atmodirono, Semarang</option>
                                            <option value="St Maria Fatima, Banyumanik, Semarang">St Maria Fatima, Banyumanik, Semarang</option>
                                            <option value="St Theresia, Bongsari, Semarang">St Theresia, Bongsari, Semarang</option>
                                            <option value="Stella Maris Jepara">Stella Maris Jepara</option>
                                            <option value="St Athanasius Agung, Karang Panas, Semarang">St Athanasius Agung, Karang Panas, Semarang</option>
                                            <option value="St Fransiskus Xaverius, Kebondalem, Semarang">St Fransiskus Xaverius, Kebondalem, Semarang</option>
                                            <option value="St. Ignatius Krapyak">St. Ignatius Krapyak</option>
                                            <option value="Mater Dei, Lampersari, Semarang">Mater Dei, Lampersari, Semarang</option>
                                            <option value="St Paulus, Sendangguwo Semarang">St Paulus, Sendangguwo Semarang</option>
                                            <option value="Hati Kudus Yesus, Tanah Mas, Semarang">Hati Kudus Yesus, Tanah Mas, Semarang</option>
                                            <option value="Kristus Raja, Ungaran">Kristus Raja, Ungaran</option>
                                            <option value="St Stanislaus, Girisonta">St Stanislaus, Girisonta</option>
                                            <option value="St Yusuf, Ambarawa">St Yusuf, Ambarawa</option>
                                            <option value="St. Thomas Rasul, Bedono">St. Thomas Rasul, Bedono</option>
                                            <option value="St. Mikael Semarang Indah">St. Mikael Semarang Indah</option>
                                            <option value="St. Petrus Sambiroto">St. Petrus Sambiroto</option>
                                            <option value="St Paulus Miki, Salatiga">St Paulus Miki, Salatiga</option>
                                            <option value="St Martinus, Weleri">St Martinus, Weleri</option>
                                            <option value="St Antonius Padua, Kendal">St Antonius Padua, Kendal</option>
                                            <option value="St Isidorus, Sukorejo/Weleri">St Isidorus, Sukorejo/Weleri</option>
                                            <option value="St Petrus, Gubug ">St Petrus, Gubug </option>
                                            <option value="Paroki Administratif St Mikael, Demak">Paroki Administratif St Mikael, Demak</option>
                                            <option value="St Yohanes Evangelista, Kudus">St Yohanes Evangelista, Kudus</option>
                                            <option value="Hati Yesus Mahakudus, Purwodadi">Hati Yesus Mahakudus, Purwodadi</option>
                                            <option value="St Yusuf, Pati">St Yusuf, Pati</option>
                                            <option value=Paroki Aministratif St Maria La Salette, Juwana "">Paroki Aministratif St Maria La Salette, Juwana </option>
                                            <option value="Kristus Raja Semesta Alam,  Tegalrejo">Kristus Raja Semesta Alam, Tegalrejo</option>
                                            <option value="St. Petrus Krisologus di Bukit Semarang Baru">St. Petrus Krisologus di Bukit Semarang Baru</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="inputNanme4" class="form-label">Wilayah</label>
                                        <select class="form-select selectadd" name="editwilayah" id="wilayah" required>
                                            <option value="<?= $anggota['wilayah']; ?>" selected><?= $anggota['wilayah']; ?></option>

                                            <option disabled>Jika nama wilayah anda tidak ada, anda dapat menginputkannya dan menekan enter</option>
                                            <option value="-">-</option>
                                            <option value="Matius">Matius</option>
                                            <option value="Markus">Markus</option>
                                            <option value="Lukas">Lukas</option>
                                            <option value="Yohanes">Yohanes</option>
                                            <option value="Maria Fatima">Maria Fatima</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="inputNanme4" class="form-label">Lingkungan</label>
                                        <input type="text" name="editlingkungan" class="form-control" id="inputNanme4" value="<?= $anggota['lingkungan']; ?>">
                                    </div>
                                    <div class="col-12">
                                        <label for="inputNanme4" class="form-label">Motivasi menjadi Misdinar</label>
                                        <input type="text" name="editmotivasi" class="form-control" id="inputNanme4" value="<?= $anggota['motivasi']; ?>" required>
                                    </div>
                                    <div class=" col-12">
                                        <label for="inputNanme4" class="form-label">Kandidat Kapten</label>
                                        <input type="text" name="layakkapten" class="form-control" id="inputNanme4" value="<?= $hasil_kapten ? $hasil_kapten : $anggota['kandidat_kapten']; ?>" readonly>
                                    </div>
                                    <div class=" col-12">
                                        <label for="inputNanme4" class="form-label">Kandidat Pengurus</label>
                                        <input type="text" name="layakpengurus" class="form-control" id="inputNanme4" value="<?= $hasil_pengurus ? $hasil_pengurus : $anggota['kandidat_pengurus']; ?>" readonly>
                                    </div>
                                    <div class=" col-12">
                                        <label for="inputNanme4" class="form-label">Kandidat Ketua</label>
                                        <input type="text" name="layakketua" class="form-control" id="inputNanme4" value="<?= $hasil_ketua ? $hasil_ketua : $anggota['kandidat_ketua']; ?>" readonly>
                                    </div>
                                    <div class="text-center" style="margin-top:10px;">
                                        <button type="submit" class="btn btn-primary">SUBMIT</button>
                                        <a href="/DataAnggota/detail/<?= $anggota['id_anggota']; ?>" class="btn btn-success">BACK</a>
                                    </div>
                                    <div style="display:none">
                                        <input type="text" name="durasi_keanggotaan" value="<?= ($diff = date_diff(date_create($anggota['tanggal_masuk']), date_create(date('Y-m-d')))->format('%y')); ?>" id="" required> <br>

                                        <input type="text" name="misa_diluar_mingguan" value="<?= $jml_tugas_misabesar; ?>" id="" required> <br>

                                        <input type="text" name="umur" value="<?= ($diff = date_diff(date_create($anggota['tanggal_lahir']), date_create(date('Y-m-d')))->format('%y')); ?>" id="" required> <br>

                                        <input type="text" name="absen" value="<?= $percent; ?>" id="" required> <br>

                                        <input type="text" name="keikutsertaan_outdoor_activity" value="<?= $jml_kegiatan; ?>" id="" required> <br>

                                    </div>
                                </form><!-- Vertical Form -->
                            </div>
                            <div class="card-footer text-center text-muted">
                                <?php
                                if ($hasil_kapten != null && $hasil_pengurus != null && $hasil_ketua != null) : //if class hasil ada nilainya

                                    echo "<p class='fw-bolder' style='color: black;'> | LAYAK KAPTEN : " . $hasil_kapten;
                                    echo " | LAYAK PENGURUS : " . $hasil_pengurus;
                                    echo " | LAYAK KETUA : " . $hasil_ketua . " |</p>"; ?>

                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Left side columns -->

        </div>
    </section>

</main>

<script>
    $(".selectadd").select2({
        tags: true
    });
</script>

<?= $this->endSection(); ?>