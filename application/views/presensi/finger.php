<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title" >&nbsp;</h3>
                </div>
                <div class="panel-body">
                    <form id="form-filter" class="form-horizontal">
    		
    		          <div class="form-group">
                            <label for="pegawai" class="col-sm-2 control-label">Mesin</label>
                            <div class="col-sm-4">
                                <?php echo $form_mesin_absensi2; ?>
                            </div>
                        </div>		
    		          
    		            <div class="form-group">
                            <label for="btn-filter" class="col-sm-2 control-label"></label>
                            <div class="col-sm-4">
                                <button type="button" id="btn-filter" class="btn btn-primary"><i class="fa fa-filter"></i> Tarik Data</button>
                                <button type="button" id="btn-reset" class="btn btn-default"><i class="fa fa-undo"></i> Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    		<div class="col-sm-12 table-responsive list_absensi_mesin">
            
                  <div class="box box-danger box-solid">
                    <div class="box-header">
                      <h3 class="box-title">Mengambil data</h3>
                    </div>
                    <div class="box-body">
                      Mohon untuk tidak berganti halaman/menutup halaman ini.
                    </div>
                    <!-- /.box-body -->
                    <!-- Loading (remove the following to stop the loading)-->
                    <div class="overlay">
                      <i class="fa fa-refresh fa-spin"></i>
                    </div>
                    <!-- end loading -->
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

