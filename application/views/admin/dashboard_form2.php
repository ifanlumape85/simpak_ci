<script type="text/javascript">

var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';
var id_instansi = '<?php echo $id_instansi; ?>';
var user_level_id = '<?php echo $this->session->userdata('user_level_id'); ?>';
var tgl_presensi = '<?php echo date('d-m-Y'); ?>';

$(document).ready(function() {

     $('#tgl_presensi').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,  
    });

    $('select[name=id_instansi]').val(id_instansi);
    $('[name=tgl_presensi]').val(tgl_presensi);

    $('.breadcrumb').html('<li><a href="'+base_url+'"><i class="fa fa-dashboard"></i> Beranda</a></li><li><a href="#">Dashboard</a></li><li class="active">Absensi</li>');
    
    setInterval(function(){
        dashboard();    
    }, 2000);

    $('#btn-filter').click(function(){ //button filter event click
        $('.dashboardx').html('<div class="col-md-12"><div class="box box-danger"><div class="box-header"><h3 class="box-title">Load Data</h3></div><div class="box-body">Mengambil data</div><div class="overlay"><i class="fa fa-refresh fa-spin"></i></div></div></div>');
        dashboard();    
    });

    $('select[name=id_jenis_presensi]').change(function(e) {
        var id = $(this).val();
        if (id!="")
        {
          tampil_absen(id);  
        }
        
    });
    $('select[name=id_instansi]').val(id_instansi);
});

function dashboard()
{
    var tgl_presensi = $('[name=tgl_presensi]').val();
    var id_instansi = $('select[name=id_instansi]').val();
    var id_jenis_presensi = $('select[name=id_jenis_presensi]').val();
    var url = "<?php echo site_url('jenis_presensi/data_presensi/')?>";

    $.ajax({
        type: "POST",
        data: {id_jenis_presensi:id_jenis_presensi, id_instansi:id_instansi, tgl_presensi:tgl_presensi, csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
        url: url,
        dataType: "text",
        success: function(data)
        {
            $('.dashboardx').html(data);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error : pengambilan data');
        }
    });
}

function tampil_absen(id)
{
    var tgl_presensi = $('[name=tgl_presensi]').val();
    var id_instansi = $('select[name=id_instansi]').val();
    var id_jenis_presensi = $('select[name=id_jenis_presensi]').val();

    $('select[name=id_jenis_presensi]').val(id);
    $('.pegawai').html("");

    $.ajax({
        url : "<?php echo site_url('presensi/instansi/')?>/",
        type: "POST",
        data: {id_instansi:id_instansi, tgl_presensi:tgl_presensi, id_jenis_presensi:id_jenis_presensi, csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
        dataType: "text",
        success: function(data)
        {
        	$('.pegawai').html(data);           
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}
</script>