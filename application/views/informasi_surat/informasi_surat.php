
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
        		<button class="btn btn-success btn-flat" onclick="add_informasi_surat()"><i class="glyphicon glyphicon-plus"></i> Tambah</button>
        		<button class="btn btn-default btn-flat" onclick="reload_informasi_surat_table()"><i class="glyphicon glyphicon-refresh"></i> Muat Ulang</button>
        		<button class="btn btn-danger btn-flat" onclick="bulk_delete()"><i class="glyphicon glyphicon-trash"></i> Hapus Masal</button>
        <br />
        <br />

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title" >Custom Filter : </h3>
            </div>
            <div class="panel-body">
                <form id="form-filter" class="form-horizontal">
		
		          <div class="form-group">
                        <label for="surat masuk " class="col-sm-2 control-label">Surat Masuk </label>
                        <div class="col-sm-4">
                            <?php echo $form_surat_masuk2; ?>
                        </div>
                    </div>
						
		          <div class="form-group">
                        <label for="status surat " class="col-sm-2 control-label">Status Surat </label>
                        <div class="col-sm-4">
                            <?php echo $form_status_surat2; ?>
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
					<th>Surat Masuk </th>
					<th>Status Surat </th>
					<th>Tgl Informasi Surat </th>
					<th>Jam Informasi Surat </th>
					<th>Tgl Entri</th>
					<th>Jam Entri</th>
					<th>User Entri </th>
					<th>Tgl Update</th>
					<th>Jam Update</th>
					<th>User Update </th>
					<th style="width:125px;">Action</th>
				</tr>                
            </thead>
            <tbody>
            </tbody>

            <tfoot>

		 		<tr>
		 			<td></td>
		 			<td></td>
					<td>Surat Masuk </td>
					<td>Status Surat </td>
					<td>Tgl Informasi Surat </td>
					<td>Jam Informasi Surat </td>
					<td>Tgl Entri</td>
					<td>Jam Entri</td>
					<td>User Entri </td>
					<td>Tgl Update</td>
					<td>Jam Update</td>
					<td>User Update </td>
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
	
		