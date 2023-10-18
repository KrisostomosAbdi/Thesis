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
                            <div class="card-body table-responsive">

                                <!-- <h2 class="card-title text-center">DATA KELOMPOK</h2> -->
                                <h3 class="fw-bold text-center" style="margin-top:15px;margin-bottom:5px;color: #444441;">DATA KELOMPOK</h3>

                                <!-- <?php d($kelompok) ?> -->
                                <!-- <p>Add <code>.table-bordered</code> for borders on all sides of the table and cells.</p> -->
                                <!-- Bordered Table -->

                                <table id="tabeldata" class="table table-bordered text-center table-striped  overflow-auto">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">NAMA KELOMPOK</th>
                                            <th scope="col">JUMLAH MEMBER</th>
                                            <th scope="col" colspan="2">ACTION</th>
                                        </tr>
                                    </thead>
                                    <?php $i = 1; ?>
                                    <tbody>
                                        <?php
                                        $this->db = db_connect();

                                        foreach ($kelompok as $k) :
                                            $jml_member = $this->db->table('detail_kelompok')->like('id_kelompok', $k['id_kelompok'])->where('id_kelompok', $k['id_kelompok'])->countAllResults();

                                        ?>
                                            <tr>
                                                <td><?= $i; ?></td>
                                                <td><?= $k['nama_kelompok']; ?></td>
                                                <td><?= $jml_member; ?></td>
                                                <td><a href="/DataKelompok/detail/<?= $k['id_kelompok']; ?>" class="btn btn-success btn-sm">MEMBER</a></td>
                                                <td><a href="/DataAnggota/detail/<?= $k['id_kelompok']; ?>" class="btn btn-success btn-sm">UPDATE</a></td>

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

<?= $this->endSection(); ?>