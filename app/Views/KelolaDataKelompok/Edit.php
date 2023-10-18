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
                                <?php d($detailkelompok); ?>
                                <?php d($anggota); ?>

                                <h1 class="card-title text-center">EDIT ANGGOTA KELOMPOK <?= strtoupper($detailkelompok['0']->nama_kelompok); ?> </h1>

                                <div class="justify-content-center text-center" style="margin-bottom:15px; margin-top:-5px;">

                                    <a href="/DataKelompok/" class="btn btn-primary">BACK</a>
                                    <a href="/DataKelompok/Edit/<?= $detailkelompok['0']->id_kelompok; ?>" class="btn btn-success">EDIT</a>

                                </div>
                                <!-- Horizontal Form -->
                                <form class="align-items-center" action="/DataKelompok/update/<?= $detailkelompok['0']->kode_kelompok; ?>" method="POST">
                                    <?php $i = 1;
                                    foreach ($detailkelompok as $m) : ?>
                                        <div class="row mb-3">
                                            <label for="inputEmail3" class="col-sm-2 col-form-label">NAMA ANGGOTA</label>
                                            <div class="col-sm-10">
                                                <select id="nama_anggota" name="nama_anggota[]" class="form-control" required>
                                                    <option value="<?= $m->id_anggota; ?>"><?= $m->nama_panggilan; ?></option>
                                                    <?php foreach ($anggota as $a) : ?>
                                                        <option value="<?= $a['id_anggota']; ?>"><?= $a['nama_panggilan']; ?></option>

                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <!-- <label for="inputEmail3" class="col-sm-1 col-form-label">Status</label>
                                            <div class="col-sm-5">
                                                <select id="status" name="status[]" class="form-control" required>
                                                    <option value="<?= $m->status; ?>"><?= $m->status; ?></option>
                                                    <option value="anggota">anggota</option>
                                                    <option value="kapten">kapten</option>
                                                    <option value="anggota">anggota</option>
                                                </select>
                                            </div> -->
                                        </div>
                                    <?php $i++;
                                    endforeach; ?>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                    </div>
                                </form><!-- End Horizontal Form -->
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