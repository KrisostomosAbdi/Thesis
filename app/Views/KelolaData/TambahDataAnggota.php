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

                                <!-- <h5 class="card-title">EDIT DATA</h5> -->
                                <h3 class="fw-bold text-center" style="margin-top:15px;color: #444441;">TAMBAH DATA</h3>
                                <?php if (session()->getFlashdata('pesan')) : ?>
                                    <div class="alert alert-primary" role="alert">
                                        <?= session()->getFlashdata('pesan'); ?>
                                    </div>
                                <?php endif; ?>
                                <!-- Vertical Form -->
                                <form class="row g-3" action="/DataAnggota/save" id="inputform" method="post" enctype="multipart/form-data">
                                    <div class="col-12">
                                        <label for="inputNanme4" class="form-label">Nama Lengkap</label>
                                        <input type="text" name="namalengkap" class="form-control" id="inputNanme4" value="<?= old('namalengkap'); ?>" maxlength="255" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="inputNanme4" class="form-label">Nama Panggilan</label>
                                        <input type="text" name="namapanggilan" class="form-control" id="inputNanme4" value="<?= old('namapanggilan'); ?>" maxlength="255" required>
                                    </div>
                                    <!-- <div class="col-12"> -->
                                    <div class="col-12">
                                        <label for="inputNanme4" class="form-label">Jabatan</label>
                                        <!-- <input type="text" name="status" class="form-control" id="inputNanme4" value="<?= old('status'); ?>" maxlength="15" required> -->
                                        <select class="form-select" name="status" required>
                                            <option value=""></option>
                                            <option value="Anggota">Anggota</option>
                                            <option value="Kapten">Kapten</option>
                                            <option value="Pengurus">Pengurus</option>
                                            <?php if (in_groups('pendamping') or in_groups('admin')) : ?>
                                                <option value="WakilKetua">Wakil Ketua</option>
                                                <option value="Ketua">Ketua</option>
                                                <option value="Pendamping">Pendamping</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class=" col-12">
                                        <label for="inputNanme4" class="form-label">Tanggal Masuk</label>
                                        <input type="date" name="tglmasuk" class="form-control" id="inputNanme4" value="<?= old('tglmasuk'); ?>" required>
                                    </div>
                                    <div class=" col-12">
                                        <label for="inputNanme4" class="form-label">Tempat Lahir</label>
                                        <input type="text" name="tempatlahir" class="form-control" id="inputNanme4" value="<?= old('tempatlahir'); ?>" maxlength="100" required>
                                    </div>
                                    <div class=" col-12">
                                        <label for="inputNanme4" class="form-label">Tanggal Lahir</label>
                                        <input type="date" name="tgllahir" class="form-control" id="inputNanme4" value="<?= old('tgllahir'); ?>" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="inputNanme4" class="form-label">Nomor telepon</label>
                                        <input type="number" name="no_telepon" class="form-control" id="inputNanme4" value="<?= old('no_telepon'); ?>" maxlength="14" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="inputNanme4" class="form-label">Nama Orang Tua</label>
                                        <input type="text" name="nama_ortu" class="form-control" id="inputNanme4" value="<?= old('nama_ortu'); ?>" maxlength="255" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="inputNanme4" class="form-label">Nomor Telepon Orang Tua</label>
                                        <input type="number" name="no_telepon_ortu" class="form-control" id="inputNanme4" value="<?= old('no_telepon_ortu'); ?>" maxlength="14" minlength="12" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="inputNanme4" class="form-label">Alamat</label>
                                        <input type="text" name="alamat" class="form-control" id="inputNanme4" value="<?= old('alamat'); ?>" maxlength="255" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="paroki" class="form-label">Paroki</label>
                                        <select class="form-select selectadd" name="paroki" id="paroki" required>
                                            <!-- <option disabled>Jika nama paroki anda tidak ada, anda dapat menginputkannya dan menekan enter</option> -->
                                            <option value=""></option>
                                            <option disabled>Jika nama paroki anda tidak ada, anda dapat menginputkannya dan menekan enter</option>
                                            <option value="-">-</option>
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
                                        <select class="form-select selectadd" name="wilayah" id="wilayah" required>
                                            <option value=""></option>
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
                                        <input type="text" name="lingkungan" class="form-control" id="inputNanme4" value="<?= old('lingkungan'); ?>" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="inputNanme4" class="form-label">Motivasi menjadi Misdinar</label>
                                        <input type="text" name="motivasi" class="form-control" id="inputNanme4" value="<?= old('motivasi'); ?>" required>
                                    </div>

                                    <?php if (in_groups('pendamping') or in_groups('admin')) : ?>
                                        <label for="checkbox" class="form-label">Berpengalaman memegang jabatan berikut?</label>
                                        <div class="form-check" id="checkbox">
                                            <input class="form-check-input" type="checkbox" name="check_kapten" value="kapten_checked" id="check_kapten">
                                            <label class="form-check-label" for="check_kapten">
                                                Kapten
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="pengurus_checked" id="check_pengurus" name="check_pengurus">
                                            <label class="form-check-label" for="check_pengurus">
                                                Pengurus
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="check_ketuawakil" value="ketuawakil_checked" id="check_ketuawakil">
                                            <label class="form-check-label" for="check_ketuawakil">
                                                Ketua/Wakil
                                            </label>
                                        </div>
                                    <?php endif; ?>
                                    <div class="text-center" style="margin-top:10px;">
                                        <button type="submit" class="btn btn-primary">SUBMIT</button>
                                        <a href="/DataAnggota/" class="btn btn-success">BACK</a>
                                    </div>
                                </form><!-- Vertical Form -->
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