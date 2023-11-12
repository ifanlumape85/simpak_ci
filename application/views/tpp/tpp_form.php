<script type="text/javascript">
    var save_method; //for save method string
    var table;
    var base_url = '<?= base_url(); ?>';

    $(document).ready(function() {

        //datatables

        //datepicker
        $('.tgl_mulai, .tgl_selesai').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
            todayHighlight: true,
            orientation: "top auto",
            todayBtn: true,
            todayHighlight: true,
        });

        //set input/textarea/select event when change value, remove class error and remove text help block
        $("input").change(function() {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });
        $("select").change(function() {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });

        $('#btn-filter').click(function() { //button filter event click
            cetak_tpp(); //just reload table
        });
        $('#btn-reset').click(function() { //button reset event click
            $('#form-filter')[0].reset();
            reload_banner_table(); //just reload table
        });

    });

    function reload_banner_table() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function cetak_tpp() {

        $('#btn-filter').html('<i class="fa fa-print"></i> Proses...'); //change button text
        $('#btn-filter').attr('disabled', true); //set button disable
        var url = "<?= site_url('tpp/cetak') ?>";

        // ajax adding data to database
        var formData = new FormData($('#form-filter')[0]);
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function(data) {
                if (data.status) //if success close modal and reload ajax table
                {
                    alert('ok');
                }
                $('#btn-filter').html('<i class="fa fa-print"></i> Cetak TPP'); //change button text
                $('#btn-filter').attr('disabled', false); //set button enable
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('TPP gagal tercetak');
                $('#btn-filter').html('<i class="fa fa-print"></i> Cetak TPP'); //change button text
                $('#btn-filter').attr('disabled', false); //set button enable
            }
        });
    }
</script>