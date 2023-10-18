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
                        <div class="card mt-4">
                            <div class="card-header text-center">
                                <h3 class="fw-bold text-center" style="margin-top:15px;color: #444441;">TAMBAH ANGGOTA KELOMPOK</h3>
                                <a href="/DataKelompok/detail/<?= $kelompok['id_kelompok']; ?>" class="btn btn-success">BACK</a>

                            </div>
                            <div class="card-body">
                                <?php if (session()->getFlashdata('pesan')) : ?>
                                    <div class="alert alert-primary" role="alert">
                                        <?= session()->getFlashdata('pesan'); ?>
                                    </div>
                                <?php endif; ?>
                                <form action="/DataKelompok/savedata/<?= $kelompok['id_kelompok']; ?>" method="POST">

                                    <div class="main-form mt-3 border-bottom">
                                        <div class="row">
                                            <div class="row content text-center" id="content" style="margin: 15px 0px 15px;">

                                                <div class="form-group col-md-2">
                                                    <label>Nama Anggota</label>
                                                </div>
                                                <div class="form-group col-md-8">
                                                    <select data-placeholder="Nama Anggota" name="nama[]" class="form-control chosen-select-width" tabindex="15" required>
                                                        <option value=""></option>
                                                        <?php foreach ($anggota as $a) : ?>
                                                            <option value="<?= $a['id_anggota']; ?>"><?= $a['nama_lengkap'] . " (" . $a['nama_panggilan'] . ")"; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <div class="change align-top col-md-2">
                                                    <!-- <label for="">&nbsp;</label><br /> -->
                                                    <a href="javascript:void(0)" class="add-more-form btn btn-warning">ADD MORE</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="paste-new-forms"></div>
                                    <center>
                                        <button type="submit" name="save_multiple_data" style="margin: 15px 0px;" class="btn btn-primary">Save Multiple Data</button>
                                    </center>
                                </form>
                            </div>
                        </div>
                    </div><!-- End Recent Sales -->
                </div>
            </div>
            <!-- End Left side columns -->
        </div>
    </section>

</main>
<script type="text/javascript" src="<?= base_url('/js/editnamakelompok.js') ?>"></script>
<?= $this->endSection(); ?>