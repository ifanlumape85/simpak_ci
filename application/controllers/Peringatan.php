<?php
class Peringatan extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Peringatan_model', 'peringatan', TRUE);
		$this->load->model('Instansi_model', 'instansi', TRUE);
		$this->load->model('Pegawai_model', 'pegawai', TRUE);
		$this->load->model('Jenis_peringatan_model', 'jenis_peringatan', TRUE);
	}

	function index()
	{
		if ($this->session->userdata('login') != TRUE) {
			redirect('login');
		} else {
			$this->load->helper('url');
			$data = array(
				'title' 	=> 'Data Peringatan',
				'main_view' => 'peringatan/peringatan',
				'form_view' => 'peringatan/peringatan_form',
			);

			if ($this->session->userdata('user_level_id') == 1)
				$instansis = $this->instansi->get_list_instansi();
			else
				$instansis = $this->instansi->get_list_instansi($this->session->userdata('instansi_id'));

			$opt_instansi = array('' => 'Pilih Instansi');
			foreach ($instansis as $i => $v) {
				$opt_instansi[$i] = $v;
			}

			$data['form_instansi'] = form_dropdown('id_instansi', $opt_instansi, '', 'id="id_instansi" class="form-control"');
			$data['form_instansi2'] = form_dropdown('id_instansi2', $opt_instansi, '', 'id="id_instansi2" class="form-control"');
			$data['options_instansi'] = $opt_instansi;

			$pegawais = $this->pegawai->get_list_pegawai();
			$opt_pegawai = array('' => 'Pilih Pegawai');
			foreach ($pegawais as $i => $v) {
				$opt_pegawai[$i] = $v;
			}

			$data['form_pegawai'] = form_dropdown('id_pegawai', $opt_pegawai, '', 'id="id_pegawai" class="form-control"');
			$data['form_pegawai2'] = form_dropdown('id_pegawai2', $opt_pegawai, '', 'id="id_pegawai2" class="form-control"');
			$data['options_pegawai'] = $opt_pegawai;
			$jenis_peringatans = $this->jenis_peringatan->get_list_jenis_peringatan();
			$opt_jenis_peringatan = array('' => 'Pilih Jenis Pelanggaran ');
			foreach ($jenis_peringatans as $i => $v) {
				$opt_jenis_peringatan[$i] = $v;
			}

			$data['form_jenis_peringatan'] = form_dropdown('id_jenis_peringatan', $opt_jenis_peringatan, '', 'id="id_jenis_peringatan" class="form-control"');
			$data['form_jenis_peringatan2'] = form_dropdown('id_jenis_peringatan2', $opt_jenis_peringatan, '', 'id="id_jenis_peringatan2" class="form-control"');
			$data['options_jenis_peringatan'] = $opt_jenis_peringatan;
			$this->load->view('admin/template', $data);
		}
	}

	function sebagai_atasan()
	{
		if ($this->session->userdata('login') != TRUE) {
			redirect('login');
		} else {
			$this->load->helper('url');
			$data = array(
				'title' 	=> 'Data Peringatan',
				'main_view' => 'peringatan/peringatan_sebagai_atasan',
				'form_view' => 'peringatan/peringatan_sebagai_atasan_form',
			);

			$instansis = $this->instansi->get_list_instansi($this->session->userdata('instansi_id'));
			$opt_instansi = array('' => 'Pilih Instansi');
			foreach ($instansis as $i => $v) {
				$opt_instansi[$i] = $v;
			}

			$data['form_instansi'] = form_dropdown('id_instansi', $opt_instansi, '', 'id="id_instansi" class="form-control"');
			$data['form_instansi2'] = form_dropdown('id_instansi2', $opt_instansi, '', 'id="id_instansi2" class="form-control"');
			$data['options_instansi'] = $opt_instansi;

			$pegawais = $this->pegawai->get_list_pegawai();
			$opt_pegawai = array('' => 'Pilih Pegawai');
			foreach ($pegawais as $i => $v) {
				$opt_pegawai[$i] = $v;
			}

			$data['form_pegawai'] = form_dropdown('id_pegawai', $opt_pegawai, '', 'id="id_pegawai" class="form-control"');
			$data['form_pegawai2'] = form_dropdown('id_pegawai2', $opt_pegawai, '', 'id="id_pegawai2" class="form-control"');
			$data['options_pegawai'] = $opt_pegawai;
			$jenis_peringatans = $this->jenis_peringatan->get_list_jenis_peringatan();
			$opt_jenis_peringatan = array('' => 'Pilih Jenis Pelanggaran');
			foreach ($jenis_peringatans as $i => $v) {
				$opt_jenis_peringatan[$i] = $v;
			}

			$data['form_jenis_peringatan'] = form_dropdown('id_jenis_peringatan', $opt_jenis_peringatan, '', 'id="id_jenis_peringatan" class="form-control"');
			$data['form_jenis_peringatan2'] = form_dropdown('id_jenis_peringatan2', $opt_jenis_peringatan, '', 'id="id_jenis_peringatan2" class="form-control"');
			$data['options_jenis_peringatan'] = $opt_jenis_peringatan;
			$this->load->view('admin/template', $data);
		}
	}

	function sebagai_pegawai()
	{
		if ($this->session->userdata('login') != TRUE) {
			redirect('login');
		} else {
			$this->load->helper('url');
			$data = array(
				'title' 	=> 'Data Peringatan',
				'main_view' => 'peringatan/peringatan_sebagai_pegawai',
				'form_view' => 'peringatan/peringatan_sebagai_pegawai_form',
			);

			$instansis = $this->instansi->get_list_instansi($this->session->userdata('instansi_id'));
			$opt_instansi = array('' => 'Pilih Instansi');
			foreach ($instansis as $i => $v) {
				$opt_instansi[$i] = $v;
			}

			$data['form_instansi'] = form_dropdown('id_instansi', $opt_instansi, '', 'id="id_instansi" class="form-control"');
			$data['form_instansi2'] = form_dropdown('id_instansi2', $opt_instansi, '', 'id="id_instansi2" class="form-control"');
			$data['options_instansi'] = $opt_instansi;

			$pegawais = $this->pegawai->get_list_pegawai();
			$opt_pegawai = array('' => 'Pilih Pegawai');
			foreach ($pegawais as $i => $v) {
				$opt_pegawai[$i] = $v;
			}

			$data['form_pegawai'] = form_dropdown('id_pegawai', $opt_pegawai, '', 'id="id_pegawai" class="form-control"');
			$data['form_pegawai2'] = form_dropdown('id_pegawai2', $opt_pegawai, '', 'id="id_pegawai2" class="form-control"');
			$data['options_pegawai'] = $opt_pegawai;
			$jenis_peringatans = $this->jenis_peringatan->get_list_jenis_peringatan();
			$opt_jenis_peringatan = array('' => 'Pilih Jenis Pelanggaran');
			foreach ($jenis_peringatans as $i => $v) {
				$opt_jenis_peringatan[$i] = $v;
			}

			$data['form_jenis_peringatan'] = form_dropdown('id_jenis_peringatan', $opt_jenis_peringatan, '', 'id="id_jenis_peringatan" class="form-control"');
			$data['form_jenis_peringatan2'] = form_dropdown('id_jenis_peringatan2', $opt_jenis_peringatan, '', 'id="id_jenis_peringatan2" class="form-control"');
			$data['options_jenis_peringatan'] = $opt_jenis_peringatan;
			$this->load->view('admin/template', $data);
		}
	}

	public function ajax_list()
	{
		$this->load->helper('url');
		$list = $this->peringatan->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $peringatan) {
			$no++;
			$row = array();

			$row[] = '<input type="checkbox" class="data-check" value="' . $peringatan->id_peringatan . '">';
			$row[] = $no;
			$row[] = $peringatan->nama_instansi;
			$row[] = $this->pegawai->get_nama_pegawai($peringatan->id_verifikator);
			$row[] = $peringatan->nama_pegawai;
			$row[] = $peringatan->nama_jenis_peringatan;
			$row[] = $peringatan->isi_peringatan;
			$row[] = tgl_indonesia2($peringatan->tgl_peringatan);

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_peringatan(' . "'" . $peringatan->id_peringatan . "'" . ')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah</a>
				  <a class="btn btn-sm btn-danger btn-flat" href="javascript:void(0)" title="Hapus" onclick="delete_peringatan(' . "'" . $peringatan->id_peringatan . "'" . ')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a>';

			$data[] = $row;
		}

		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->peringatan->count_all(),
			"recordsFiltered" 	=> $this->peringatan->count_filtered(),
			"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_list2()
	{
		$this->load->helper('url');
		$list = $this->peringatan->get_datatables2();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $peringatan) {
			$no++;
			$row = array();

			$row[] = '<input type="checkbox" class="data-check" value="' . $peringatan->id_peringatan . '">';
			$row[] = $no;
			$row[] = $peringatan->nama_instansi;
			$row[] = $peringatan->nama_pegawai;
			$row[] = $peringatan->nama_jenis_peringatan;
			$row[] = $peringatan->isi_peringatan;
			$row[] = tgl_indonesia2($peringatan->tgl_peringatan);

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_peringatan(' . "'" . $peringatan->id_peringatan . "'" . ')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah</a>
				  <a class="btn btn-sm btn-danger btn-flat" href="javascript:void(0)" title="Hapus" onclick="delete_peringatan(' . "'" . $peringatan->id_peringatan . "'" . ')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a>';

			$data[] = $row;
		}

		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->peringatan->count_all(),
			"recordsFiltered" 	=> $this->peringatan->count_filtered2(),
			"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_list3()
	{
		$this->load->helper('url');
		$list = $this->peringatan->get_datatables3();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $peringatan) {
			$no++;
			$row = array();

			$row[] = $no;
			$row[] = $peringatan->nama_instansi;
			$row[] = $peringatan->nama_pegawai;
			$row[] = $peringatan->nama_jenis_peringatan;
			$row[] = $peringatan->isi_peringatan;
			$row[] = tgl_indonesia2($peringatan->tgl_peringatan);

			$data[] = $row;
		}

		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->peringatan->count_all(),
			"recordsFiltered" 	=> $this->peringatan->count_filtered2(),
			"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->peringatan->get_by_id($id);
		$data->tgl_peringatan = ($data->tgl_peringatan == '00-00-0000') ? '' : date('d-m-Y', strtotime($data->tgl_peringatan)); // if 0000-00-00 set tu empty for datepicker compatibility

		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();

		$data = array(
			'id_pegawai' => $this->input->post('id_pegawai', TRUE),
			'id_verifikator' => $this->input->post('id_verifikator', TRUE),
			'id_jenis_peringatan' => $this->input->post('id_jenis_peringatan', TRUE),
			'isi_peringatan' => $this->input->post('isi_peringatan', TRUE),
			'tgl_peringatan' => date('Y-m-d', strtotime($this->input->post('tgl_peringatan', TRUE))),
		);
		$insert = $this->peringatan->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_add2()
	{
		// $this->_validate();

		$arr = array();
		if ($this->input->post('id_pegawai') != "" && $this->input->post('id_verifikator') != "" && $this->input->post('id_jenis_peringatan') != "" && $this->input->post('isi_peringatan') != "") {

			$data = array(
				'id_pegawai' => $this->pegawai->get_id($this->input->post('id_pegawai', TRUE)),
				'id_verifikator' => $this->input->post('id_verifikator', TRUE),
				'id_jenis_peringatan' => $this->jenis_peringatan->get_id_jenis_peringatan($this->input->post('id_jenis_peringatan', TRUE)),
				'isi_peringatan' => $this->input->post('isi_peringatan', TRUE),
				'tgl_peringatan' => date('Y-m-d'),
			);
			$insert = $this->peringatan->save($data);
			echo json_encode(array("status" => TRUE, "code" => 1, "message" => "Success"));
		} else {
			echo json_encode(array("status" => FALSE, "code" => 0, "message" => "Lengkapi form isian."));
		}
	}

	public function ajax_update()
	{
		$this->_validate();

		$data = array(
			'id_pegawai' => $this->input->post('id_pegawai', TRUE),
			'id_verifikator' => $this->input->post('id_verifikator', TRUE),
			'id_jenis_peringatan' => $this->input->post('id_jenis_peringatan', TRUE),
			'isi_peringatan' => $this->input->post('isi_peringatan', TRUE),
			'tgl_peringatan' => date('Y-m-d', strtotime($this->input->post('tgl_peringatan', TRUE))),
		);
		$this->peringatan->update(array('id_peringatan' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update2()
	{
		// $this->_validate2();

		if ($this->input->post('id_pegawai') != "" && $this->input->post('id_jenis_peringatan') != "" && $this->input->post('isi_peringatan') != "") {
			$data = array(
				'id_pegawai' => $this->pegawai->get_id($this->input->post('id_pegawai', TRUE)),
				'id_jenis_peringatan' => $this->jenis_peringatan->get_id_jenis_peringatan($this->input->post('id_jenis_peringatan', TRUE)),
				'isi_peringatan' => $this->input->post('isi_peringatan', TRUE),
				'tgl_peringatan' => date('Y-m-d'),
			);
			$this->peringatan->update(array('id_peringatan' => $this->input->post('id')), $data);
			echo json_encode(array("status" => TRUE, "code" => 1, "message" => "Success "));
		} else {
			echo json_encode(array("status" => FALSE, "code" => 0, "message" => "Lengkapi data"));
		}
	}

	public function ajax_delete($id = "")
	{
		if ($this->input->post('id', TRUE) != "") $id = $this->input->post('id', TRUE);

		$this->peringatan->delete_by_id($id);
		echo json_encode(array("status" => TRUE, "code" => 1, "message" => "Success"));
	}

	public function ajax_bulk_delete()
	{
		$list_id = $this->input->post('id');
		foreach ($list_id as $id) {
			$this->peringatan->delete_by_id($id);
		}
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;


		if ($this->input->post('id_pegawai') == '') {
			$data['inputerror'][] = 'id_pegawai';
			$data['error_string'][] = 'Pegawai is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('id_verifikator') == '') {
			$data['inputerror'][] = 'id_verifikator';
			$data['error_string'][] = 'Verifikator is required';
			$data['status'] = FALSE;
		}


		if ($this->input->post('id_jenis_peringatan') == '') {
			$data['inputerror'][] = 'id_jenis_peringatan';
			$data['error_string'][] = 'Jenis Peringatan  is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('isi_peringatan') == '') {
			$data['inputerror'][] = 'isi_peringatan';
			$data['error_string'][] = 'Isi Peringatan is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('tgl_peringatan') == '') {
			$data['inputerror'][] = 'tgl_peringatan';
			$data['error_string'][] = 'Tgl Peringatan is required';
			$data['status'] = FALSE;
		}


		if ($data['status'] === FALSE) {
			echo json_encode($data);
			exit();
		}
	}

	private function _validate2()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;


		if ($this->input->post('id_jenis_peringatan') == '') {
			$data['inputerror'][] = 'id_jenis_peringatan';
			$data['error_string'][] = 'Jenis Peringatan  is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('isi_peringatan') == '') {
			$data['inputerror'][] = 'isi_peringatan';
			$data['error_string'][] = 'Isi Peringatan is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('tgl_peringatan') == '') {
			$data['inputerror'][] = 'tgl_peringatan';
			$data['error_string'][] = 'Tgl Peringatan is required';
			$data['status'] = FALSE;
		}


		if ($data['status'] === FALSE) {
			echo json_encode($data);
			exit();
		}
	}

	function peringatan_pegawai()
	{
		$id = $_POST['id'] ?? 0;
		$query = $_POST['query'] ?? "";
		$limit = $_POST['limit'] ?? 10;
		$start = $_POST['start'] ?? 0;

		// $id=296;
		// $query='';
		// $limit=5;
		// $start=0;

		$sql = "SELECT peringatan.*, jenis_peringatan.nama_jenis_peringatan, pegawai.nama_pegawai, pegawai.photo as photo_pegawai FROM peringatan LEFT JOIN jenis_peringatan ON peringatan.id_jenis_peringatan=jenis_peringatan.id_jenis_peringatan LEFT JOIN pegawai on peringatan.id_pegawai=pegawai.id_pegawai ";

		if ($query != '') {
			$sql .= " WHERE (peringatan.tgl_peringatan LIKE '%$query%' OR peringatan.isi_peringatan LIKE '%$query%') AND peringatan.id_pegawai='$id'";
		} else {
			$sql .= " WHERE peringatan.id_pegawai='$id'";
		}

		$sql .= " ORDER BY peringatan.id_peringatan DESC LIMIT $limit OFFSET $start ";

		$qry = $this->db->query($sql);
		// print(json_encode(array("code" => 1, "message" => "Success", "result" => $qry->result())));
		if ($qry->num_rows() > 0) {

			$peringatans = array();
			foreach ($qry->result() as $row) {
				$idPegawai = $row->id_verifikator;
				$qry = $this->db->query("select nama_pegawai from pegawai where id_pegawai=$idPegawai");
				$nama_verifikator = "";
				if ($qry->num_rows() > 0) {
					$row2 = $qry->row();
					$nama_verifikator = $row2->nama_pegawai;
				}
				array_push(
					$peringatans,
					array(
						"id" => $row->id_peringatan,
						"id_pegawai" => $row->id_pegawai,
						"nama_pegawai" => $this->pegawai->get_nama_pegawai($row->id_pegawai),
						"nip" => $this->pegawai->get_nip_pegawai($row->id_pegawai),
						"id_jenis_peringatan" => $row->id_jenis_peringatan,
						"nama_jenis_peringatan" => $this->jenis_peringatan->get_nama_jenis_peringatan($row->id_jenis_peringatan),
						"isi_peringatan" => $row->isi_peringatan,
						"tgl_peringatan" => $row->tgl_peringatan,
						"tgl_peringatan_" => tgl_indonesia2($row->tgl_peringatan),
						"photo" => $row->photo_pegawai,
						"nama_verifikator" => $nama_verifikator
					)
				);
			}
			print(json_encode(array("code" => 1, "message" => "Success", "result" => $peringatans, "peringatans" => $peringatans)));
		} else {
			print(json_encode(array("code" => 0, "message" => "Data Not Found")));
		}
	}

	function peringatan_bawahan()
	{
		$id = $_POST['id'];
		$query = $_POST['query'];
		$limit = $_POST['limit'];
		$start = $_POST['start'];

		// $id=296;
		// $query='';
		// $limit=5;
		// $start=0;

		$sql = "SELECT peringatan.*, jenis_peringatan.nama_jenis_peringatan, pegawai.nama_pegawai, pegawai.photo as photo_pegawai FROM peringatan LEFT JOIN jenis_peringatan ON peringatan.id_jenis_peringatan=jenis_peringatan.id_jenis_peringatan LEFT JOIN pegawai on peringatan.id_pegawai=pegawai.id_pegawai ";

		if ($query != '') {
			$sql .= " WHERE (pegawai.nama_pegawai LIKE '%$query%' OR peringatan.tgl_peringatan LIKE '%$query%') AND peringatan.id_verifikator='$id'";
		} else {
			$sql .= " WHERE peringatan.id_verifikator='$id'";
		}

		$sql .= " ORDER BY peringatan.id_peringatan DESC LIMIT $limit OFFSET $start ";

		$qry = $this->db->query($sql);
		if ($qry->num_rows() > 0) {

			$peringatans = array();
			foreach ($qry->result() as $row) {
				array_push(
					$peringatans,
					array(
						"id" => $row->id_peringatan,
						"id_pegawai" => $row->id_pegawai,
						"nama_pegawai" => $this->pegawai->get_nama_pegawai($row->id_pegawai),
						"nip" => $this->pegawai->get_nip_pegawai($row->id_pegawai),
						"id_verifikator" => $row->id_verifikator,
						"nama_verifikator" => $this->pegawai->get_nama_pegawai($row->id_verifikator),
						"id_jenis_peringatan" => $row->id_jenis_peringatan,
						"nama_jenis_peringatan" => $this->jenis_peringatan->get_nama_jenis_peringatan($row->id_jenis_peringatan),
						"isi_peringatan" => $row->isi_peringatan,
						"tgl_peringatan" => $row->tgl_peringatan,
						"tgl_peringatan_" => tgl_indonesia2($row->tgl_peringatan),
						"photo" => $row->photo_pegawai
					)
				);
			}
			print(json_encode(array("code" => 1, "message" => "Success", "result" => $peringatans, "peringatans" => $peringatans)));
		} else {
			print(json_encode(array("code" => 0, "message" => "Data Not Found")));
		}
	}

	function get_jumlah()
	{
		$id = $this->input->post('id', TRUE);

		if ($id != "") {
			$n = date('n');
			$qry = $this->db->query("select count(*) as jml from peringatan where id_pegawai='$id' and month(tgl_peringatan)=$n");
			if ($qry->num_rows() > 0) {
				$row = $qry->row();
				echo json_encode(array('message' => $row->jml));
			} else {
				echo json_encode(array('message' => 0));
			}
		} else {
			echo json_encode(array('message' => 0));
		}
	}
}
// END Peringatan Class
/* End of file peringatan.php */
/* Location: ./sytem/application/controlers/peringatan.php */
