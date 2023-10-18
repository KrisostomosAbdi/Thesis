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
                            <div class="card-header text-center">
                                <?php
                                $timestamp_mulai = strtotime($kegiatan['tanggal_mulai']);
                                // $dateMulai   = DateTime::createFromFormat('!m', date("d", strtotime($kegiatan['tanggal_mulai'])));
                                // $monthMulai = $dateMulai->format('F'); // March 
                                // $formattedDate = date('F d, Y', $timestamp_mulai);
                                $dateMulai = date('d', $timestamp_mulai);
                                $monthMulai = date('F', $timestamp_mulai);

                                // d($dateMulai, $monthMulai, $formattedDate, $kegiatan['tanggal_mulai']);
                                $timestamp_selesai = strtotime($kegiatan['tanggal_selesai']);
                                // $dateSelesai   = DateTime::createFromFormat('!m', date("d", strtotime($kegiatan['tanggal_selesai'])));
                                // $monthSelesai = $dateSelesai->format('F'); // March 
                                $dateSelesai = date('d', $timestamp_selesai);
                                $monthSelesai = date('F', $timestamp_selesai);
                                ?>
                                <h4 class="fw-bold" style="color: #444441;">DATA PESERTA
                                    <?php

                                    if (date("y", strtotime($kegiatan['tanggal_mulai'])) != date("y", strtotime($kegiatan['tanggal_selesai']))) { //tahun tdk sama
                                        echo strtoupper($kegiatan['nama_kegiatan']);
                                        echo "<br>";
                                        echo strtoupper($kegiatan['lokasi_kegiatan']);
                                        echo ", ";
                                        echo date("d", strtotime($kegiatan['tanggal_mulai']));
                                        echo " " . $monthMulai . " ";
                                        echo date("Y", strtotime($kegiatan['tanggal_mulai']));
                                        echo "-";
                                        echo date("d", strtotime($kegiatan['tanggal_selesai']));
                                        echo " " . $monthSelesai . " ";
                                        echo date("Y", strtotime($kegiatan['tanggal_selesai']));
                                    } else { //tahun sama
                                        if (date("m", strtotime($kegiatan['tanggal_mulai'])) == date("m", strtotime($kegiatan['tanggal_selesai']))) { //bulan sama
                                            if (date("d", strtotime($kegiatan['tanggal_mulai'])) == date("d", strtotime($kegiatan['tanggal_selesai']))) { //bulan sama tgl sama
                                                echo strtoupper($kegiatan['nama_kegiatan']);
                                                echo "<br>";
                                                echo strtoupper($kegiatan['lokasi_kegiatan']);
                                                echo ", ";
                                                echo date("d", strtotime($kegiatan['tanggal_mulai']));
                                                echo " " . $monthMulai . " ";
                                                echo date("Y", strtotime($kegiatan['tanggal_mulai']));
                                            } else { //bulan sama tgl beda
                                                echo strtoupper($kegiatan['nama_kegiatan']);
                                                echo "<br>";
                                                echo strtoupper($kegiatan['lokasi_kegiatan']);
                                                echo ", ";
                                                echo date("d", strtotime($kegiatan['tanggal_mulai']));
                                                echo "-";
                                                echo date("d", strtotime($kegiatan['tanggal_selesai']));
                                                echo " " . $monthSelesai . " ";
                                                echo date("Y", strtotime($kegiatan['tanggal_selesai']));
                                            }
                                        } else { //bulan beda
                                            echo strtoupper($kegiatan['nama_kegiatan']);
                                            echo "<br>";
                                            echo strtoupper($kegiatan['lokasi_kegiatan']);
                                            echo ", ";
                                            echo date("d", strtotime($kegiatan['tanggal_mulai']));
                                            echo " " . $monthMulai . " ";
                                            echo "-";
                                            echo date("d", strtotime($kegiatan['tanggal_selesai']));
                                            echo " " . $monthSelesai . " ";
                                            echo date("Y", strtotime($kegiatan['tanggal_selesai']));
                                        }
                                    }

                                    ?>
                                </h4>
                            </div>
                            <div class="card-body table-responsive">
                                <!-- <?php d($detailkegiatan); ?>
                                <?php d($kegiatan); ?>
                                <?php d($anggota); ?> -->



                                <div class="justify-content-center text-center" style="margin-bottom:15px; margin-top:10px;">

                                    <a href="/DataOutdoor/index" class="btn btn-primary" style="margin-bottom: 10px;">BACK</a>
                                    <a href="/DataOutdoor/inputPeserta" class="btn btn-success" style="margin-bottom: 10px;">TAMBAH</a>
                                    <?php if (session()->getFlashdata('pesan')) : ?>
                                        <div class="alert alert-primary" role="alert">
                                            <?= session()->getFlashdata('pesan'); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <table class="table table-bordered text-center table-striped  overflow-auto">
                                    <tr>
                                        <!-- <th scope="col">NAMA PANJANG</th> -->
                                        <th scope="col">NAMA PESERTA</th>
                                        <th scope="col">ACTION</th>
                                    </tr>

                                    <?php $i = 1;
                                    foreach ($detailkegiatan as $m) : ?>
                                        <?php if ($m->nama_panggilan == null) : ?>
                                            <tr>
                                                <td colspan="3">
                                                    This group has no member.
                                                </td>
                                            </tr>
                                        <?php else : ?>
                                            <tr>
                                                <td><?= $m->nama_panggilan; ?></td>
                                                <td>
                                                    <!-- <form action="/DataOutdoor/deletepeserta/<?= $m->id_anggota; ?>/<?= $kegiatan['id_kegiatan']; ?>" method="post" class="d-inline">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('apakah anda yakin?');">DELETE</button>
                                                    </form> -->
                                                    <button type="button" class="btn btn-danger btn-delete" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="<?= $m->id_anggota; ?>">
                                                        DELETE
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endif; ?>

                                    <?php $i++;
                                    endforeach; ?>
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
                <form action="/DataOutdoor/deletepeserta/<?= $kegiatan['id_kegiatan']; ?>" method="post" class="d-inline">
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
<?= $this->endSection(); ?>