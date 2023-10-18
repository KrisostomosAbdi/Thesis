<?= $this->extend('auth/template/index'); ?>

<?= $this->section('content'); ?>
<main>
    <div class="container">

        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                        <!-- End Logo -->

                        <div class="card mb-3">

                            <div class="card-body">

                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4"><?= lang('Auth.register') ?></h5>
                                    <!-- <p class="text-center small">Enter your personal details to create account</p> -->
                                    <?= view('Myth\Auth\Views\_message_block') ?>

                                </div>

                                <form class="row g-3 needs-validation" action="<?= url_to('register') ?>" method="post" novalidate>
                                    <?= csrf_field() ?>

                                    <div class="col-12">
                                        <label for="email" class="form-label"><?= lang('Auth.email') ?></label>
                                        <input type="email" name="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" name="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required>
                                        <div class="invalid-feedback">Please enter a valid Email adddress!</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="username" class="form-label"><?= lang('Auth.username') ?></label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                                            <input type="text" name="username" class="form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" name="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>" required>
                                            <!-- <div class=" invalid-feedback">Please choose a username. -->
                                        </div>
                                    </div>


                                    <div class="col-12">
                                        <label for="password" class="form-label"><?= lang('Auth.password') ?></label>
                                        <input type="password" name="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>" autocomplete="off" required>
                                        <div class="invalid-feedback">Please enter your password!</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="pass_confirm" class="form-label"><?= lang('Auth.repeatPassword') ?></label>
                                        <input type="password" name="pass_confirm" class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.repeatPassword') ?>" autocomplete="off">
                                        <div class="invalid-feedback">Please enter your password!</div>
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit"><?= lang('Auth.register') ?></button>
                                    </div>
                                    <div class="col-12">
                                        <p class="small mb-0"><?= lang('Auth.alreadyRegistered') ?><a href="<?= url_to('login') ?>"><?= lang('Auth.signIn') ?></a></p>
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