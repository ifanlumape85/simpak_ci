<?php
class Verifikator extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Verifikator_model', 'verifikator', TRUE);
		$this->load->model('Instansi_model', 'instansi', TRUE);
		$this->load->model('Pegawai_model', 'pegawai', TRUE);
	}

	function index()
	{
		if ($this->session->userdata('login') != TRUE) {
			redirect('login');
		} else {
			$this->load->helper('url');
			$data = array(
				'title' 	=> 'Atasan Langsung',
				'main_view' => 'verifikator/verifikator',
				'form_view' => 'verifikator/verifikator_form',
			);

			$instansis = $this->instansi->get_list_instansi();
			$opt_instansi = array('' => 'Semua Instansi');
			foreach ($instansis as $i => $v) {
				$opt_instansi[$i] = $v;
			}

			$data['form_instansi'] = form_dropdown('id_instansi', $opt_instansi, '', 'id="id_instansi" class="form-control"');
			$data['form_instansi2'] = form_dropdown('id_instansi2', $opt_instansi, '', 'id="id_instansi2" class="form-control"');
			$data['options_instansi'] = $opt_instansi;

			$this->load->view('admin/template', $data);
		}
	}

	public function ajax_list()
	{
		$this->load->helper('url');
		$list = $this->verifikator->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $verifikator) {
			$no++;
			$row = array();

			$row[] = '<input type="checkbox" class="data-check" value="' . $verifikator->id_verifikator . '">';
			$row[] = $no;
			$row[] = $verifikator->nama_instansi;
			$row[] = $verifikator->nama_pegawai;
			$row[] = $this->pegawai->get_nama_pegawai($verifikator->verifikator);

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_verifikator(' . "'" . $verifikator->id_verifikator . "'" . ')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah</a>
				  <a class="btn btn-sm btn-danger btn-flat" href="javascript:void(0)" title="Hapus" onclick="delete_verifikator(' . "'" . $verifikator->id_verifikator . "'" . ')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a>';

			$data[] = $row;
		}

		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->verifikator->count_all(),
			"recordsFiltered" 	=> $this->verifikator->count_filtered(),
			"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->verifikator->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();


		$data = array(
			'id_pegawai' => $this->input->post('id_pegawai', TRUE),
			'verifikator' => $this->input->post('verifikator', TRUE),
		);
		$insert = $this->verifikator->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function android_add()
	{
		$error = array();
		if ($this->input->post('id_pegawai') == null)
			$error[] = '';
		if ($this->input->post('id_verifikator') == null)
			$error[] = '';


		if (count($error) == 0) {
			$id_pegawai = $this->input->post('id_pegawai', TRUE);
			$verifikator = $this->pegawai->get_id($this->input->post('id_verifikator', TRUE));
			$query = $this->db->query("select * from verifikator where id_pegawai='$id_pegawai'");

			if ($query->num_rows() > 0) {
				echo json_encode(array("status" => FALSE, "code" => 2, "message" => "Proses insert gagal. Data sudah ada.", "id" => ""));
			} else {
				$data = array(
					'id_pegawai' => $this->input->post('id_pegawai', TRUE),
					'verifikator' => $verifikator,
				);

				if ($insert = $this->verifikator->save($data))
					echo json_encode(array("status" => TRUE, "code" => 1, "message" => "Sukses", "id" => $verifikator));
				else
					echo json_encode(array("status" => FALSE, "code" => 2, "message" => "Proses insert gagal", "id" => ""));
			}
		} else {
			echo json_encode(array("status" => FALSE, "code" => 2, "message" => "Lengkapi form isian."));
		}
	}

	public function ajax_update()
	{
		$this->_validate();

		$data = array(
			'id_pegawai' => $this->input->post('id_pegawai', TRUE),
			'verifikator' => $this->input->post('verifikator', TRUE),
		);
		$this->verifikator->update(array('id_verifikator' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function android_update()
	{
		$error = array();
		if ($this->input->post('id_verifikator') == null)
			$error[] = '';

		if (count($error) == 0) {
			$verifikator = $this->pegawai->get_id($this->input->post('id_verifikator', TRUE));
			$data = array(
				'verifikator' => $verifikator,
			);

			$this->verifikator->update(array('id_pegawai' => $this->input->post('id')), $data);
			echo json_encode(array("status" => TRUE, "code" => 1, "message" => "Atasan Langsung berhasil diupdate", "id" => $verifikator));
		} else {
			echo json_encode(array("status" => FALSE, "code" => 2, "message" => "Lengkapi form isian."));
		}
	}

	public function ajax_delete($id = "")
	{
		if ($this->input->post('id', TRUE) != "")
			$id = $this->input->post('id', TRUE);

		$this->verifikator->delete_by_id($id);
		echo json_encode(array("status" => TRUE, "code" => 1, "message" => "Success"));
	}

	public function ajax_bulk_delete()
	{
		$list_id = $this->input->post('id');
		foreach ($list_id as $id) {
			$this->verifikator->delete_by_id($id);
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

		if ($this->input->post('verifikator') == '') {
			$data['inputerror'][] = 'verifikator';
			$data['error_string'][] = 'Verifikator is required';
			$data['status'] = FALSE;
		}


		if ($data['status'] === FALSE) {
			echo json_encode($data);
			exit();
		}
	}

	function option_pegawai()
	{
		$id_verifikator = $this->input->post('id_verifikator', TRUE);

		$verifikators = $this->db->query("select verifikator.*, pegawai.nip, pegawai.nama_pegawai from verifikator left join pegawai on verifikator.id_pegawai=pegawai.id_pegawai where verifikator.verifikator='$id_verifikator'");

		$otpions = '<option value="">Pilih Pegawai</option>';
		if ($verifikators->num_rows() > 0) {
			foreach ($verifikators->result() as $verifikator) {
				$otpions .= '<option value="' . $verifikator->id_pegawai . '">' . $verifikator->nama_pegawai . '</option>';
			}
		}
		echo $otpions;
	}

	function option_verifikator2()
	{
		$id_pegawai = $this->input->post('id_pegawai', TRUE);
		$verifikators = $this->db->query("
			select verifikator.*, 
			pegawai.nip, 
			pegawai.nama_pegawai 
		from 
			verifikator 
			left join pegawai on verifikator.verifikator=pegawai.id_pegawai 
		where 
			verifikator.id_pegawai='$id_pegawai'");

		$otpions = '<option value="">Pilih Atasan Langsung</option>';
		if ($verifikators->num_rows() > 0) {
			foreach ($verifikators->result() as $verifikator) {
				$otpions .= '<option value="' . $verifikator->verifikator . '">' . $verifikator->nama_pegawai . '</option>';
			}
		}
		echo $otpions;
	}


	function option_instansi_verifikator()
	{
		$id_instansi = $this->input->post('id_instansi', TRUE);
		$verifikators = $this->db->query("select verifikator.*, pegawai.nip, pegawai.nama_pegawai, pegawai.id_instansi from verifikator left join pegawai on verifikator.verifikator=pegawai.id_pegawai where pegawai.id_instansi='$id_instansi'");

		$otpions = '<option value="">Verifikator</option>';
		if ($verifikators->num_rows() > 0) {
			foreach ($verifikators->result() as $verifikator) {
				$otpions .= '<option value="' . $verifikator->id_verifikator . '">' . $verifikator->nip . ' ' . $verifikator->nama_pegawai . '</option>';
			}
		}
		echo $otpions;
	}

	function get_verifikator($id = "")
	{
		if ($this->input->post('id', TRUE))
			$id = $this->input->post('id', TRUE);

		$qry = $this->db->query("select * from verifikator where id_pegawai='$id'");
		$id_verifikator = '';
		if ($qry->num_rows() > 0) {
			$row = $qry->row();
			$id_verifikator = $row->verifikator;
		}

		echo json_encode(array('id_verifikator' => $id_verifikator));
	}

	function verifikator_pegawai()
	{
		$id = $_POST['id'];
		$query = $_POST['query'];
		$limit = $_POST['limit'];
		$start = $_POST['start'];

		$sql = "SELECT verifikator.*, pegawai.nip, pegawai.nama_pegawai, pegawai.photo as photo_verifikator FROM verifikator LEFT JOIN pegawai ON verifikator.verifikator=pegawai.id_pegawai WHERE verifikator.id_pegawai='$id'";

		if ($query != '') {
			$sql .= " AND (pegawai.nip LIKE '%$query%' OR pegawai.nama_pegawai LIKE '%$query%') ";
		}

		$sql .= " ORDER BY pegawai.nama_pegawai DESC LIMIT $limit OFFSET $start ";

		$qry = $this->db->query($sql);
		if ($qry->num_rows() > 0) {

			$verifikators = array();
			foreach ($qry->result() as $row) {
				array_push(
					$verifikators,
					array(
						"id"                => $row->id_verifikator,
						"id_pegawai"        => $row->id_pegawai,
						"nama_pegawai"      => $this->pegawai->get_nama_pegawai($row->id_pegawai),
						"nip_pegawai"       => $this->pegawai->get_nip_pegawai($row->id_pegawai),
						"id_verifikator"    => $row->verifikator,
						"nama_verifikator"  => $row->nama_pegawai,
						"nip_verifikator"   => $row->nip,
						"photo"             => $row->photo_verifikator
					)
				);
			}
			print(json_encode(array("code" => 1, "message" => "Success", "result" => $verifikators, "atasan_langsungs" => $verifikators)));
		} else {
			print(json_encode(array("code" => 0, "message" => "Data tidak ditemukan")));
		}
	}

	function cek_verifikator()
	{
		$id_pegawai = $this->input->post('id', TRUE);
		$sql = $this->db->query("select * from verifikator where id_pegawai='$id_pegawai'");
		$response = array();
		if ($sql->num_rows() > 0) {
			$response['code'] = 0;
			$response['message'] = '';
			$response['exists'] = TRUE;
			$response['err_msg'] = '';
		} else {
			$response['code'] =  1;
			$response['message'] = 'Pilih Atasan Langsung anda.';
			$response['exists'] = FALSE;
			$response['err_msg'] = 'Atasan Langsung belum dipilih.';
		}

		echo json_encode($response);
	}

	function bawahan()
	{
		$id = $this->input->post('id', TRUE);

		$sql = "SELECT verifikator.*, pegawai.nama_pegawai FROM verifikator LEFT JOIN pegawai ON verifikator.id_pegawai=pegawai.id_pegawai WHERE verifikator.verifikator='$id'";

		$sql .= " ORDER BY pegawai.nama_pegawai ASC";

		$qry = $this->db->query($sql);
		if ($qry->num_rows() > 0) {

			$verifikators = array();
			foreach ($qry->result() as $row) {
				array_push(
					$verifikators,
					array(
						"id_pegawai"    => $row->id_pegawai,
						"nama_pegawai"  => $row->nama_pegawai,
					)
				);
			}
			print(json_encode(array("code" => 1, "message" => "Success", "result" => $verifikators, "pegawais" => $verifikators)));
		} else {
			print(json_encode(array("code" => 0, "message" => "Data tidak ditemukan")));
		}
	}
}
// END Verifikator Class
/* End of file verifikator.php */
/* Location: ./sytem/application/controlers/verifikator.php */
