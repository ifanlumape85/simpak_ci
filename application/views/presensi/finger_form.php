<script type="text/javascript">

var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';

$(document).ready(function() {
    
    $('#btn-filter').click(function(){ //button filter event click
        reload_presensi_table();  //just reload table
    });

    $('#btn-reset').click(function(){ //button reset event click
        $('#form-filter')[0].reset();
        reload_presensi_table();  //just reload table
    });

    $('.list_absensi_mesin').hide();
});

function reload_presensi_table()
{
    var id_mesin_absensi = $('#id_mesin_absensi2').val();
    var tgl_absensi = '<?php echo date('Y-m-d'); ?>';

    $.ajax({        
        url : base_url+'presensi/list_absensi_mesin',
        type: "POST",
        data: {id_mesin_absensi:id_mesin_absensi,tgl_absensi:tgl_absensi,csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
        dataType: "text",  
        beforeSend: function(){
            $('.list_absensi_mesin').show();
        },   
        success: function(data)
        {
            $('.list_absensi_mesin').html(data);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Data absensi gagal diambil.');
        }
    });
}


</script>

