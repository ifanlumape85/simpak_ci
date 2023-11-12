<script type="text/javascript">

var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';
var user_level_id = "<?php echo $this->session->userdata('user_level_id'); ?>";
var instansi_id = "<?php echo $this->session->userdata('instansi_id'); ?>";
var pegawai_id = "<?php echo $this->session->userdata('pegawai_id'); ?>";
var tgl_sekarang = "<?php echo date('d-m-Y'); ?>";
var paging = true;
var searching = true;
var ordering = true;
var visible = true;

$(document).ready(function() {

    //datatables
    table = $('#table').DataTable({ 
        "searching": false,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('peringatan/ajax_list3')?>",
            "type": "POST", "data":function(data){
                data.csrf_test_name = '<?=$this->security->get_csrf_hash()?>';
                data.tgl_peringatan = $('[name=tgl_peringatan]').val();
                data.tgl_mulai = $('[name=tgl_mulai]').val();
                data.tgl_selesai = $('[name=tgl_selesai]').val();
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
            "targets": [ 2 ], //first column
            "orderable": false, //set not orderable
        },
        { 
            "targets": [ -2 ], //last column
            "orderable": false, //set not orderable
        },  
        ],

    });

    //datepicker
    $('#tgl_peringatan,#tgl_mulai,#tgl_selesai').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy"
    });

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
        reload_peringatan_table();  //just reload table
    });
    $('#btn-reset').click(function(){ //button reset event click
        $('select[name=jenis_peringatan2]').val("");
        $('select[name=id_pegawai2]').val("");
        $('[name=tgl_mulai]').val("");
        $('[name=tgl_selesai]').val("");
        reload_peringatan_table();  //just reload table
    });

    $('select[name=id_instansi2]').val(instansi_id);
    $.ajax({
        url : "<?php echo site_url('verifikator/option_pegawai/')?>/",
        type: "POST",
        data: {id_verifikator:<?=$this->session->userdata('pegawai_id')?>, csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
        dataType: "text",
        success: function(data)
        {
            $('select[name=id_pegawai2]').html(data);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });

    $('select[name=id_instansi2]').change(function() {
        var id = $('select[name=id_instansi2]').val();        
    });

    $('select[name=id_instansi]').change(function() {
        var id = $('select[name=id_instansi]').val();

        $.ajax({
            url : "<?php echo site_url('pegawai/option_pegawai/')?>/" + id,
            type: "POST",
            data: {id_instansi:id, csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
            dataType: "text",
            success: function(data)
            {
                $('select[name=id_pegawai]').html(data);
                $('.fg-pegawai').show();       
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });    
    });
});

function add_peringatan()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('[name=tgl_peringatan]').val(tgl_sekarang);
    $('[name=id_instansi]').val(instansi_id);
    $('.fg-tgl_peringatan').hide();

    $.ajax({
        url : "<?php echo site_url('pegawai/option_pegawai/')?>/" + instansi_id,
        type: "POST",
        data: {id_instansi:instansi_id, id_pegawai:pegawai_id, csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
        dataType: "text",
        success: function(data)
        {
            $('select[name=id_verifikator]').html(data);
            $('select[name=id_verifikator]').val(pegawai_id);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });

    $.ajax({
        url : "<?php echo site_url('verifikator/option_pegawai/')?>/" + pegawai_id,
        type: "POST",
        data: {id_verifikator:pegawai_id, csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
        dataType: "text",
        success: function(data)
        {
            $('select[name=id_pegawai]').html(data);
                  
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
 
    
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('input[name=csrf_test_name]').val('<?=$this->security->get_csrf_hash()?>');
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambah Peringatan'); // Set Title to Bootstrap modal title

}

function edit_peringatan(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals

    if (user_level_id > 1)
    {
        $('.fg-instansi').hide();
        $('.fg-verifikator').hide();
        $('.fg-tgl_peringatan').hide();
        $.ajax({
            url : "<?php echo site_url('pegawai/option_pegawai/')?>/" + instansi_id,
            type: "POST",
            data:{id_instansi:instansi_id, csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
            dataType: "text",
            success: function(data)
            {
                $('select[name=id_verifikator]').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });

        $.ajax({
            url : "<?php echo site_url('pegawai/option_pegawai/')?>/" + instansi_id,
            type: "POST",
            data: {id_instansi:instansi_id, csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
            dataType: "text",
            success: function(data)
            {
                $('select[name=id_pegawai]').html(data);
                $('.fg-pegawai').show();       
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
    
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    $('input[name=csrf_test_name]').val('<?=$this->security->get_csrf_hash()?>');
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('peringatan/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
			$('[name="id"]').val(data.id_peringatan);
			$('[name="id_pegawai"]').val(data.id_pegawai);
			$('[name="id_jenis_peringatan"]').val(data.id_jenis_peringatan);
            $('[name="id_verifikator"]').val(data.id_verifikator);
			$('[name="isi_peringatan"]').val(data.isi_peringatan);
			$('[name="tgl_peringatan"]').val(data.tgl_peringatan);
            
            var id_instansi = data.id_instansi;
            var id_pegawai = data.id_pegawai;

            $('select[name=id_instansi]').val(id_instansi); 
            $.ajax({
                url : "<?php echo site_url('pegawai/option_pegawai/')?>/" + id_instansi,
                type: "GET",
                dataType: "text",
                success: function(data)
                {
                    $('select[name=id_pegawai]').html(data);
                    $('select[name=id_pegawai]').val(id_pegawai);  
                    $('.fg-pegawai').show();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    // alert('Error get data from ajax');
                }
            }); 

            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Peringatan'); // Set title to Bootstrap modal title           
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function reload_peringatan_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function save()
{
    $('#btnSave').html('<i class="fa fa-plus"></i> Simpan...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('peringatan/ajax_add')?>";
    } else {
        url = "<?php echo site_url('peringatan/ajax_update')?>";
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
                reload_peringatan_table();
                if (save_method== 'add')
                {
				    $('select[name=id_pegawai]').val("");
                    $('select[name=id_jenis_peringatan]').val("");
                    $('select[name=isi_peringatan]').val("");

				    $('.form-group').removeClass('has-error'); // clear error class
				    $('.help-block').empty(); // clear error string
				    $('.modal-title').text('Tambah Peringatan'); // Set Title to Bootstrap modal title 
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
            $('#btnSave').html('<i class="fa fa-plus"></i> Simpan'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
        }
    });
}

function delete_peringatan(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('peringatan/ajax_delete')?>/"+id,
            type: "POST",
            data: {id:id, csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_peringatan_table();
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
                url: "<?php echo site_url('peringatan/ajax_bulk_delete')?>",
                dataType: "JSON",
                success: function(data)
                {
                    if(data.status)
                    {
                        reload_peringatan_table();
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
                <h3 class="modal-title">Peringatan Form</h3>
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


                <div class="form-group fg-verifikator">
                        <label class="control-label col-md-3" for="id_verifikator">Atasan Langsung</label>
                        <div class="col-md-9">
                            <select name="id_verifikator" id="id_verifikator" class="form-control"></select>
                            <span class="help-block"></span>
                        </div>
                    </div>

				<div class="form-group fg-pegawai">
						<label class="control-label col-md-3" for="id_pegawai">Pegawai</label>
						<div class="col-md-9">
							<select name="id_pegawai" id="id_pegawai" class="form-control"></select>
							<span class="help-block"></span>
						</div>
					</div>
				
                
                

				<div class="form-group">
						<label class="control-label col-md-3" for="id_jenis_peringatan">Jenis Peringatan </label>
						<div class="col-md-9">
							<?php echo $form_jenis_peringatan; ?>
							<span class="help-block"></span>
						</div>
					</div>
				
				<div class="form-group">
					<label class="control-label col-md-3" for="isi_peringatan">Isi Peringatan</label>
					<div class="col-md-9">
					<textarea class="form-control" name="isi_peringatan" id="isi_peringatan"><?php echo set_value('isi_peringatan', isset($default['isi_peringatan']) ? $default['isi_peringatan'] : ''); ?></textarea>
					<span class="help-block"></span>
					</div>
				</div>
				
				<div class="form-group fg-tgl_peringatan">
					<label class="control-label col-md-3" for="tgl_peringatan">Tgl Peringatan</label>
					<div class="col-md-9">
					<input placeholder="DD-MM-YYYY" type="text" name="tgl_peringatan" class="form-control" id="datepicker" />
					<span class="help-block"></span>
					</div>
				</div>
					
</div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary btn-flat btn-sm"><i class="fa fa-save"></i> Simpan</button>
                <button type="button" class="btn btn-danger btn-sm btn-flat" data-dismiss="modal"><i class="fa fa-undo"></i> Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->	
		