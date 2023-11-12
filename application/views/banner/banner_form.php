<script type="text/javascript">

var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';

$(document).ready(function() {

    //datatables
    table = $('#table').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('banner/ajax_list')?>",
            "type": "POST", "data":function(data){
                data.csrf_test_name = '<?=$this->security->get_csrf_hash()?>';
                data.id_banner = $('#id_banner').val();
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
        reload_banner_table();  //just reload table
    });
    $('#btn-reset').click(function(){ //button reset event click
        $('#form-filter')[0].reset();
        reload_banner_table();  //just reload table
    });

});

function add_banner()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    $('input[name=csrf_test_name]').val('<?=$this->security->get_csrf_hash()?>');
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambah Banner'); // Set Title to Bootstrap modal title

    $('#photo-preview').hide(); // hide photo preview modal
    $('#label-photo').text('Upload Photo'); // label photo upload
}

function edit_banner(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    $('input[name=csrf_test_name]').val('<?=$this->security->get_csrf_hash()?>');

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('banner/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
           $('[name="id"]').val(data.id_banner);
           $('[name="judul_banner"]').val(data.judul_banner);
           $('[name="tgl_input"]').val(data.tgl_input);
           $('[name="tgl_update"]').val(data.tgl_update);

            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Banner'); // Set title to Bootstrap modal title
            $('#photo-preview').show(); // show photo preview modal

            if(data.photo)
            {
                $('#label-photo').text('Ubah Photo'); // label photo upload
                $('#photo-preview div').html('<img src="'+base_url+'upload/banner/thumbs/'+data.photo+'" class="img-responsive">'); // show photo
                $('#photo-preview div').append('<input type="checkbox" name="remove_photo" value="'+data.photo+'"/> Hapus photo'); // remove photo
            }
            else
            {
                $('#label-photo').text('Upload Photo'); // label photo upload
                $('#photo-preview div').text('(No photo)');
            }           
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function reload_banner_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function save()
{
    $('#btnSave').html('<i class="fa fa-plus"></i> Simpan...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('banner/ajax_add')?>";
    } else {
        url = "<?php echo site_url('banner/ajax_update')?>";
    }

    // ajax adding data to database    
    var formData = new FormData($('#form')[0]);
    $.ajax({
        url : url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",        
        success: function(data)
        {
            if(data.status) //if success close modal and reload ajax table
            {
                reload_banner_table();
                if (save_method== 'add')
                {
				    $('#form')[0].reset(); // reset form on modals
				    $('.form-group').removeClass('has-error'); // clear error class
				    $('.help-block').empty(); // clear error string
				    $('.modal-title').text('Tambah Banner'); // Set Title to Bootstrap modal title 
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

function delete_banner(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('banner/ajax_delete')?>/"+id,
            type: "POST",
            data : {id:id, csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_banner_table();
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
                url: "<?php echo site_url('banner/ajax_bulk_delete')?>",
                dataType: "JSON",
                success: function(data)
                {
                    if(data.status)
                    {
                        reload_banner_table();
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
                <h3 class="modal-title">Banner Form</h3>
            </div>
            <div class="modal-body form">
                <?=form_open('#', array("id" => "form", "class" => "form-horizontal"))?>
                <input type="hidden" value="" name="id"/> 
                <div class="form-body">

                    <div class="form-group">
                     <label class="control-label col-md-3" for="judul_banner">Judul Banner</label>
                     <div class="col-md-9">
                        <input placeholder="Judul Banner" type="text" name="judul_banner" class="form-control" />		
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
        <button type="button" id="btnSave" onclick="save()" class="btn btn-sm btn-primary btn-flat"><i class="glyphicon glyphicon-ok"></i> Simpan</button>
        <button type="button" class="btn btn-danger btn-sm btn-flat" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Tutup</button>
    </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->	
