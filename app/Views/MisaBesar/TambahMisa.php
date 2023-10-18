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
                            <div class="card-header text-center">
                                <h3 class="fw-bold text-center" style="margin-top:15px;color: #444441;">TAMBAH DATA MISA KHUSUS</h3>
                            </div>

                            <div class="card-body">
                                <?php if (session()->getFlashdata('pesan')) : ?>
                                    <div class="alert alert-primary" role="alert">
                                        <?= session()->getFlashdata('pesan'); ?>
                                    </div>
                                <?php endif; ?>

                                <form action="/DataPetugasMisaBesar/simpandatamisa" method="POST">

                                    <div class="main-form mt-3 border-bottom">
                                        <div class="row">
                                            <div class="content" id="content">
                                                <div class="form-group mb-2">
                                                    <div class="row mb-3">
                                                        <div class="col-sm-2 align-middle text-center">
                                                            <label for="inputNanme4" class="form-label ">Nama Misa</label>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="namamisa[]" class="form-control" id="inputNanme4" value="<?= old('nama_misa'); ?>" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="change d-flex justify-content-center" style="margin: 15px 0px;">
                                                    <a href="javascript:void(0)" class="add-more-form float-end btn btn-primary">ADD MORE</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="paste-new-forms"></div>
                                    <center>
                                        <button type="submit" name="save_multiple_data" style="margin: 15px 0px;" class="btn btn-success">Save Data</button>
                                    </center>
                                </form>
                                <center>
                                    <a href="/DataPetugasMisaBesar/home" class="btn btn-success">BACK</a>
                                </center>
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