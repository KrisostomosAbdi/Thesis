<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<!-- <link href="<?= base_url('/css/dataanggota.css'); ?>" rel="stylesheet"> -->

<main id="main" class="main">

    <!-- <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div> -->
    <!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Recent Sales -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body table-responsive text-center">

                                <!-- <h2 class="card-title text-center">DATA ANGGOTA</h2> -->
                                <h3 class="fw-bold text-center" style="margin-top:15px;margin-bottom:5px;color: #444441;">DATA ANGGOTA</h3>
                                <hr>
                                <a class="btn btn-success" style="margin-top: 5px;" href="/DataAnggota/create">TAMBAH DATA</a>
                                <!-- <?php d($anggota) ?> -->

                                <!-- <p>Add <code>.table-bordered</code> for borders on all sides of the table and cells.</p> -->
                                <!-- Bordered Table -->
                                <center>
                                    <table id="table" class="table table-hover  text-center table-striped text-center overflow-auto" style="width:100%" data-search="true" data-show-columns="true" data-show-multi-sort="true" data-toggle="table" data-show-columns-toggle-all="true" data-show-fullscreen="true" data-pagination="true" data-pagination-pre-text="Previous" data-pagination-next-text="Next">
                                        <thead>
                                            <tr class="text-center">
                                                <th scope="col" rowspan="2" class="align-middle text-center">#</th>
                                                <th scope="col" rowspan="2" class="align-middle text-center" data-sortable="true">NAMA</th>
                                                <th scope="col" rowspan="2" class="align-middle text-center" data-sortable="true">KELOMPOK</th>
                                                <th scope="col" rowspan="2" class="align-middle text-center" data-sortable="true">JABATAN</th>
                                                <!-- <th scope="col" rowspan="2" class="align-middle text-center" data-sortable="true">DURASI</th> -->
                                                <th scope="col" rowspan="2" class="align-middle text-center" data-sortable="true">KONTAK</th>
                                                <!-- <th scope="col" rowspan="2" class="align-middle text-center" data-sortable="true">UMUR</th> -->
                                                <!-- <th scope="col" rowspan="2" class="align-middle text-center" data-sortable="true">OUTDOOR</th> -->
                                                <!-- <th scope="col" rowspan="2" class="align-middle text-center">ABSEN</th> -->
                                                <!-- <th scope="col" rowspan="2" class="align-middle text-center" data-sortable="true">MISA BESAR</th> -->
                                                <th scope="col" colspan="3" class="align-middle text-center">KANDIDAT</th>
                                                <th scope="col" rowspan="2" class="align-middle text-center">ACTION</th>
                                            </tr>
                                            <tr class="align-middle">
                                                <th scope="col" data-sortable="true">KAPTEN</th>
                                                <th scope="col" data-sortable="true">PENGURUS</th>
                                                <th scope="col" data-sortable="true">KETUA</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1;
                                            // d($anggota);
                                            ?>
                                            <?php foreach ($anggota as $a) : ?>
                                                <tr>
                                                    <th scope="row"><?= $i++; ?></th>
                                                    <td><?= $a->nama_panggilan; ?></td>
                                                    <td><?= $a->nama_kelompok ? $a->nama_kelompok : '-'; ?></td>
                                                    <td><?= $a->status ? $a->status : '-'; ?></td>
                                                    <td>
                                                        <?php if ($a->no_telepon != '0') : ?>
                                                            <a href="https://wa.me/<?= '+62' . $var = ltrim($a->no_telepon, '0'); ?>"><i class="bi bi-whatsapp" style="color: green;"></i></a>
                                                        <?php else : ?>
                                                            <a href="#" disabled><i class="bi bi-whatsapp" style="color: red;"></i></a>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= $a->kandidat_kapten ? $a->kandidat_kapten : 'no'; ?></td>
                                                    <td><?= $a->kandidat_pengurus ? $a->kandidat_pengurus : 'no'; ?></td>
                                                    <td><?= $a->kandidat_ketua ? $a->kandidat_ketua : 'no'; ?></td>
                                                    <td>
                                                        <a href="/DataAnggota/detail/<?= $a->kode_anggota; ?>" class="btn btn-primary btn-sm" style="font-size: 12px;">DETAIL</a>
                                                    </td>
                                                </tr>

                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </center>
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