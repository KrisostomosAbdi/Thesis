<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<style>
  .card {
    margin-bottom: -70px !important;
    padding-bottom: -20px !important;
  }

  .card-body {
    /* opacity: 0.3; */
    position: relative;
    text-align: center;
    /* color: white; */
  }

  h1 {
    /* position: absolute; */
    width: max-content;
    opacity: 1;
    font-family: "Open Sans", sans-serif;
    font-weight: bold;
    font-size: 4vw;
    color: #1d1819;
  }

  img {
    object-fit: cover;
    max-width: 40%;
    height: auto;
  }

  blockquote {
    font-family: Georgia, serif;
    font-size: 17px;
    font-style: italic;
    width: 500px;
    margin: 0.25em 0;
    padding: 0.35em 40px;
    line-height: 1.45;
    position: relative;
    color: #383838;
  }

  .blockquote2 {
    font-family: Georgia, serif;
    font-size: 17px;
    font-style: italic;
    width: 700px;
    margin: 0.25em 0;
    padding: 0.35em 40px;
    line-height: 1.45;
    position: relative;
    color: #383838;
  }

  blockquote cite {
    color: #999999;
    font-size: 20px;
    display: block;
    margin-top: 5px;
  }

  blockquote cite:before {
    content: "\2014 \2009";
  }
</style>
<main id="main" class="main">
  <!-- <div class="container-fluid"> -->

  <section class="section dashboard">

    <div class="card mh-100">
      <div class="card-body overflow-hidden">
        <!-- <div class="row">
          <div class="col-lg-12 text-center"> -->
        <center>
          <!-- <img style="opacity: 0.3;" src="<?= base_url('/img/logo_misdinar.png') ?>" alt="">
                  <h1>WELCOME <br> PUTRA ALTAR KATEDRAL</h1> -->
          <img src="<?= base_url('/img/logo_misdinar.png') ?>" alt="">
          <!-- <h1> -->
          <?php

          $file = "quoteToday.txt";
          // read the file into an array
          $quoteArray = file("./quote/quoteData.txt");

          // set random seed
          //srand($seed);

          //get the random number
          $qrnd = rand(0, sizeof($quoteArray) - 1);

          // pick quote name from random numbers
          $quote = "$quoteArray[$qrnd]";


          //write the string to the file

          // Note: mode 'w' opens for writing only; place the file pointer at 
          //   the beginning of the file and truncate the file to zero length.
          //   If the file does not exist, attempt to create it.

          $fh = fopen($file, "w");
          fputs($fh, $quote);
          fclose($fh);

          //uncomment the following line for debugging and testing
          echo ($quote);

          ?>
          <!-- </h1> -->
        </center>
        <!-- </div>
        </div> -->

      </div>

    </div>

  </section>
  <!-- </div> -->

</main>
<?= $this->endSection(); ?>