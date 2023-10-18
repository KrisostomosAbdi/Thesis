<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<style>
    .change>a {
        margin-bottom: 10px;
    }
</style>
<main id="main" class="main">

    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Recent Sales -->
                    <div class="col-12">
                        <div class="card mt-4">
                            <div class="card-header text-center">
                                <h3 class="fw-bold" style="color: #444441;">TAMBAH DATA ABSEN
                                </h3>
                            </div>

                            <div class="card-body">
                                <?php if (session()->getFlashdata('pesan')) : ?>
                                    <div class="alert alert-primary" role="alert">
                                        <?= session()->getFlashdata('pesan'); ?>
                                    </div>
                                <?php endif; ?>

                                <form action="/DataAbsen/savedata" method="POST">

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
                                            <div class="content" id="content">

                                                <div class="row">
                                                    <!-- <div class="col-md-6">
                                                        <div class="form-group mb-2">
                                                            <label for="">Tanggal Misa</label>
                                                            <input id="input_tanggal" type="date" name="tanggal[]" class="form-control" required placeholder="Enter Name">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-2">
                                                            <label for="">Jam Misa</label>
                                                            <input id="input_jam" type="time" name="jam[]" class="form-control" required placeholder="Enter Time">
                                                        </div>
                                                    </div> -->
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-2">
                                                            <label>Nama Anggota</label>
                                                            <select data-placeholder="Nama Anggota" name="nama[]" class="form-control chosen-select-width" tabindex="15" required>
                                                                <option value=""></option>
                                                                <?php foreach ($anggota as $a) : ?>
                                                                    <option class="text-center" value="<?= $a->id_anggota; ?>"><?= $a->nama_lengkap . " (" . $a->nama_panggilan . ")"; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-6">
                                                        <div class="form-group mb-2">
                                                            <label for="">absen</label><br>
                                                            <input type="checkbox" id="vehicle1" name="absensi[]" value="HADIR" class="form-check-input" required placeholder="Enter Absence State" checked>
                                                            <label for="absensi[]">HADIR</label><br>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="change d-flex justify-content-center" style="margin-top: 5px;">
                                                    <a href="javascript:void(0)" class="add-more-form float-end btn btn-primary" accesskey="a" data-bs-toggle="tooltip" data-bs-placement="top" title="You can also press 'Alt+A' to click this button">ADD MORE</a>
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
<script type="text/javascript" src="<?= base_url('/js/tambahdataabsen.js') ?>"></script>
<?= $this->endSection(); ?>