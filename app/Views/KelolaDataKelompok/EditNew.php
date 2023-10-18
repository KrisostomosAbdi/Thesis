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
                                <h1 class="fw-bold text-center" style="margin-top:15px;color: #444441;">EDIT ANGGOTA KELOMPOK <?= strtoupper($detailkelompok['0']->nama_kelompok); ?> </h1>

                                <!-- <h1 class="card-title text-center"></h1> -->

                                <div class="justify-content-center text-center" style="margin-bottom:15px; margin-top:-5px;">

                                    <a href="/DataKelompok/" class="btn btn-primary">BACK</a>
                                    <a href="/DataKelompok/Edit/<?= $detailkelompok['0']->kode_kelompok; ?>" class="btn btn-success">EDIT</a>
                                    <a href="/DataKelompok/Tambah" class="btn btn-success">TAMBAH</a>

                                </div>
                                <table class="table table-bordered text-center table-striped  overflow-auto">
                                    <tr>
                                        <th>
                                            #
                                        </th>
                                        <th>
                                            NAMA
                                        </th>
                                        <th>
                                            ACTION
                                        </th>
                                    </tr>
                                    <?php $i = 0;
                                    $j = 1;
                                    foreach ($detailkelompok as $m) : ?>
                                        <tr>
                                            <td><?= $j; ?></td>
                                            <td><?= $detailkelompok[$i]->nama_panggilan; ?></td>
                                            <td>
                                                <form action="/DataKelompok/hapus/<?= $detailkelompok[$i]->id_anggota; ?>/$detailkelompok[$i]->kode_kelompok; ?>" method="post" class="d-inline">
                                                    <?= csrf_field(); ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('apakah anda yakin?');">DELETE</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php $i++;
                                        $j++;
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