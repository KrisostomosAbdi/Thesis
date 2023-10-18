<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<style>
    div.col-3 {
        text-align: left;
        margin-bottom: 10px;
    }

    div.col-9 {
        margin-bottom: 10px;
    }

    /* math {
        font-size: 21px;
        margin-top: 5px;
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
                                    <h3 class="fw-bold text-center" style="margin-top:15px;color: #444441;">PREDIKSI KELAYAKAN KANDIDAT - ADVANCE</h3>
                                </div>

                                <div class="row content" id="content">
                                    <div class="form-group col-md-3" style="margin-top:13px; margin-bottom: 5px;">

                                        <label>NAMA ANGGOTA</label>
                                    </div>
                                    <div class="form-group col-md-9" style="margin-top:13px; margin-bottom: 5px;">
                                        <select id="namaanggota" name="namaanggota[]" class="form-control chosen-select-width" tabindex="15" required>
                                            <option value=""></option>
                                            <option value=""></option>
                                            <?php foreach ($anggota as $b) : ?>
                                                <option value="<?= $b['id_anggota']; ?>"><?= $b['nama_lengkap'] . " (" . $b['nama_panggilan'] . ")"; ?></option>

                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="text-center" style="margin-bottom:15px; margin-top:10px;">

                                    <!-- text FORM-->
                                    <form class="row g-3" action="/NaiveBayesController/prediksiAdvancedKetua/<?= 'admin'; ?>" id="predictform" method="post" enctype="multipart/form-data">
                                        <div>
                                            <div class="row">
                                                <div class="col-3">
                                                    <!-- <label for="" class="form-label">ID</label> -->
                                                </div>
                                                <div class="col-9">
                                                    <input type="hidden" class="form-control" name="idanggota" value="" id="idanggota">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3">
                                                    <label for="" class="form-label">DURASI KEANGGOTAAN</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="number" class="form-control readon" name="durasi_keanggotaan" value="<?= ($durasi != null) ? ($durasi) : ('') ?>" id="durasi_keanggotaan" min="0" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3">
                                                    <label for="" class="form-label">MISA BESAR</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="number" class="form-control readon" name="misa_diluar_mingguan" value="<?= ($misa != null) ? ($misa) : ('') ?>" id="misa_diluar_mingguan" min="0" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3">
                                                    <label for="" class="form-label">UMUR</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="number" class="form-control readon" name="umur" value="<?= ($umur != null) ? ($umur) : ('') ?>" id="umur" min="9" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3">
                                                    <label for="" class="form-label">ABSEN</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="number" class="form-control readon" name="absen" value="<?= ($absen != null) ? ($absen) : ('') ?>" id="absen" min="0" max="100" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3">
                                                    <label for="" class="form-label">KEGIATAN OUTDOOR</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="number" class="form-control readon" name="keikutsertaan_outdoor_activity" value="<?= ($outdoor != null) ? ($outdoor) : ('') ?>" id="keikutsertaan_outdoor_activity" min="0" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <!-- <button class="btn btn-success" name="proses" class="predictbutton" type="submit" value="PROSES">PREDICT</button> -->
                                            <input name="proses" class="btn btn-success" type="submit" value="PREDICT KAPTEN" onclick='this.form.action="/NaiveBayesController/prediksiAdvancedKapten/<?= 'admin'; ?>"' />
                                            <input name="proses" class="btn btn-success" type="submit" value="PREDICT PENGURUS" onclick='this.form.action="/NaiveBayesController/prediksiAdvancedPengurus/<?= 'admin'; ?>"' />
                                            <input name="proses" class="btn btn-success" type="submit" value="PREDICT KETUA" onclick='this.form.action="/NaiveBayesController/prediksiAdvancedKetua/<?= 'admin'; ?>"' />

                                            <a class="btn btn-danger" name="proses" class="predictbutton" href="/NaiveBayesController/viewadvanced" value="PROSES">RESET</a>
                                        </div>
                                    </form>
                                </div>
                                <div class="text-center">

                                    <?php if ($hasil_kapten != null && $hasil_pengurus == null && $hasil_ketua == null) : //kapten
                                        echo "<p class='fw-bold'>LAYAK KAPTEN: " . $hasil_kapten . "</p>"; ?>

                                    <?php elseif ($hasil_kapten == null && $hasil_pengurus != null && $hasil_ketua == null) : //pengurus
                                        echo "<p class='fw-bold'>LAYAK PENGURUS: " . $hasil_pengurus . "</p>"; ?>

                                    <?php elseif ($hasil_kapten == null && $hasil_pengurus == null && $hasil_ketua != null) : //ketua
                                        echo "<p class='fw-bold'>LAYAK KETUA: " . $hasil_ketua . "</p>"; ?>
                                    <?php endif; ?>
                                </div>
                                <?php
                                if ($mean != null && ($hasil_kapten != null || $hasil_pengurus != null || $hasil_ketua != null)) : ?> <!-- if hasil dan mean ada nilainya -->
                                    <div id="myDIV" class="overflow-auto text-wrap" style="width:100%;">
                                        <!-- Prior Probability -->

                                        <p>
                                            <span class="fw-bold">
                                                Prior Probability of class <?= $label[0]; ?>
                                            </span>
                                            <br>
                                            P(status_layak=<?= $label[0]; ?>): <?= $prior['yes']; ?>

                                            <br>
                                            <span class="fw-bold">
                                                Prior Probability of class <?= $label[1]; ?>
                                            </span>
                                            <br>
                                            P(status_layak=<?= $label[1]; ?>): <?= $prior['no']; ?>
                                        </p>

                                        <!-- MEAN -->

                                        <h3>
                                            <span class="fw-bold text-decoration-underline">Mean</span> <br>
                                        </h3>
                                        <?php
                                        $i = 0;
                                        foreach ($listsampel as $sample) : ?>
                                            <p><span class="fw-bold">Atribut <?= $listlabels2[$i]; ?></span>
                                                <br>

                                                <?php foreach ($label as $index => $labels) : ?>
                                                    μ(<?= $listlabels2[$i]; ?>|Layak=<?= $labels; ?>) :
                                                    <br>
                                                    <math xmlns="http://www.w3.org/1998/Math/MathML">
                                                        <mfrac>
                                                            <mrow>
                                                                <mi>
                                                                    <?php
                                                                    $j = 0;
                                                                    // foreach ($listsampel as $sample) : 
                                                                    ?>
                                                                    <?php
                                                                    $jumlah = count($datacsv);
                                                                    // d($datacsv);
                                                                    $x = 0;
                                                                    $y = 0;
                                                                    $totalnilai = [];
                                                                    $totalnilai2 = [];
                                                                    for ($b = 0; $b < $jumlah; $b++) {
                                                                        if ($datacsv[$b][5] == $labels) {
                                                                            $y++;
                                                                            $totalnilai2[$y] =  $datacsv[$b][$i];
                                                                        }
                                                                    }

                                                                    for ($a = 0; $a < $jumlah; $a++) {
                                                                        if ($datacsv[$a][5] == $labels) {
                                                                            $x++;
                                                                            $totalnilai[$x] = $datacsv[$a][$i];
                                                                            echo $datacsv[$a][$i];
                                                                            if ($x < count($totalnilai2)) {
                                                                                echo '+';
                                                                            }
                                                                        } else {
                                                                        }
                                                                    }
                                                                    // var_dump($totalnilai);
                                                                    // echo $x;
                                                                    ?>
                                                                    <?php $j++; ?>
                                                                </mi>
                                                            </mrow>
                                                            <mrow>
                                                                <mi><?= count($totalnilai); ?></mi>
                                                            </mrow>
                                                        </mfrac>
                                                    </math>
                                                    = <?= $mean[$label[$index]][$i]; ?> <br>
                                                <?php endforeach; ?>
                                            </p>
                                        <?php $i++;
                                        endforeach; ?>

                                        <!-- <p>
                <span class="fw-bold">Mean:</span> <br>
                Atribut Durasi Keanggotaan
                <br>
                μ(durasi keanggotaan|Layak=yes) : <?= $mean['yes'][0]; ?>
                <br>
                μ(durasi keanggotaan|Layak=no) : <?= $mean['no'][0]; ?>
            </p>
            <p>Atribut Umur
                <br>
                μ(durasi keanggotaan|Layak=yes) : <?= $mean['yes'][1]; ?>
                <br>
                μ(durasi keanggotaan|Layak=no) : <?= $mean['no'][1]; ?>
            </p>
            <p>Atribut Misa Diluar Mingguan
                <br>
                μ(durasi keanggotaan|Layak=yes) : <?= $mean['yes'][2]; ?>
                <br>
                μ(durasi keanggotaan|Layak=no) : <?= $mean['no'][2]; ?>
            </p>
            <p>Atribut Keikutsertaan Kegiatan Outdoor
                <br>
                μ(durasi keanggotaan|Layak=yes) : <?= $mean['yes'][3]; ?>
                <br>
                μ(durasi keanggotaan|Layak=no) : <?= $mean['no'][3]; ?>
            </p> -->

                                        <!-- STANDARD DEVIATION -->

                                        <!-- <p> -->
                                        <?php
                                        // echo '<pre>';
                                        // print_r($datacsv);
                                        // echo '</pre>';
                                        ?>
                                        <h3 class="fw-bold text-decoration-underline">Standard Deviation:</h3>
                                        <?php
                                        $i = 0;
                                        foreach ($listsampel as $sample) : ?>
                                            <p><span class="fw-bold">Atribut <?= $listlabels2[$i]; ?></span>
                                                <br>

                                                <?php foreach ($label as $index => $labels) : ?>
                                                    σ(<?= $listlabels2[$i]; ?>|Layak=<?= $labels; ?>) :
                                                    <br>
                                                    <math xmlns="http://www.w3.org/1998/Math/MathML">
                                                        <msqrt>
                                                            <mfrac>
                                                                <mrow>
                                                                    <!-- <mo>&Sigma;</mo> -->
                                                                    <?php
                                                                    $j = 0;
                                                                    // foreach ($listsampel as $sample) : 
                                                                    ?>
                                                                    <?php
                                                                    $jumlah = count($datacsv);
                                                                    $x = 0;
                                                                    for ($a = 0; $a < $jumlah; $a++) {
                                                                        if ($datacsv[$a][5] == $labels) {
                                                                            echo '<msup>';
                                                                            echo '<mrow>';
                                                                            echo '<mo>(</mo>';
                                                                            echo '<msub>';
                                                                            echo '<mi>' . $datacsv[$a][$i] . '</mi>';
                                                                            echo '</msub>';
                                                                            echo '<mo>&minus;</mo>';
                                                                            echo '<menclose notation="top">';
                                                                            echo '<mi>' . sprintf("%0.2f", $mean[$labels][$i]) . '</mi>';
                                                                            echo '</menclose>';
                                                                            echo '<mo>)</mo>';
                                                                            // echo "<br>";
                                                                            echo '</mrow>';
                                                                            echo '<mrow>';
                                                                            echo '<mn>2</mn>';
                                                                            echo '</mrow>';
                                                                            echo '</msup>';
                                                                            $x++;
                                                                        } else {
                                                                        }
                                                                    }
                                                                    // echo $x;

                                                                    ?>

                                                                    <?php $j++; ?>
                                                                </mrow>
                                                                <mrow>
                                                                    <mi><?= $x; ?></mi>
                                                                    <mo>&minus;</mo>
                                                                    <mn>1</mn>
                                                                </mrow>
                                                            </mfrac>
                                                        </msqrt>
                                                    </math>
                                                    = <?= $std[$label[$index]][$i]; ?> <br>
                                                <?php endforeach; ?>
                                            </p>
                                        <?php $i++;
                                        endforeach; ?>

                                        <!-- <p>
                    <span class="fw-bold">Standard Deviation:</span> <br>
                    Atribut Durasi Keanggotaan
                    <br>
                    σ(durasi keanggotaan|Layak=yes) : <?= $std['yes'][0]; ?>
                    <br>
                    σ(durasi keanggotaan|Layak=no) : <?= $std['no'][0]; ?>
                </p>
                <p>Atribut Umur
                    <br>
                    σ(durasi keanggotaan|Layak=yes) : <?= $std['yes'][1]; ?>
                    <br>
                    σ(durasi keanggotaan|Layak=no) : <?= $std['no'][1]; ?>
                </p>
                <p>Atribut Misa Diluar Mingguan
                    <br>
                    σ(durasi keanggotaan|Layak=yes) : <?= $std['yes'][2]; ?>
                    <br>
                    σ(durasi keanggotaan|Layak=no) : <?= $std['no'][2]; ?>
                </p>
                <p>Atribut Keikutsertaan Kegiatan Outdoor
                    <br>
                    σ(durasi keanggotaan|Layak=yes) : <?= $std['yes'][3]; ?>
                    <br>
                    σ(durasi keanggotaan|Layak=no) : <?= $std['no'][3]; ?>
            </p> -->

                                        <!-- GAUSSIAN DISTRIBUTION -->


                                        <h3 class="fw-bold text-decoration-underline">Gaussian Distribution</h3> <br>
                                        <?php
                                        $i = 0;
                                        foreach ($listsampel as $sample) : ?>
                                            <p><span class="fw-bold">Atribut <?= $listlabels[$i] . ' (' . $sample . ')'; ?></span>
                                                <br>
                                                <?php foreach ($label as $index => $labels) : ?>
                                                    P(<?= $listlabels[$i]; ?>=<?= $sample; ?>|Layak=<?= $labels; ?>) :
                                                    <math xmlns="http://www.w3.org/1998/Math/MathML">
                                                        <mfrac>
                                                            <mrow>
                                                                <!-- numerator content grouped in one mrow -->
                                                                <mn>1</mn>
                                                            </mrow>
                                                            <mrow>
                                                                <!-- denominator content grouped in one mrow -->
                                                                <mi><?= sprintf("%0.2f", $std[$labels][$i]); ?></mi>
                                                                <mrow>
                                                                    <!-- fenced expression grouped in one mrow -->
                                                                    <!-- <mo>(</mo> -->
                                                                    <mrow>
                                                                        <!-- fenced content grouped in one mrow -->
                                                                        <msqrt>
                                                                            <mn>2</mn>
                                                                            <mi>&pi;</mi>
                                                                        </msqrt>
                                                                    </mrow>
                                                                    <!-- <mo>)</mo> -->
                                                                </mrow>
                                                            </mrow>
                                                        </mfrac>
                                                        <mrow>
                                                            <!-- numerator content grouped in one mrow -->
                                                            <msup>
                                                                <mi>e</mi>
                                                                <mrow>
                                                                    <mo>&minus;</mo>
                                                                    <mfrac>
                                                                        <mrow>
                                                                            <!-- numerator content grouped in one mrow -->
                                                                            <mn>1</mn>
                                                                        </mrow>
                                                                        <mrow>
                                                                            <mn>2</mn>
                                                                        </mrow>
                                                                    </mfrac>
                                                                    <msup>
                                                                        <mrow>
                                                                            <mo>(</mo>
                                                                            <mfrac>
                                                                                <mrow>
                                                                                    <!-- numerator content grouped in one mrow -->
                                                                                    <mi><?= $sample; ?></mi>
                                                                                    <mo>-</mo>
                                                                                    <mi><?= sprintf("%0.2f", $mean[$labels][$i]); ?></mi>
                                                                                </mrow>
                                                                                <mrow>
                                                                                    <mi><?= sprintf("%0.2f", $std[$labels][$i]); ?></mi>
                                                                                </mrow>
                                                                            </mfrac>
                                                                            <mo>)</mo>
                                                                        </mrow>
                                                                        <mn>2</mn>
                                                                    </msup>
                                                                </mrow>
                                                            </msup>
                                                        </mrow>
                                                    </math>
                                                    = <?= $gaussian[$label[$index]][$i]; ?> <br>
                                                <?php endforeach; ?>
                                            </p>
                                        <?php $i++;
                                        endforeach; ?>

                                        <!-- POSTERIOR PROBABILITY -->
                                        <h3 class="fw-bold text-decoration-underline">Posterior Probability</h3>

                                        <p>
                                            <?php foreach ($label as $index => $labels) : ?>
                                                <span class="fw-bold">P(Layak=<?= $labels; ?>|X) :</span>
                                                <?php
                                                $i = 0;
                                                foreach ($listsampel as $sample) : ?>
                                                    P(<?= $listlabels[$i]; ?>=<?= $sample; ?>|Layak=<?= $labels; ?>) x
                                                    <?= $i > 3 ? "P(status_layak=" . $labels . ")" : ""; ?>
                                                <?php $i++;
                                                endforeach; ?>
                                                <br>
                                                <span class="fw-bold">P(Layak=<?= $labels; ?>|X) :</span>
                                                <?php
                                                $i = 0;
                                                foreach ($listsampel as $sample) : ?>
                                                    <?= $gaussian[$labels][$i]; ?> x <?= $i > 3 ? $prior[$labels] . " = " . sprintf("%.5e", $posterior[$labels]) : ""; ?>
                                                <?php $i++;
                                                endforeach; ?>
                                                <br><br>
                                            <?php endforeach; ?>
                                        </p>

                                        <!-- RESULT -->

                                        <p>
                                            <span class="fw-bold">RESULT:</span> <br>
                                            <?php if ($hasil_kapten != null && $hasil_pengurus == null && $hasil_ketua == null) : //kapten
                                                echo "<p class='fw-bold'>LAYAK KAPTEN: " . $hasil_kapten . "</p>"; ?>

                                            <?php elseif ($hasil_kapten == null && $hasil_pengurus != null && $hasil_ketua == null) : //pengurus
                                                echo "<p class='fw-bold'>LAYAK PENGURUS: " . $hasil_pengurus . "</p>"; ?>

                                            <?php elseif ($hasil_kapten == null && $hasil_pengurus == null && $hasil_ketua != null) : //ketua
                                                echo "<p class='fw-bold'>LAYAK KETUA: " . $hasil_ketua . "</p>"; ?>
                                            <?php endif; ?>
                                            <?php foreach ($label as $index => $labels) : ?>
                                                <span class="fw-bold">P(Layak=<?= $labels; ?>|X) :</span>
                                                <!-- <?= $posterior[$labels]; ?> -->
                                                <?php echo sprintf("%.5e", $posterior[$labels]); ?>

                                                <br>
                                            <?php endforeach; ?>
                                        </p>

                                    </div>

                                <?php endif; ?>

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
                    $('.readon').attr('readonly', 'readonly');
                    // $("#someId").removeAttr('readonly');
                }
            },
        });
    })
</script>
<?= $this->endSection(); ?>