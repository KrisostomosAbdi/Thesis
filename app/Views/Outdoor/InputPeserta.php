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
                        <div class="card mt-4 clearfix">

                            <div class="text-center" style="margin-top: 20px;">
                                <h3 class="fw-bold" style="color: #444441;">TAMBAH DATA PESERTA KEGIATAN
                                </h3>
                                <a type="submit" name="save_multiple_data" class="btn btn-success" href="/DataOutdoor/">DASHBOARD</a>

                            </div>

                            <div class="card-body">
                                <?php if (session()->getFlashdata('pesan')) : ?>
                                    <div class="alert alert-primary" role="alert">
                                        <?= session()->getFlashdata('pesan'); ?>
                                    </div>
                                <?php endif; ?>
                                <form action="/DataOutdoor/savedata" method="POST">

                                    <div class="main-form mt-3 border-bottom">
                                        <div class="container-fluid">
                                            <div class="row content2 text-end" id="content2" style="margin-bottom: 20px;">
                                                <!-- <div class="col-md-12"> -->
                                                <!-- <div class="form-group mb-2"> -->
                                                <div class="form-group col-md-2 text-center">
                                                    <label>NAMA KEGIATAN</label>
                                                </div>
                                                <div class="form-group col-md-10 text-center">
                                                    <select id="input_nama_kegiatan" name="namakegiatan" class="form-control" required>
                                                        <option value=""></option>
                                                        <?php foreach ($kegiatan as $a) : ?>
                                                            <option value="<?= $a->id_kegiatan; ?>"><?= $a->nama_kegiatan; ?> (<?= $a->lokasi_kegiatan; ?> | <?= date("d-m-Y", strtotime($a->tanggal_mulai)); ?>)</option>

                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <!-- </div> -->
                                                <!-- </div> -->
                                            </div>
                                            <div class="content text-end" id="content">
                                                <!-- <div class="col-md-12"> -->
                                                <!-- <div class="form-group mb-2"> -->
                                                <div class="row">
                                                    <div class="form-group col-md-2 text-center">
                                                        <label>NAMA PESERTA</label>
                                                    </div>
                                                    <div class="form-group col-md-10 text-center">

                                                        <select name="namapeserta[]" class="form-control chosen-select-width" tabindex="15" required>
                                                            <option value=""></option>
                                                            <?php foreach ($anggota as $b) : ?>
                                                                <option value="<?= $b->id_anggota; ?>"><?= $b->nama_lengkap . " (" . $b->nama_panggilan . ")"; ?></option>

                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- </div> -->
                                                <!-- </div> -->

                                                <div class="change d-flex justify-content-center">
                                                    <label for="">&nbsp;</label><br />
                                                    <a href="javascript:void(0)" style="margin-top:15px; margin-bottom: 10px;" class="add-more-form float-end btn btn-primary" accesskey="a" data-bs-toggle="tooltip" data-bs-placement="top" title="You can also press 'Alt+A' to click this button">ADD MORE</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- <div class="paste-new-forms"></div> -->
                                    <center>
                                        <button type="submit" name="save_multiple_data" style="margin: 15px 0px;" class="btn btn-success">Save</button>
                                    </center>
                                </form>
                            </div>
                        </div>
                    </div><!-- End Recent Sales -->
                </div>
            </div>
            <!-- End Left side columns -->
        </div>
    </section>

</main>
<script type="text/javascript" src="<?= base_url('/js/tambahpetugasoutdoor.js') ?>"></script>
<?= $this->endSection(); ?>