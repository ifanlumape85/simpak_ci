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
        $('.fg-instansi2').hide(); 
        $('select[name=id_instansi2]').val(instansi_id);
        $.ajax({
            url : "<?php echo site_url('pegawai/option_pegawai/')?>/" + instansi_id,
            type: "GET",
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
    }


    $('#btn-filter').click(function(){ //button filter event click
        if (user_level_id > 1)
        {
           $('select[name=id_instansi2]').val(instansi_id);
            $.ajax({
                url : "<?php echo site_url('pegawai/option_pegawai/')?>/" + instansi_id,
                type: "GET",
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
        }
        reload_kegiatan_bulanan_table();  //just reload table
    });
    $('#btn-reset').click(function(){ //button reset event click
        $('#form-filter')[0].reset();
        reload_kegiatan_bulanan_table();  //just reload table
    });

    
    $('select[name=id_instansi2]').change(function() {
        var id = $('select[name=id_instansi2]').val();

        $.ajax({
            url : "<?php echo site_url('pegawai/option_pegawai/')?>/" + id,
            type: "GET",
            dataType: "text",
            success: function(data)
            {
                $('select[name=id_pegawai2]').html(data);
                // $('.fg-pegawai2').show();       
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });    
    });

    $('select[name=id_pegawai2]').change(function() {
        // $('.fg-tahun2').show();  
    });

    $('[name=tahun2]').keyup(function(){
        
        var ltahun = $('[name=tahun2]').val().length;
        var tahun = $('[name=tahun2]').val();
        var id_pegawai = $('select[name=id_pegawai2]').val();

        if (ltahun > 2)
        {
            $.ajax({
                url : "<?php echo site_url('kegiatan_tahunan/option_kegiatan/')?>",
                type: "POST",
                data:{tahun:tahun,id_pegawai:id_pegawai},
                dataType: "text",
                success: function(data)
                {
                    $('select[name=id_kegiatan_tahunan2]').html(data);
                    // $('.fg-kegiatan2').show();       
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error get data from ajax');
                }
            });    
        }
    });

    $('select[name=id_instansi]').change(function() {
        var id = $('select[name=id_instansi]').val();

        $.ajax({
            url : "<?php echo site_url('pegawai/option_pegawai/')?>/" + id,
            type: "GET",
            dataType: "text",
            success: function(data)
            {
                $('select[name=id_pegawai]').html(data);
                // $('.fg-pegawai').show();       
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });    
    });

    $('select[name=id_pegawai]').change(function() {
        // $('.fg-tahun').show();  
    });

    $('[name=tahun]').keyup(function(){
        
        var ltahun = $('[name=tahun]').val().length;
        var tahun = $('[name=tahun]').val();
        var id_pegawai = $('select[name=id_pegawai]').val();

        if (ltahun > 2)
        {
            $.ajax({
                url : "<?php echo site_url('kegiatan_tahunan/option_kegiatan/')?>",
                type: "POST",
                data:{tahun:tahun,id_pegawai:id_pegawai},
                dataType: "text",
                success: function(data)
                {
                    $('select[name=id_kegiatan_tahunan]').html(data);
                    // $('.fg-kegiatan').show();       
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error get data from ajax');
                }
            });    
        }
    });
});




function reload_kegiatan_bulanan_table()
{
    var id_instansi = $('select[name=id_instansi2]').val();
    var id_pegawai = $('select[name=id_pegawai2]').val();
    var tahun = $('select[name=tahun2]').val();
    var id_kegiatan_tahunan = $('select[name=id_kegiatan_tahunan2]').val();
    $.ajax({
        url : "<?php echo site_url('kegiatan_bulanan/laporan_kegiatan')?>/",
        data : {id_instansi:id_instansi,id_pegawai:id_pegawai,tahun:tahun,id_kegiatan_tahunan:id_kegiatan_tahunan},
        type: "POST",
        dataType: "text",
        success: function(data)
        {
            $('.tabel_laporan').html(data);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data');
        }
    }); 
}
</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Kegiatan Bulanan Form</h3>
            </div>
            <div class="modal-body form">
                <?=form_open('#', array("id" => "form", "class" => "form-horizontal"))?>
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">

                <div class="form-group fg-instansi">
                        <label class="control-label col-md-3" for="id_kegiatan_tahunan">Instansi</label>
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

                <div class="form-group fg-tahun">
                        <label class="control-label col-md-3" for="tahun">Tahun</label>
                        <div class="col-md-9">
                            <input type="number" name="tahun" id="tahun" class="form-control">
                            <span class="help-block"></span>
                        </div>
                    </div>    

                 <div class="form-group fg-kegiatan">
                        <label class="control-label col-md-3" for="id_kegiatan_tahunan">Kegiatan Tahunan</label>
                        <div class="col-md-9">
                            <select name="id_kegiatan_tahunan" id="id_kegiatan_tahunan" class="form-control"></select>
                            <span class="help-block"></span>
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
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-save"></i> Simpan</button>
                <button type="button" class="btn btn-danger btn-sm btn-flat" data-dismiss="modal"><i class="fa fa-undo"></i> Tutup</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->	
		