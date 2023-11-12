    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">LAPORAN PRESENSI</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

        <div class="panel panel-default custom_filter">
            <div class="panel-heading">
                <h3 class="panel-title"></h3>
            </div>
            <div class="panel-body">
                <form id="form-filter" class="form-horizontal">

		          <div class="form-group fg-instansi2">
                        <label for="instansi" class="col-sm-2 control-label">Instansi</label>
                        <div class="col-sm-4">
                            <?php echo $form_instansi2; ?>
                        </div>
                    </div>

                    <div class="form-group fg-pegawai2">
                        <label for="pegawai" class="col-sm-2 control-label">Pegawai</label>
                        <div class="col-sm-4">
                            <select name="id_pegawai2" id="id_pegawai2" class="form-control"></select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="jenis" class="col-sm-2 control-label">Jenis Presensi</label>
                        <div class="col-sm-4">
                            <?php echo $form_jenis_presensi2; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status" class="col-sm-2 control-label">Status Presensi</label>
                        <div class="col-sm-4">
                            <?php echo $form_status_presensi2; ?>
                        </div>
                    </div>



                    <div class="form-group">
                        <label for="mulai" class="col-sm-2 control-label">Mulai</label>
                        <div class="col-sm-4">
                            <input type="text" name="tgl_mulai" id="tgl_mulai" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="selesai" class="col-sm-2 control-label">Selesai</label>
                        <div class="col-sm-4">
                            <input type="text" name="tgl_selesai" id="tgl_selesai" class="form-control">
                        </div>
                    </div>

		            <div class="form-group">
                        <label for="btn-filter" class="col-sm-2 control-label"></label>
                        <div class="col-sm-4">
                            <button type="button" id="btn-filter" class="btn btn-primary btn-flat btn-sm"><i class="glyphicon glyphicon-filter"></i> Filter</button>
                            <button type="button" id="btn-cetak" class="btn btn-warning btn-flat btn-sm"><i class="glyphicon glyphicon-print"></i> Cetak</button>
                            <button type="button" id="btn-reset" class="btn btn-default btn-flat btn-sm"><i class="glyphicon glyphicon-refresh"></i> Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
		<div class="col-sm-12 table-responsive tabel_laporan">

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

