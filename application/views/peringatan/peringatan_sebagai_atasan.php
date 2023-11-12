    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">PERINGATAN (SEBAGAI ATASAN)</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

            <button class="btn btn-success btn-flat btn-sm btn_add" onclick="add_peringatan()"><i class="glyphicon glyphicon-plus"></i> Tambah</button>
            <button class="btn btn-default btn-flat btn-sm btn_refresh" onclick="reload_peringatan_table()"><i class="glyphicon glyphicon-refresh"></i> Muat Ulang</button>
            
            <button class="btn btn-danger btn-flat btn-sm" onclick="bulk_delete()"><i class="glyphicon glyphicon-trash"></i> Hapus Masal</button><br /><br />
            <br />
            <div class="panel panel-default custom_filter">
        
            <div class="panel-body">      
                <form id="form-filter" class="form-horizontal">
		          <div class="form-group">
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
                        <label for="instansi" class="col-sm-2 control-label">Jenis Pelanggaran</label>
                        <div class="col-sm-4">
                            <?php echo $form_jenis_peringatan2; ?>
                        </div>
                    </div>

                <div class="form-group">
                        <label for="instansi" class="col-sm-2 control-label">Tgl Mulai</label>
                        <div class="col-sm-4">
                            <input type="text" name="tgl_mulai" id="tgl_mulai" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="instansi" class="col-sm-2 control-label">Tgl Selesai</label>
                        <div class="col-sm-4">
                            <input type="text" name="tgl_selesai" id="tgl_selesai" class="form-control">
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
		<div class="col-sm-12 table-responsive">
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
		 		<tr>
		 			<th><input type="checkbox" id="check-all"></th>
		            <th>No.</th>
                    <th>Instansi</th>
					<th>Pegawai</th>
					<th>Jenis Pelanggaran </th>
					<th>Isi Pelanggaran</th>
					<th>Tgl Pelanggaran</th>
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
					<td>Jenis Pelanggaran </td>
					<td>Isi Pelanggaran</td>
					<td>Tgl Pelanggaran</td>
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
	
		