<script type="text/javascript">

var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';
var instansi_id = '<?php echo $this->session->userdata('instansi_id'); ?>';
var user_level_id = '<?php echo $this->session->userdata('user_level_id'); ?>';

$(document).ready(function() {

    //datatables
    table = $('#table').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('mesin_absensi/ajax_list')?>",
            "type": "POST", "data":function(data){
                data.csrf_test_name = '<?=$this->security->get_csrf_hash()?>';
                data.id_mesin_absensi = $('#id_mesin_absensi').val();
            }
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0 ], //first column
            "orderable": false, //set not orderable
        },
        { 
            "targets": [ 1 ], //first column
            "orderable": false, //set not orderable
        },  
        { 
            "targets": [ -8 ], //last column
            "orderable": false, //set not orderable
        },
        { 
            "targets": [ -7 ], //last column
            "orderable": false, //set not orderable
        },
        { 
            "targets": [ -6 ], //last column
            "orderable": false, //set not orderable
        },
        { 
            "targets": [ -5 ], //last column
            "orderable": false, //set not orderable
        },
        { 
            "targets": [ -4 ], //last column
            "orderable": false, //set not orderable
        },
        { 
            "targets": [ -3 ], //last column
            "orderable": false, //set not orderable
        },
        { 
            "targets": [ -2 ], //last column
            "orderable": false, //set not orderable
        },
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
        },       
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
        },
        ],

    });

    //datepicker
    // $('.datepicker').datepicker({
    //     autoclose: true,
    //     format: "yyyy-mm-dd",
    //     todayHighlight: true,
    //     orientation: "top auto",
    //     todayBtn: true,
    //     todayHighlight: true,  
    // });

    //set input/textarea/select event when change value, remove class error and remove text help block 
    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("textarea").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("select").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    //check all
    $("#check-all").click(function () {
        $(".data-check").prop('checked', $(this).prop('checked'));
    }); 

    $('#btn-filter').click(function(){ //button filter event click
        reload_mesin_absensi_table();  //just reload table
    });
    $('#btn-reset').click(function(){ //button reset event click
        $('#form-filter')[0].reset();
        reload_mesin_absensi_table();  //just reload table
    });

});

function add_mesin_absensi()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals

    $('.form-group').removeClass('has-error'); // clear error class
    $('input[name=csrf_test_name]').val('<?=$this->security->get_csrf_hash()?>');
    $('.help-block').empty(); // clear error string
    $('input[name=aktif][value="N"]').prop('checked', 'checked');
    
    if (user_level_id > 1)
    {
        $('select[name=id_instansi]').val(instansi_id);     
        $('.fg-instansi').hide();
    }

    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambah Mesin Absensi'); // Set Title to Bootstrap modal title

}

function edit_mesin_absensi(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals

    if (user_level_id > 1)
    {
        $('select[name=id_instansi]').val(instansi_id);     
        $('.fg-instansi').hide();
    }

    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('input[name=csrf_test_name]').val('<?=$this->security->get_csrf_hash()?>');

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('mesin_absensi/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
			$('[name="id"]').val(data.id_mesin_absensi);
            $('select[name="id_instansi"]').val(data.id_instansi);
			$('[name="nama_mesin_absensi"]').val(data.nama_mesin_absensi);
			$('[name="serial_port"]').val(data.serial_port);
			$('[name="port"]').val(data.port);
			$('[name="ip_address"]').val(data.ip_address);
			$('[name="lokasi"]').val(data.lokasi);

            $('input[name=aktif][value='+data.aktif+']').prop('checked', 'checked');
                                    
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Mesin Absensi'); // Set title to Bootstrap modal title           
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function reload_mesin_absensi_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function save()
{
    $('#btnSave').html('<span class="glyphicon glyphicon-ok"></span> Simpan...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('mesin_absensi/ajax_add')?>";
    } else {
        url = "<?php echo site_url('mesin_absensi/ajax_update')?>";
    }

    // ajax adding data to database
    $.ajax({        
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",        
        success: function(data)
        {
            if(data.status) //if success close modal and reload ajax table
            {
                reload_mesin_absensi_table();
                if (save_method== 'add')
                {
				    $('#form')[0].reset(); // reset form on modals
				    $('.form-group').removeClass('has-error'); // clear error class
				    $('.help-block').empty(); // clear error string
				    $('.modal-title').text('Tambah Mesin Absensi'); // Set Title to Bootstrap modal title 
				}
				else
				{
					$('#modal_form').modal('hide');
				}                
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').html('<i class="fa fa-plus"></i> Simpan'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').html('<span class="glyphicon glyphicon-ok"></span> Simpan'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
        }
    });
}

function delete_mesin_absensi(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('mesin_absensi/ajax_delete')?>/"+id,
            type: "POST",
            data: {id:id,csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_mesin_absensi_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });

    }
}

function bulk_delete()
{
    var list_id = [];
    $(".data-check:checked").each(function() {
            list_id.push(this.value);
    });
    if(list_id.length > 0)
    {
        if(confirm('Are you sure delete this '+list_id.length+' data?'))
        {
            $.ajax({
                type: "POST",
                data: {id:list_id,csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
                url: "<?php echo site_url('mesin_absensi/ajax_bulk_delete')?>",
                dataType: "JSON",
                success: function(data)
                {
                    if(data.status)
                    {
                        reload_mesin_absensi_table();
                    }
                    else
                    {
                        alert('Failed.');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error deleting data');
                }
            });
        }
    }
    else
    {
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
                <h3 class="modal-title">Mesin Absensi Form</h3>
            </div>
            <div class="modal-body form">
                <?=form_open('#', array("id" => "form", "class" => "form-horizontal"))?>
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">

                <div class="form-group fg-instansi">
                    <label class="control-label col-md-3" for="id_instansi">Instansi</label>
                    <div class="col-md-9">
                    <?php echo $form_instansi; ?>     
                    <span class="help-block"></span>
                    </div>
                </div>

				<div class="form-group">
					<label class="control-label col-md-3" for="nama_mesin_absensi">Nama Mesin Absensi </label>
					<div class="col-md-9">
    				<input placeholder="Nama Mesin Absensi " type="text" name="nama_mesin_absensi" class="form-control" />		
					<span class="help-block"></span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3" for="serial_port">Serial Port</label>
					<div class="col-md-9">
    				<input placeholder="Serial Port" type="text" name="serial_port" class="form-control" />		
					<span class="help-block"></span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3" for="port">Port</label>
					<div class="col-md-9">
    				<input placeholder="Port" type="text" name="port" class="form-control" />		
					<span class="help-block"></span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3" for="ip_address">IP Address</label>
					<div class="col-md-9">
    				<input placeholder="Ip Address" type="text" name="ip_address" class="form-control" />		
					<span class="help-block"></span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3" for="password">Password</label>
					<div class="col-md-9">
    				<input type="password" name="password" class="form-control" />
					<span class="help-block"></span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3" for="lokasi">Lokasi</label>
					<div class="col-md-9">
    				<input placeholder="Lokasi" type="text" name="lokasi" class="form-control" />		
					<span class="help-block"></span>
					</div>
				</div>
				    
				<div class="form-group">
					<label class="control-label col-md-3" for="aktif">Aktif</label>
					<div class="col-md-9">
					<input name="aktif" type="radio" value="Y" /> Y
					<input name="aktif" type="radio" value="N" /> N  
					<span class="help-block"></span>
					</div>
				</div>
	
</div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary btn-flat btn-sm"><span class="glyphicon glyphicon-ok"></span> Simpan</button>
                <button type="button" class="btn btn-danger btn-flat btn-sm" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->	
		