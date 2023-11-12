    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">KEGIATAN HARIAN (SEBAGAI ATASAN)</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
       
    

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title" ></h3>
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
                        <label for="pegawai" class="col-sm-2 control-label">Tgl Mulai</label>
                        <div class="col-sm-4">
                            <input type="text" name="tgl_mulai2" id="tgl_mulai2" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="pegawai" class="col-sm-2 control-label">Tgl Akhir</label>
                        <div class="col-sm-4">
                            <input type="text" name="tgl_akhir2" id="tgl_akhir2" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="pegawai" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-4">
                            <select name="status2" id="status2" class="form-control">
                                <option value="">Pilih Status</option>
                                <option value="0">Menunggu</option>
                                <option value="1">Disetujui</option>
                                <option value="2">Ditolak</option>
                            </select>
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
	
		