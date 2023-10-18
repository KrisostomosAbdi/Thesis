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
                                <h3 class="fw-bold" style="color: #444441;">DATA KEGIATAN OUTDOOR
                                </h3>
                                <?php if (session()->getFlashdata('pesan')) : ?>
                                    <div class="alert alert-primary" role="alert">
                                        <?= session()->getFlashdata('pesan'); ?>
                                    </div>
                                <?php endif; ?>
                                <a class="btn btn-success" style="margin-top: 10px;margin-bottom: 10px;" href="/DataOutdoor/inputKegiatan">TAMBAH KEGIATAN</a>
                            </div>

                            <!-- <?php d($kegiatan) ?>
                            <?php d($anggota) ?> -->

                            <div class="card-body table-responsive text-center">
                                <!-- <h2 class="card-title text-center">KELOLA DATA MISA BESAR</h2> -->


                                <!-- <p>Add <code>.table-bordered</code> for borders on all sides of the table and cells.</p> -->
                                <!-- Bordered Table -->

                                <table id="table" class="table table-bordered text-center table-striped overflow-auto align-middle datatable">
                                    <thead>
                                        <tr class="align-middle">
                                            <th scope="col" class="text-center align-middle">#</th>
                                            <th scope="col" class="text-center align-middle">NAMA KEGIATAN</th>
                                            <th scope="col" class="text-center align-middle">JUMLAH PESERTA</th>
                                            <th scope="col" class="text-center align-middle">LOKASI</th>
                                            <th scope="col" class="text-center align-middle">TANGGAL MULAI</th>
                                            <th scope="col" class="text-center align-middle">TANGGAL SELESAI</th>

                                            <th scope="col" class="text-center align-middle" colspan="3">ACTION</th>
                                        </tr>
                                    </thead>
                                    <?php $i = 1; ?>
                                    <tbody>
                                        <?php foreach ($kegiatan as $k) :
                                            $this->db = db_connect();

                                            $jml_petugas = $this->db->table('peserta_outdoor')->like('id_kegiatan', $k['id_kegiatan'])->where('id_kegiatan', $k['id_kegiatan'])->countAllResults();

                                        ?>
                                            <tr>
                                                <td class="align-middle"><?= $i; ?></td>
                                                <td class="align-middle"><?= $k['nama_kegiatan']; ?></td>
                                                <td class="align-middle"><?= $jml_petugas; ?></td>
                                                <td class="align-middle"><?= $k['lokasi_kegiatan']; ?></td>
                                                <td class="align-middle"><?= $newDate = date("d-m-Y", strtotime($k['tanggal_mulai'])); ?></td>
                                                <td class="align-middle"><?= $newDate = date("d-m-Y", strtotime($k['tanggal_selesai'])); ?></td>

                                                <td class="align-middle"><a href="/DataOutdoor/detail/<?= $k['id_kegiatan']; ?>" class="btn btn-primary">PESERTA</a></td>
                                                <td class="align-middle">
                                                    <!-- <form action="/DataOutdoor/deletekegiatan/<?= $k['id_kegiatan']; ?>" method="post" class="d-inline">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('apakah anda yakin?');">DELETE</button>
                                                    </form> -->
                                                    <button type="button" class="btn btn-danger btn-delete" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="<?= $k['id_kegiatan']; ?>">
                                                        DELETE
                                                    </button>
                                                </td>
                                                <td class="align-middle"><a class="btn btn-success" href="/DataOutdoor/editkegiatan/<?= $k['id_kegiatan']; ?>">EDIT</a></td>
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
                <form action="/DataOutdoor/deletekegiatan/" method="post" class="d-inline">
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