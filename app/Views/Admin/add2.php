<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<style>
    .hide {
        display: none;
    }

    .showinfo:hover+.hide {
        display: block;
        color: black;
    }
</style>
<main id="main" class="main">

    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Recent Sales -->
                    <div class="col-12">
                        <div class="card mt-4">
                            <!-- <div class="card-header text-center"> -->
                            <h2 class="fw-bold text-center" style="margin-top:15px;color: #444441;">TAMBAH USER
                            </h2>
                            <!-- </div> -->

                            <div class="card-body">
                                <?php if (session()->getFlashdata('pesan')) : ?>
                                    <div class="alert alert-primary" role="alert">
                                        <?= session()->getFlashdata('pesan'); ?>
                                    </div>
                                <?php endif; ?>
                                <?= view('Myth\Auth\Views\_message_block') ?>
                                <div class="row content" id="content">
                                    <div class="form-group col-md-2" style="margin-top:13px; margin-bottom: 5px;">

                                        <label>NAMA ANGGOTA</label>
                                    </div>
                                    <div class="form-group col-md-10" style="margin-top:13px; margin-bottom: 5px;">
                                        <select id="namaanggota" name="namaanggota[]" class="form-control chosen-select-width" tabindex="15" required>
                                            <option value=""></option>
                                            <?php foreach ($anggota as $b) : ?>
                                                <option value="<?= $b['id_anggota']; ?>"><?= $b['nama_panggilan']; ?></option>

                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <form class="row g-3 needs-validation" action="<?= base_url(); ?>/Admin/save" method="post" novalidate>
                                    <?= csrf_field() ?>

                                    <div class="col-12">
                                        <label for="email" class="form-label"><?= lang('Auth.email') ?></label>
                                        <input type="email" name="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" name="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required>
                                        <div class="invalid-feedback">Please enter a valid Email adddress!</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="username" class="form-label"><?= lang('Auth.username') ?></label>
                                        <i class="bi bi-info-circle-fill showinfo"></i>
                                        <div class="hide">Format Username : NamaPanggilan+Tanggal+2 DigitTahunLahir </div>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                                            <input type="text" id="username" name="username" class="form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" name="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>" required readonly>
                                            <!-- <div class=" invalid-feedback">Please choose a username. -->
                                        </div>
                                    </div>


                                    <div class="col-12">
                                        <label for="password" class="form-label"><?= lang('Auth.password') ?></label>
                                        <i class="bi bi-info-circle-fill showinfo"></i>
                                        <div class="hide">Password format : PAK-(BulanLahir+TanggalLahir+2DigitTahunLahir) </div>
                                        <input type="password" id="password" name="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>" autocomplete="off" required readonly>
                                        <div class="invalid-feedback">Please enter your password!</div>
                                        <input type="checkbox" onclick="showPassword()"> Show Password
                                    </div>

                                    <div class="col-12">
                                        <label for="pass_confirm" class="form-label"><?= lang('Auth.repeatPassword') ?></label>
                                        <input type="password" id="repeatpassword" name="pass_confirm" class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.repeatPassword') ?>" autocomplete="off" readonly>
                                        <div class="invalid-feedback">Please enter your password!</div>
                                        <input type="checkbox" onclick="showPassword2()"> Show Password
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit"><?= lang('Auth.register') ?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div><!-- End Recent Sales -->
                </div>
            </div>
            <!-- End Left side columns -->
        </div>
    </section>

</main>
<script type="text/javascript" src="<?= base_url('/js/naivebayesview.js') ?>"></script>
<script>
    $("#namaanggota").on('change', function() {
        let kode = $("#namaanggota").val();
        // document.write(kode);

        $.ajax({
            url: "<?= base_url('Admin/getId') ?>",
            type: "GET",
            data: {
                'kode': kode,
            },
            dataType: 'json',
            success: function(data) {
                if (data == null) {
                    // $("#voucher").removeClass('is-valid');
                    // $("#voucher").addClass('is-invalid');
                    // var total_harga = (jumlah_pembelian * harga) + ongkir;
                    // $("#total_harga").val(total_harga);
                    // str = JSON.stringify(data[0]);
                    // console.log(str)

                    // console.log(data);
                    alert(data)
                } else {
                    console.log(data);
                    let nama = data[0]['nama_panggilan'];
                    let tanggal_lahir = data[0]['tanggal_lahir'];
                    const d = new Date(tanggal_lahir);

                    let tanggal = d.getDate();
                    let tahun_lahir = d.getFullYear().toString().substr(-2);
                    let bulan_lahir = d.getMonth() + 1;
                    let username = nama + tanggal + tahun_lahir;
                    let usernameLower = username.toLowerCase();
                    let password = "PAK-" + bulan_lahir + tanggal + tahun_lahir;

                    // let absen = data['absen'];
                    // let misa_khusus = data['misa_khusus'];
                    // let outdoor = data['outdoor'];

                    $("#username").val(usernameLower);
                    $("#password").val(password);
                    $("#repeatpassword").val(password);
                    // $("#absen").val(absen);
                    // $("#keikutsertaan_outdoor_activity").val(outdoor);
                }
            },
        });
    })

    function showPassword() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

    function showPassword2() {
        var x = document.getElementById("repeatpassword");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>
<?= $this->endSection(); ?>