<script type="text/javascript">
    var save_method; //for save method string
    var table;
    var base_url = '<?= base_url(); ?>';
    var user_level_id = "<?= $this->session->userdata('user_level_id'); ?>";
    var instansi_id = "<?= $this->session->userdata('instansi_id'); ?>";
    var pegawai_id = "<?= $this->session->userdata('pegawai_id'); ?>";
    var paging = true;
    var searching = true;
    var ordering = true;
    var visible = true;

    $(document).ready(function() {

        if (user_level_id > 1) {
            $('.fg-instansi2').hide();
            $('select[name=id_instansi2]').val(instansi_id);
            $.ajax({
                url: "<?= site_url('pegawai/option_pegawai/') ?>",
                type: "POST",
                data: {
                    id_instansi: instansi_id,
                    csrf_test_name: '<?= $this->security->get_csrf_hash() ?>'
                },
                dataType: "text",
                success: function(data) {
                    $('select[name=id_pegawai2]').html(data);
                    if (user_level_id == 5) {
                        $('select[name=id_pegawai2]').val(pegawai_id);
                        $('.fg-pegawai2').hide();
                    } else {
                        $('.fg-pegawai2').show();
                    }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        }

        $('#tgl_mulai,#tgl_selesai').datepicker({
            autoclose: true,
            format: "dd-mm-yyyy"
        });

        $('#btn-filter').click(function() { //button filter event click
            if (user_level_id > 1) {
                $('.fg-instansi2').hide();
                $('select[name=id_instansi2]').val(instansi_id);
            }
            reload_presensi_table(); //just reload table
        });

        $('#btn-cetak').click(function() { //button filter event click
            alert('ok');
        });



        $('#btn-reset').click(function() { //button reset event click
            if (user_level_id == 1) {
                $('#form-filter')[0].reset();
                reload_presensi_table(); //just reload table
            } else {
                $('select[name=id_pegawai2]').val("");
                $('[name=tgl_mulai]').val("");
                $('[name=tgl_selesai]').val("");
                $('select[name=id_jenis_presensi2]').val("");
                $('select[name=id_status_presensi2]').val("");
                $('.tabel_laporan').html("");
            }
        });

        $('.fg-pegawai2').hide();

        $('select[name=id_instansi2]').change(function() {
            var id = $('select[name=id_instansi2]').val();

            $.ajax({
                url: "<?= site_url('pegawai/option_pegawai/') ?>/",
                type: "POST",
                data: {
                    id_instansi: id,
                    csrf_test_name: '<?= $this->security->get_csrf_hash() ?>'
                },
                dataType: "text",
                success: function(data) {
                    $('select[name=id_pegawai2]').html(data);
                    $('.fg-pegawai2').show();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        });
    });

    function reload_presensi_table() {
        var id_instansi = $('select[name=id_instansi2]').val();
        var id_pegawai = $('select[name=id_pegawai2]').val();
        var id_jenis_presensi = $('select[name=id_jenis_presensi2]').val();
        var id_status_presensi = $('select[name=id_status_presensi2]').val();
        var tgl_mulai = $('[name=tgl_mulai]').val();
        var tgl_selesai = $('[name=tgl_selesai]').val();


        $.ajax({
            url: "<?= site_url('presensi/laporan_presensi/') ?>/",
            data: {
                id_instansi: id_instansi,
                id_pegawai: id_pegawai,
                id_jenis_presensi: id_jenis_presensi,
                id_status_presensi: id_status_presensi,
                tgl_mulai: tgl_mulai,
                tgl_selesai: tgl_selesai,
                csrf_test_name: '<?= $this->security->get_csrf_hash() ?>'
            },
            type: "POST",
            dataType: "text",
            success: function(data) {
                $('.tabel_laporan').html(data);

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }
</script>