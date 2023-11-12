<script type="text/javascript">
    var save_method; //for save method string
    var table;
    var base_url = '<?php echo base_url(); ?>';
    var user_level_id = '<?php echo $this->session->userdata('user_level_id'); ?>';
    var pegawai_id = '<?php echo $this->session->userdata('pegawai_id'); ?>';
    var instansi_id = '<?php echo $this->session->userdata('instansi_id'); ?>';
    var visible = true;
    $(document).ready(function() {

        if (user_level_id > 1) {
            $('.fg-instansi2').hide();
            $('select[name=id_instansi2]').val(instansi_id);
            $.ajax({
                url: "<?php echo site_url('pegawai/option_pegawai/') ?>/" + instansi_id,
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

        $('#datepicker1, #datepicker2').datepicker({
            autoclose: true,
            format: "dd-mm-yyyy"
        });


        $('#btn-filter').click(function() { //button filter event click
            if (user_level_id > 1) {
                $('.fg-instansi2').hide();
                $('select[name=id_instansi2]').val(instansi_id);
            }
            get_report_kinerja(); //just reload table
        });

        $('#btn-cetak').click(function() { //button filter event click
            laporan_pdf()
        });

        $('#btn-reset').click(function() { //button reset event click
            if (user_level_id == 1) {
                $('#form-filter')[0].reset();
            } else {
                $('[name=tgl_awal]').val("");
                $('[name=tgl_akhir]').val("");
            }
            $('.tabel_laporan').html("");
        });

        $('select[name=id_instansi2]').change(function() {
            var id = $('select[name=id_instansi2]').val();

            $.ajax({
                url: "<?php echo site_url('pegawai/option_pegawai/') ?>/" + id,
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

        $('select[name=id_pegawai2]').change(function() {
            $('.fg-tahun2').show();
        });
    });

    function get_report_kinerja() {
        var id_pegawai = $('select[name=id_pegawai2]').val();
        var tanggal_awal = $('[name=tgl_awal]').val();
        var tanggal_akhir = $('[name=tgl_akhir]').val();

        $.ajax({
            url: "<?php echo site_url('kegiatan_harian/laporan_kegiatan/') ?>/",
            data: {
                id_pegawai: id_pegawai,
                tgl_awal: tanggal_awal,
                tgl_akhir: tanggal_akhir,
                csrf_test_name: '<?= $this->security->get_csrf_hash() ?>'
            },
            type: "POST",
            dataType: "text",
            success: function(data) {
                $('.tabel_laporan').html(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data laporan');
            }
        });
    }

    function laporan_pdf() {
        var id_pegawai = $('select[name=id_pegawai2]').val();
        var tanggal_awal = $('[name=tgl_awal]').val();
        var tanggal_akhir = $('[name=tgl_akhir]').val();
        console.log(id_pegawai + " " + tanggal_awal + " " + tanggal_akhir);
        window.location.href = base_url + 'kegiatan_harian/laporan_pdf/' + id_pegawai + '/' + tanggal_awal + '/' + tanggal_akhir;
    }
</script>