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
                                    <h3 class="fw-bold text-center" style="margin-top:15px;color: #444441;">AKURASI</h3>
                                </div>

                                <div class="col-lg-12 text-center">
                                    <!-- <h3 class="fw-bold text-center" style="margin-top:15px;color: navy;">AKURASI</h3> -->

                                    <!-- <h1 class="mt-5">AKURASI</h1> -->

                                    <form style="margin-top:15px;margin-bottom: 10px;" action="/NaiveBayesController/akurasiresult" method="post" enctype="multipart/form-data">
                                        <?= csrf_field(); ?>
                                        <div class="row mb-3">
                                            <label for="dataset" class="col-sm-3 col-form-label">DATASET</label>
                                            <div class="col-sm-9">
                                                <select class="form-select" name="dataset" id="dataset" required>
                                                    <option value=""></option>
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

                                        <input style="margin-top:15px;" type="submit" class="btn btn-success" value="Submit" />
                                    </form>
                                    <!-- <button class="btn btn-primary"><a href="/" style="text-decoration: none; color:white;">BACK</a></button> -->
                                    <!-- <button onclick='window.location.reload(true);'>Refresh Page</button> -->

                                </div>
                                <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') : ?>
                                    <!-- <h2 class='lead'>Algorithm Performance</h2> -->
                                    <h3 class='text-center' style="margin-top: 10px;">Confusion Matrix</h3>
                                    <p class=''>Presentase data training : <?= round((float)(1 - $testdata) * 100) . '%'; ?></p>
                                    <p class=''>Presentase data test : <?= round((float)($testdata) * 100) . '%'; ?></p>

                                    <table border="1" class="table text-center">
                                        <tr class="table-secondary">
                                            <th>&nbsp;</th>
                                            <th>YES</th>
                                            <th>NO</th>
                                        </tr>
                                        <tr>
                                            <th class="table-secondary">YES</th>
                                            <td><?php echo $confusionMatrix[0][0] ?></td>
                                            <td><?php echo $confusionMatrix[0][1] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="table-secondary">NO</th>
                                            <td><?php echo $confusionMatrix[1][0] ?></td>
                                            <td><?php echo $confusionMatrix[1][1] ?></td>
                                        </tr>
                                    </table>

                                    <?php
                                    echo "Akurasi: " . round((float)($akurasi) * 100) . '%'; //(actual, predicted)
                                    echo "<br/> Precision: ";
                                    echo $presisipercent . " / " . $presisi["No"];
                                    echo "<br/> Recall: ";
                                    // $recall = $report->getRecall();
                                    echo $recall["No"];
                                    echo "<br/> F1: ";
                                    // $F1 = $report->getF1score();
                                    echo $F1["No"];

                                    echo "<h3 class='text-center'>TRAIN SAMPLE</h3>";

                                    echo "<table>";
                                    echo "<th>&nbsp;</th>";

                                    // var_dump($train_labels);

                                    // Table header
                                    foreach ($train_sample[0] as $clave => $fila) {
                                        echo "<th>" . $clave . "</th>";
                                    }

                                    // Table body
                                    $i = 0;
                                    foreach ($train_sample as $index => $fila) {
                                        echo "<tr>";
                                        echo "<th class='table-secondary'>" . $i++ . "</th>";
                                        foreach ($fila as $elemento) {
                                            echo "<td>" . $elemento . "</td>";
                                        }

                                        echo "<td>" . $train_labels[$index] . "</td>";

                                        echo "</tr>";
                                    }

                                    echo "</table>";

                                    echo "<table>";
                                    echo "<th>&nbsp;</th>";

                                    // var_dump($train_labels);

                                    echo "<h3 class='text-center'>TEST SAMPLE</h3>";

                                    // Table header
                                    foreach ($test_sample[0] as $clave => $fila) {
                                        echo "<th>" . $clave . "</th>";
                                    }

                                    // Table body
                                    $i = 0;
                                    foreach ($test_sample as $index => $fila) {
                                        echo "<tr>";
                                        echo "<th class='table-secondary'>" . $i++ . "</th>";
                                        foreach ($fila as $elemento) {
                                            echo "<td>" . $elemento . "</td>";
                                        }

                                        echo "<td>" . $test_labels[$index] . "</td>";

                                        echo "</tr>";
                                    }

                                    echo "</table>";

                                    // echo "<br/> Support: ";
                                    // var_dump($report->getSupport());
                                    // echo "<br/> Average: ";
                                    // var_dump($report->getAverage());
                                    // echo "<br/>";
                                    // }
                                    // }

                                    ?>
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

<?= $this->endSection(); ?>