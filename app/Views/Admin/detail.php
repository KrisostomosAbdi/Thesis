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
                                <h2 class="fw-bold" style="margin-top:15px;color: #444441;">DATA USER
                                </h2>
                                <?php if (session()->getFlashdata('pesan')) : ?>
                                    <div class="alert alert-primary" role="alert">
                                        <?= session()->getFlashdata('pesan'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="card-body text-center">
                                <table class="table table-bordered text-center table-striped  overflow-auto">
                                    <!-- <?php d($user) ?> -->

                                    <tr>
                                        <td scope="col" colspan="2" class="text-center fw-bold">IDENTITAS USER</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">USERNAME</th>
                                        <td>
                                            <?= $user->username; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="col">EMAIL</th>
                                        <td>
                                            <?= $user->email; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="col">ROLE</th>
                                        <td>
                                            <span class="badge rounded-pill bg-<?= ($user->name == 'pendamping') ? 'success' : 'warning' ?>"><?= $user->name; ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="col">DESKRIPSI</th>
                                        <td>
                                            <?= $user->description; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="col">CREATED AT</th>
                                        <td>
                                            <?= $user->created_at; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="col" colspan="2" class="text-center fw-bold">
                                            <a class="btn btn-primary" href="<?= base_url('admin') ?>">&laquo; BACK</a>
                                        </td>
                                    </tr>
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
<!-- <script type="text/javascript" src="<?= base_url('/js/tambahdatapetugasmisa.js') ?>"></script> -->
<?= $this->endSection(); ?>