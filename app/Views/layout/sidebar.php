<!-- <style>
    .nav-link>span {
        font-weight: bold;
        font-size: 17pt !important;
    }

    .nav-heading {
        font-weight: bold;
        font-size: 17pt !important;
    }
</style> -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link collapsed" href="/">
                <i class="bi bi-grid"></i>
                <span>Main Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-heading">Data Anggota</li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= base_url('/DataAnggota/'); ?>">
                <i class="bi bi-card-list"></i>
                <span>Data Anggota</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= base_url('/DataAbsen/'); ?>">
                <i class="bi bi-card-list"></i>
                <span>Data Absen</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= base_url('/DataAbsen/inputAbsen'); ?>">
                <i class="bi bi-card-list"></i>
                <span>Input Absen</span>
            </a>
        </li>

        <li class="nav-heading">Data Kelompok</li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= base_url('/DataKelompok/'); ?>">
                <i class="bi bi-card-list"></i>
                <span>Data Kelompok</span>
            </a>
        </li>
        <!-- <li class="nav-item">
            <a class="nav-link collapsed" href="/">
                <i class="bi bi-card-list"></i>
                <span>Detail Data Kelompok</span>
            </a>
        </li> -->

        <li class="nav-heading">Data Misa Besar</li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= base_url('/DataPetugasMisaBesar/home'); ?>">
                <i class="bi bi-card-list"></i>
                <span>Data Misa Khusus</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= base_url('/DataPetugasMisaBesar/'); ?>">
                <i class="bi bi-card-list"></i>
                <span>Input Petugas Misa Khusus</span>
            </a>
        </li>

        <li class="nav-heading">Data Kegiatan</li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= base_url('/DataOutdoor/'); ?>">
                <i class="bi bi-card-list"></i>
                <span>Kelola Data Kegiatan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= base_url('/DataOutdoor/inputPeserta'); ?>">
                <i class="bi bi-card-list"></i>
                <span>Input Peserta Kegiatan</span>
            </a>
        </li>

        <!-- <li class="nav-heading">Prediksi Kelayakan</li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="/DataOutdoor/">
                <i class="bi bi-card-list"></i>
                <span>Prediksi Kelayakan - Simple</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="/DataOutdoor/inputPeserta" style="font-size: 10pt;">
                <i class="bi bi-card-list"></i>
                <span>Prediksi Kelayakan - Complex</span>
            </a>
        </li> -->

        <li class="nav-heading">Naive Bayes</li>

        <?php if (in_groups('admin')) : ?>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-card-list"></i><span>Prediksi Kelayakan</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?= base_url('/NaiveBayesController/viewsimple'); ?>">
                            <i class="bi bi-circle"></i><span>Simple</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('/NaiveBayesController/viewadvanced'); ?>">
                            <i class="bi bi-circle"></i><span>Advanced</span>
                        </a>
                    </li>
                </ul>
            </li>
        <?php else : ?>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-card-list"></i><span>Prediksi Kelayakan</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?= base_url('/NaiveBayesController/viewsimple'); ?>">
                            <i class="bi bi-circle"></i><span>Simple</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('/NaiveBayesController/viewadvanceduser'); ?>">
                            <i class="bi bi-circle"></i><span>Advanced</span>
                        </a>
                    </li>
                </ul>
            </li>
        <?php endif; ?>

        <?php if (in_groups('pengurus') or in_groups('pendamping')) : ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= base_url('/NaiveBayesController/akurasiSimple'); ?>">
                    <i class="bi bi-card-list"></i>
                    <span>Akurasi</span>
                </a>
            </li>
        <?php else : ?>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#tables-nav1" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-card-list"></i><span>Akurasi</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="tables-nav1" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?= base_url('/NaiveBayesController/akurasiSimple'); ?>">
                            <i class="bi bi-circle"></i><span>Simple</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('/NaiveBayesController/akurasi'); ?>">
                            <i class="bi bi-circle"></i><span>Advanced</span>
                        </a>
                    </li>
                </ul>
            </li>

        <?php endif; ?>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#tables-nav4" data-bs-toggle="collapse" href="#">
                <i class="bi bi-card-list"></i><span>Data Kelayakan</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="tables-nav4" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="<?= base_url('/NaiveBayesController/viewDataKapten'); ?>">
                        <i class="bi bi-circle"></i><span>Kapten</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('/NaiveBayesController/viewDataPengurus'); ?>">
                        <i class="bi bi-circle"></i><span>Pengurus</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('/NaiveBayesController/viewDataKetua'); ?>">
                        <i class="bi bi-circle"></i><span>Ketua</span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- End Icons Nav -->
        <!-- <li class="nav-heading">INPUT DATA</li> -->
        <?php if (in_groups('admin') or in_groups('pendamping')) : ?>

            <li class="nav-heading">KELOLA DATASET</li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= base_url('/KelolaDataset/DatasetKapten'); ?>">
                    <i class="bi bi-person"></i>
                    <span>Dataset Kapten</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= base_url('/KelolaDataset/DatasetPengurus'); ?>">
                    <i class="bi bi-person"></i>
                    <span>Dataset Pengurus</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= base_url('/KelolaDataset/DatasetKetuaWakil'); ?>">
                    <i class="bi bi-person"></i>
                    <span>Dataset Ketua-Wakil</span>
                </a>
            </li><!-- End Profile Page Nav -->
        <?php endif; ?>

        <?php if (in_groups('pendamping') or in_groups('admin')) : ?>

            <li class="nav-heading">User Management</li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= base_url('/Admin/'); ?>">
                    <i class="bi bi-person"></i>
                    <span>User List</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= base_url('/Admin/add'); ?>">
                    <i class="bi bi-card-list"></i>
                    <span>Tambah User</span>
                </a>
            </li>
        <?php endif; ?>

        <!-- <li class="nav-heading">Pages</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-register.html">
                <i class="bi bi-card-list"></i>
                <span>Register</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-login.html">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Login</span>
            </a>
        </li>End Login Page Nav -->

    </ul>

</aside>