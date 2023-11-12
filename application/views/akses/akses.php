<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <!-- /.box -->

      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?= isset($title) ? ucwords(str_replace('_', ' ', $title)) : ''; ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <button class="btn btn-success btn-flat btn-sm" onclick="add_akses()"><i class="glyphicon glyphicon-plus"></i> Tambah</button>
          <button class="btn btn-default btn-flat btn-sm" onclick="reload_akses_table()"><i class="glyphicon glyphicon-refresh"></i> Muat Ulang</button>
          <button class="btn btn-danger btn-flat btn-sm" onclick="bulk_delete()"><i class="glyphicon glyphicon-trash"></i> Hapus Masal</button>
          <br />
          <br />

          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"></h3>
            </div>
            <div class="panel-body">
              <form id="form-filter" class="form-horizontal">

                <div class="form-group">
                  <label for="jenis akses " class="col-sm-2 control-label">Pegawai </label>
                  <div class="col-sm-4">
                    <?php echo $form_pegawai2; ?>
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
                  <th>Pegawai </th>
                  <th>Package Name</th>
                  <th>Status</th>
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
                  <td>Package Name</td>
                  <td>Status</td>
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