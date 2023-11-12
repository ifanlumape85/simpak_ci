<script type="text/javascript">
    var save_method; //for save method string
    var table;
    var base_url = '<?php echo base_url(); ?>';
    var id_instansi = '<?php echo $this->session->userdata('instansi_id'); ?>';
    var user_level_id = '<?php echo $this->session->userdata('user_level_id'); ?>';
    var tgl_presensi = '<?php echo date('d-m-Y'); ?>';
    var tgl_mulai, tgl_selesai, id_jenis_presensi;

    $(document).ready(function() {

        $('#tgl_awal, #tgl_akhir').datepicker({
            autoclose: true,
            format: "dd-mm-yyyy",
            todayHighlight: true,
            orientation: "top auto",
            todayBtn: true,
            todayHighlight: true,
        });

        $('.breadcrumb').html('<li><a href="' + base_url + '"><i class="fa fa-dashboard"></i> Beranda</a></li><li><a href="#">Dashboard</a></li><li class="active">Absensi</li>');

        setInterval(function() {
            if (user_level_id == 1) {
                dashboard_admin();
                dashboard_kegiatan_admin();
            } else {
                dashboard_user();
                dashboard_kegiatan_user();
            }

        }, 2000);

        $('#btn-filter').click(function() { //button filter event click
            if (user_level_id == 1) {
                dashboard_admin();
            } else {
                dashboard_user();
            }
        });

        $('select[name=id_instansi]').change(function(e) {
            if (user_level_id == 1) {
                dashboard_admin();
                dashboard_kegiatan_admin();
            } else {
                dashboard_user();
                dashboard_kegiatan_user();
            }
        });

        if (user_level_id > 1) {
            $('select[name=id_instansi]').val(id_instansi);
        }
    });

    // admin skpd
    function dashboard_user() {
        var id_instansi = $('select[name=id_instansi]').val();
        var tgl_awal = $('[name=tgl_awal]').val();
        var tgl_akhir = $('[name=tgl_akhir]').val();
        var url = "<?php echo site_url('jenis_presensi/data_presensi/') ?>";
        $.ajax({
            type: "POST",
            data: {
                id_instansi: id_instansi,
                tgl_awal: tgl_awal,
                tgl_akhir: tgl_akhir,
                csrf_test_name: '<?= $this->security->get_csrf_hash() ?>'
            },
            url: url,
            dataType: "text",
            success: function(data) {
                $('.dashboardx').html(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {

            }
        });
    }
    // khusus super admin
    function dashboard_admin() {
        var id_instansi = $('select[name=id_instansi]').val();
        var tgl_awal = $('[name=tgl_awal]').val();
        var tgl_akhir = $('select[name=tgl_akhir]').val();

        var url = "<?php echo site_url('instansi/data_instansi/') ?>";
        $.ajax({
            type: "POST",
            data: {
                id_instansi: id_instansi,
                tgl_awal: tgl_awal,
                tgl_akhir: tgl_akhir,
                csrf_test_name: '<?= $this->security->get_csrf_hash() ?>'
            },
            url: url,
            dataType: "text",
            success: function(data) {
                $('.dashboardx').html(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {

            }
        });
    }

    function dashboard_kegiatan_admin() {
        var id_instansi = $('select[name=id_instansi]').val();
        var tgl_awal = $('[name=tgl_awal]').val();
        var tgl_akhir = $('[name=tgl_akhir]').val();

        var url2 = "<?php echo site_url('instansi/data_instansi2/') ?>";
        $.ajax({
            type: "POST",
            data: {
                id_instansi: id_instansi,
                tgl_awal: tgl_awal,
                tgl_akhir: tgl_akhir,
                csrf_test_name: '<?= $this->security->get_csrf_hash() ?>'
            },
            url: url2,
            dataType: "text",
            success: function(data) {
                $('.dashboardx2').html(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {

            }
        });
    }

    function dashboard_kegiatan_user() {

    }
</script>