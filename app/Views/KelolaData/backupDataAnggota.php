<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<link href="<?= base_url('/css/dataanggota.css'); ?>" rel="stylesheet">

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
                            <div class="card-body table-responsive">

                                <h2 class="card-title text-center">DATA ANGGOTA </h2>
                                <?php d($anggota) ?>
                                <!-- <p>Add <code>.table-bordered</code> for borders on all sides of the table and cells.</p> -->
                                <!-- Bordered Table -->

                                <table class="table table-bordered text-center table-striped  overflow-auto">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">NAMA</th>
                                            <th scope="col">KELOMPOK</th>
                                            <th scope="col">STATUS</th>
                                            <th scope="col">DURASI ANGGOTA</th>
                                            <th scope="col">UMUR</th>
                                            <th scope="col">ABSEN</th>
                                            <th scope="col">MISA BESAR</th>
                                            <th scope="col">Kandidat Kapten</th>
                                            <th scope="col">Kandidat Pengurus</th>
                                            <th scope="col">Kandidat Ketua/Wakil</th>
                                            <th scope="col" colspan="2">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1 ?>
                                        <?php foreach ($anggota as $a) : ?>
                                            <tr>
                                                <th scope="row"><?= $i++; ?></th>
                                                <td><?= $a['nama']; ?></td>
                                                <td><?= $a['nama_kelompok'] ? $a['nama_kelompok'] : '-'; ?></td>
                                                <td><?= $a['status'] ? $a['status'] : '-'; ?></td>
                                                <td><?= ($diff = date_diff(date_create($a['tanggal_masuk']), date_create(date("Y-m-d")))->format('%y')); ?></td>
                                                <td><?= ($diff = date_diff(date_create($a['tanggal_lahir']), date_create(date("Y-m-d")))->format('%y')); ?></td>
                                                <td></td>
                                                <td></td>
                                                <td><?= $a['kandidat_kapten'] ? $a['kandidat_kapten'] : 'no'; ?></td>
                                                <td><?= $a['kandidat_pengurus'] ? $a['kandidat_pengurus'] : 'no'; ?></td>
                                                <td><?= $a['kandidat_ketua'] ? $a['kandidat_ketua'] : 'no'; ?></td>
                                                <td></td>
                                                <td></td>
                                            </tr>

                                        <?php endforeach; ?>
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

<?= $this->endSection(); ?>