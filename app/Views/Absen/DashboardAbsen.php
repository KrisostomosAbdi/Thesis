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

                                <!-- <h2 class="card-title text-center">DATA ANGGOTA</h2> -->
                                <h3 class="fw-bold text-center" style="margin-top:15px;margin-bottom:5px;color: #444441;">DATA ABSEN</h3>
                                <hr>
                                <a class="btn btn-success" style="margin-bottom: 5px;" href="/DataAbsen/inputAbsen">TAMBAH DATA</a>
                                <?php if (session()->getFlashdata('pesan')) : ?>
                                    <div class="alert alert-primary" role="alert">
                                        <?= session()->getFlashdata('pesan'); ?>
                                    </div>
                                <?php endif; ?>

                                <center>
                                    <form action="/DataAbsen/deleteAbsenbatch" method="post" class="d-inline">
                                        <button class="btn btn-danger" type="submit" name="deletebacth">DELETE BATCH</button>
                                        <table id="table" class="table table-hover  text-center table-striped text-center overflow-auto" style="width:100%" data-search="true" data-show-columns="true" data-show-multi-sort="true" data-toggle="table" data-show-columns-toggle-all="true" data-show-fullscreen="true" data-pagination="true" data-pagination-pre-text="Previous" data-pagination-next-text="Next">
                                            <thead>
                                                <tr class="text-center">
                                                    <!-- <th scope="col" class="align-middle text-center" data-sortable="true">#</th> -->
                                                    <th scope="col" class="align-middle text-center">#</th>
                                                    <th scope="col" class="align-middle text-center" data-sortable="true">NAMA</th>
                                                    <th scope="col" class="align-middle text-center" data-sortable="true">ABSENSI</th>
                                                    <th scope="col" Class="align-middle text-center" data-sortable="true">TANGGAL</th>
                                                    <th scope="col" class="align-middle text-center" data-sortable="true">JAM</th>
                                                    <th scope="col" class="align-middle text-center">ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1;
                                                ?>
                                                <?php foreach ($anggota as $a) : ?>
                                                    <?php $this->db = db_connect(); ?>
                                                    <tr>
                                                        <!-- <th scope="row" class="text-center"><?= $i++; ?></th> -->

                                                        <td><input class="form-check-input" type="checkbox" name="check_value[]" value="<?= $a->id_absen; ?>" autocomplete="off"></td>
                                                        <td><?= $a->nama_panggilan; ?></td>
                                                        <td><?php if ($a->absen == 'HADIR') : ?>
                                                                <?= $a->absen; ?>
                                                            <?php else : ?>
                                                                <?= 'TIDAK HADIR'; ?>
                                                            <?php endif; ?></td>
                                                        <td>
                                                            <?= ($newDate = date("d-m-Y", strtotime($a->tanggal))) ? ($newDate = date("d-m-Y", strtotime($a->tanggal))) : '-' ?>
                                                        </td>
                                                        <td><?= $a->jam; ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger btn-delete" data-bs-toggle="modal" data-bs-target="#exampleModal" data-idhapus="<?= $a->id_absen; ?>">
                                                                DELETE
                                                            </button>

                                                        </td>
                                                    </tr>

                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </form>
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
                <br>
                <form action="/DataAbsen/deleteAbsen/" method="post" class="d-inline">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id_del" class="id_hapus">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger">YES</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">NO</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '.btn-delete', function() {

            var id = $(this).data("idhapus");

            $('.id_hapus').val(id);
        });
    });

    $(function() {
        $('#table').bootstrapTable()
    })
</script>
<script src="<?= base_url('/js/dataanggota.js'); ?>"></script>

<?= $this->endSection(); ?>