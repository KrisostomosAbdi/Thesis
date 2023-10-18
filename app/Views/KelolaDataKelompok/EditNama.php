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
                            <div class="card-body table-responsive">
                                <!-- <?php d($kelompok); ?> -->

                                <!-- <h1 class="card-title text-center">EDIT NAMA KELOMPOK</h1> -->
                                <h3 class="fw-bold text-center" style="margin-top:15px;color: #444441;">EDIT NAMA KELOMPOK</h3>

                                <div class="justify-content-center text-center" style="margin-bottom:15px; margin-top:5px;">

                                    <a href="/DataKelompok/" class="btn btn-primary">BACK</a>

                                </div>
                                <?php if (session()->getFlashdata('pesan')) : ?>
                                    <div class="alert alert-primary" role="alert">
                                        <?= session()->getFlashdata('pesan'); ?>
                                    </div>
                                <?php endif; ?>

                                <div class="justify-content-center text-center" style="margin-bottom:15px; margin-top:-5px;">

                                    <!-- Horizontal Form -->
                                    <form style="display: inline;" action="/DataKelompok/UpdateNamaProses" method="POST">
                                        <?php $i = 1;
                                        foreach ($kelompok as $k) : ?>
                                            <div class="row mb-3" style="display:none">
                                                <label for="inputid" class="col-sm-3 col-form-label">ID Kelompok #<?= $i; ?></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="inputid" value="<?= $k['id_kelompok']; ?>" name="idkelompok[]">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="inputNama" class="col-sm-3 col-form-label">Nama Kelompok #<?= $i; ?></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="inputNama" value="<?= (old('nama_kelompok')) ? old('nama_kelompok') : $k['nama_kelompok']; ?>" name="namakelompok[]">
                                                </div>
                                            </div>
                                        <?php $i++;
                                        endforeach; ?>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <!-- <button type="reset" class="btn btn-secondary">Reset</button> -->
                                        </div>
                                    </form><!-- End Horizontal Form -->

                                </div>

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