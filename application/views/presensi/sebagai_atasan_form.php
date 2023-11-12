<script type="text/javascript">

var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';
var user_level_id = "<?php echo $this->session->userdata('user_level_id'); ?>";
var instansi_id = "<?php echo $this->session->userdata('instansi_id'); ?>";
var pegawai_id = "<?php echo $this->session->userdata('pegawai_id'); ?>";

$(document).ready(function() {

    $.ajax({
        url : "<?php echo site_url('presensi/list_presensi_bawahan/')?>/" + id,
        type: "POST",
        data: {id:id, csrf_test_name: '<?=$this->security->get_csrf_hash()?>'},
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

</script>