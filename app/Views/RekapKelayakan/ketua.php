<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<link href="<?= base_url('/css/dataset.css'); ?>" rel="stylesheet">

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
                                <h3 class="fw-bold" style="margin-top:15px;color: #444441;">DATA KELAYAKAN KETUA</h3>

                                <!-- <?php d($data_kelayakan) ?> -->

                                <?php if (session()->getFlashdata('pesan')) : ?>
                                    <div class="alert alert-primary" role="alert">
                                        <?= session()->getFlashdata('pesan'); ?>
                                    </div>
                                <?php endif; ?>
                                <!-- <h2 class=" card-title text-center">DATASET KAPTEN</h2> -->
                                <!-- Button trigger modal -->

                                <table id="table" class="table table-bordered text-center table-striped  overflow-auto" data-search="true" data-show-columns="true" data-show-multi-sort="true" data-toggle="table" data-show-columns-toggle-all="true" data-show-fullscreen="true" data-pagination="true" data-pagination-pre-text="Previous" data-pagination-next-text="Next">
                                    <thead>
                                        <tr>
                                            <!-- <th scope="col">#</th>
                                            <th scope="col">NAMA</th>
                                            <th scope="col">KELOMPOK</th>
                                            <th scope="col">STATUS</th> -->
                                            <th scope="col">#</th>
                                            <th scope="col">NAMA</th>
                                            <th scope="col" data-sortable="true">YES</th>
                                            <th scope="col" data-sortable="true">NO</th>
                                            <!-- <th scope="col" data-sortable="true">KANDIDAT KETUA</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        ?>
                                        <?php foreach ($data_kelayakan as $d) : ?>
                                            <tr>
                                                <td><?= $i; ?></td>
                                                <td><?= $d->nama_panggilan; ?></td>
                                                <td><?php echo sprintf("%.5e", $d->post_yes); ?> </td>
                                                <td><?php echo sprintf("%.5e", $d->post_no); ?> </td>
                                                <!-- <td><?= $d->kandidat_ketua ? $d->kandidat_ketua : 'no'; ?></td> -->

                                            </tr>

                                        <?php $i++;
                                        endforeach; ?>
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

<script src="<?= base_url('/js/dataanggota.js'); ?>"></script>

<script>
    $(function() {
        $('.table').bootstrapTable()
    })
</script>
<?= $this->endSection(); ?>