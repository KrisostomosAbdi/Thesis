<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<main id="main" class="main">

    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">
                    <!-- <?php d($groups) ?> -->
                    <!-- Recent Sales -->
                    <div class="col-12">
                        <div class="card mt-4">
                            <div class="card-header text-center">
                                <h2 class="fw-bold" style="margin-top:15px;color: #444441;">DATA USER</h2>
                                <?= view('Myth\Auth\Views\_message_block') ?>

                                <?php if (session()->getFlashdata('pesan')) : ?>
                                    <div class="alert alert-primary" role="alert">
                                        <?= session()->getFlashdata('pesan'); ?>
                                    </div>
                                <?php endif; ?>
                                <a class="btn btn-success" style="margin-top: 10px;margin-bottom: 10px;" href="/Admin/add">TAMBAH</a>
                                <!-- <a class="btn btn-success" style="margin-top: 10px;margin-bottom: 10px;" href="/DataPetugasMisaBesar/UpdateNama">EDIT</a> -->
                            </div>

                            <div class="card-body text-center">
                                <!-- <h2 class="card-title text-center">KELOLA DATA MISA BESAR</h2> -->


                                <!-- <p>Add <code>.table-bordered</code> for borders on all sides of the table and cells.</p> -->
                                <!-- Bordered Table -->

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Username</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Role</th>
                                            <th scope="col">Aktif</th>
                                            <th scope="col" colspan="3">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($users as $s) : ?>
                                            <?php
                                            $this->db = db_connect();
                                            $jml_admin = $this->db->table('auth_groups_users')->like('group_id', 3)->countAllResults();
                                            ?>
                                            <tr>
                                                <th scope="row"><?= $i++; ?></th>
                                                <td><?= $s->username; ?></td>
                                                <td><?= $s->email; ?></td>
                                                <td><?= $s->name; ?></td>
                                                <td>
                                                    <!-- cek btn admin -->
                                                    <?php if ($s->name == 'admin') : ?>
                                                        <!-- cek role admin -->
                                                        <?php if (in_groups('admin')) : ?>
                                                            <!-- cek jumlah admin -->
                                                            <?php if ($jml_admin > 1) : ?>
                                                                <a href="#" class="btn btn-sm btn-circle btn-active-users" data-id="<?= $s->userid; ?>" data-active="<?= $s->active == 1 ? 1 : 0; ?>" title="Klik untuk Mengaktifkan atau Menonaktifkan">
                                                                    <?= $s->active == 1 ? '<i class="bi bi bi-check-circle"></i>' : '<i class="bi bi-x-circle"></i>'; ?>
                                                                </a>
                                                            <?php else : ?>
                                                                <a href="#" class="btn btn-sm btn-circle">
                                                                    <i class="bi bi bi-check-circle"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                        <?php else : ?>
                                                            <a href="#" class="btn btn-sm btn-circle">
                                                                <i class="bi bi bi-check-circle"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                    <?php else : ?>
                                                        <a href="#" class="btn btn-sm btn-circle btn-active-users" data-id="<?= $s->userid; ?>" data-active="<?= $s->active == 1 ? 1 : 0; ?>" title="Klik untuk Mengaktifkan atau Menonaktifkan">
                                                            <?= $s->active == 1 ? '<i class="bi bi bi-check-circle"></i>' : '<i class="bi bi-x-circle"></i>'; ?>
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <!-- cek btn admin -->
                                                    <?php if ($s->name == 'admin') : ?>
                                                        <!-- cek role admin -->
                                                        <?php if (in_groups('admin')) : ?>
                                                            <a title="Detail data" href="<?= base_url('admin/' . $s->userid); ?>" class="btn btn-primary">
                                                                <i class="bi bi-person-lines-fill"></i>
                                                            </a>
                                                        <?php else : ?>
                                                            <a title="Detail data" href="<?= base_url('admin/' . $s->userid); ?>" class="btn btn-primary d-none">
                                                                <i class="bi bi-person-lines-fill"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                    <?php else : ?>
                                                        <a title="Detail data" href="<?= base_url('admin/' . $s->userid); ?>" class="btn btn-primary">
                                                            <i class="bi bi-person-lines-fill"></i>
                                                        </a>
                                                        </a>
                                                    <?php endif; ?>

                                                </td>
                                                <td style="vertical-align: middle">
                                                    <!-- cek btn admin -->
                                                    <?php if ($s->name == 'admin') : ?>
                                                        <!-- cek role admin -->
                                                        <?php if (in_groups('admin')) : ?>

                                                            <a href="#" class="btn btn-success btn-circle btn btn-change-group" data-id="<?= $s->userid; ?>" title="Ubah Grup">
                                                                <i class="bi bi-list-task"></i>
                                                            </a>

                                                            <!-- role bukan admin -->
                                                        <?php else : ?>
                                                            <a href="#" class="btn btn-success btn-circle btn btn-change-group d-none" data-id="<?= $s->userid; ?>" title="Ubah Grup">
                                                                <i class="bi bi-list-task"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                        <!-- bukan btn admin -->
                                                    <?php else : ?>
                                                        <a href="#" class="btn btn-success btn-circle btn btn-change-group" data-id="<?= $s->userid; ?>" title="Ubah Grup">
                                                            <i class="bi bi-list-task"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <!-- cek btn admin -->
                                                    <?php if ($s->name == 'admin') : ?>
                                                        <!-- cek role admin -->
                                                        <?php if (in_groups('admin')) : ?>
                                                            <!-- cek jumlah admin > 1 -->
                                                            <?php if ($jml_admin > 1) : ?>
                                                                <a title="Delete User" href="<?= base_url('admin/delete/' . $s->userid); ?>" class="btn btn-danger">
                                                                    <i class="bi bi-trash"></i>
                                                                </a>
                                                                <!-- jumlah admin < 1 -->
                                                            <?php else : ?>
                                                                <a title="Delete User" href="<?= base_url('admin/delete/' . $s->userid); ?>" class="btn btn-danger d-none">
                                                                    <i class="bi bi-trash"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                            <!-- role bukan admin -->
                                                        <?php else : ?>
                                                            <a title="Delete User" href="<?= base_url('admin/delete/' . $s->userid); ?>" class="btn btn-danger d-none">
                                                                <i class="bi bi-trash"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                        <!-- bukan btn admin -->
                                                    <?php else : ?>
                                                        <!-- <a title="Delete User" href="<?= base_url('admin/delete/' . $s->userid); ?>" class="btn btn-danger">
                                                            <i class="bi bi-trash"></i>
                                                        </a> -->
                                                        <!-- <form action="/admin/delete/<?= $s->userid; ?>" method="post" class="d-inline">
                                                            <?= csrf_field(); ?>
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <button type="submit" class="btn btn-danger" onclick="return confirm('apakah anda yakin?');"><i class="bi bi-trash"></i></button>
                                                        </form> -->
                                                        <button type="button" class="btn btn-danger btn-delete" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="<?= $s->userid; ?>">
                                                            <i class="bi bi-trash"></i>
                                                        </button>

                                                    <?php endif; ?>

                                                </td>

                                            </tr>
                                        <?php endforeach; ?>
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

