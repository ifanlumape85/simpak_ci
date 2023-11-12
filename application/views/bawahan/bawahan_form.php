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
        $('.btn_refresh').hide();
        $('.btn_delete').hide();
        $('.custom_filter').hide();
        visible = false;
    }
    //datatables
    table = $('#table').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('bawahan/ajax_list')?>",
            "type": "POST", "data":function(data){
                data.csrf_test_name = '<?=$this->security->get_csrf_hash()?>';
                data.id_instansi = $('#id_instansi2').val();
            }
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0 ], //first column
            "orderable": false, //set not orderable
            "visible" : visible
        },
        { 
            "targets": [ 1 ], //first column
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
        reload_bawahan_table();  //just reload table
    });
    $('#btn-reset').click(function(){ //button reset event click
        $('#form-filter')[0].reset();
        reload_bawahan_table();  //just reload table
    });

    $('.fg-pegawai').hide();
    $('.fg-bawahan').hide();
    $('.fg-pegawai2').hide();
    
    $('select[name=id_instansi2]').change(function() {
        var id = $('select[name=id_instansi2]').val();

        $.ajax({
            url : "<?php echo site_url('pegawai/option_pegawai/')?>/" + id,
            type: "POST",
            data: {id_instansi:id,csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
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
            data: {id_instansi:id,csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
            dataType: "text",
            success: function(data)
            {
                $('select[name=id_pegawai]').html(data);
                $('select[name=bawahan]').html(data);
                $('.fg-pegawai').show();
                $('.fg-bawahan').show();       
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });    
    });
});

function add_bawahan()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    if (user_level_id > 1)
    {
        $('select[name=id_instansi]').val(instansi_id);
        $.ajax({
            url : "<?php echo site_url('pegawai/option_pegawai/')?>/" + instansi_id,
            type: "POST",
            data: {id_instansi:instansi_id,csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
            dataType: "text",
            success: function(data)
            {
                $('select[name=id_pegawai]').html(data);
                $('select[name=bawahan]').html(data);
                $('.fg-instansi').hide();
                $('.fg-pegawai').show();
                $('.fg-bawahan').show();       
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });      
    }
    $('input[name=csrf_test_name]').val('<?=$this->security->get_csrf_hash()?>');
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambah Bawahan'); // Set Title to Bootstrap modal title

}

function edit_bawahan(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('input[name=csrf_test_name]').val('<?=$this->security->get_csrf_hash()?>');

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('bawahan/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
         $('[name="id"]').val(data.id_bawahan);
         $('[name="tgl_entri"]').val(data.tgl_entri);
         $('[name="tgl_update"]').val(data.tgl_update);

         var id_instansi = data.id_instansi;
         $('select[name=id_instansi]').val(id_instansi);
         $('.fg-instansi').hide();
         $.ajax({
            url : "<?php echo site_url('pegawai/option_pegawai/')?>/" + id_instansi,
            type: "POST",
            data: {id_instansi:id_instansi,csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
            dataType: "text",
            success: function(data2)
            {
                $('select[name=id_pegawai]').html(data2);
                $('select[name=bawahan]').html(data2);

                $('[name="id_pegawai"]').val(data.id_pegawai);
                $('[name="bawahan"]').val(data.bawahan);

                $('.fg-pegawai').show();
                $('.fg-bawahan').show();       
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });    

            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Bawahan'); // Set title to Bootstrap modal title           
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function reload_bawahan_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function save()
{
    $('#btnSave').html('<i class="fa fa-plus"></i> Simpan...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('bawahan/ajax_add')?>";
    } else {
        url = "<?php echo site_url('bawahan/ajax_update')?>";
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
                reload_bawahan_table();
                if (save_method== 'add')
                {
				    $('#form')[0].reset(); // reset form on modals
				    $('.form-group').removeClass('has-error'); // clear error class
				    $('.help-block').empty(); // clear error string
				    $('.modal-title').text('Tambah Bawahan'); // Set Title to Bootstrap modal title 
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

function delete_bawahan(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('bawahan/ajax_delete')?>/"+id,
            type: "POST",
            data:{id:id, csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_bawahan_table();
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
                data: {id:list_id, csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
                url: "<?php echo site_url('bawahan/ajax_bulk_delete')?>",
                dataType: "JSON",
                success: function(data)
                {
                    if(data.status)
                    {
                        reload_bawahan_table();
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
                <h3 class="modal-title">Bawahan Form</h3>
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
                  <label class="control-label col-md-3" for="id_pegawai">Atasan</label>
                  <div class="col-md-9">
                     <select name="id_pegawai" id="id_pegawai" class="form-control"></select>
                     <span class="help-block"></span>
                 </div>
             </div>

             <div class="form-group fg-bawahan">
               <label class="control-label col-md-3" for="bawahan">Bawahan</label>
               <div class="col-md-9">	
                   <select name="bawahan" id="bawahan" class="form-control"></select>
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
