<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<main id="main" class="main">

    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">
                    <!-- <?php d($detailkegiatan) ?> -->
                    <!-- Recent Sales -->
                    <div class="col-12">
                        <div class="card mt-4">
                            <div class="card-header text-center">
                                <h3 class="fw-bold" style="color: #444441;">EDIT DATA KEGIATAN
                                </h3>
                            </div>
                            <div class="card-body">
                                <?php if (session()->getFlashdata('pesan')) : ?>
                                    <div class="alert alert-primary" role="alert">
                                        <?= session()->getFlashdata('pesan'); ?>
                                    </div>
                                <?php endif; ?>

                                <form action="/DataOutdoor/editprosesKegiatan/<?= $detailkegiatan['0']->id_kegiatan; ?>" method="POST">

                                    <div class="main-form mt-3 border-bottom">
                                        <div class="row">
                                            <div class="content" id="content">
                                                <div class="form-group mb-2">
                                                    <div class="row mb-3">
                                                        <div class="col-sm-2 align-middle text-center">
                                                            <label for="inputNanme4" class="form-label ">Nama Kegiatan</label>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="nama_kegiatan" class="form-control" id="inputNanme4" value="<?= old('nama_kegiatan') ? old('nama_kegiatan') : $detailkegiatan['0']->nama_kegiatan ?>" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-2">
                                                    <div class="row mb-3">
                                                        <div class="col-sm-2 align-middle text-center">
                                                            <label for="lokasi" class="form-label ">Lokasi Kegiatan</label>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="lokasi" class="form-control" id="lokasi" value="<?= old('lokasi') ? old('lokasi') : $detailkegiatan['0']->lokasi_kegiatan; ?>" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-2">
                                                    <div class="row mb-3">
                                                        <div class="col-sm-2 align-middle text-center">
                                                            <label for="tgl_mulai" class="form-label ">Tanggal Mulai</label>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <input type="date" name="tgl_mulai" class="form-control" id="tgl_mulai" value="<?= old('tgl_mulai') ? old('tgl_mulai') : $detailkegiatan['0']->tanggal_mulai; ?>" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-2">
                                                    <div class="row mb-3">
                                                        <div class="col-sm-2 align-middle text-center">
                                                            <label for="tgl_selesai" class="form-label ">Tanggal Selesai</label>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <input type="date" name="tgl_selesai" class="form-control" id="tgl_selesai" value="<?= old('tgl_selesai') ? old('tgl_selesai') : $detailkegiatan['0']->tanggal_selesai; ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="paste-new-forms"></div>
                                    <center>
                                        <button type="submit" name="save_multiple_data" style="margin: 15px 0px;" class="btn btn-success">Save</button>
                                    </center>
                                </form>
                                <center>
                                    <a href="/DataOutdoor/" class="btn btn-primary">BACK</a>
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
<?= $this->endSection(); ?>