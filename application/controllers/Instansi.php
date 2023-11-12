<?php
class Instansi extends CI_Controller
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
				'title' 	=> 'Data Instansi',
				'main_view' => 'instansi/instansi',
				'form_view' => 'instansi/instansi_form',
			);

			$this->load->view('admin/template', $data);
		}
	}

	public function ajax_list()
	{
		$this->load->helper('url');
		$list = $this->instansi->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $instansi) {
			$no++;
			$row = array();

			$row[] = '<input type="checkbox" class="data-check" value="' . $instansi->id_instansi . '">';
			$row[] = $no;
			$row[] = $instansi->nama_instansi;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_instansi(' . "'" . $instansi->id_instansi . "'" . ')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah</a>
				  <a class="btn btn-sm btn-danger btn-flat" href="javascript:void(0)" title="Hapus" onclick="delete_instansi(' . "'" . $instansi->id_instansi . "'" . ')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a>';

			$data[] = $row;
		}

		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->instansi->count_all(),
			"recordsFiltered" 	=> $this->instansi->count_filtered(),
			"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->instansi->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();


		$data = array(
			'nama_instansi' => $this->input->post('nama_instansi', TRUE),
		);
		$insert = $this->instansi->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();

		$data = array(
			'nama_instansi' => $this->input->post('nama_instansi', TRUE),
		);
		$this->instansi->update(array('id_instansi' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		if ($this->input->post('id', TRUE) != "")
			$id = $this->input->post('id', TRUE);

		$this->instansi->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_bulk_delete()
	{
		$list_id = $this->input->post('id');
		foreach ($list_id as $id) {
			$this->instansi->delete_by_id($id);
		}
		echo json_encode(array("status" => TRUE));
	}
	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;


		if ($this->input->post('nama_instansi') == '') {
			$data['inputerror'][] = 'nama_instansi';
			$data['error_string'][] = 'Nama Instansi is required';
			$data['status'] = FALSE;
		}


		if ($data['status'] === FALSE) {
			echo json_encode($data);
			exit();
		}
	}

	function test()
	{
		// $instansis = $this->db->query("select * from instansi");
		// $instansix = "";
		// foreach ($instansis->result() as $instansi) {
		// 	$instansix .= '"' . strtoupper($instansi->nama_instansi) . '",';
		// }

		// echo $instansix;
		$qry = $this->db->query("
		SELECT
			*
		FROM
			kegiatan_harian
			JOIN pegawai ON kegiatan_harian.id_pegawai=pegawai.id_pegawai
		WHERE
			pegawai.id_instansi=2 AND
			MONTH(tgl_kegiatan)='07' AND
			YEAR(tgl_kegiatan)='2021'
		GROUP BY
			pegawai.id_pegawai
		HAVING
			sum(kegiatan_harian.kuantitas) BETWEEN 16 AND 24
		");
		echo $qry->num_rows();
		echo '<br />';
		if ($qry->num_rows() > 0) {
			foreach ($qry->result() as $rest) {
				echo $rest->nama_pegawai . ' ' . $rest->jml . '<br />';
			}
		}
	}

	// dashboard presensi
	function data_instansi()
	{
		$id_instansi = $this->input->post('id_instansi', TRUE);
		$tgl_awal = date('Y-m-d', strtotime($this->input->post('tgl_awal', TRUE))) ?? date('Y-m-d');
		$tgl_akhir = date('Y-m-d', strtotime($this->input->post('tgl_akhir', TRUE))) ?? date('Y-m-d');

		$sql = "SELECT * FROM instansi WHERE status='Y'";

		if ($id_instansi != "")
			$sql .= " and id_instansi='" . $id_instansi . "'";
		$sql .= " order by nama_instansi";

		$instansis = $this->db->query($sql);

		$html = '';
		$j = 1;

		foreach ($instansis->result() as $i => $instansi) :
			$id_instansi = $instansi->id_instansi;
			$nama_instansi = $instansi->nama_instansi;

			$pegawais = $this->db->query("SELECT count(*) AS jml_pegawai FROM pegawai WHERE id_instansi='$id_instansi'");
			$pegawai = $pegawais->row();
			$jml_pegawai = $pegawai->jml_pegawai;

			$sql2 = "
			SELECT
				presensi.id_presensi,
				COUNT(presensi.id_presensi) AS jml,
				pegawai.id_instansi
			FROM
				presensi
				LEFT JOIN pegawai ON presensi.id_pegawai=pegawai.id_pegawai
			WHERE
				pegawai.id_instansi='$id_instansi'
			";

			if ($tgl_awal != "" && $tgl_akhir == "") {
				$sql2 .= " and tgl_presensi='" . $tgl_awal . "'";
			} elseif ($tgl_awal == "" && $tgl_akhir != "") {
				$sql2 .= " and tgl_presensi='" . $tgl_akhir . "'";
			} else {
				$sql2 .= " and tgl_presensi between '" . $tgl_awal . "' and '" . $tgl_akhir . "'";
			}
			
			$presensis = $this->db->query($sql2);

			$presensi = $presensis->row();
			$jml = $presensi->jml;

			$prosentase = round(($jml / $jml_pegawai) * 100);

			//bootstrap_bg($i)
			$html .= "
	    	<div class=\"col-xs-12\">
	          <div class=\"info-box bg-aqua\">
	            <span class=\"info-box-icon\"><i class=\"fa fa-calendar\"></i></span>

	            <div class=\"info-box-content\">
	              <span class=\"info-box-text\">$nama_instansi</span>
	              <span class=\"info-box-number\">$jml/$jml_pegawai</span>

	              <div class=\"progress\">
	                <div class=\"progress-bar\" style=\"width: $prosentase%\"></div>
	              </div>
	                  <span class=\"progress-description\">
    		            <a style=\"color:white;\" href=\"" . base_url('dashboard/instansi/' . decode($id_instansi) . '/' . url_title($nama_instansi)) . "\" class=\"small-box-footer\">$prosentase% <i class=\"fa fa-arrow-circle-right\"></i></a>

	                  </span>
	            </div>
	            <!-- /.info-box-content -->
	          </div>
	          <!-- /.info-box -->
	        </div>
	        ";

		endforeach;

		echo $html;
	}

	// dashboard kinerja
	function data_instansi2()
	{
		$id_instansi = $this->input->post('id_instansi', TRUE) ?? "";
		$tgl_awal = date('Y-m-d', strtotime($this->input->post('tgl_awal', TRUE))) ?? date('Y-m-d');
		$tgl_akhir = date('Y-m-d', strtotime($this->input->post('tgl_akhir', TRUE))) ?? date('Y-m-d');
		// $exp = explode('-', $tgl_kegiatan);

		$sql = "SELECT * FROM instansi WHERE status='Y'";

		if ($id_instansi != "")
			$sql .= " and id_instansi='" . $id_instansi . "'";
		$sql .= " order by nama_instansi";

		$instansis = $this->db->query($sql);

		$html = '';
		$j = 1;

		foreach ($instansis->result() as $i => $instansi) :
			$id_instansi = $instansi->id_instansi;
			$nama_instansi = $instansi->nama_instansi;

			$pegawais = $this->db->query("
			SELECT
				count(*) AS jml_pegawai
			FROM
				pegawai
			WHERE
				id_instansi='$id_instansi'
			");
			$pegawai = $pegawais->row();
			$jml_pegawai = $pegawai->jml_pegawai;

			$hijau = "
			SELECT
				*
			FROM
				kegiatan_harian
				JOIN pegawai ON kegiatan_harian.id_pegawai=pegawai.id_pegawai
			WHERE
				(tgl_kegiatan BETWEEN '$tgl_awal' AND '$tgl_akhir') AND
				pegawai.id_instansi=$id_instansi
			GROUP BY
				pegawai.id_pegawai
			HAVING
				sum(kegiatan_harian.kuantitas) > 24
			";

			$kuning = "
			SELECT
				*
			FROM
				kegiatan_harian
				JOIN pegawai ON kegiatan_harian.id_pegawai=pegawai.id_pegawai
			WHERE
				(tgl_kegiatan BETWEEN '$tgl_awal' AND '$tgl_akhir') AND
				pegawai.id_instansi=$id_instansi
			GROUP BY
				pegawai.id_pegawai
			HAVING
				sum(kegiatan_harian.kuantitas) BETWEEN 16 AND 24
			";

			$merah = "
			SELECT
				*
			FROM
				kegiatan_harian
				JOIN pegawai ON kegiatan_harian.id_pegawai=pegawai.id_pegawai
			WHERE
				pegawai.id_instansi=$id_instansi AND
				(tgl_kegiatan BETWEEN '$tgl_awal' AND '$tgl_akhir')
			GROUP BY
				pegawai.id_pegawai
			HAVING
				sum(kegiatan_harian.kuantitas) BETWEEN 0 AND 15
			";

			$qryHijau = $this->db->query($hijau);
			$qryKuning = $this->db->query($kuning);
			$qryMerah = $this->db->query($merah);

			$jmlHijau = $qryHijau->num_rows();
			$jmlKuning = $qryKuning->num_rows();
			$jmlMerah = $qryMerah->num_rows();

			// echo $jmlHijau . ' ' . $jmlKuning . ' ' . $jmlMerah;

			$jml = $jmlHijau + $jmlKuning + $jmlMerah;

			$prosentaseHijau = round(($jmlHijau / $jml_pegawai) * 100);
			$prosentaseKuning = round(($jmlKuning / $jml_pegawai) * 100);
			$prosentaseMerah = round(($jmlMerah / $jml_pegawai) * 100);

			$html .= "
	    	<div class=\"col-xs-12\">
	          <div class=\"info-box bg-aqua\">
	            <span class=\"info-box-icon\"><i class=\"fa fa-bookmark-o\"></i></span>

	            <div class=\"info-box-content\">
	              <span class=\"info-box-text\">$nama_instansi</span>
	              <span class=\"info-box-number\">$jml/$jml_pegawai</span>

	              <div class=\"progress\">
	                <div class=\"progress-bar\" style=\"width: $prosentaseHijau%\"></div>
	                <div class=\"progress-bar\" style=\"width: $prosentaseKuning%\"></div>
	                <div class=\"progress-bar\" style=\"width: $prosentaseMerah%\"></div>
	              </div>
	                  <span class=\"progress-description\">
    		            <a style=\"color:white;\" href=\"" . base_url('dashboard/instansi/' . decode($id_instansi) . '/' . url_title($nama_instansi)) . "\" class=\"small-box-footer\">Hijau : $prosentaseHijau% | Kuning : $prosentaseKuning% | Merah : $prosentaseMerah% <i class=\"fa fa-arrow-circle-right\"></i></a>
	                  </span>
	            </div>
	            <!-- /.info-box-content -->
	          </div>
	          <!-- /.info-box -->
	        </div>
	        ";

		endforeach;

		echo $html;
	}

	function lon_lat()
	{
		$id_instansi = $this->input->post('id', TRUE);
		$instansis = $this->db->query("select * from instansi where id_instansi='$id_instansi'");

		$lat = "";
		$lon = "";
		if ($instansis->num_rows() > 0) {
			$instansi = $instansis->row();
			$lat = $instansi->lat;
			$lon = $instansi->lon;
		}

		echo json_encode(array('code' => '1', 'lat' => $lat, 'lon' => $lon));
	}
}
// END Instansi Class
/* End of file instansi.php */
/* Location: ./sytem/application/controlers/instansi.php */
