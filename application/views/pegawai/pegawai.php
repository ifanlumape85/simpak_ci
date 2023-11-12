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
                        <?php if ($this->session->userdata('user_level_id') == 1) { ?>
                            <button class="btn btn-success btn-flat btn-sm btn_add" onclick="add_pegawai()"><i class="glyphicon glyphicon-plus"></i> Tambah</button>
                            <button class="btn btn-default btn-flat btn-sm btn_refresh" onclick="reload_pegawai_table()"><i class="glyphicon glyphicon-refresh"></i> Muat Ulang</button>

                            <button class="btn btn-danger btn-flat btn-sm" onclick="bulk_delete()"><i class="glyphicon glyphicon-trash"></i> Hapus Masal</button>
                            <br />
                            <br />
                        <?php } ?>


                        <div class="panel panel-default custom_filter">
                            <div class="panel-heading">
                                <h3 class="panel-title">&nbsp;</h3>
                            </div>
                            <div class="panel-body">
                                <form id="form-filter" class="form-horizontal">

                                    <div class="form-group fg-instansi2">
                                        <label for="instansi" class="col-sm-2 control-label">Instansi</label>
                                        <div class="col-sm-4">
                                            <?php echo $form_instansi2; ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="status pegawai " class="col-sm-2 control-label">Status Pegawai </label>
                                        <div class="col-sm-4">
                                            <?php echo $form_status_pegawai2; ?>
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <label for="id_jabatan" class="col-sm-2 control-label">Jabatan </label>
                                        <div class="col-sm-4">
                                            <?php echo $form_jabatan2; ?>
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
                                        <th>Jabatan</th>
                                        <th>Status Pegawai </th>
                                        <th>Aktif</th>
                                        <th>Photo</th>
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
                                        <td>Jabatan</td>
                                        <td>Status Pegawai </td>
                                        <td>Aktif</td>
                                        <td>Photo</td>
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