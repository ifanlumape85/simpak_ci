<script type="text/javascript">
    var save_method; //for save method string
    var table;
    var base_url = '<?= base_url(); ?>';
    var pegawai_id = '<?= $this->session->userdata('pegawai_id'); ?>';
    var user_level_id = '<?= $this->session->userdata('user_level_id'); ?>';
    var instansi_id = '<?= $this->session->userdata('instansi_id'); ?>';
    var searching = true;
    var visible = true;

    $(document).ready(function() {

        if (user_level_id > 1) {
            if (user_level_id == 5) {
                searching = false;
            }
            visible = false;

            if (user_level_id == 5) {
                $('.btn_add').hide();
                $('.btn_refresh').hide();
                $('.custom_filter').hide();
                $('.fg-password').hide();
                $('.fg-aktif').hide();
            }
            $('.fg-instansi2').hide();
        }

        //datatables
        table = $('#table').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "searching": searching,
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?= site_url('Pegawai/ajax_list') ?>",
                "type": "POST",
                "data": function(data) {
                    data.csrf_test_name = '<?= $this->security->get_csrf_hash() ?>';
                    data.id_status_pegawai = $('select[name=id_status_pegawai2]').val();
                    data.id_instansi = $('select[name=id_instansi2]').val();
                    data.id_jabatan = $('select[name=id_jabatan2]').val();
                }
            },

            //Set column definition initialisation properties.
            "columnDefs": [{
                    "targets": [0], //first column
                    "orderable": false, //set not orderable
                    "visible": visible,
                },
                {
                    "targets": [1], //first column
                    "orderable": false, //set not orderable
                },
                {
                    "targets": [-3], //last column
                    "orderable": false, //set not orderable
                },
                {
                    "targets": [-2], //last column
                    "orderable": false, //set not orderable
                },
                {
                    "targets": [-1], //last column
                    "orderable": false, //set not orderable
                },
            ],

        });

        $('#datepicker').datepicker({
            autoclose: true,
            format: "dd-mm-yyyy"
        });

        //set input/textarea/select event when change value, remove class error and remove text help block
        $("input").change(function() {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });
        $("textarea").change(function() {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });
        $("select").change(function() {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });
        //check all
        $("#check-all").click(function() {
            $(".data-check").prop('checked', $(this).prop('checked'));
        });

        $('#btn-filter').click(function() { //button filter event click
            reload_pegawai_table(); //just reload table
        });
        $('#btn-reset').click(function() { //button reset event click
            $('#form-filter')[0].reset();
            if (user_level_id > 1) {
                $('select[name=id_instansi2]').val(instansi_id);
            }
            reload_pegawai_table(); //just reload table
        });

        if (user_level_id > 1) {
            $('.fg-instansi2').hide();
            $('select[name=id_instansi2]').val(instansi_id);
        }
        $('.fg_pangkat').hide();
    });

    function add_pegawai() {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('input[name=aktif][value="N"]').prop('checked', 'checked');
        $('input[name=jenis_kelamin][value="L"]').prop('checked', 'checked');
        $('input[name=csrf_test_name]').val('<?= $this->security->get_csrf_hash() ?>');
        if (user_level_id > 1) {
            // $('.fg-instansi').hide();
            $('select[name=id_instansi]').val(instansi_id);
        }
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Pegawai'); // Set Title to Bootstrap modal title

        $('#photo-preview').hide(); // hide photo preview modal
        $('#label-photo').text('Upload Photo'); // label photo upload
    }

    function edit_pegawai(id) {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        if (user_level_id > 1) {
            $('.fg-instansi').hide();
        }

        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        $('input[name=csrf_test_name]').val('<?= $this->security->get_csrf_hash() ?>');
        //Ajax Load data from ajax
        $.ajax({
            url: "<?= site_url('Pegawai/ajax_edit/') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="id"]').val(data.id_pegawai);
                $('[name="nip"]').val(data.nip);
                $('[name="nama_pegawai"]').val(data.nama_pegawai);
                $('[name="tempat_lahir"]').val(data.tempat_lahir);
                $('[name="tgl_lahir"]').val(data.tgl_lahir);
                $('[name="no_telp"]').val(data.no_telp);
                $('[name="id_status_pegawai"]').val(data.id_status_pegawai);
                $('[name="id_instansi"]').val(data.id_instansi);
                $('[name="id_jabatan"]').val(data.id_jabatan);
                $('[name="id_pangkat"]').val(data.id_pangkat);
                $('[name="id_golongan"]').val(data.id_golongan);

                $('input[name=aktif][value=' + data.aktif + ']').prop('checked', 'checked');
                $('input[name=jenis_kelamin][value=' + data.jenis_kelamin + ']').prop('checked', 'checked');
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Pegawai'); // Set title to Bootstrap modal title
                $('#photo-preview').show(); // show photo preview modal

                if (data.photo) {
                    $('#label-photo').text('Ubah Photo'); // label photo upload
                    $('#photo-preview div').html('<img src="' + base_url + 'upload/Pegawai/thumbs/' + data.photo + '" class="img-responsive">'); // show photo
                    $('#photo-preview div').append('<input type="checkbox" name="remove_photo" value="' + data.photo + '"/> Hapus photo'); // remove photo
                } else {
                    $('#label-photo').text('Upload Photo'); // label photo upload
                    $('#photo-preview div').text('(No photo)');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function reload_pegawai_table() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function save() {
        $('#btnSave').html('<i class="fa fa-save"></i> Simpan...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable
        var url;

        if (save_method == 'add') {
            url = "<?= site_url('Pegawai/ajax_add') ?>";
        } else {
            url = "<?= site_url('Pegawai/ajax_update') ?>";
        }

        // ajax adding data to database
        var formData = new FormData($('#form')[0]);
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function(data) {
                if (data.status) //if success close modal and reload ajax table
                {
                    reload_pegawai_table();
                    if (save_method == 'add') {
                        $('#form')[0].reset(); // reset form on modals
                        $('.form-group').removeClass('has-error'); // clear error class
                        $('.help-block').empty(); // clear error string
                        $('.modal-title').text('Tambah Pegawai'); // Set Title to Bootstrap modal title
                    } else {
                        $('#modal_form').modal('hide');
                    }
                } else {
                    for (var i = 0; i < data.inputerror.length; i++) {
                        $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]); //select span help-block class set text error string
                    }
                }
                $('#btnSave').html('<i class="fa fa-save"></i> Simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data');
                $('#btnSave').html('<i class="fa fa-save"></i> Simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable
            }
        });
    }

    function delete_pegawai(id) {
        if (confirm('Are you sure delete this data?')) {
            // ajax delete data to database
            $.ajax({
                url: "<?= site_url('Pegawai/ajax_delete') ?>/" + id,
                type: "POST",
                data: {
                    id: id,
                    csrf_test_name: '<?= $this->security->get_csrf_hash() ?>'
                },
                dataType: "JSON",
                success: function(data) {
                    //if success reload ajax table
                    $('#modal_form').modal('hide');
                    reload_pegawai_table();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error deleting data');
                }
            });

        }
    }

    function bulk_delete() {
        var list_id = [];
        $(".data-check:checked").each(function() {
            list_id.push(this.value);
        });
        if (list_id.length > 0) {
            if (confirm('Are you sure delete this ' + list_id.length + ' data?')) {
                $.ajax({
                    type: "POST",
                    data: {
                        id: list_id,
                        csrf_test_name: '<?= $this->security->get_csrf_hash() ?>'
                    },
                    url: "<?= site_url('Pegawai/ajax_bulk_delete') ?>",
                    dataType: "JSON",
                    success: function(data) {
                        if (data.status) {
                            reload_pegawai_table();
                        } else {
                            alert('Failed.');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error deleting data');
                    }
                });
            }
        } else {
            alert('no data selected');
        }
    }
</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Pegawai Form</h3>
            </div>
            <div class="modal-body form">
                <?= form_open('#', array("id" => "form", "class" => "form-horizontal")) ?>
                <input type="hidden" value="" name="id" />
                <div class="form-body">

                    <div class="form-group fg-instansi">
                        <label class="control-label col-md-3" for="id_instansi">Instansi</label>
                        <div class="col-md-9">
                            <?= $form_instansi; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3" for="nip">NIP</label>
                        <div class="col-md-9">
                            <input placeholder="NIP" type="text" name="nip" class="form-control" />
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3" for="nama_pegawai">Nama Pegawai</label>
                        <div class="col-md-9">
                            <input placeholder="Nama Pegawai" type="text" name="nama_pegawai" class="form-control" />
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3" for="tempat_lahir">Tempat Lahir</label>
                        <div class="col-md-9">
                            <input placeholder="Tempat Lahir" type="text" name="tempat_lahir" class="form-control" />
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3" for="tgl_lahir">Tgl Lahir</label>
                        <div class="col-md-9">
                            <input placeholder="DD-MM-YYYY" type="text" name="tgl_lahir" class="form-control" id="datepicker" />
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3" for="no_telp">No Telp</label>
                        <div class="col-md-9">
                            <input placeholder="No Telp" type="text" name="no_telp" class="form-control" />
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3" for="id_status_pegawai">Status Pegawai </label>
                        <div class="col-md-9">
                            <?= $form_status_pegawai; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group fg_pangkat">
                        <label class="control-label col-md-3" for="id_pangkat">Pangkat</label>
                        <div class="col-md-9">
                            <?= $form_pangkat; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3" for="id_golongan">Golongan/Pangkat</label>
                        <div class="col-md-9">
                            <?= $form_golongan; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group fg-jabatan">
                        <label class="control-label col-md-3" for="id_jabatan">Jabatan</label>
                        <div class="col-md-9">
                            <?= $form_jabatan; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group fg-password">
                        <label class="control-label col-md-3" for="password">Password</label>
                        <div class="col-md-9">
                            <input type="password" name="password" class="form-control" />
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group fg-aktif">
                        <label class="control-label col-md-3" for="aktif">Aktif</label>
                        <div class="col-md-9">
                            <input name="aktif" type="radio" value="Y" /> Y
                            <input name="aktif" type="radio" value="N" /> N
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group fg-jenis_kelamin">
                        <label class="control-label col-md-3" for="jenis_kelamin">Jenis Kelamin</label>
                        <div class="col-md-9">
                            <input name="jenis_kelamin" type="radio" value="L" /> Laki-laki
                            <input name="jenis_kelamin" type="radio" value="P" /> Perempuan
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group" id="photo-preview">
                        <label class="control-label col-md-3">Photo</label>
                        <div class="col-md-9">
                            (No photo)
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3" id="label-photo">Upload File</label>
                        <div class="col-md-9">
                            <input name="photo" type="file">
                            <span class="help-block"></span>
                        </div>
                    </div>

                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                <button type="button" class="btn btn-sm btn-danger btn-flat" data-dismiss="modal"><i class="fa fa-undo"></i> Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->