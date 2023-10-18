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
                            <!-- <div class="card-header text-center">
                            </div> -->
                            <div class="card-body table-responsive">
                                <!-- <?php d($detailmisa); ?>
                                <?php d($misa); ?>
                                <?php d($anggota); ?> -->

                                <!-- <h1 class="card-title text-center">DATA PETUGAS <?= strtoupper($misa['nama_misa']); ?></h1> -->
                                <h3 class="fw-bold text-center" style="margin-top:15px;color: #444441;">DATA PETUGAS <?= strtoupper($misa['nama_misa']); ?></h3>

                                <div class="justify-content-center text-center" style="margin-bottom:15px; margin-top:5px;">

                                    <a href="/DataPetugasMisaBesar/home" class="btn btn-primary" style="margin-bottom: 10px;">BACK</a>
                                    <!-- <a href="/DataKelompok/Edit/<?= $misa['id_misa']; ?>" class="btn btn-success">EDIT</a> -->
                                    <a href="/DataPetugasMisaBesar/" class="btn btn-success" style="margin-bottom: 10px;">TAMBAH PETUGAS</a>

                                    <?php if (session()->getFlashdata('pesan')) : ?>
                                        <div class="alert alert-primary" role="alert">
                                            <?= session()->getFlashdata('pesan'); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <table id="table" class="table table-bordered text-center table-striped  overflow-auto" data-search="true" data-show-fullscreen="true" data-pagination="true" data-pagination-pre-text="Previous" data-pagination-next-text="Next">
                                    <thead>
                                        <tr>
                                            <!-- <th scope="col">NAMA PANJANG</th> -->
                                            <th scope="col">NAMA PETUGAS</th>
                                            <th scope="col">TANGGAL</th>
                                            <th scope="col">JAM</th>
                                            <th scope="col">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        $x = 0;
                                        foreach ($detailmisa as $m) : ?>
                                            <?php if ($m->nama_panggilan == null) : ?>
                                                <tr>
                                                    <td colspan="4">
                                                        This group has no member.
                                                    </td>
                                                </tr>
                                            <?php else : ?>
                                                <?php if ($i == 1) : ?>
                                                    <tr>
                                                        <td colspan="4"><?= $misa['nama_misa'] . ' ' . date("d-m-Y", strtotime($m->tanggal)); ?> <?= $m->jam; ?></td>
                                                    </tr>
                                                <?php elseif ($detailmisa[$i - 2]->tanggal == $m->tanggal && $detailmisa[$i - 2]->jam == $m->jam) : ?>
                                                <?php else : ?>
                                                    <tr>
                                                        <td colspan="4"><?= $misa['nama_misa'] . ' ' . date("d-m-Y", strtotime($m->tanggal)); ?> <?= $m->jam; ?></td>
                                                    </tr>
                                                <?php endif; ?>
                                                <tr>
                                                    <td><?= $m->nama_panggilan; ?></td>
                                                    <td><?= date("d-m-Y", strtotime($m->tanggal)); ?></td>
                                                    <td><?= $m->jam; ?></td>
                                                    <td>
                                                        <!-- <form action="/DataPetugasMisaBesar/hapus/<?= $m->id_anggota; ?>/<?= $misa['id_misa']; ?>/<?= $m->tanggal; ?>/<?= $m->jam; ?>" method="post" class="d-inline">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('apakah anda yakin?');">DELETE</button>
                                                    </form> -->
                                                        <button type="button" class="btn btn-danger btn-delete" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="<?= $m->id_anggota; ?>" data-misa="<?= $misa['id_misa']; ?>" data-tanggal="<?= $m->tanggal; ?>" data-jam="<?= $m->jam; ?>">
                                                            DELETE
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>

                                        <?php
                                            $i++;
                                        endforeach; ?>
                                    </tbody>
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
                <form action="/DataPetugasMisaBesar/hapus/" method="post" class="d-inline">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id_del" class="id_del">
                    <input type="hidden" name="misa_del" class="misa_del">
                    <input type="hidden" name="tanggal_del" class="tanggal_del">
                    <input type="hidden" name="jam_del" class="jam_del">
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
            var id = $(this).data("id");
            var misa = $(this).data("misa");
            var tanggal = $(this).data("tanggal");
            var jam = $(this).data("jam");

            $('.id_del').val(id);
            $('.misa_del').val(misa);
            $('.tanggal_del').val(tanggal);
            $('.jam_del').val(jam);

        });
    });
    $(function() {
        $('#table').bootstrapTable()
    })
</script>
<?= $this->endSection(); ?>