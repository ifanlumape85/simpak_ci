    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List <? echo isset($title) ? ucwords(str_replace('_', ' ', $title)) : ''; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title" >Custom Filter : </h3>
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

                    <div class="form-group fg-tahun2">
                        <label for="tahun" class="col-sm-2 control-label">Tahun</label>
                        <div class="col-sm-4">
                            <input type="text" name="tahun2" id="tahun2" class="form-control" />
                        </div>
                    </div>
				
		            <div class="form-group">
                        <label for="btn-filter" class="col-sm-2 control-label"></label>
                        <div class="col-sm-4">
                            <button type="button" id="btn-filter" class="btn btn-primary btn-flat btn-sm"><i class="fa fa-filter"></i> Filter</button>
                            <button type="button" id="btn-reset" class="btn btn-default btn-flat btn-sm"><i class="fa fa-undo"></i> Reset</button>
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
	
		