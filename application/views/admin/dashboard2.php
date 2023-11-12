<section class="content">
	<div class="row">
		<div class="col-md-12">
		<div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Custom Filter :</h3>
            </div>
            <div class="box-body">
              <div class="row">
              <div class="col-xs-4">
                  <?=$form_instansi?>
                </div>
                <div class="col-xs-2">
                  <input type="text" class="form-control" name="tgl_presensi" id="tgl_presensi" placeholder="Tgl Absen">
                </div>
                <div class="col-xs-4">
                  <?=$form_jenis_presensi?>
                </div>
                <div class="col-xs-2">
                  <button class="btn btn-primary btn-sm btn-flat" id="btn-filter"><i class="glyphicon glyphicon-search"></i> Tampilkan</button>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
		</div>
	
	</div>
	<div class="row dashboardx">
		<div class="col-md-12">
          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Load Data</h3>
            </div>
            <div class="box-body">
              Mengambil data
            </div>
            <!-- /.box-body -->
            <!-- Loading (remove the following to stop the loading)-->
            <div class="overlay">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
            <!-- end loading -->
          </div>
          <!-- /.box -->
        </div>
	</div>  
  <div class="row">
   <div class="col-md-12 pegawai">
   </div>
  </div> 
</section>   

	