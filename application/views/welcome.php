<!--BANNER START-->
  <div id="banner" class="section-padding">
    <div class="container">
      <div class="row">
        <div class="jumbotron">
          <h1 class="small">Selamat datang di <span class="bold">Asmara</span></h1>
          <p class="big">Layanan aspirasi dan pengaduan online masyarakat.</p>
          <a href="<?php echo base_url('asmara'); ?>" class="btn btn-banner">Pelajari lebih lanjut<i class="fa fa-send"></i></a>
        </div>
      </div>
    </div>
  </div>
  <!--BANNER END-->

  <!--CTA1 START-->
  <div class="cta-1">
    <div class="container">
      <div class="row text-center white">
        <h1 class="cta-title">JUMLAH LAPORAN SEKARANG!!</h1>
        <p class="cta-sub-title">1</p>
      </div>
    </div>
  </div>
  <!--CTA1 END-->

  <!--SERVICE START-->
  <div id="service" class="section-padding">
    <div class="container">
      <div class="row">
        <div class="page-title text-center">
          <h1>Apa itu ASMARA?</h1>
          <p>ASMARA! (Layanan Aspirasi dan Pengaduan Masyarakat) adalah sebuah sarana aspirasi dan pengaduan berbasis teknologi informasi yang mudah diakses dan terpadu. </p>
          <hr class="pg-titl-bdr-btm"></hr>
        </div>
        <div class="col-md-3">
          <div class="service-box">
            <div class="service-icon"><i class="fa fa-comments-o"></i></div>
            <div class="service-text">
              <h3>Tulis Laporan!</h3>
              <p>Laporkan keluhan atau aspirasi anda dengan jelas dan lengkap.</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="service-box">
            <div class="service-icon"><i class="fa fa-calendar"></i></div>
            <div class="service-text">
              <h3>Proses Verifikasi!</h3>
              <p>Dalam 3 hari laporan anda akan diverifikasi dan diteruskan kepada instansi berwenang.</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="service-box">
            <div class="service-icon"><i class="fa fa-calendar-check-o"></i></div>
            <div class="service-text">
              <h3>Proses Tindak Lanjut!</h3>
              <p>Dalam 5 hari, instansi akan menindaklanjuti dan membalas laporan anda. Anda dapat menanggapi balasan yang diberikan.</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="service-box">
            <div class="service-icon"><i class="fa  fa-check"></i></div>
            <div class="service-text">
              <h3>Selesai!</h3>
              <p>Laporan anda akan terus ditindaklanjuti hingga terselesaikan.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--SERVICE END-->
  <div id="portfolio">
    <div class="container">
      <div class="page-title text-center">
        <h1>Laporan Masyarakat</h1>
        <p>&nbsp;</p>
        <hr class="pg-titl-bdr-btm"></hr>
      </div>
      <div class="row" id="portfolio-wrapper">
        <div class="form-sec">
          <form action="" name="form_lapor" method="post" role="form" class="contactForm">
            <div class="col-md-12 form-group">
              <textarea class="form-control text-field-box" name="isi_laporan" rows="5" data-rule="required" data-msg="Harap mengetikan laporan atau aspirasi anda" placeholder="Ketik laporan anda..."></textarea>
              <div class="validation"></div>
            </div>
            <div class="col-md-12 form-group">
              <?php echo $form_kategori; ?>
              <div class="validation"></div>
            </div>
            <div class="col-md-12 form-group">
              <button class="button-medium" id="btn_laporan" type="submit" name="btn_laporan">Lapor</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!--TEAM START-->
  <div id="about" class="section-padding">
    <div class="container">
      <div class="row">
        <div class="page-title text-center">
          <h1>Hingga hari ini</h1>
          <p>Aplikasi ASMARA telah menerima banyak laporan dari masyarakat lewat berbagai kanal ASMARA!. </p>
          <hr class="pg-titl-bdr-btm"></hr>
        </div>
        <div class="autoplay">
                  <div class="chart" id="line-chart" style="height: 300px; width: 100%"></div>
        </div>
      </div>
    </div>
  </div>
  <!--TEAM END-->

  <!--CTA2 START-->
  <div class="cta2">
    <div class="container">
      <div class="row white text-center">
        <h3 class="wd75 fnt-24">“Laporan anda akan kami tangani, maksimal 10 hari kerja.”</h3>
        <p class="cta-sub-title"></p>
        <a href="<?php echo base_url('masyarakat/laporan'); ?>" class="btn btn-default">Aya lapor</a>
      </div>
    </div>
  </div>
  <!--CTA2 END-->

  <!--CONTACT START-->
  <div id="contact" class="section-padding">
    <div class="container">
      <div class="row">
        <div class="page-title text-center">
          <h1>Cari Aduan</h1>
          <p>Silahkan memasukkan Tracking ID. </p>
          <hr class="pg-titl-bdr-btm"></hr>
        </div>
        <div id="sendmessage">Your message has been sent. Thank you!</div>
        <div id="errormessage"></div>

        <div class="form-sec">
          <form action="" method="post" name="form_tracking" id="form_tracking" role="form" class="contactForm">
            <div class="col-md-12 form-group">
              <input type="text" name="tracking_id" class="form-control text-field-box" id="tracking_id" placeholder="Tracking ID" data-rule="minlen:4" data-msg="Masukkan paling kurang 4 karakter" />
              <div class="validation"></div>
            </div>
            <div class="col-md-12 form-group">
              <button class="button-medium" id="btn_tracking" type="submit" name="btn_tracking">Cari Sekarang</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!--CONTACT END-->