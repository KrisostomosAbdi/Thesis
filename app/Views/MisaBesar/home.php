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
                                <h3 class="fw-bold text-center" style="margin-top:10px;color: #444441;">DATA MISA KHUSUS</h3>
                                <?php if (session()->getFlashdata('pesan')) : ?>
                                    <div class="alert alert-primary" role="alert">
                                        <?= session()->getFlashdata('pesan'); ?>
                                    </div>
                                <?php endif; ?>
                                <a class="btn btn-success" style="margin-top: 5px;margin-bottom: 5px;" href="/DataPetugasMisaBesar/TambahMisa">TAMBAH MISA</a>
                                <a class="btn btn-success" style="margin-top: 5px;margin-bottom: 5px;" href="/DataPetugasMisaBesar/UpdateNama">EDIT MISA</a>
                            </div>
                            <!-- <?php d($misabesar) ?> -->

                            <div class="card-body text-center">
                                <!-- <h2 class="card-title text-center">KELOLA DATA MISA BESAR</h2> -->


                                <!-- <p>Add <code>.table-bordered</code> for borders on all sides of the table and cells.</p> -->
                                <!-- Bordered Table -->

                                <table style="margin-top: 5px;" id="tabeldata" class="table table-bordered text-center table-striped  overflow-auto datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">#</th>
                                            <th scope="col" class="text-center">NAMA MISA</th>
                                            <th scope="col" class="text-center">LAST UPDATE</th>
                                            <th scope="col" class="text-center" colspan="2">ACTION</th>
                                        </tr>
                                    </thead>
                                    <?php $i = 1; ?>
                                    <tbody>
                                        <?php foreach ($misabesar as $k) :
                                            $this->db = db_connect();

                                            // $jml_petugas = $this->db->table('petugas_misa_khusus')->select('*')->like('id_misa', $k['id_misa'])->where('id_misa', $k['id_misa'])->orderBy('created_at', 'DESC');
                                            $builder4 = $this->db->table("petugas_misa_khusus");
                                            $builder4->select('*')->like('id_misa', $k['id_misa']);
                                            $builder4->orderBy('created_at', 'DESC');
                                            $query4 = $builder4->get();
                                            $result4 = $query4->getFirstRow();
                                        ?>
                                            <tr>
                                                <td><?= $i; ?></td>
                                                <td><?= $k['nama_misa']; ?></td>
                                                <td>
                                                    <?php if ($result4 != null) : ?>
                                                        <?= ($newDate = date("d-m-Y H:m", strtotime($result4->created_at))); ?>

                                                    <?php else : ?>
                                                        <?= '-'; ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td><a href="/DataPetugasMisaBesar/detail/<?= $k['id_misa']; ?>" class="btn btn-primary">PETUGAS</a></td>
                                                <td>
                                                    <!-- <form action="/DataPetugasMisaBesar/hapusdatamisa/<?= $k['id_misa']; ?>" method="post" class="d-inline">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('apakah anda yakin?');">DELETE</button>
                                                    </form> -->

                                                    <button type="button" class="btn btn-danger btn-delete" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="<?= $k['id_misa']; ?>">
                                                        DELETE
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php $i++;
                                        endforeach; ?>
                                    </tbody>
                                </table>
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
                <form action="/DataPetugasMisaBesar/hapusdatamisa/" method="post" class="d-inline">
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
        $(document).on('click', '.btn-delete', function() {
            var id = $(this).data("id");

            $('.id_del').val(id);
        });
    });
</script>
<!-- <script type="text/javascript" src="<?= base_url('/js/tambahdatapetugasmisa.js') ?>"></script> -->
<?= $this->endSection(); ?>