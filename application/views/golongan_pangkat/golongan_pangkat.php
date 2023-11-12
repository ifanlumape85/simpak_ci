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
        		<button class="btn btn-success btn-flat btn-sm" onclick="add_golongan_pangkat()"><i class="glyphicon glyphicon-plus"></i> Tambah</button>
        		<button class="btn btn-default btn-flat btn-sm" onclick="reload_golongan_pangkat_table()"><i class="glyphicon glyphicon-refresh"></i> Muat Ulang</button>
        		<button class="btn btn-danger btn-flat btn-sm" onclick="bulk_delete()"><i class="glyphicon glyphicon-trash"></i> Hapus Masal</button>
        <br />
        <br />

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title" >Custom Filter : </h3>
            </div>
            <div class="panel-body">
                <form id="form-filter" class="form-horizontal">
		          
                  <div class="form-group fg-instansi2">
                        <label for="id_instansi2" class="col-sm-2 control-label">Instansi</label>
                        <div class="col-sm-4">
                            <?php echo $form_instansi2; ?>
                        </div>
                    </div>

		          <div class="form-group fg-pegawai2">
                        <label for="pegawai" class="col-sm-2 control-label">Pegawai</label>
                        <div class="col-sm-4">
                            <select name="id_pegawai2" class="form-control" id="id_pegawai2"></select>
                        </div>
                    </div>
						
		          <div class="form-group">
                        <label for="golongan" class="col-sm-2 control-label">Golongan</label>
                        <div class="col-sm-4">
                            <?php echo $form_golongan2; ?>
                        </div>
                    </div>
						
		          <div class="form-group">
                        <label for="pangkat" class="col-sm-2 control-label">Pangkat</label>
                        <div class="col-sm-4">
                            <?php echo $form_pangkat2; ?>
                        </div>
                    </div>
				
		            <div class="form-group">
                        <label for="btn-filter" class="col-sm-2 control-label"></label>
                        <div class="col-sm-4">
                            <button type="button" id="btn-filter" class="btn btn-primary"><i class="fa fa-filter"></i> Filter</button>
                            <button type="button" id="btn-reset" class="btn btn-default"><i class="fa fa-undo"></i> Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
		<div class="col-sm-12 table-responsive">
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
		 		<tr>
		 			<th><input type="checkbox" id="check-all"></th>
		            <th>No.</th>
					<th>Instansi</th>
                    <th>Pegawai</th>
					<!-- <th>Verifikator</th> -->
					<th>Golongan</th>
					<th>Pangkat</th>
					<th style="width:125px;">Action</th>
				</tr>                
            </thead>
            <tbody>
            </tbody>

            <tfoot>

		 		<tr>
		 			<td></td>
		 			<td></td>
					<td>Instansi</td>
                    <td>Pegawai</td>
					<!-- <td>Verifikator</td> -->
					<td>Golongan</td>
					<td>Pangkat</td>
					<td></td>
				</tr>
           </tfoot>
       </table>
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
	
		