<form action="<?= base_url(); ?>/Admin/changeGroup" method="post">
    <div class="modal fade" id="changeGroupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title align-middle" id="exampleModalLabel">Ubah Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="list-group-item p-3">
                        <div class="row align-items-start">
                            <div class="col-md-4 mb-8pt mb-md-0">
                                <div class="media align-items-left">
                                    <div class="media-body media-middle">
                                        <span class="card-title">Role</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col mb-8pt mb-md-0">
                                <select name="group" class="form-control" data-toggle="select">
                                    <?php
                                    foreach ($groups as $key => $row) {
                                    ?>
                                        <?php if (in_groups('admin')) : ?>
                                            <?php if ($jml_admin > 1) : ?>
                                                <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                                            <?php else : ?>
                                                <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                                            <?php endif; ?>
                                        <?php elseif (in_groups('pendamping')) : ?>
                                            <?php if ($row->name != 'admin') : ?>
                                                <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                                            <?php endif; ?>
                                        <?php else : ?>
                                            <?php if ($row->name != 'admin' && $row->name != 'pendamping') : ?>
                                                <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" class="id">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
            </div>
        </div>
    </div>
</form>

<form action="<?= base_url(); ?>/admin/activate" method="post">
    <div class="modal fade" id="activateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Aktivasi User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Pilih "Ya" untuk mengaktivasi/non-aktivasi User</div>
                <div class="modal-footer">
                    <input type="hidden" name="id" class="id">
                    <input type="hidden" name="active" class="active">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Ya</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
                <br>
                <form action="/admin/delete/" method="post" class="d-inline">
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

<script type="text/javascript">
    $(document).ready(function() {
        $('.btn-change-group').on('click', function() {
            const id = $(this).data('id');

            $('.id').val(id);
            $('#changeGroupModal').modal('show');
        });
    });


    $(document).ready(function() {
        // get Delete Page
        $('.btn-active-users').on('click', function() {
            // get data from button edit
            const id = $(this).data('id');
            const active = $(this).data('active');

            // Set data to Form Edit
            $('.id').val(id);
            $('.active').val(active);
            // Call Modal Edit
            $('#activateModal').modal('show');
        });

    });
</script>
<?= $this->endSection() ?>