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
            type: "POST",
            data: {id_instansi:instansi_id, csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
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
    }
    $('#btn-filter').click(function(){ //button filter event click
        if (user_level_id > 1)
        {
            $('.fg-instansi2').hide();
            $('select[name=id_instansi2]').val(instansi_id);
        }
        reload_kegiatan_tahunan_table();  //just reload table
    });
    
    $('#btn-reset').click(function(){ //button reset event click
        $('#form-filter')[0].reset();

        reload_kegiatan_tahunan_table();  //just reload table
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
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });    
    });
});

function reload_kegiatan_tahunan_table()
{
    var id_instansi = $('select[name=id_instansi2]').val();
    var id_pegawai = $('select[name=id_pegawai2]').val();
    var tahun = $('[name=tahun2]').val();

    $.ajax({
        url : "<?php echo site_url('kegiatan_tahunan/laporan_kegiatan')?>/",
        data : {id_instansi:id_instansi,id_pegawai:id_pegawai,tahun:tahun,csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
        type: "POST",
        dataType: "text",
        success: function(data)
        {
            $('.tabel_laporan').html(data);
            // $('#table').DataTable();
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error : Data tidak ditemukan');
        }
    });
}


</script>