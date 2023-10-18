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

                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4"><?= lang('Auth.loginTitle') ?></h5>
                                    <!-- <p class="text-center small">Enter your username & password to login</p> -->
                                    <?= view('Myth\Auth\Views\_message_block') ?>

                                </div>

                                <form class="row g-3 needs-validation" action="<?= url_to('login') ?>" method="post">
                                    <?= csrf_field() ?>

                                    <div class="col-12">
                                        <?php if ($config->validFields === ['email']) : ?>

                                            <label for="login" class="form-label"><?= lang('Auth.email') ?></label>
                                            <div class="input-group has-validation">
                                                <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                                                <input type="email" name="login" class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.email') ?>" required>
                                                <div class="invalid-feedback"><?= session('errors.login') ?></div>
                                            </div>
                                        <?php else : ?>
                                            <label for="login" class="form-label"><?= lang('Auth.emailOrUsername') ?></label>
                                            <div class="input-group has-validation">
                                                <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                                                <input type="text" name="login" class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.emailOrUsername') ?>" required>
                                                <div class="invalid-feedback"><?= session('errors.login') ?></div>
                                            </div>
                                        <?php endif; ?>

                                    </div>

                                    <div class="col-12">
                                        <label for="Password" class="form-label"><?= lang('Auth.password') ?></label>
                                        <input type="password" id="password" name="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>" required>
                                        <div class="invalid-feedback"><?= session('errors.password') ?></div>
                                        <input class="mt-3" type="checkbox" onclick="showPassword()"> Show Password

                                    </div>
                                    <?php if ($config->allowRemembering) : ?>

                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input <?php if (old('remember')) : ?> checked <?php endif ?>" type="checkbox" name="remember" value="true" id="rememberMe">
                                                <label class="form-check-label" for="rememberMe"><?= lang('Auth.rememberMe') ?></label>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit"><?= lang('Auth.loginAction') ?></button>
                                    </div>
                                    <!-- <?php if ($config->allowRegistration) : ?>

                                        <div class="col-12">
                                            <p class="small mb-0">Don't have account? <a href="<?= url_to('register') ?>"><?= lang('Auth.needAnAccount') ?></a></p>
                                        </div>
                                    <?php endif; ?> -->
                                    <?php if ($config->activeResetter) : ?>
                                        <p><a href="<?= url_to('forgot') ?>"><?= lang('Auth.forgotYourPassword') ?></a></p>
                                    <?php endif; ?>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </section>

    </div>
</main><!-- End #main -->

<script>
    function showPassword() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>
<?= $this->endSection(); ?>