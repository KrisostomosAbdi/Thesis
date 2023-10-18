<?= $this->extend('auth/template/index'); ?>

<?= $this->section('content'); ?>

<main>
    <div class="container">

        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                        <!-- <div class="d-flex justify-content-center py-4">
                            <a href="index.html" class="logo d-flex align-items-center w-auto">
                                <img src="assets/img/logo.png" alt="">
                                <span class="d-none d-lg-block">NiceAdmin</span>
                            </a>
                        </div> -->
                        <!-- End Logo -->

                        <div class="card mb-3">
                            <div class="card-body">

                                <div class="pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4"><?= lang('Auth.forgotPassword') ?></h5>
                                    <!-- <p class="text-center small">Enter your username & password to login</p> -->
                                    <?= view('Myth\Auth\Views\_message_block') ?>
                                </div>

                                <p class="fs-6"><?= lang('Auth.enterEmailForInstructions') ?></p>

                                <form class="row g-3 needs-validation" action="<?= url_to('forgot') ?>" method="post">
                                    <?= csrf_field() ?>
                                    <div class="col-2">
                                        <label for="login" class="form-label"><?= lang('Auth.email') ?></label>
                                    </div>
                                    <div class="col-10">
                                        <div class="input-group has-validation">
                                            <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                                            <input type="email" name="login" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.email') ?>" required>
                                            <div class="invalid-feedback"><?= session('errors.login') ?></div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit"><?= lang('Auth.sendInstructions') ?></button>
                                    </div>

                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </section>

    </div>
</main><!-- End #main -->

<?= $this->endSection(); ?>