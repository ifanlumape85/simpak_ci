<script type="text/javascript">

var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';
var user_level_id = '<?php echo $this->session->userdata('user_level_id'); ?>';
var pegawai_id = '<?php echo $this->session->userdata('pegawai_id'); ?>';
var instansi_id = '<?php echo $this->session->userdata('instansi_id'); ?>';
var tgl_sekarang = '<?php echo date('d-m-Y'); ?>';
var visible = true;
$(document).ready(function() {

    if (user_level_id > 1)
    {
        //visible = false;
    }
    //datatables
    table = $('#table').DataTable({ 
        "searching": false,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('kegiatan_harian/ajax_list3')?>",
            "type": "POST", "data":function(data){
                data.csrf_test_name = '<?=$this->security->get_csrf_hash()?>';
                data.tgl_selesai = $('[name=tgl_selesai2]').val();
                data.tgl_mulai = $('[name=tgl_mulai2]').val();
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
            "visible": visible, //set not orderable
        },
        { 
            "targets": [ 2 ], //first column
            "visible": visible, //set not orderable
        },
        { 
            "targets": [ 3 ], //first column
            "visible": visible, //set not orderable
        },
        { 
            "targets": [ 4 ], //first column
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
            "visible":false,
        },         
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
        },
        ],

    });

    $('#tgl_mulai2,#tgl_selesai2').datepicker({
      autoclose: true,
      format: "dd-mm-yyyy"
    });

    $(".timepicker").timepicker({
      showInputs: false
    });

    $(".timepicker2").timepicker({
      showInputs: false
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
        reload_kegiatan_harian_table();  //just reload table
    });
    
    $('#btn-reset').click(function(){ //button reset event click
        $('#form-filter')[0].reset();
        $('.fg-pegawai2').hide();
        reload_kegiatan_harian_table();  //just reload table
    });

    //$('select[name=id_instansi]').attr('readonly', true);
    //$('select[name=id_pegawai]').attr('readonly', true);
    //$('select[name=id_verifikator]').attr('readonly', true);
});

