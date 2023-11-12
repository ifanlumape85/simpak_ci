<script type="text/javascript">

var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';
var id_instansi = '<?php echo $this->session->userdata('instansi_id'); ?>';
var user_level_id = '<?php echo $this->session->userdata('user_level_id'); ?>';
var id_pegawai = '<?php echo $id_pegawai; ?>';
var tgl_presensi = '<?php echo date('d-m-Y'); ?>';
var tgl_mulai,tgl_selesai,id_jenis_presensi;

$(document).ready(function() {

    $('#tgl_mulai,#tgl_selesai').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,  
    });

    $('[name=tgl_mulai]').val(tgl_presensi);
    $('[name=tgl_selesai]').val(tgl_presensi);
    $('select[name=id_jenis_presensi]').val(4);
    $('select[name=id_pegawai]').val(id_pegawai);

    $('.breadcrumb').html('<li><a href="'+base_url+'"><i class="fa fa-dashboard"></i> Beranda</a></li><li><a href="'+base_url+'">Dashboard</a></li><li class="active">Absensi</li>');

    setInterval(function(){
        dashboard();    
    }, 2000);

    $('#btn-filter').click(function(){ //button filter event click     
        dashboard();    
    });
});

function dashboard()
{
    var id_pegawai = $('select[name=id_pegawai]').val();
    var tgl_mulai = $('[name=tgl_mulai]').val();
    var tgl_selesai = $('[name=tgl_selesai]').val();
    var id_jenis_presensi = $('select[name=id_jenis_presensi]').val();

    var url = "<?php echo site_url('presensi/pegawai2/')?>";
    $.ajax({
        type: "POST",
        data:{id_pegawai:id_pegawai,tgl_mulai:tgl_mulai,tgl_selesai:tgl_selesai,id_jenis_presensi:id_jenis_presensi,csrf_test_name:'<?=$this->security->get_csrf_hash()?>'},
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

</script>