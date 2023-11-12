<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <!-- /.box -->
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?= isset($title) ? ucwords(str_replace('_', ' ', $title)) : ''; ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="col-sm-12 table-responsive">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title"></h3>
              </div>
              <div class="panel-body">
                <?= form_open('#', array("id" => "form", "class" => "form-horizontal")) ?>
                <div class="form-group">
                  <label for="instansi" class="col-sm-12">Instansi</label>
                  <div class="col-sm-12">
                    <?= $form_instansi2; ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="pegawai" class="col-sm-12">Tgl Mulai</label>
                  <div class="col-sm-12">
                    <input type="text" name="tgl_mulai2" id="tgl_mulai2" class="form-control tgl_mulai">
                  </div>
                </div>
                <div class="form-group">
                  <label for="pegawai" class="col-sm-12">Tgl Akhir</label>
                  <div class="col-sm-12">
                    <input type="text" name="tgl_akhir2" id="tgl_akhir2" class="form-control tgl_selesai">
                  </div>
                </div>
                <div class="form-group">
                  <label for="btn-filter" class="col-sm-12"></label>
                  <div class="col-sm-12">
                    <button type="button" id="btn-filter" class="btn btn-primary btn-flat btn-sm"><i class="fa fa-print"></i> Cetak TPP</button>
                    <button type="button" id="btn-reset" class="btn btn-default btn-flat btn-sm"><i class="fa fa-undo"></i> Reset</button>
                  </div>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>