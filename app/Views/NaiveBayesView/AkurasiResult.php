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
                            <div class="card-body">
                                <div class="card-header text-center">
                                    <h3 class="fw-bold text-center" style="margin-top:15px;color: #444441;">AKURASI RESULT</h3>
                                </div>
                                <div class="container-fluid">


                                    <div class="row">
                                        <div class="col-lg-12 text-center" style="margin-top: 10px; margin-bottom: 10px;">
                                            <!-- <h1 class="mt-5">AKURASI</h1> -->
                                            <form action="/NaiveBayesController/akurasiresult" method="post" enctype="multipart/form-data">
                                                <div class="row mb-3">
                                                    <label for="dataset" class="col-sm-3 col-form-label">DATASET</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-select" name="dataset" id="dataset" required>
                                                            <option value="<?= ($filedataset) ? $filedataset : '' ?>"><?= ($filedataset) ? $filedataset . ' (current)' : '' ?> </option>
                                                            <option value="kapten">KAPTEN</option>
                                                            <option value="pengurus">PENGURUS</option>
                                                            <option value="ketua">KETUA-WAKIL</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="data" class="col-sm-3 col-form-label">JUMLAH DATA TRAINING</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-select" name="testdata" id="data" required>
                                                            <option value=""></option>
                                                            <option value="0.9">10%</option>
                                                            <option value="0.8">20%</option>
                                                            <option value="0.7">30%</option>
                                                            <option value="0.6">40%</option>
                                                            <option value="0.5">50%</option>
                                                            <option value="0.4">60%</option>
                                                            <option value="0.3">70%</option>
                                                            <option value="0.2">80%</option>
                                                            <option value="0.1">90%</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <input type="submit" class="btn btn-success" value="Submit" />
                                            </form>
                                            <div class="container" style="margin-top: 10px;">
                                                <button class="btn btn-danger"><a href="/NaiveBayesController/akurasi" style="text-decoration: none; color:white;">RESET</a></button>
                                                <button class="btn btn-primary" onClick="window.location.reload();">Refresh Page</button>
                                            </div>

                                        </div>
                                        <p class=''>Presentase data training : <?= round((float)(1 - $testdata) * 100) . '%'; ?></p>
                                        <p class=''>Presentase data test : <?= round((float)($testdata) * 100) . '%'; ?></p>
                                        <!-- <h2 class='lead'>Algorithm Performance</h2> -->
                                        <!-- <hr> -->
                                        <h3 class="text-center">Confusion Matrix</h3>
                                        <!-- <hr> -->
                                        <table class="table text-center table-bordered">
                                            <tr>
                                                <th>&nbsp;</th>
                                                <th>YES</th>
                                                <th>NO</th>
                                            </tr>
                                            <tr>
                                                <th>YES</th>
                                                <td><?php echo $confusionMatrix[0][0] ?></td>
                                                <td><?php echo $confusionMatrix[0][1] ?></td>
                                            </tr>
                                            <tr>
                                                <th>NO</th>
                                                <td><?php echo $confusionMatrix[1][0] ?></td>
                                                <td><?php echo $confusionMatrix[1][1] ?></td>
                                            </tr>
                                        </table>

                                        <div class='container-fluid'>
                                            <p>
                                                <!-- <?php d($TP, $FP, $FN) ?> -->
                                                <span class="fw-bold">AKURASI :</span>

                                                <math xmlns="http://www.w3.org/1998/Math/MathML">
                                                    <mfrac>
                                                        <mrow>
                                                            <!-- TP -->
                                                            <mn><?php echo $confusionMatrix[0][0] ?></mn>
                                                            <mo>+</mo>
                                                            <!-- TN -->
                                                            <mn><?php echo $confusionMatrix[1][1] ?></mn>
                                                        </mrow>
                                                        <mrow>
                                                            <mn><?php echo $confusionMatrix[0][0] ?></mn>
                                                            <mo>+</mo>
                                                            <mn><?php echo $confusionMatrix[1][1] ?></mn>
                                                            <mo>+</mo>
                                                            <!-- FN -->
                                                            <mn><?php echo $confusionMatrix[0][1] ?></mn>
                                                            <mo>+</mo>
                                                            <!-- FP -->
                                                            <mn><?php echo $confusionMatrix[1][0] ?></mn>
                                                        </mrow>
                                                        <!-- <mo>=</mo> -->
                                                    </mfrac>
                                                </math>
                                                =
                                                <?= round((float)$akurasi * 100, 2) . '%'; ?>

                                                <br>
                                                <br>

                                                <span class="fw-bold">PRESISI :</span>
                                                <math xmlns="http://www.w3.org/1998/Math/MathML">
                                                    <mfrac>
                                                        <mrow>
                                                            <!-- <mn><?php echo $confusionMatrix[0][0] ?></mn> -->
                                                            <mn><?= $TP['no']; ?></mn>
                                                        </mrow>
                                                        <mrow>
                                                            <!-- <mn><?php echo $confusionMatrix[0][0] ?></mn> -->
                                                            <mn><?= $TP['no']; ?></mn>
                                                            <mo>+</mo>
                                                            <!-- <mn><?php echo $confusionMatrix[1][0] ?></mn> -->
                                                            <mn><?= $FP['no']; ?></mn>
                                                        </mrow>
                                                        <!-- <mo>=</mo> -->
                                                    </mfrac>
                                                </math>
                                                =
                                                <?= round((float)$presisi["no"] * 100, 2) . '%'; ?>

                                                <br>
                                                <br>

                                                <span class="fw-bold">RECALL :</span>
                                                <math xmlns="http://www.w3.org/1998/Math/MathML">
                                                    <mfrac>
                                                        <mrow>
                                                            <!-- <mn><?php echo $confusionMatrix[0][0] ?></mn> -->
                                                            <mn><?= $TP['no']; ?></mn>
                                                        </mrow>
                                                        <mrow>
                                                            <!-- <mn><?php echo $confusionMatrix[0][0] ?></mn> -->
                                                            <mn><?= $TP['no']; ?></mn>
                                                            <mo>+</mo>
                                                            <!-- <mn><?php echo $confusionMatrix[1][0] ?></mn> -->
                                                            <mn><?= $FN['no']; ?></mn>
                                                        </mrow>
                                                        <!-- <mo>=</mo> -->
                                                    </mfrac>
                                                </math>
                                                =
                                                <?= round((float)$recall["no"] * 100, 2) . '%'; ?>
                                                <!-- <br>
                                                F1 :
                                                <?= round((float)$F1["no"] * 100) . '%'; ?> -->
                                            </p>

                                        </div>


                                        <hr>
                                        <h3 class='text-center'>TRAIN SAMPLE</h3>
                                        <hr>

                                        <table class='table text-center table-borderless' style="margin-bottom: 20px;">
                                            <th>&nbsp;</th>
                                            <?php
                                            // var_dump($train_labels);
                                            // Table header
                                            foreach ($train_sample[0] as $clave => $fila) : ?>
                                                <th> <?= $clave; ?> </th>
                                            <?php endforeach; ?>

                                            <th>status</th>

                                            <!-- // Table body -->
                                            <?php
                                            $i = 0;
                                            foreach ($train_sample as $index => $fila) {
                                                echo "<tr>";
                                                echo "<th>" . $i++ . "</th>";
                                                foreach ($fila as $elemento) {
                                                    echo "<td>" . $elemento . "</td>";
                                                }

                                                echo "<td>" . $train_labels[$index] . "</td>";

                                                echo "</tr>";
                                            }
                                            ?>
                                        </table>

                                        <hr>
                                        <h3 class='text-center'>TEST SAMPLE</h3>
                                        <hr>
                                        <!-- // var_dump($train_labels); -->

                                        <table class='table text-center table-borderless'>
                                            <th>&nbsp;</th>
                                            <!-- // Table header -->

                                            <?php foreach ($test_sample[0] as $clave => $fila) : ?>
                                                <th> <?= $clave; ?> </th>
                                            <?php endforeach; ?>
                                            <th>status</th>

                                            <!-- // Table body -->
                                            <?php
                                            $i = 0;
                                            foreach ($test_sample as $index => $fila) {
                                                echo "<tr>";
                                                echo "<th>" . $i++ . "</th>";
                                                foreach ($fila as $elemento) {
                                                    echo "<td>" . $elemento . "</td>";
                                                }

                                                echo "<td>" . $test_labels[$index] . "</td>";

                                                echo "</tr>";
                                            }
                                            ?>
                                        </table>
                                        <!-- // echo "<br /> Support: ";
                                        // var_dump($report->getSupport());
                                        // echo "<br /> Average: ";
                                        // var_dump($report->getAverage());
                                        // echo "<br />"; -->
                                    </div>
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

<?= $this->endSection(); ?>