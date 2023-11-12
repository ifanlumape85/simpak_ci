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
    					<th>Realisasi</th>
                        <th>Hasil</th>
                        <th>Kualitas</th>
                        <th>Nilai</th>
                        <th></th>
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
    					<td>Realisasi</td>
                        <td>Hasil</td>
                        <td>Kualitas</td>
                        <td>Nilai</td>
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
	
		