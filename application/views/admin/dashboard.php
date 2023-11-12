<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title">Custom Filter :</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-sm-12 col-md-12">
              <div class="form-group">
                <?= $form_instansi ?>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="tgl_awal" id="tgl_awal" placeholder="<?= date('d-m-Y') ?>">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="tgl_akhir" id="tgl_akhir" placeholder="<?= date('d-m-Y') ?>">
              </div>
              <div class="form-group">
                <button class="btn btn-primary btn-sm btn-flat" id="btn-filter"><i class="glyphicon glyphicon-search"></i> Tampilkan</button>
              </div>
            </div>

          </div>
          <p>&nbsp;</p>
          <div class="row">
            <div class="col-sm-12 col-md-6 dashboardx">

            </div>
            <div class="col-sm-12 col-md-6 dashboardx2">

            </div>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
    </div>

  </div>
</section>