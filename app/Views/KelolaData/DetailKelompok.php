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
                                <?php d($detailkelompok); ?>
                                <h1 class="card-title text-center">DATA ANGGOTA </h1>

                                <div class="justify-content-center text-center" style="margin-bottom:15px; margin-top:-5px;">

                                    <a href="/DataKelompok/" class="btn btn-primary">BACK</a>
                                    <a href="/DataKelompok/Update/<?= $detailkelompok['0']->id_kelompok; ?>" class="btn btn-success">EDIT</a>

                                </div>


                                <table class="table table-bordered text-center table-striped  overflow-auto">

                                    <tr>
                                        <th scope="col" colspan="4" class="text-center fw-bold">MISA BESAR</th>
                                    </tr>
                                    <tr>
                                        <!-- <th scope="col">NAMA PANJANG</th> -->
                                        <th scope="col">NAMA</th>
                                        <th scope="col">STATUS</th>
                                    </tr>

                                    <?php $i = 1;
                                    foreach ($detailkelompok as $m) : ?>
                                        <tr>
                                            <td><?= $m->nama_panggilan; ?></td>
                                            <td><?= $m->status; ?></td>
                                        </tr>
                                    <?php $i++;
                                    endforeach; ?>
                                </table>

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