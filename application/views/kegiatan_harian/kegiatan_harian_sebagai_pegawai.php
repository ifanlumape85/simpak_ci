    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">KEGIATAN HARIAN (SEBAGAI PEGAWAI)</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
        		
                <button class="btn btn-success btn-flat btn-sm" onclick="add_kegiatan_harian()"><i class="glyphicon glyphicon-plus"></i> Tambah</button>
                <?php if ($this->session->userdata('user_level_id')==1) { ?> 
        		<button class="btn btn-default btn-flat btn-sm" onclick="reload_kegiatan_harian_table()"><i class="glyphicon glyphicon-refresh"></i> Muat Ulang</button>
        		<button class="btn btn-danger btn-flat btn-sm" onclick="bulk_delete()"><i class="glyphicon glyphicon-trash"></i> Hapus Masal</button>
        <?php } ?>
        <br />
        <br /> 

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title" ></h3>
            </div>
            <div class="panel-body">
                <form id="form-filter" class="form-horizontal">
                    
                    <div class="form-group">
                        <label for="pegawai" class="col-sm-2 control-label">Tgl Mulai</label>
                        <div class="col-sm-4">
                            <input type="text" name="tgl_mulai2" id="tgl_mulai2" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="pegawai" class="col-sm-2 control-label">Tgl Selesai</label>
                        <div class="col-sm-4">
                            <input type="text" name="tgl_selesai2" id="tgl_selesai2" class="form-control">
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
                    <th>Pegawai</th>
                    <th>Instansi</th>
					<th>Tgl Kegiatan</th>
					<th>Kegiatan</th>
					<th>Kuantitas</th>
					<th>Status</th>
                    <th>Waktu</th>
					<th>Pendukung</th>
					<th style="width:125px;">Action</th>
				</tr>                
            </thead>
            <tbody>
            </tbody>

            <tfoot>

		 		<tr>
		 			<td></td>
		 			<td></td>
                    <td>Pegawai</td>
                    <td>Instansi</td>
					<td>Tgl Kegiatan</td>
					<td>Kegiatan</td>
					<td>Kuantitas</td>
					<td>Status</td>
                    <td>Waktu</td>
					<td>Pendukung</td>
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
	
		