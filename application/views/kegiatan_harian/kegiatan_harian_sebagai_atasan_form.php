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
        visible = false;
    }
    //datatables
    table = $('#table').DataTable({ 
        "searching": false,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('kegiatan_harian/ajax_list2')?>",
            "type": "POST", "data":function(data){
                data.csrf_test_name = '<?=$this->security->get_csrf_hash()?>';
                data.id_pegawai = $('select[name=id_pegawai2').val();
                data.status = $('[name=status2]').val();
                data.tgl_mulai = $('[name=tgl_mulai2]').val();
                data.tgl_selesai = $('[name=tgl_akhir2]').val();
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
            "targets": [ 4 ], //first column
            "orderable": false, //set not orderable
        },
        { 
            "targets": [ 5 ], //last column
            "orderable": false, //set not orderable
        },
        { 
            "targets": [ 7 ], //last column
            "orderable": false, //set not orderable
        },
        { 
            "targets": [ 8 ], //last column
            "visible": false, //set not orderable
        },
        { 
            "targets": [ 9 ], //last column
            "orderable": false, //set not orderable
        }
        ],

    });

    $('#tgl_mulai2, #tgl_akhir2').datepicker({
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
        reload_kegiatan_harian_table();  //just reload table
    });

    $('.fg-pegawai').hide();
    $('.fg-verifikator').hide();
     
    $('select[name=id_instansi2]').val(instansi_id);
    $('.fg-instansi2').hide();  

    $.ajax({
        url : "<?php echo site_url('verifikator/option_pegawai/')?>",
        type: "POST",
        data: {id_verifikator:pegawai_id,csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
        dataType: "text",
        success: function(data)
        {
            $('select[name=id_pegawai2]').html(data);       
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get bawahan');
        }
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
                alert('Error get instansi from ajax');
            }
        });    
    });

});

function edit_kegiatan_harian(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.pesan').html("");

    $('select[name=id_pegawai]').attr('readonly', 'true');
    $('select[name=id_instansi]').attr('readonly', 'true');
    $('[name=tgl_kegiatan]').attr('readonly', 'true');
    $('select[name=tgl_kegiatan]').removeAttr('id');
    $('[name=kegiatan]').attr('readonly', 'true');
    $('[name=kuantitas]').attr('readonly', 'true');
    $('select[name=id_jenis_kuantitas]').attr('readonly', 'true');
    $('[name=jam_mulai]').attr('readonly', 'true');
    $('[name=jam_mulai]').removeAttr('id');
    $('[name=jam_selesai]').attr('readonly', 'true');
    $('[name=jam_selesai]').removeAttr('id');

    $('.fg-pegawai').show();
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('input[name=csrf_test_name]').val('<?=$this->security->get_csrf_hash()?>');

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('kegiatan_harian/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="id"]').val(data.id_kegiatan_harian);
            $('[name="id_kegiatan_bulanan"]').val(data.id_kegiatan_bulanan);
            $('[name="tgl_kegiatan"]').val(data.tgl_kegiatan);
            $('[name="kegiatan"]').val(data.kegiatan);
            $('[name="kuantitas"]').val(data.kuantitas);
            $('[name="id_jenis_kuantitas"]').val(data.id_jenis_kuantitas);
            $('[name="jam_mulai"]').val(data.jam_mulai);
            $('[name="jam_selesai"]').val(data.jam_selesai);
            $('input[name=revisi][value='+data.revisi+']').prop('checked', 'checked'); 
            $('input[name=status][value='+data.status+']').prop('checked', 'checked'); 
            $('input[name=kunci][value='+data.kunci+']').prop('checked', 'checked');    

            var id_instansi = data.id_instansi;
            
            $('select[name=id_instansi]').val(id_instansi);
            
            $.ajax({
                url : "<?php echo site_url('pegawai/option_pegawai/')?>/" + id_instansi,
                type: "POST",
                data: {id_instansi:id_instansi,csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
                dataType: "text",
                success: function(data2)
                {
                    $('select[name=id_pegawai]').html(data2);
                    $('select[name=id_verifikator]').html(data2); 

                    if (user_level_id==5)
                    {
                        $('.fg-pegawai').hide();
                    }

                    $('select[name=id_pegawai]').val(data.id_pegawai);
                    $('select[name=id_verifikator]').val(data.id_verifikator)
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    // alert('Error get data from ajax');
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




</script>

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
                
                <div class="form-group tgl_kegiatan fg-tgl_kegiatan">
                    <label class="control-label col-md-3" for="tgl_kegiatan">Tgl Kegiatan</label>
                    <div class="col-md-9">  
                    <input placeholder="<?php echo date('d-m-Y'); ?>" type="text" name="tgl_kegiatan" class="form-control" />
                    <span class="help-block"></span>
                    </div>
                </div>
                
                <div class="form-group fg-kegiatan">
                    <label class="control-label col-md-3" for="kegiatan">Kegiatan</label>
                    <div class="col-md-9">
                    <textarea class="form-control" name="kegiatan" id="kegiatan"><?php echo set_value('kegiatan', isset($default['kegiatan']) ? $default['kegiatan'] : ''); ?></textarea>
                    <span class="help-block"></span>
                    </div>
                </div>
                
                <div class="form-group fg-kuantitas">
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
        
                <div class="bootstrap-timepicker fg-jam_mulai">
                    <div class="form-group">
                        <label class="control-label col-md-3" for="jam_mulai">Jam Mulai</label>
                        <div class="col-md-9">
                        <input placeholder="<?php echo date('H:i:s'); ?>"  type="text" name="jam_mulai" class="form-control timepicker" />
                        <span class="help-block"></span>
                        </div>
                    </div>
                </div>
                
                <div class="bootstrap-timepicker fg-jam_selesai">
                    <div class="form-group">
                        <label class="control-label col-md-3" for="jam_selesai">Jam Selesai</label>
                        <div class="col-md-9">
                        <input placeholder="<?php echo date('H:i:s'); ?>"  type="text" name="jam_selesai" class="form-control timepicker" />
                        <span class="help-block"></span>
                        </div>
                    </div>
                </div>

                <div class="form-group fg-revisi">
                    <label class="control-label col-md-3" for="kegiatan">Revisi</label>
                    <div class="col-md-9">
                    <input type="radio" name="revisi" id="revisi" value="0"> N
                    <input type="radio" name="revisi" id="revisi" value="1"> Y
                    </div>
                </div>

                <div class="form-group fg-status">
                    <label class="control-label col-md-3" for="status">Status</label>
                    <div class="col-md-9">
                    <input type="radio" name="status" id="status" value="0"> Menunggu
                    <input type="radio" name="status" id="status" value="1"> Disetujui
                    <input type="radio" name="status" id="status" value="2"> Ditolak
                    </div>
                </div>

                <div class="form-group fg-kunci">
                    <label class="control-label col-md-3" for="kunci">Kunci</label>
                    <div class="col-md-9">
                    <input type="radio" name="kunci" id="status" value="0"> N
                    <input type="radio" name="kunci" id="status" value="1"> Y
                    </div>
                </div>

                
                <div class="form-group fg-keterangan">
                    <label class="control-label col-md-3" for="keterangan">Keterangan</label>
                    <div class="col-md-9">
                    <textarea class="form-control" name="keterangan" id="keterangan"></textarea>
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
        