<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<style>
    div.col-3,
    div.col-md-3 {
        text-align: left;
        margin-bottom: 10px;
    }

    div.col-9,
    div.col-md-9 {
        margin-bottom: 10px;
    }

    /* select,
    #namaanggota,
    #durasi_keanggotaan,
    #misa_diluar_mingguan,
    #umur,
    #absen,
    #keikutsertaan_outdoor_activity,
    #idanggota {
        font-weight: bold;
        font-size: 20pt;
    }

    p {
        font-weight: bold;
        font-size: 20pt;
        margin-bottom: -5px;
    }

    label {
        font-size: 20pt;
    } */
</style>
<main id="main" class="main">


    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">
                    <!-- Recent Sales -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-header text-center">
                                    <h1 class="fw-bold text-center" style="margin-top:15px; color: #444441;">PREDIKSI KELAYAKAN KANDIDAT - SIMPLE</h1>
                                </div>

                                <div class="row content" id="content">
                                    <div class="form-group fw-bold col-md-3" style="margin-top:13px; margin-bottom: 5px;">

                                        <label>NAMA ANGGOTA</label>
                                    </div>
                                    <div class="form-group col-md-9" style="margin-top:13px; margin-bottom: 5px;">
                                        <select id="namaanggota" name="namaanggota[]" class="form-control chosen-select-width" tabindex="15" required>
                                            <option value=""></option>
                                            <?php foreach ($anggota as $b) : ?>
                                                <option class="text-center" value="<?= $b['id_anggota']; ?>"><?= $b['nama_lengkap'] . " (" . $b['nama_panggilan'] . ")"; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="text-center" style="margin-bottom:15px; margin-top:10px;">

                                    <!-- text FORM-->
                                    <form class="row g-3" action="/NaiveBayesController/prediksi/" id="predictform" method="post" enctype="multipart/form-data">
                                        <div>
                                            <!-- <label for="">id_anggota</label>
                                            <input type="text" name="id_anggota" value="" id="id_anggota" required> <br> -->
                                            <div class="row">
                                                <div class="col-3">
                                                    <!-- <label for="" class="form-label">ID</label> -->
                                                </div>
                                                <div class="col-9">
                                                    <input type="hidden" class="form-control" name="idanggota" value="<?= ($id != null) ? ($id) : ('') ?>" id="idanggota">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3">
                                                    <label for="" class="form-label fw-bold">DURASI KEANGGOTAAN</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="number" class="form-control" name="durasi_keanggotaan" value="<?= ($durasi != null) ? ($durasi) : ('') ?>" id="durasi_keanggotaan" min="0" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3">
                                                    <label for="" class="form-label fw-bold">MISA BESAR</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="number" class="form-control" name="misa_diluar_mingguan" value="<?= ($misa != null) ? ($misa) : ('') ?>" id="misa_diluar_mingguan" min="0" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3">
                                                    <label for="" class="form-label fw-bold">UMUR</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="number" class="form-control" name="umur" value="<?= ($umur != null) ? ($umur) : ('') ?>" id="umur" min="9" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3">
                                                    <label for="" class="form-label fw-bold">ABSEN</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="number" class="form-control" name="absen" value="<?= ($absen != null) ? ($absen) : ('') ?>" id="absen" min="0" max="100" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3">
                                                    <label for="" class="form-label fw-bold">KEGIATAN OUTDOOR</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="number" class="form-control" name="keikutsertaan_outdoor_activity" value="<?= ($outdoor != null) ? ($outdoor) : ('') ?>" id="keikutsertaan_outdoor_activity" min="0" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12" style="margin-bottom:-5px;">
                                            <button class="btn btn-success fw-bold" name="proses" class="predictbutton" type="submit" value="PROSES">PREDICT</button>
                                            <a class="btn btn-danger fw-bold" name="proses" class="predictbutton" href="/NaiveBayesController/viewsimple" value="PROSES">RESET</a>
                                        </div>
                                    </form>
                                </div>
                                <div class="text-center">
                                    <?php
                                    if (!empty($dataanggota)) {
                                        echo "<p> <span class='fw-bold'>NAMA : </span>" . $dataanggota[0]['nama_panggilan'] . "</p>";
                                    } else {
                                    }
                                    ?>
                                    <?php
                                    if ($hasil_kapten != null && $hasil_pengurus != null && $hasil_ketua != null) : //all
                                        echo "<p><span class='fw-bold'>LAYAK KAPTEN : " . strtoupper($hasil_kapten) . " (";
                                        if ($hasil_kapten == 'yes') {
                                            echo sprintf("%.2e", $posteriorkapten['yes']);
                                        } else if ($hasil_kapten == 'no') {
                                            echo sprintf("%.2e", $posteriorkapten['no']);
                                        }
                                        echo ") </span></p>";
                                        echo "<p><span class='fw-bold'>LAYAK PENGURUS : " . strtoupper($hasil_pengurus) . " (";
                                        if ($hasil_pengurus == 'yes') {
                                            echo sprintf("%.2e", $posteriorpengurus['yes']);
                                        } else if ($hasil_pengurus == 'no') {
                                            echo sprintf("%.2e", $posteriorpengurus['no']);
                                        }
                                        echo ") </span></p>";
                                        echo "<p><span class='fw-bold'>LAYAK KETUA : " . strtoupper($hasil_ketua) . " (";
                                        if ($hasil_ketua == 'yes') {
                                            echo sprintf("%.2e", $posteriorketua['yes']);
                                        } else if ($hasil_ketua == 'no') {
                                            echo sprintf("%.2e", $posteriorketua['no']);
                                        }
                                        echo ") </span></p>";
                                    ?>

                                    <?php elseif ($hasil_kapten != null && $hasil_pengurus == null && $hasil_ketua == null) : //kapten
                                        echo "RESULT";
                                        echo "<p class='fw-bold'>LAYAK KAPTEN: " . $hasil_kapten . "</p>"; ?>

                                    <?php elseif ($hasil_kapten == null && $hasil_pengurus != null && $hasil_ketua == null) : //pengurus
                                        echo "RESULT";
                                        echo "<p class='fw-bold'>LAYAK PENGURUS: " . $hasil_pengurus . "</p>"; ?>

                                    <?php elseif ($hasil_kapten == null && $hasil_pengurus == null && $hasil_ketua != null) : //ketua
                                        echo "RESULT";
                                        echo "<p class='fw-bold'>LAYAK KETUA: " . $hasil_ketua . "</p>"; ?>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
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
            url: "<?= base_url('NaiveBayesController/getId') ?>",
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
                    let durasi_keanggotaan = data['durasi'];
                    let umur = data['umur'];
                    let absen = data['absen'];
                    let misa_khusus = data['misa_khusus'];
                    let outdoor = data['outdoor'];
                    let idanggota = data['id'];

                    $("#durasi_keanggotaan").val(durasi_keanggotaan);
                    $("#misa_diluar_mingguan").val(misa_khusus);
                    $("#umur").val(umur);
                    $("#absen").val(absen);
                    $("#keikutsertaan_outdoor_activity").val(outdoor);
                    $("#idanggota").val(idanggota);
                    $(':input').attr('readonly', 'readonly');
                }
            },
        });
    })
</script>
<?= $this->endSection(); ?>