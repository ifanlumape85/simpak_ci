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
            "url": "<?php echo site_url('kegiatan_tahunan/ajax_list')?>",
            "type": "POST", "data":function(data){
                data.csrf_test_name = '<?=$this->security->get_csrf_hash()?>';
                data.id_instansi = $('select[name=id_instansi2]').val();
                data.id_pegawai = $('select[name=id_pegawai2').val();
                data.tahun = $('[name=tahun2').val();
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
        reload_kegiatan_tahunan_table();  //just reload table
    });
    $('#btn-reset').click(function(){ //button reset event click
        $('#form-filter')[0].reset();
        $('.fg-pegawai2').hide();
        $('.fg-tahun2').hide();
    
        reload_kegiatan_tahunan_table();  //just reload table
    });

    $('.fg-pegawai').hide();
    $('.fg-tahun').hide();

    $('.fg-pegawai2').hide();
    $('.fg-tahun2').hide();
    
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

    $('select[name=id_pegawai]').change(function() {
        $('.fg-tahun').show();  
    });

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

    $('select[name=id_pegawai2]').change(function() {
        $('.fg-tahun2').show();  
    });
});

function add_kegiatan_tahunan()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    if (user_level_id > 1)
    {
        $('.fg-instansi').hide();
        $('[name=id_instansi]').val(instansi_id);
        $.ajax({
            url : "<?php echo site_url('pegawai/option_pegawai/')?>/" + instansi_id,
            type: "POST",
            data: {id_instansi:instansi_id,csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
            dataType: "text",
            success: function(data)
            {
                $('select[name=id_pegawai]').html(data);
                if (user_level_id==5)
                {
                    $('select[name=id_pegawai]').val(pegawai_id);
                    $('.fg-pegawai').hide(); 
                }
                else
                {
                    $('.fg-pegawai').show(); 
                }
                // $('.fg-pegawai').show();       
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });   
        // $('.fg-pegawai').show();
    }

    
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('input[name=csrf_test_name]').val('<?=$this->security->get_csrf_hash()?>');
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambah Kegiatan Tahunan'); // Set Title to Bootstrap modal title
}

function add_kegiatan_bulanan(id)
{
    save_method = 'add';
    $('#form_bulananan')[0].reset(); // reset form on modals
    
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    $('input[name=csrf_test_name]').val('<?=$this->security->get_csrf_hash()?>');
    $.ajax({
        url : "<?php echo site_url('kegiatan_tahunan/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name=id_kegiatan_tahunan]').val(id);
            $('#nama_pegawai').val(data.nama_pegawai);
            $('#tahun').val(data.tahun);
            $('#detail_kegiatan').val(data.kegiatan);
            $('#target_kuantitas').val(data.target_kuantitas+' '+data.nama_jenis_kuantitas);
            $('#target_penyelesaian').val(data.target_penyelesaian+' Bulan');
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });

    $('#modal_bulanan').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambah Kegiatan Bulanan'); // Set Title to Bootstrap modal title
}

function edit_kegiatan_tahunan(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    if (user_level_id > 1)
    {
        $('.fg-instansi').hide();
        $('[name=id_instansi]').val(instansi_id);
        $.ajax({
            url : "<?php echo site_url('pegawai/option_pegawai/')?>/" + instansi_id,
            type: "POST",
            data: {id_instansi:instansi_id,csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
            dataType: "text",
            success: function(data)
            {
                $('select[name=id_pegawai]').html(data);
                if (user_level_id==5)
                {
                    $('.fg-pegawai').hide(); 
                }
                else
                {
                    $('.fg-pegawai').show(); 
                }       
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });   
        // $('.fg-pegawai').show();
    }
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('kegiatan_tahunan/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
			$('[name="id"]').val(data.id_kegiatan_tahunan);
			$('[name="id_pegawai"]').val(data.id_pegawai);
			$('[name="tahun"]').val(data.tahun);
			$('[name="kegiatan"]').val(data.kegiatan);
			$('[name="target_kuantitas"]').val(data.target_kuantitas);
			$('[name="id_jenis_kuantitas"]').val(data.id_jenis_kuantitas);
			$('[name="target_penyelesaian"]').val(data.target_penyelesaian);
			$('[name="tgl_input"]').val(data.tgl_input);
			$('[name="tgl_update"]').val(data.tgl_update);
            
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Kegiatan Tahunan'); // Set title to Bootstrap modal title           
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function reload_kegiatan_tahunan_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function save_kegiatan_bulanan()
{
    $('#btnSaveBulanan').html('<i class="fa fa-save"></i> Simpan...'); //change button text
    $('#btnSaveBulanan').attr('disabled',true); //set button disable 
    var url = "<?php echo site_url('kegiatan_bulanan/ajax_add')?>";

    // ajax adding data to database
    $.ajax({        
        url : url,
        type: "POST",
        data: $('#form_bulananan').serialize(),
        dataType: "JSON",        
        success: function(data)
        {
            if(data.status) //if success close modal and reload ajax table
            {
                var id = $('[name=id_kegiatan_tahunan]').val();

                $('#form_bulananan')[0].reset(); // reset form on modals
                $('.form-group').removeClass('has-error'); // clear error class
                $('.help-block').empty(); // clear error string
                $('.modal-title').text('Tambah Kegiatan Bulanan'); // Set Title to Bootstrap modal title                

                $.ajax({
                    url : "<?php echo site_url('kegiatan_tahunan/ajax_edit/')?>/" + id,
                    type: "POST",
                    data: {id_kegiatan_tahunan:id, csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
                    dataType: "JSON",
                    success: function(data)
                    {
                        $('[name=id_kegiatan_tahunan]').val(id);
                        $('#nama_pegawai').val(data.nama_pegawai);
                        $('#tahun').val(data.tahun);
                        $('#detail_kegiatan').val(data.kegiatan);
                        $('#target_kuantitas').val(data.target_kuantitas+' '+data.nama_jenis_kuantitas);
                        $('#target_penyelesaian').val(data.target_penyelesaian+' Bulan');

                        alert('Data berhasil disimpan');
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error get data from ajax');
                    }
                });
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSaveBulanan').html('<i class="fa fa-plus"></i> Simpan'); //change button text
            $('#btnSaveBulanan').attr('disabled',false); //set button enable 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSaveBulanan').html('<i class="fa fa-save"></i> Simpan'); //change button text
            $('#btnSaveBulanan').attr('disabled',false); //set button enable 
        }
    });
}

function save()
{
    $('#btnSave').html('<i class="fa fa-plus"></i> Simpan...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('kegiatan_tahunan/ajax_add')?>";
    } else {
        url = "<?php echo site_url('kegiatan_tahunan/ajax_update')?>";
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
                reload_kegiatan_tahunan_table();
                if (save_method== 'add')
                {
				    $('#form')[0].reset(); // reset form on modals
				    $('.form-group').removeClass('has-error'); // clear error class
				    $('.help-block').empty(); // clear error string
				    $('.modal-title').text('Tambah Kegiatan Tahunan'); // Set Title to Bootstrap modal title 
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

function delete_kegiatan_tahunan(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('kegiatan_tahunan/ajax_delete')?>/"+id,
            type: "POST",
            data: {id:id, csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_kegiatan_tahunan_table();
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
                url: "<?php echo site_url('kegiatan_tahunan/ajax_bulk_delete')?>",
                dataType: "JSON",
                success: function(data)
                {
                    if(data.status)
                    {
                        reload_kegiatan_tahunan_table();
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
                <h3 class="modal-title">Kegiatan Tahunan Form</h3>
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
							<select name="id_pegawai" id="id_pegawai" class="form-control"></select>
							<span class="help-block"></span>
						</div>
					</div>
				
				<div class="form-group">
					<label class="control-label col-md-3" for="tahun">Tahun</label>
					<div class="col-md-9">	
					<input placeholder="<?php echo date('Y'); ?>" type="number" name="tahun" class="form-control" />
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
					<label class="control-label col-md-3" for="target_kuantitas">Target Kuantitas</label>
					<div class="col-md-3">	
					<input placeholder="1" type="number" name="target_kuantitas" class="form-control" />
					<span class="help-block"></span>
					</div>
                    <div class="col-md-6">
                            <?php echo $form_jenis_kuantitas; ?>
                            <span class="help-block"></span>
                        </div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3" for="target_penyelesaian">Target Penyelesaian</label>
					<div class="col-md-3">	
					<input placeholder="1" type="number" name="target_penyelesaian" class="form-control" />
					<span class="help-block"></span>
					</div>
                    <div class="col-md-6">
                        Bulan
                    </div>
				</div>
				
</div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-save"></i> Simpan</button>
                <button type="button" class="btn btn-danger btn-sm btn-flat" data-dismiss="modal"><i class="fa fa-undo"></i> Tutup</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->	

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_bulanan" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Kegiatan Bulanan Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_bulananan" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <input type="hidden" name="id_kegiatan_tahunan" id="id_kegiatan_tahunan">
                    <div class="form-body">

                <div class="form-group">
                    <label class="control-label col-md-3" for="pegawai">Pegawai</label>
                    <div class="col-md-9 detail_pegawai">  
                        <input type="text" id="nama_pegawai" class="form-control" disabled="disabled">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3" for="tahun">Tahun</label>
                    <div class="col-md-9 detail_tahun"> 
                    <input type="text" id="tahun" class="form-control" disabled="disabled"> 
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3" for="kegiatan">Kegiatan</label>
                    <div class="col-md-9 detail_kegiatan">  
                        <input type="text" id="detail_kegiatan" class="form-control" disabled="disabled">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3" for="target">Target Kuantias</label>
                    <div class="col-md-9 detail_kuantitas">  
                        <input type="text" id="target_kuantitas" class="form-control" disabled="disabled">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3" for="target">Target Penyelesaian</label>
                    <div class="col-md-9 detail_penyelesaian">  
                        <input type="text" id="target_penyelesaian" class="form-control" disabled="disabled">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3" for="bulan">Bulan</label>
                    <div class="col-md-9">  
                    <select name="bulan" class="form-control" id="bulan">
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
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
</div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSaveBulanan" onclick="save_kegiatan_bulanan()" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-save"></i> Simpan</button>
                <button type="button" class="btn btn-danger btn-sm btn-flat" data-dismiss="modal"><i class="fa fa-undo"></i> Tutup</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->    
