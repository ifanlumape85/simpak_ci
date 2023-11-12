<script type="text/javascript">

var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';
var user_level_id = '<?php echo $this->session->userdata('user_level_id'); ?>';
var pegawai_id = '<?php echo $this->session->userdata('pegawai_id'); ?>';
var instansi_id = '<?php echo $this->session->userdata('instansi_id'); ?>';
var visible = true;
$(document).ready(function() {
    if (user_level_id > 1)
    {
        visible = false;
    }
    //datatables
    table = $('#table').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('golongan_pangkat/ajax_list')?>",
            "type": "POST", "data":function(data){
                data.csrf_test_name = '<?=$this->security->get_csrf_hash()?>';
                data.id_pegawai = $('select[name=id_pegawai2]').val();
                data.id_golongan = $('select[name=id_golongan2]').val();
                data.id_pangkat = $('select[name=id_pangkat2]').val();
            }
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0 ], //first column
            "orderable": false, //set not orderable
            "visible":visible
        },
        { 
            "targets": [ 1 ], //first column
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
        reload_golongan_pangkat_table();  //just reload table
    });
    $('#btn-reset').click(function(){ //button reset event click
        $('#form-filter')[0].reset();
        reload_golongan_pangkat_table();  //just reload table
    });

    $('.fg-pegawai').hide();
    $('.fg-pegawai2').hide();

    $('select[name=id_instansi2]').change(function() {
        var id = $('select[name=id_instansi2]').val();

        $.ajax({
            url : "<?php echo site_url('pegawai/option_pegawai/')?>/" + id,
            type: "POST",
            data: {id_instansi:id, csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
            dataType: "text",
            success: function(data)
            {
                $('select[name=id_pegawai2]').html(data);
                $('.fg-pegawai2').show();       
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });    
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

function add_golongan_pangkat()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('input[name=csrf_test_name]').val('<?=$this->security->get_csrf_hash()?>');
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambah Golongan Pangkat'); // Set Title to Bootstrap modal title

}

function edit_golongan_pangkat(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    if (user_level_id > 1)
    {
        $('.fg-instansi').hide();

    }
    $('.fg-pegawai').show();
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('input[name=csrf_test_name]').val('<?=$this->security->get_csrf_hash()?>');

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('golongan_pangkat/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
         $('[name="id"]').val(data.id_golongan_pangkat);
         $('[name="id_pegawai"]').val(data.id_pegawai);
			// $('[name="verifikator"]').val(data.verifikator);
			$('[name="id_golongan"]').val(data.id_golongan);
			$('[name="id_pangkat"]').val(data.id_pangkat);

            var id_instansi = data.id_instansi;
            var id_pegawai = data.id_pegawai;
            $('select[name=id_instansi]').val(id_instansi);
            $.ajax({
                url : "<?php echo site_url('pegawai/option_pegawai/')?>/" + id_instansi,
                type: "POST",
                data: {id_instansi:id_instansi, csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
                dataType: "text",
                success: function(data)
                {
                    $('select[name=id_pegawai]').html(data);
                    $('select[name=id_pegawai]').val(id_pegawai);  
                    if (user_level_id==5)
                    {
                        $('.fg-pegawai').hide();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    // alert('Error get data from ajax');
                }
            }); 
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Golongan Pangkat'); // Set title to Bootstrap modal title           
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function reload_golongan_pangkat_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function save()
{
    $('#btnSave').html('<i class="fa fa-plus"></i> Simpan...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('golongan_pangkat/ajax_add')?>";
    } else {
        url = "<?php echo site_url('golongan_pangkat/ajax_update')?>";
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
                reload_golongan_pangkat_table();
                if (save_method== 'add')
                {
				    $('#form')[0].reset(); // reset form on modals
				    $('.form-group').removeClass('has-error'); // clear error class
				    $('.help-block').empty(); // clear error string
				    $('.modal-title').text('Tambah Golongan Pangkat'); // Set Title to Bootstrap modal title 
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

function delete_golongan_pangkat(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('golongan_pangkat/ajax_delete')?>/"+id,
            type: "POST",
            data: {id:id, csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_golongan_pangkat_table();
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
                url: "<?php echo site_url('golongan_pangkat/ajax_bulk_delete')?>",
                dataType: "JSON",
                success: function(data)
                {
                    if(data.status)
                    {
                        reload_golongan_pangkat_table();
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
                <h3 class="modal-title">Golongan Pangkat Form</h3>
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

                    <div class="form-group fg-pegawai">
                      <label class="control-label col-md-3" for="id_pegawai">Pegawai</label>
                      <div class="col-md-9">
                         <select name="id_pegawai" class="form-control" id="id_pegawai"></select>
                         <span class="help-block"></span>
                     </div>
                 </div>

<!-- 				<div class="form-group">
					<label class="control-label col-md-3" for="verifikator">Verifikator</label>
					<div class="col-md-9">
    				<input placeholder="Verifikator" type="text" name="verifikator" class="form-control" />		
					<span class="help-block"></span>
					</div>
				</div> -->
				
				<div class="form-group">
                  <label class="control-label col-md-3" for="id_golongan">Golongan</label>
                  <div class="col-md-9">
                     <?php echo $form_golongan; ?>
                     <span class="help-block"></span>
                 </div>
             </div>

             <div class="form-group">
              <label class="control-label col-md-3" for="id_pangkat">Pangkat</label>
              <div class="col-md-9">
                 <?php echo $form_pangkat; ?>
                 <span class="help-block"></span>
             </div>
         </div>

     </div>
 </form>
</div>
<div class="modal-footer">
    <button type="button" id="btnSave" onclick="save()" class="btn btn-primary btn-flat btn-sm"><i class="glyphicon glyphicon-ok"></i> Simpan</button>
    <button type="button" class="btn btn-danger btn-flat btn-sm" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Batal</button>
</div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->	
