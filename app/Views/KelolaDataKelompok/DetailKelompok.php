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
                                <!-- <?php d($detailkelompok); ?>
                                <?php d($kelompok); ?>
                                <?php d($anggota); ?> -->

                                <!-- <h1 class="card-title text-center">DATA KELOMPOK <?= strtoupper($kelompok['nama_kelompok']); ?></h1> -->
                                <h3 class="fw-bold text-center" style="margin-top:15px;color: #444441;">DATA KELOMPOK <?= strtoupper($kelompok['nama_kelompok']); ?></h3>

                                <div class="justify-content-center text-center" style="margin-bottom:15px; margin-top:-5px;">

                                    <a href="/DataKelompok/" class="btn btn-primary">BACK</a>
                                    <!-- <a href="/DataKelompok/Edit/<?= $kelompok['id_kelompok']; ?>" class="btn btn-success">EDIT</a> -->
                                    <a href="/DataKelompok/Tambah/<?= $kelompok['id_kelompok']; ?>" class="btn btn-success">TAMBAH</a>

                                </div>


                                <table class="table table-bordered text-center table-striped  overflow-auto">
                                    <tr>
                                        <!-- <th scope="col">NAMA PANJANG</th> -->
                                        <th scope="col">NAMA</th>
                                        <th scope="col">STATUS</th>
                                        <th scope="col">ACTION</th>
                                    </tr>

                                    <?php $i = 1;
                                    foreach ($detailkelompok as $m) : ?>
                                        <?php if ($m->nama_panggilan == null) : ?>
                                            <tr>
                                                <td colspan="3">
                                                    This group has no member.
                                                </td>
                                            </tr>
                                        <?php else : ?>
                                            <tr>
                                                <td><?= $m->nama_panggilan; ?></td>
                                                <td><?= $m->status; ?></td>
                                                <td>
                                                    <!-- <form action="/DataKelompok/hapus/<?= $m->id_anggota; ?>/<?= $kelompok['id_kelompok']; ?>" method="post" class="d-inline">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('apakah anda yakin?');">DELETE</button>
                                                    </form> -->

                                                    <button type="button" class="btn btn-danger btn-delete" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="<?= $m->id_anggota; ?>">
                                                        DELETE
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endif; ?>

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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
                <br>
                <form action="/DataKelompok/hapus/<?= $kelompok['id_kelompok']; ?>" method="post" class="d-inline">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id_del" class="id_del">
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
        $('.btn-delete').on('click', function() {
            var id = $(this).data("id");

            $('.id_del').val(id);
        });
    });
</script>
<?= $this->endSection(); ?>