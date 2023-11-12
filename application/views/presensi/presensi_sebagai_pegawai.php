    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><? echo isset($title) ? ucwords(str_replace('_', ' ', $title)) : ''; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
        <div class="panel panel-default custom_filter">
        
            <div class="panel-body">
                <form id="form-filter" class="form-horizontal">
		

                    <div class="form-group">
                        <label for="instansi" class="col-sm-2 control-label">Jenis Absensi</label>
                        <div class="col-sm-4">
                            <?php echo $form_jenis_presensi2; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tgl_mulai2" class="col-sm-2 control-label">Tgl Mulai</label>
                        <div class="col-sm-4">
                            <input type="text" name="tgl_mulai2" id="tgl_mulai2" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tgl_mulai2" class="col-sm-2 control-label">Tgl Selesai</label>
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
		 			<th>No.</th>
					<th>Instansi</th>
                    <th>Pegawai</th>
                    <th>Tgl Presensi</th>
					<th>Jenis Presensi </th>
					<th>Status Presensi </th>
				</tr>                
            </thead>
            <tbody>
            </tbody>

            <tfoot>

		 		<tr>
		 			<td></td>
					<td>Instansi</td>
                    <td>Pegawai</td>
                    <td>Tgl Presensi</td>
					<td>Jenis Presensi </td>
					<td>Status Presensi </td>
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
	
		