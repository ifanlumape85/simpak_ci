    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List <? echo isset($title) ? ucwords(str_replace('_', ' ', $title)) : ''; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
        		<button class="btn btn-success btn-flat btn-sm" onclick="add_kegiatan_bulanan()"><i class="glyphicon glyphicon-plus"></i> Tambah</button>
                <?php if ($this->session->userdata('user_level_id') == 1) { ?> 
        		<button class="btn btn-default btn-flat btn-sm" onclick="reload_kegiatan_bulanan_table()"><i class="glyphicon glyphicon-refresh"></i> Muat Ulang</button>
        		<button class="btn btn-danger btn-flat btn-sm" onclick="bulk_delete()"><i class="glyphicon glyphicon-trash"></i> Hapus Masal</button>
        <br />
        <br />
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title" >Custom Filter : </h3>
            </div>
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

                    <div class="form-group fg-tahun2">
                        <label for="tahun" class="col-sm-2 control-label">Tahun</label>
                        <div class="col-sm-4">
                            <input type="text" name="tahun2" id="tahun2" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group fg-kegiatan2">
                        <label for="kegiatan" class="col-sm-2 control-label">Kegiatan</label>
                        <div class="col-sm-4">
                            <select name="id_kegiatan_tahunan2" id="id_kegiatan_tahunan2" class="form-control"></select>
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
    <?php } ?>
		<div class="col-sm-12">
            <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
    		 		<tr>
    		 			<th><input type="checkbox" id="check-all"></th>
    		            <th>No.</th>
                        <th>Tahun</th>
                        <th>Instansi</th>
                        <th>Pegawai</th>
    					<th>Kegiatan Tahunan </th>
    					<th>Bulan</th>
    					<th>Kegiatan</th>
    					<th>Kuantitas</th>
    					<th style="width:125px;">Action</th>
    				</tr>                
                </thead>
                <tbody>
                </tbody>

                <tfoot>
    		 		<tr>
    		 			<td></td>
    		 			<td></td>
                        <td>Tahun</td>
                        <td>Instansi</td>
                        <td>Pegawai</td>
    					<td>Kegiatan Tahunan </td>
    					<td>Bulan</td>
    					<td>Kegiatan</td>
    					<td>Kuantitas</td>
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
	
		