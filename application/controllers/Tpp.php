<?php
class Tpp extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Instansi_model', 'instansi', TRUE);
    }

    function index()
    {
        if ($this->session->userdata('login') != TRUE) {
            redirect('login');
        } else {
            $this->load->helper('url');
            $data = array(
                'title'     => 'Cetak TPP',
                'main_view' => 'tpp/tpp',
                'form_view' => 'tpp/tpp_form',
            );

            $instansis = $this->instansi->get_list_instansi();
            $opt_instansi = array('' => 'Pilih Instansi');
            foreach ($instansis as $i => $v) {
                $opt_instansi[$i] = $v;
            }

            $data['form_instansi'] = form_dropdown('id_instansi', $opt_instansi, '', 'id="id_instansi" class="form-control"');
            $data['form_instansi2'] = form_dropdown('id_instansi2', $opt_instansi, '', 'id="id_instansi2" class="form-control"');
            $data['options_instansi'] = $opt_instansi;
            $this->load->view('admin/template', $data);
        }
    }

    function cetak()
    {
        $id_instansi = 2; //$this->input->post('id_instansi2');
        $tgl_mulai = $this->input->post('tgl_mulai2');
        $tgl_akhir = $this->input->post('tgl_akhir2');

        $instansi = $this->db->query("SELECT nama_instansi FROM instansi WHERE id_instansi=$id_instansi")->row();
        $pegawai = $this->db->query("
        SELECT
            nama_pegawai, nip
        FROM
            pegawai
        WHERE
            id_instansi=$id_instansi
        ORDER BY
            nip
        ");
        $tabel = '
        <div style="display:block; text-align:center; margin-bottom:5px;">
        <span style="font-weight:bold">PEMERINTAH KABUPATEN BOLAANG MONGONDOW</span><br />
        <span style="font-weight:bold; margin-bottom:5px; display:block;">' . strtoupper($instansi->nama_instansi) . '</span><br />
        <span>TAMBAHAN PENGAHASILAN PEGAWAI NEGERI SIPIL</span><br />
        <span>' . strtoupper($instansi->nama_instansi) . '</span><br />
        <span>SELANG BULAN APRIL 2021</span><br />

        </div>

        <table id="customers" style="width:100%">
        <tr>
            <th>No</th>
            <th>NAMA</th>
            <th>NIP</th>
            <th>Hari Kerja</th>
            <th>Tdk Apel<br />Pagi<br />(kali)</th>
            <th>Bobot Nilai<br /> Apel<br />(%)</th>
            <th>Tdk Cukup Jam Kerja</th>
            <th>Bobot Nilai Jam Kerja</th>
            <th>Jumlah Upacara</th>
            <th>Kehadiran</th>
            <th>Bobot Nilai Upacara</th>
            <th>Jumlah Rapat/Sidang</th>
            <th>Kehadiran</th>
            <th>Bobot Nilai Rapt</th>
            <th>Sub Total I</th>
            <th>Output Pekerjaan</th>
            <th>Bobot Output Pekerjaan</th>
            <th>Sub Total II</th>
            <th>Total</th>
        </tr>
        ';
        $i = 1;
        foreach ($pegawai->result() as $row) {
            $tabel .= '
            <tr>
                <td>' . $i . '</td>
                <td width="15%">' . $row->nama_pegawai . '</td>
                <td>' . $row->nip . '</td>
                <td>20</td>
                <td></td>
                <td>100%</td>
                <td></td>
                <td>100%</td>
                <td></td>
                <td></td>
                <td>100%</td>
                <td></td>
                <td></td>
                <td>100%</td>
                <td></td>
                <td></td>
                <td>100%</td>
                <td></td>
                <td></td>
            </tr>';
            $i++;
        }
        $tabel .= '</table>';
        $this->load->view('print/template', ['tabel' => $tabel]);
    }
}
// END Agenda Class
/* End of file agenda.php */
/* Location: ./sytem/application/controlers/agenda.php */