function add_kegiatan_harian()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.no_photo').hide();
    $('.upload_file').hide();
    $('.pesan').html("");
    
    // $('.fg-instansi').hide();
    $('[name=id_instansi]').val(instansi_id);
    $('[name=tgl_kegiatan]').val(tgl_sekarang);
    // $('.tgl_kegiatan').hide();
    
    $.ajax({
        url : "<?php echo site_url('pegawai/option_pegawai/')?>/" + instansi_id,
        type: "POST",
        data: {id_instansi:instansi_id, id_pegawai:pegawai_id, csrf_test_name: '<?=$this->security->get_csrf_hash()?>'},
        dataType: "text",
        success: function(data)
        {
            $('select[name=id_pegawai]').html(data);
            
            $('select[name=id_pegawai]').val(pegawai_id);
            // $('.fg-pegawai').hide();
            
            $.ajax({
                url : "<?php echo site_url('verifikator/option_verifikator2/')?>",
                type: "POST",
                data: {id_pegawai:pegawai_id, csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
                dataType: "text",
                success: function(data2)
                {
                    $('select[name=id_verifikator]').html(data2);       
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error get option verifikator from ajax');
                }
            });


            $.ajax({
                url : "<?php echo site_url('verifikator/get_verifikator/')?>",
                type: "POST",
                data: {id:pegawai_id, csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
                dataType: "json",
                success: function(data3)
                {
                    $('select[name=id_verifikator]').val(data3.id_verifikator);       
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error get verifikator from ajax');
                }
            });
            
                   
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });

    $.ajax({
        url : "<?php echo site_url('presensi/cek_presensi_ajax/')?>",
        type: "POST",
        data: {id_pegawai:pegawai_id, csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
        dataType: "json",
        success: function(data)
        {
            if (data.exists)
            {
                $('#btnSave').attr('disabled',false); //set button disable 
            }
            else
            {
                $('.pesan').html("Anda belum absensi hari ini.");
                $('#btnSave').attr('disabled',true); //set button disable 
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error cek presensi');
        }
    });   
    // $('.fg-pegawai').show();
    

    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('input[name=csrf_test_name]').val('<?=$this->security->get_csrf_hash()?>');
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambah Kegiatan Harian'); // Set Title to Bootstrap modal title

    $('#photo-preview').hide(); // hide photo preview modal
    $('#label-photo').text('Upload Photo'); // label photo upload
}

function edit_kegiatan_harian(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.pesan').html("");
    $('#btnSave').attr('disabled',false);
    $('.fg-pegawai').show();
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('kegiatan_harian/ajax_edit/')?>/" + id,
        type: "POST",
        data: {id:id, csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
        dataType: "JSON",
        success: function(data)
        {
			$('[name="id"]').val(data.id_kegiatan_harian);
			$('[name="tgl_kegiatan"]').val(data.tgl_kegiatan);
			$('[name="kegiatan"]').val(data.kegiatan);
			$('[name="kuantitas"]').val(data.kuantitas);
			$('[name="id_jenis_kuantitas"]').val(data.id_jenis_kuantitas);
			$('[name="jam_mulai"]').val(data.jam_mulai);
			$('[name="jam_selesai"]').val(data.jam_selesai);

            var id_instansi = data.id_instansi;
            var id_pegawai = data.id_pegawai;
            var id_verifikator = data.id_verifikator;

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

            $.ajax({
                url : "<?php echo site_url('verifikator/option_verifikator2/')?>",
                type: "POST",
                data: {id_pegawai:id_pegawai, csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
                dataType: "text",
                success: function(data3)
                {
                    $('select[name=id_verifikator]').html(data3);
                    $('select[name=id_verifikator]').val(id_verifikator);
                    $('.fg-verifikator').show();       
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error get option verifikator from ajax');
                }
            });

            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Kegiatan Harian'); // Set title to Bootstrap modal title
            $('#photo-preview').show(); // show photo preview modal
			
			if(data.photo)
            {
                $('#label-photo').text('Ubah Photo'); // label photo upload
                $('#photo-preview div').html('<img src="'+base_url+'upload/kegiatan_harian/thumbs/'+data.photo+'" class="img-responsive">'); // show photo
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

function reload_kegiatan_harian_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function save()
{
    $('#btnSave').html('<i class="fa fa-save"></i> Simpan...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('kegiatan_harian/ajax_add')?>";
    } else {
        url = "<?php echo site_url('kegiatan_harian/ajax_update')?>";
    }

    // ajax adding data to database    
    var formData = new FormData($('#form')[0]);
    formData.append("csrf_test_name", '<?=$this->security->get_csrf_hash()?>');

    for (var pair of formData.entries()) {
        console.log(pair[0]+ ', ' + pair[1]); 
    }

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
                reload_kegiatan_harian_table();
                if (save_method== 'add')
                {
				    $('#form')[0].reset(); // reset form on modals
				    $('.form-group').removeClass('has-error'); // clear error class
				    $('.help-block').empty(); // clear error string
				    $('.modal-title').text('Tambah Kegiatan Harian'); // Set Title to Bootstrap modal title 
				}
				else
				{
					$('#modal_form').modal('hide');
				}                
            }
            else
            {
                if (data.code=="2")
                {
                    $('#modal_form').modal('hide');
                }
                else
                {
                    for (var i = 0; i < data.inputerror.length; i++) 
                    {
                        $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                        $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                    }    
                }
            }
            $('#btnSave').html('<i class="fa fa-save"></i> Simpan'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').html('<i class="fa fa-save"></i> Simpan'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
        }
    });
}

function delete_kegiatan_harian(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('kegiatan_harian/ajax_delete')?>/"+id,
            type: "POST",
            data: {id:id,csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_kegiatan_harian_table();
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
                url: "<?php echo site_url('kegiatan_harian/ajax_bulk_delete')?>",
                dataType: "JSON",
                success: function(data)
                {
                    if(data.status)
                    {
                        reload_kegiatan_harian_table();
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
                <h3 class="modal-title">Kegiatan Harian Form</h3>
            </div>
            <div class="modal-body form">
                <code class="pesan"></code>
                <?=form_open('#', array("id" => "form", "class" => "form-horizontal"))?>
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">

                <div class="form-group fg-instansi">
                        <label class="control-label col-md-3" for="id_kegiatan_bulanan">Instansi</label>
                        <div class="col-md-9">
                            <?php echo $form_instansi; ?>
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

				<div class="form-group fg-verifikator">
						<label class="control-label col-md-3" for="id_verifikator">Atasan Langsung</label>
						<div class="col-md-9">
							<select name="id_verifikator" id="id_verifikator" class="form-control"></select>
							<span class="help-block"></span>
						</div>
				</div>
				
				<div class="form-group tgl_kegiatan">
					<label class="control-label col-md-3" for="tgl_kegiatan">Tgl Kegiatan</label>
					<div class="col-md-9">	
					<input placeholder="<?php echo date('d-m-Y'); ?>" type="text" name="tgl_kegiatan" class="form-control" id="datepicker" />
					<span class="help-block"></span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3" for="kegiatan">Kegiatan</label>
					<div class="col-md-9">
					<textarea class="form-control" name="kegiatan" id="kegiatan"><?php echo set_value('kegiatan', isset($default['kegiatan']) ? $default['kegiatan'] : ''); ?></textarea>
					<span class="help-block"></span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3" for="kuantitas">Kuantitas</label>
					<div class="col-md-3">	
					<input placeholder="1" type="number" name="kuantitas" class="form-control" />
					<span class="help-block"></span>
					</div>
                    <div class="col-md-6">
                            <?php echo $form_jenis_kuantitas; ?>
                            <span class="help-block"></span>
                        </div>
				</div>
		
				<div class="bootstrap-timepicker">
    				<div class="form-group">
    					<label class="control-label col-md-3" for="jam_mulai">Jam Mulai</label>
    					<div class="col-md-9">
        				<input placeholder="<?php echo date('H:i:s'); ?>"  type="text" name="jam_mulai" class="form-control timepicker" />
    					<span class="help-block"></span>
    					</div>
    				</div>
                </div>
				
                <div class="bootstrap-timepicker">
    				<div class="form-group">
    					<label class="control-label col-md-3" for="jam_selesai">Jam Selesai</label>
    					<div class="col-md-9">
        				<input placeholder="<?php echo date('H:i:s'); ?>"  type="text" name="jam_selesai" class="form-control timepicker" />
    					<span class="help-block"></span>
    					</div>
    				</div>
                </div>
				
				<!-- <div class="form-group fg-no-photo no_photo" id="photo-preview">
                    <label class="control-label col-md-3">Photo</label>
                    <div class="col-md-9">
                        (No photo)
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group fg-upload-file upload_file">
                    <label class="control-label col-md-3" id="label-photo">Upload File</label>
                    <div class="col-md-9">
                        <input name="photo" type="file">
                        <span class="help-block"></span>
                     </div>
                </div> -->
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
		