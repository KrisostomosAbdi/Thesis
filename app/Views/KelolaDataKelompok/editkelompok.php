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
                                    <a href="/DataKelompok/Edit/<?= $detailkelompok['0']->kode_kelompok; ?>" class="btn btn-success">EDIT</a>

                                </div>
                                <!-- Horizontal Form -->
                                <form class="align-items-center" action="/DataKelompok/updateKelompok" method="POST">

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