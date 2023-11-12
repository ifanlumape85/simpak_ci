<?php
class Jenis_presensi extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Jenis_presensi_model', 'jenis_presensi', TRUE);
	}

	function index()
	{
		if ($this->session->userdata('login') != TRUE) {
			redirect('login');
		} else {
			$this->load->helper('url');
			$data = array(
				'title' 	=> 'Data Jenis presensi',
				'main_view' => 'jenis_presensi/jenis_presensi',
				'form_view' => 'jenis_presensi/jenis_presensi_form',
			);

			$this->load->view('admin/template', $data);
		}
	}

	public function ajax_list()
	{
		$this->load->helper('url');
		$list = $this->jenis_presensi->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $jenis_presensi) {
			$no++;
			$row = array();

			$row[] = '<input type="checkbox" class="data-check" value="' . $jenis_presensi->id_jenis_presensi . '">';
			$row[] = $no;
			$row[] = $jenis_presensi->nama_jenis_presensi;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_jenis_presensi(' . "'" . $jenis_presensi->id_jenis_presensi . "'" . ')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah</a>
				  <a class="btn btn-sm btn-danger btn-flat" href="javascript:void(0)" title="Hapus" onclick="delete_jenis_presensi(' . "'" . $jenis_presensi->id_jenis_presensi . "'" . ')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a>';

			$data[] = $row;
		}

		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->jenis_presensi->count_all(),
			"recordsFiltered" 	=> $this->jenis_presensi->count_filtered(),
			"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->jenis_presensi->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();


		$data = array(
			'nama_jenis_presensi' => $this->input->post('nama_jenis_presensi', TRUE),
		);
		$insert = $this->jenis_presensi->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();

		$data = array(
			'nama_jenis_presensi' => $this->input->post('nama_jenis_presensi', TRUE),
		);
		$this->jenis_presensi->update(array('id_jenis_presensi' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		if ($this->input->post('id', TRUE) != "")
			$id = $this->input->post('id', TRUE);

		$this->jenis_presensi->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_bulk_delete()
	{
		$list_id = $this->input->post('id');
		foreach ($list_id as $id) {
			$this->jenis_presensi->delete_by_id($id);
		}
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;


		if ($this->input->post('nama_jenis_presensi') == '') {
			$data['inputerror'][] = 'nama_jenis_presensi';
			$data['error_string'][] = 'Nama Jenis Presensi  is required';
			$data['status'] = FALSE;
		}


		if ($data['status'] === FALSE) {
			echo json_encode($data);
			exit();
		}
	}

	function list_jenis_presensi()
	{
		$query = $_POST['query'];
		$limit = $_POST['limit'];
		$start = $_POST['start'];

		$sql = "select * from jenis_presensi where status='1' ";

		if ($query != '') {
			$sql .= " and (nama_jenis_presensi LIKE '%$query%') ";
		}

		$sql .= " ORDER BY nama_jenis_presensi asc LIMIT $limit OFFSET $start ";

		$qry = $this->db->query($sql);
		if ($qry->num_rows() > 0) {

			$jenis_presensis = array();
			foreach ($qry->result() as $row) {
				array_push(
					$jenis_presensis,
					array(
						"id" => $row->id_jenis_presensi,
						"nama_jenis_presensi" => $row->nama_jenis_presensi,
						"status" => $row->status,
						"cek" => $row->cek,
						"photo" => $row->photo
					)
				);
			}
			print(json_encode(array("code" => 1, "message" => "Success", "result" => $jenis_presensis, "jenis_presensis" => $jenis_presensis)));
		} else {
			print(json_encode(array("code" => 0, "message" => "Data Not Found")));
		}
	}

	function data_presensi()
	{
		$id_instansi = $this->input->post('id_instansi', TRUE);
		$tgl_awal = date('Y-m-d', strtotime($this->input->post('tgl_awal', TRUE))) ?? date('Y-m-d');
		$tgl_akhir = date('Y-m-d', strtotime($this->input->post('tgl_akhir', TRUE))) ?? date('Y-m-d');

		$sql = "select * from jenis_presensi where status='1'";
		// if ($id_jenis_presensi!="")
		// 	$sql .= " and id_jenis_presensi='$id_jenis_presensi'";

		$jenis_presensis = $this->db->query($sql);

		$sql1 = "select count(*) as jml_pegawai from pegawai ";
		if ($id_instansi != "")
			$sql1 .= " where id_instansi='$id_instansi'";

		$pegawais = $this->db->query($sql1);
		$pegawai = $pegawais->row();
		$jml_pegawai = $pegawai->jml_pegawai;

		$html = '';
		$j = 1;
		$pindah = 3;
		$bg = array('bg-aqua', 'bg-green', 'bg-red', 'bg-yellow', 'bg-aqua', 'bg-green', 'bg-red', 'bg-yellow', 'bg-aqua', 'bg-green', 'bg-red', 'bg-yellow');

		foreach ($jenis_presensis->result() as $i => $jenis_presensi) :

			$id_jenis_presensi = $jenis_presensi->id_jenis_presensi;
			$nama_jenis_presensi = $jenis_presensi->nama_jenis_presensi;

			$sql2 = "
	    		SELECT
	    			count(presensi.id_pegawai) as jml,
	    			presensi.id_jenis_presensi,
	    			pegawai.id_instansi
	    		FROM
	    			presensi
	    			LEFT JOIN pegawai ON presensi.id_pegawai=pegawai.id_pegawai
	    		";
			if ($id_instansi != "") {
				$sql2 .= " WHERE pegawai.id_instansi=" . $id_instansi . " ";
			}

			if ($tgl_awal != "" && $tgl_akhir == "") {
				if ($id_instansi == "") {
					$sql2 .= " WHERE tgl_presensi='" . $tgl_awal . "' ";
				} else {
					$sql2 .= " AND tgl_presensi='" . $tgl_awal . "' ";
				}
			} elseif ($tgl_awal == "" && $tgl_akhir != "") {
				if ($id_instansi == "") {
					$sql2 .= " WHERE tgl_presensi='" . $tgl_akhir . "' ";
				} else {
					$sql2 .= " AND tgl_presensi='" . $tgl_akhir . "' ";
				}
			} else {
				if ($id_instansi == "") {
					$sql2 .= " WHERE tgl_presensi between '" . $tgl_awal . "' AND '" . $tgl_akhir . "' ";
				} else {
					$sql2 .= " AND tgl_presensi between '" . $tgl_awal . "' AND '" . $tgl_akhir . "' ";
				}
			}
			$presensis = $this->db->query($sql2);

			$presensi = $presensis->row();

			$jml = $presensi->jml;
			$prosentase = ($jml / $jml_pegawai) * 100;
			$html .= "

	    	<div class=\"col-md-3 col-sm-6 col-xs-12\">
	          <div class=\"info-box $bg[$i]\">
	            <span class=\"info-box-icon\"><i class=\"fa fa-calendar\"></i></span>

	            <div class=\"info-box-content\">
	              <span class=\"info-box-text\">$nama_jenis_presensi</span>
	              <span class=\"info-box-number\">$jml/$jml_pegawai</span>

	              <div class=\"progress\">
	                <div class=\"progress-bar\" style=\"width: $prosentase%\"></div>
	              </div>
	                  <span class=\"progress-description\">
		            <a style=\"color:white;\" href=\"javascript:void(0)\" onclick=\"tampil_absen('" . $id_jenis_presensi . "')\" class=\"small-box-footer\">Detail <i class=\"fa fa-arrow-circle-right\"></i></a>

	                  </span>
	            </div>
	            <!-- /.info-box-content -->
	          </div>
	          <!-- /.info-box -->
	        </div>
	        ";


			$j++;

		endforeach;

		echo $html;
	}

	function list_jenis_presensi2()
	{
		$sql = "SELECT * FROM jenis_presensi where status='1'";

		$qry = $this->db->query($sql);
		if ($qry->num_rows() > 0) {

			$jenis_presensis = array();
			foreach ($qry->result() as $row) {
				array_push(
					$jenis_presensis,
					array(
						"id" => $row->id_jenis_presensi,
						"nama_jenis_presensi" => $row->nama_jenis_presensi,
						"cek" => $row->cek,
						"photo" => $row->photo
					)
				);
			}
			print(json_encode(array("code" => 1, "message" => "Success", "result" => $jenis_presensis)));
		} else {
			print(json_encode(array("code" => 2, "message" => "Data Not Found")));
		}
	}
}
// END Jenis_presensi Class
/* End of file jenis_presensi.php */
/* Location: ./sytem/application/controlers/jenis_presensi.php */
