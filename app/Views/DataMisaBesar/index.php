<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<!-- <link href="<?= base_url('/css/dataanggota.css'); ?>" rel="stylesheet"> -->

<main id="main" class="main">
    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Recent Sales -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body table-responsive text-center">

                                <h2 class="card-title text-center">KELOLA DATA MISA BESAR</h2>
                                <a class="btn btn-success" style="margin-top: -10px;margin-bottom: 15px;" href="/DataKelompok/UpdateNama">UPDATE</a>

                                <!-- <p>Add <code>.table-bordered</code> for borders on all sides of the table and cells.</p> -->
                                <!-- Bordered Table -->

                                <table id="tabeldata" class="table table-bordered text-center table-striped  overflow-auto">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">NAMA KELOMPOK</th>
                                            <th scope="col">JUMLAH PETUGAS</th>
                                            <th scope="col" colspan="2">ACTION</th>
                                        </tr>
                                    </thead>
                                    <?php $i = 1; ?>
                                    <tbody>
                                    </tbody>
                                </table>
                                <!-- End Bordered Table -->
                            </div>
                        </div>
                    </div><!-- End Recent Sales -->

                </div>
            </div>
            <!-- End Left side columns -->

        </div>
    </section>

</main>

<!-- <script src="<?= base_url('/js/dataanggota.js'); ?>"></script> -->

<?= $this->endSection(); ?>