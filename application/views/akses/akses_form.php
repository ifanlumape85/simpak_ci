<script type="text/javascript">
    var save_method; //for save method string
    var table;
    var base_url = '<?php echo base_url(); ?>';

    $(document).ready(function() {

        //datatables
        table = $('#table').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('akses/ajax_list') ?>",
                "type": "POST",
                "data": function(data) {
                    data.csrf_test_name = '<?= $this->security->get_csrf_hash() ?>';
                    data.id_pegawai = $('select[name=id_pegawai2]').val();
                }
            },

            //Set column definition initialisation properties.
            "columnDefs": [{
                    "targets": [0], //first column
                    "orderable": false, //set not orderable
                },
                {
                    "targets": [1], //first column
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

        $(".timepicker").timepicker({
            showInputs: false
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
            reload_akses_table(); //just reload table
        });
        $('#btn-reset').click(function() { //button reset event click
            $('#form-filter')[0].reset();
            reload_akses_table(); //just reload table
        });

    });

    function add_akses() {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah akses'); // Set Title to Bootstrap modal title

    }

    function edit_akses(id) {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('akses/ajax_edit/') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="id"]').val(data.id_akses);
                $('[name="id_pegawai"]').val(data.id_pegawai);
                $('[name="package_name"]').val(data.package_name);
                $('[name="status"]').val(data.status);

                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit akses'); // Set title to Bootstrap modal title
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function reload_akses_table() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function save() {
        $('#btnSave').html('<i class="fa fa-plus"></i> Simpan...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable
        var url;

        if (save_method == 'add') {
            url = "<?php echo site_url('akses/ajax_add') ?>";
        } else {
            url = "<?php echo site_url('akses/ajax_update') ?>";
        }

        // ajax adding data to database
        $.ajax({
            url: url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data) {
                if (data.status) //if success close modal and reload ajax table
                {
                    reload_akses_table();
                    if (save_method == 'add') {
                        $('#form')[0].reset(); // reset form on modals
                        $('.form-group').removeClass('has-error'); // clear error class
                        $('.help-block').empty(); // clear error string
                        $('.modal-title').text('Tambah akses'); // Set Title to Bootstrap modal title
                    } else {
                        $('#modal_form').modal('hide');
                    }
                } else {
                    for (var i = 0; i < data.inputerror.length; i++) {
                        $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]); //select span help-block class set text error string
                    }
                }
                $('#btnSave').html('<i class="fa fa-plus"></i> Simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data');
                $('#btnSave').html('<i class="fa fa-plus"></i> Simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable
            }
        });
    }

    function delete_akses(id) {
        if (confirm('Are you sure delete this data?')) {
            // ajax delete data to database
            $.ajax({
                url: "<?php echo site_url('akses/ajax_delete') ?>/" + id,
                type: "POST",
                data: {
                    id: id,
                    csrf_test_name: '<?= $this->security->get_csrf_hash() ?>'
                },
                dataType: "JSON",
                success: function(data) {
                    //if success reload ajax table
                    $('#modal_form').modal('hide');
                    reload_akses_table();
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
                    url: "<?php echo site_url('akses/ajax_bulk_delete') ?>",
                    dataType: "JSON",
                    success: function(data) {
                        if (data.status) {
                            reload_akses_table();
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
                <h3 class="modal-title">Akses Form</h3>
            </div>
            <div class="modal-body form">
                <?= form_open('#', array('id' => 'form', 'class' => 'form-horizontal')) ?>
                <input type="hidden" value="" name="id" />
                <div class="form-body">

                    <div class="form-group">
                        <label class="control-label col-md-3" for="id_pegawai">Pegawai </label>
                        <div class="col-md-9">
                            <?php echo $form_pegawai; ?>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3" for="package_name">Package Name</label>
                        <div class="col-md-9">
                            <textarea name="package_name" id="package_name" cols="30" rows="10" class="form-control"></textarea>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="bootstrap-timepicker">
                        <div class="form-group">
                            <label class="control-label col-md-3" for="status">Status</label>
                            <div class="col-md-9">
                                <input type="number" name="status" class="form-control" />
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>

                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary btn-flat btn-sm"><i class="fa fa-plus"></i> Simpan</button>
                <button type="button" class="btn btn-danger btn-flat btn-sm" data-dismiss="modal"><i class="fa fa-undo"></i> Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->