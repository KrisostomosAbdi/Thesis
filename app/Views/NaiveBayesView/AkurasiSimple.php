<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<style>
    /* label,
    th,
    td,
    select {
        font-weight: bold;
        font-size: 20pt !important;
    }

    p {
        font-weight: bold;
        font-size: 20pt !important;
    }

    math {
        font-weight: 900;
        font-size: 30pt;
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
                                <!-- <div class="card-header text-center"> -->
                                <h1 class="fw-bold text-center" style="margin-top:15px;color: #444441;">AKURASI</h1>
                                <!-- </div> -->
                                <div class="container-fluid">


                                    <div class="row">
                                        <div class="col-lg-12 text-center" style="margin-top: 10px; margin-bottom: 10px;">
                                            <!-- <h1 class="mt-5">AKURASI</h1> -->
                                            <form action="/NaiveBayesController/AkurasiSimpleProses" method="post" enctype="multipart/form-data">
                                                <div class="row mb-3">
                                                    <label for="dataset" class="col-sm-2 col-form-label">DATASET</label>
                                                    <div class="col-sm-10">
                                                        <select class="form-select" name="dataset" id="dataset" required>
                                                            <option value="<?= ($filedataset) ? $filedataset : '' ?>"><?= ($filedataset) ? $filedataset . ' (current)' : '' ?> </option>
                                                            <option value="kapten">KAPTEN</option>
                                                            <option value="pengurus">PENGURUS</option>
                                                            <option value="ketua">KETUA-WAKIL</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- <div class="row mb-3">
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
                                                </div> -->
                                                <input type="submit" class="btn btn-success fw-bold" value="SUBMIT" />
                                            </form>
                                            <?php if ($filedataset != null or $confusionMatrix != null or $akurasi != null or $presisipercent != null or $presisi != null or $recall != null or $F1 != null) : ?>
                                                <div class="container" style="margin-top: 10px;">
                                                    <button class="btn btn-primary fw-bold" onClick="window.location.reload();">REFRESH PAGE</button>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <?php if ($filedataset != null or $confusionMatrix != null or $akurasi != null or $presisipercent != null or $presisi != null or $recall != null or $F1 != null) : ?>

                                            <!-- <h2 class='lead'>Algorithm Performance</h2> -->
                                            <!-- <hr> -->

                                            <h2 class="fw-bold">Confusion Matrix</h2>


                                            <!-- <hr> -->
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

                                            <div class='container-fluid text-center'>
                                                <p>
                                                    <!-- <?php d($TP, $FP, $FN) ?> -->
                                                    <span class="fw-bold">AKURASI </span>
                                                    <math xmlns="http://www.w3.org/1998/Math/MathML">
                                                        <mfrac>
                                                            <mrow>
                                                                <mn><?php echo $confusionMatrix[0][0] ?></mn>
                                                                <mo>+</mo>
                                                                <mn><?php echo $confusionMatrix[1][1] ?></mn>
                                                            </mrow>
                                                            <mrow>
                                                                <mn><?php echo $confusionMatrix[0][0] ?></mn>
                                                                <mo>+</mo>
                                                                <mn><?php echo $confusionMatrix[1][1] ?></mn>
                                                                <mo>+</mo>
                                                                <mn><?php echo $confusionMatrix[0][1] ?></mn>
                                                                <mo>+</mo>
                                                                <mn><?php echo $confusionMatrix[1][0] ?></mn>
                                                            </mrow>
                                                        </mfrac>
                                                    </math>
                                                    =
                                                    <?= round((float)$akurasi * 100, 2) . '%'; ?>

                                                    <br>
                                                    <br>

                                                    <span class="fw-bold">PRESISI </span>
                                                    <math xmlns="http://www.w3.org/1998/Math/MathML">
                                                        <mfrac>
                                                            <mrow>
                                                                <mn><?= $TP['no']; ?></mn>
                                                            </mrow>
                                                            <mrow>
                                                                <mn><?= $TP['no']; ?></mn>
                                                                <mo>+</mo>
                                                                <mn><?= $FP['no']; ?></mn>
                                                            </mrow>
                                                        </mfrac>
                                                    </math>
                                                    =
                                                    <?= round((float)$presisi["no"] * 100, 2) . '%'; ?>

                                                    <br>
                                                    <br>

                                                    <span class="fw-bold">RECALL </span>
                                                    <math xmlns="http://www.w3.org/1998/Math/MathML">
                                                        <mfrac>
                                                            <mrow>
                                                                <mn><?= $TP['no']; ?></mn>
                                                            </mrow>
                                                            <mrow>
                                                                <mn><?= $TP['no']; ?></mn>
                                                                <mo>+</mo>
                                                                <mn><?= $FN['no']; ?></mn>
                                                            </mrow>
                                                        </mfrac>
                                                    </math>
                                                    =
                                                    <?= round((float)$recall["no"] * 100, 2) . '%'; ?>
                                                    <!-- <br>
                                                F1 :
                                                <?= round((float)$F1["no"] * 100) . '%'; ?> -->
                                                </p>

                                            </div>

                                        <?php endif; ?>

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