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
            "url": "<?php echo site_url('pengaturan_presensi/ajax_list')?>",
            "type": "POST", "data":function(data){
                data.csrf_test_name = '<?=$this->security->get_csrf_hash()?>';
    			data.id_jenis_presensi = $('select[name=id_jenis_presensi2]').val();
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
        reload_pengaturan_presensi_table();  //just reload table
    });
    $('#btn-reset').click(function(){ //button reset event click
        $('#form-filter')[0].reset();
        reload_pengaturan_presensi_table();  //just reload table
    });

});

function add_pengaturan_presensi()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('input[name=cek_perangkat][value="Y"]').prop('checked', 'checked');
    $('input[name=cek_lokasi][value="N"]').prop('checked', 'checked');
    $('input[name=ikut_jadwal][value="N"]').prop('checked', 'checked');
    $('input[name=csrf_test_name]').val('<?=$this->security->get_csrf_hash()?>');
    $('input[name=penyesuaian_instansi][value="N"]').prop('checked', 'checked');
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambah Pengaturan Presensi'); // Set Title to Bootstrap modal title

}

function edit_pengaturan_presensi(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('input[name=csrf_test_name]').val('<?=$this->security->get_csrf_hash()?>');

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('pengaturan_presensi/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
			$('[name="id"]').val(data.id_pengaturan_presensi);
			$('[name="id_jenis_presensi"]').val(data.id_jenis_presensi);
			$('[name="mulai"]').val(data.mulai);
			$('[name="akhir"]').val(data.akhir);
			// $('[name="cek_perangkat"]').val(data.cek_perangkat);
			// $('[name="cek_lokasi"]').val(data.cek_lokasi);
            $('input[name=cek_perangkat][value='+data.cek_perangkat+']').prop('checked', 'checked');
            $('input[name=cek_lokasi][value='+data.cek_lokasi+']').prop('checked', 'checked');
            $('input[name=ikut_jadwal][value='+data.ikut_jadwal+']').prop('checked', 'checked');
            $('input[name=penyesuaian_instansi][value='+data.penyesuaian_instansi+']').prop('checked', 'checked');
			$('[name="longitude"]').val(data.longitude);
			$('[name="latitude"]').val(data.latitude);
            
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Pengaturan Presensi'); // Set title to Bootstrap modal title           
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function reload_pengaturan_presensi_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function save()
{
    $('#btnSave').html('<i class="glyphicon glyphicon-ok"></i> Simpan...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('pengaturan_presensi/ajax_add')?>";
    } else {
        url = "<?php echo site_url('pengaturan_presensi/ajax_update')?>";
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
                reload_pengaturan_presensi_table();
                if (save_method== 'add')
                {
				    $('#form')[0].reset(); // reset form on modals
				    $('.form-group').removeClass('has-error'); // clear error class
				    $('.help-block').empty(); // clear error string
				    $('.modal-title').text('Tambah Pengaturan Presensi'); // Set Title to Bootstrap modal title 
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
            $('#btnSave').html('<i class="glyphicon glyphicon-ok"></i> Simpan'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').html('<i class="glyphicon glyphicon-ok"></i> Simpan'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
        }
    });
}

function delete_pengaturan_presensi(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('pengaturan_presensi/ajax_delete')?>/"+id,
            type: "POST",
            data: {id:id, csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_pengaturan_presensi_table();
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
                url: "<?php echo site_url('pengaturan_presensi/ajax_bulk_delete')?>",
                dataType: "JSON",
                success: function(data)
                {
                    if(data.status)
                    {
                        reload_pengaturan_presensi_table();
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
                <h3 class="modal-title">Pengaturan Presensi Form</h3>
            </div>
            <div class="modal-body form">
                <?=form_open('#', array('id' => 'form', 'class' => 'form-horizontal'))?>
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">

				<div class="form-group">
						<label class="control-label col-md-3" for="id_jenis_presensi">Jenis Presensi </label>
						<div class="col-md-9">
							<?php echo $form_jenis_presensi; ?>
							<span class="help-block"></span>
						</div>
					</div>
				
				<div class="form-group">
					<label class="control-label col-md-3" for="mulai">Mulai</label>
					<div class="col-md-9">
    				<input placeholder="HH:ii:ss"  type="text" name="mulai" class="form-control" />
					<span class="help-block"></span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3" for="akhir">Akhir</label>
					<div class="col-md-9">
    				<input placeholder="HH:ii:ss"  type="text" name="akhir" class="form-control" />
					<span class="help-block"></span>
					</div>
				</div>
				
                <div class="form-group fg-aktif" id="aktif">
                    <label class="control-label col-md-3" for="ikut_jadwal">Ikut Jadwal?</label>
                    <div class="col-md-9">
                        <label class="radio-inline">
                            <input type="radio" name="ikut_jadwal" id="ikut_jadwal" value="Y"> Ya
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="ikut_jadwal" id="ikut_jadwal" value="N"> Tidak
                        </label>
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group fg-aktif" id="aktif">
                    <label class="control-label col-md-3" for="penyesuaian_instansi">Penyesuaian Instansi?</label>
                    <div class="col-md-9">
                        <label class="radio-inline">
                            <input type="radio" name="penyesuaian_instansi" id="penyesuaian_instansi" value="Y"> Ya
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="penyesuaian_instansi" id="penyesuaian_instansi" value="N"> Tidak
                        </label>
                        <span class="help-block"></span>
                    </div>
                </div>

				<div class="form-group fg-aktif" id="aktif">
                    <label class="control-label col-md-3" for="cek_perangkat">Cek Perangkat?</label>
                    <div class="col-md-9">
                        <label class="radio-inline">
                            <input type="radio" name="cek_perangkat" id="cek_perangkat" value="Y"> Ya
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="cek_perangkat" id="cek_perangkat" value="N"> Tidak
                        </label>
                        <span class="help-block"></span>
                    </div>
                </div>
				
				<div class="form-group fg-aktif" id="aktif">
                    <label class="control-label col-md-3" for="cek_lokasi">Cek Lokasi?</label>
                    <div class="col-md-9">
                        <label class="radio-inline">
                            <input type="radio" name="cek_lokasi" id="cek_lokasi" value="Y"> Ya
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="cek_lokasi" id="cek_lokasi" value="N"> Tidak
                        </label>
                        <span class="help-block"></span>
                    </div>
                </div>
				
				<div class="form-group">
					<label class="control-label col-md-3" for="longitude">Longitude</label>
					<div class="col-md-9">
    				<input placeholder="Longitude" type="text" name="longitude" class="form-control" />		
					<span class="help-block"></span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3" for="latitude">Latitude</label>
					<div class="col-md-9">
    				<input placeholder="Latitude" type="text" name="latitude" class="form-control" />		
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
		