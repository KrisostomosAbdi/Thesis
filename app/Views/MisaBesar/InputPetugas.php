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
                        <div class="card mt-4">
                            <!-- <div class="card-header text-center">
                                <h4>TAMBAH DATA PETUGAS MISA BESAR
                                </h4>
                            </div> -->
                            <div class="card-header text-center">
                                <h3 class="fw-bold text-center" style="margin-top:15px;color: #444441;">TAMBAH DATA PETUGAS MISA KHUSUS</h3>
                                <a type="submit" name="save_multiple_data" class="btn btn-success" href="/DataPetugasMisaBesar/home">DASHBOARD</a>

                            </div>
                            <!-- <?php d(
                                        $misabesar
                                    ) ?> -->

                            <div class="card-body">
                                <?php if (session()->getFlashdata('pesan')) : ?>
                                    <div class="alert alert-primary" role="alert">
                                        <?= session()->getFlashdata('pesan'); ?>
                                    </div>
                                <?php endif; ?>
                                <form action="/DataPetugasMisaBesar/savedata" method="POST">

                                    <div class="main-form mt-3 border-bottom">
                                        <div class="row">
                                            <div class="tanggal col-md-6">
                                                <div class="form-group mb-2">
                                                    <label for="">Tanggal Misa</label>
                                                    <input id="input_tanggal" type="date" name="tanggal[]" class="form-control" required placeholder="Enter Name">
                                                </div>
                                            </div>
                                            <div class="tanggal col-md-6">
                                                <div class="form-group mb-2">
                                                    <label for="">Jam Misa</label>
                                                    <input id="input_jam" type="time" name="jam[]" class="form-control" required placeholder="Enter Time">
                                                </div>
                                            </div>
                                            <div class="content2" id="content2" style="margin-top: 5px;">
                                                <div class="row" style="margin-bottom: 5px;">
                                                    <div class="col-md-2 text-center">
                                                        <label>Nama Misa</label>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="form-group mb-2 text-center">
                                                            <select id="input_nama_misa" name="misabesar[]" class="form-control" required>
                                                                <option value=""></option>
                                                                <?php foreach ($misabesar as $a) : ?>
                                                                    <option value="<?= $a['id_misa']; ?>"><?= $a['nama_misa']; ?></option>

                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="content" id="content">
                                                <div class="row">
                                                    <div class="col-md-2 text-center">
                                                        <label>Nama Petugas</label>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="form-group mb-2 text-center">
                                                            <select data-placeholder="Nama Petugas" name="nama[]" class="form-control chosen-select-width" tabindex="15" required>
                                                                <option value=""></option>
                                                                <?php foreach ($petugas as $b) : ?>
                                                                    <option value="<?= $b['id_anggota']; ?>"><?= $b['nama_lengkap'] . " (" . $b['nama_panggilan'] . ")"; ?></option>

                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="change d-flex justify-content-center" style="margin-bottom: 10px;">
                                                    <label for="">&nbsp;</label><br />
                                                    <a href="javascript:void(0)" class="add-more-form float-end btn btn-primary" accesskey="a" data-bs-toggle="tooltip" data-bs-placement="top" title="You can also press 'Alt+A' to click this button">ADD MORE</a>
                                                    <!-- <i class="bi bi-info-circle-fill showinfo"></i>
                                                    <div class="hide">Password format : PAK-(BulanLahir+TanggalLahir+2DigitTahunLahir) </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="paste-new-forms"></div>
                                    <center>
                                        <button type="submit" name="save_multiple_data" style="margin: 15px 0px;" class="btn btn-success">Save Data</button>
                                    </center>
                                </form>
                                <!-- <center>
                                    <button name="" class="btn btn-primary">
                                        <a href="#" style="color:inherit"> ABSEN </a>
                                    </button>
                                </center> -->
                            </div>
                        </div>
                    </div><!-- End Recent Sales -->
                </div>
            </div>
            <!-- End Left side columns -->
        </div>
    </section>

</main>
<script type="text/javascript" src="<?= base_url('/js/tambahdatapetugasmisa.js') ?>"></script>
<?= $this->endSection(); ?>