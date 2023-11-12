<?php
class Pegawai extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Pegawai_model', 'pegawai', TRUE);
		$this->load->model('Status_pegawai_model', 'status_pegawai', TRUE);
		$this->load->model('Instansi_model', 'instansi', TRUE);
		$this->load->model('Jabatan_model', 'jabatan', TRUE);
		$this->load->model('Pangkat_model', 'pangkat', TRUE);
		$this->load->model('Golongan_model', 'golongan', TRUE);
	}

	function index()
	{
		if ($this->session->userdata('login') != TRUE) {
			redirect('login');
		} else {
			$this->load->helper('url');
			$data = array(
				'title' 	=> 'Data Pegawai',
				'main_view' => 'pegawai/pegawai',
				'form_view' => 'pegawai/pegawai_form',
			);

			$pangkats = $this->pangkat->get_list_pangkat();
			$opt_pangkat = array('' => 'All pangkat');
			foreach ($pangkats as $i => $v) {
				$opt_pangkat[$i] = $v;
			}

			$data['form_pangkat'] = form_dropdown('id_pangkat', $opt_pangkat, '', 'id="id_pangkat" class="form-control"');
			$data['form_pangkat2'] = form_dropdown('id_pangkat2', $opt_pangkat, '', 'id="id_pangkat2" class="form-control"');
			$data['options_pangkat'] = $opt_pangkat;

			$jabatans = $this->jabatan->get_list_jabatan();
			$opt_jabatan = array('' => 'All jabatan');
			foreach ($jabatans as $i => $v) {
				$opt_jabatan[$i] = $v;
			}

			$data['form_jabatan'] = form_dropdown('id_jabatan', $opt_jabatan, '', 'id="id_jabatan" class="form-control"');
			$data['form_jabatan2'] = form_dropdown('id_jabatan2', $opt_jabatan, '', 'id="id_jabatan2" class="form-control"');
			$data['options_jabatan'] = $opt_jabatan;

			$golongans = $this->golongan->get_list_golongan();
			$opt_golongan = array('' => 'Pilih golongan');
			foreach ($golongans as $i => $v) {
				$opt_golongan[$i] = $v;
			}

			$data['form_golongan'] = form_dropdown('id_golongan', $opt_golongan, '', 'id="id_golongan" class="form-control"');
			$data['form_golongan2'] = form_dropdown('id_golongan2', $opt_golongan, '', 'id="id_golongan2" class="form-control"');
			$data['options_golongan'] = $opt_golongan;

			$status_pegawais = $this->status_pegawai->get_list_status_pegawai();
			$opt_status_pegawai = array('' => 'Pilih Status Pegawai ');
			foreach ($status_pegawais as $i => $v) {
				$opt_status_pegawai[$i] = $v;
			}

			$data['form_status_pegawai'] = form_dropdown('id_status_pegawai', $opt_status_pegawai, '', 'id="id_status_pegawai" class="form-control"');
			$data['form_status_pegawai2'] = form_dropdown('id_status_pegawai2', $opt_status_pegawai, '', 'id="id_status_pegawai2" class="form-control"');
			$data['options_status_pegawai'] = $opt_status_pegawai;

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

	public function ajax_list()
	{
		$this->load->helper('url');
		$list = $this->pegawai->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pegawai) {
			$no++;
			$row = array();

			$row[] = '<input type="checkbox" class="data-check" value="' . $pegawai->id_pegawai . '">';
			$row[] = $no;
			$row[] = $pegawai->nama_instansi;
			$row[] = $pegawai->nama_pegawai . '<br />' . $pegawai->nip;
			$row[] = $pegawai->nama_jabatan . ' ' . $pegawai->nama_pangkat . ' ' . $pegawai->nama_golongan;
			$row[] = $pegawai->nama_status_pegawai;
			$row[] = $pegawai->aktif;

			if ($pegawai->photo)
				$row[] = '<a href="' . base_url('upload/pegawai/thumbs/' . $pegawai->photo) . '" target="_blank"><img src="' . base_url('upload/pegawai/thumbs/' . $pegawai->photo) . '" class="img-responsive" /></a>';
			else
				$row[] = '(No photo)';
			//add html for action

			if ($this->session->userdata('user_level_id') == 1) {
				$row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_pegawai(' . "'" . $pegawai->id_pegawai . "'" . ')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah</a>
				  <a class="btn btn-sm btn-danger btn-flat" href="javascript:void(0)" title="Hapus" onclick="delete_pegawai(' . "'" . $pegawai->id_pegawai . "'" . ')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a>';
			} else {
				$row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_pegawai(' . "'" . $pegawai->id_pegawai . "'" . ')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah</a>';
			}

			$data[] = $row;
		}

		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->pegawai->count_all(),
			"recordsFiltered" 	=> $this->pegawai->count_filtered(),
			"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->pegawai->get_by_id($id);
		$data->tgl_lahir = ($data->tgl_lahir == '00-00-0000') ? '' : date('d-m-Y', strtotime($data->tgl_lahir)); // if 0000-00-00 set tu empty for datepicker compatibility

		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();


		$data = array(
			'nip' => $this->input->post('nip', TRUE),
			'nama_pegawai' => $this->input->post('nama_pegawai', TRUE),
			'tempat_lahir' => $this->input->post('tempat_lahir', TRUE),
			'tgl_lahir' => date('Y-m-d', strtotime($this->input->post('tgl_lahir', TRUE))),
			'no_telp' => $this->input->post('no_telp', TRUE),
			'id_status_pegawai' => $this->input->post('id_status_pegawai', TRUE),
			'id_instansi' => $this->input->post('id_instansi', TRUE),
			'id_pangkat' => $this->input->post('id_pangkat', TRUE),
			'id_golongan' => $this->input->post('id_golongan', TRUE),
			'id_jabatan' => $this->input->post('id_jabatan', TRUE),
			'aktif' => $this->input->post('aktif', TRUE),
			'jenis_kelamin' => $this->input->post('jenis_kelamin', TRUE),
		);
		if ($this->input->post('password')) {
			$data['password'] = md5($this->input->post('password', TRUE));
		}

		if (!empty($_FILES['photo']['name'])) {
			$upload = $this->_do_upload();
			$data['photo'] = $upload;
		}
		$insert = $this->pegawai->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();

		$data = array(
			'nip' => $this->input->post('nip', TRUE),
			'nama_pegawai' => $this->input->post('nama_pegawai', TRUE),
			'tempat_lahir' => $this->input->post('tempat_lahir', TRUE),
			'tgl_lahir' => date('Y-m-d', strtotime($this->input->post('tgl_lahir', TRUE))),
			'no_telp' => $this->input->post('no_telp', TRUE),
			'id_status_pegawai' => $this->input->post('id_status_pegawai', TRUE),
			'id_instansi' => $this->input->post('id_instansi', TRUE),
			'id_pangkat' => $this->input->post('id_pangkat', TRUE),
			'id_golongan' => $this->input->post('id_golongan', TRUE),
			'id_jabatan' => $this->input->post('id_jabatan', TRUE),
			'aktif' => $this->input->post('aktif', TRUE),
			'jenis_kelamin' => $this->input->post('jenis_kelamin', TRUE),
		);
		if ($this->input->post('password')) {
			$data['password'] = md5($this->input->post('password', TRUE));
		}


		if ($this->input->post('remove_photo')) // if remove photo checked
		{
			if (file_exists('upload/pegawai/' . $this->input->post('remove_photo')) && $this->input->post('remove_photo')) {
				unlink('upload/pegawai/' . $this->input->post('remove_photo'));
				unlink('upload/pegawai/thumbs/' . $this->input->post('remove_photo'));
			}
			$data['photo'] = '';
		}

		if (!empty($_FILES['photo']['name'])) {
			$upload = $this->_do_upload();

			//delete file
			$pegawai = $this->pegawai->get_by_id($this->input->post('id'));
			if (file_exists('upload/pegawai/' . $pegawai->photo) && $pegawai->photo) {
				unlink('upload/pegawai/' . $pegawai->photo);
				unlink('upload/pegawai/thumbs/' . $pegawai->photo);
			}

			$data['photo'] = $upload;
		}
		$this->pegawai->update(array('id_pegawai' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	function logout()
	{
		$id_pegawai = $this->input->post('id', TRUE);

		$validate = array();
		if ($id_pegawai == "") $validate[] = 'Empty Pegawai';

		$jml_validate = count($validate);
		if ($jml_validate < 1) {
			$ubah_passwrod = $this->db->query("update user set user_aktif='0' where id_pegawai='$id_pegawai'");
			print(json_encode(array("code" => 1, "message" => "Logout Berhasil.")));
		} else {
			print(json_encode(array("code" => 0, "message" => "Gagal Logout.")));
		}
	}

	function upload_photo()
	{
		$id = $this->input->post('id', TRUE);
		$photo = $this->input->post('photo', TRUE);

		if ($photo != null) {
			if ($id != "") {
				$qry = $this->db->query("update pegawai set photo='" . $id . ".jpeg' where id_pegawai='$id'");
				$path = "upload/pegawai/thumbs/$id.jpeg";
				@file_put_contents($path, base64_decode($photo));
				print(json_encode(array('code' => 1, 'message' => 'Photo berhasil diupload.')));
			} else {
				print(json_encode(array('code' => 2, 'message' => 'ID tidak ditemukan.')));
			}
		} else {
			print(json_encode(array('code' => 2, 'message' => 'Photo kosong.')));
		}
	}

	public function android_update()
	{
		$error = array();
		if ($this->input->post('nip') == null)
			$error[] = '';
		if ($this->input->post('nama_pegawai') == null)
			$error[] = '';
		if ($this->input->post('tempat_lahir') == null)
			$error[] = '';
		if ($this->input->post('tgl_lahir') == null)
			$error[] = '';
		if ($this->input->post('no_telp') == null)
			$error[] = '';
		// if ($this->input->post('jenis_kelamin') == null)
		// 	$error[] = '';

		if (count($error) == 0) {
			$data = array(
				'nip' => $this->input->post('nip', TRUE),
				'nama_pegawai' => $this->input->post('nama_pegawai', TRUE),
				'tempat_lahir' => $this->input->post('tempat_lahir', TRUE),
				'tgl_lahir' => date('Y-m-d', strtotime($this->input->post('tgl_lahir', TRUE))),
				'no_telp' => $this->input->post('no_telp', TRUE)
				// 'jenis_kelamin' => $this->input->post('jenis_kelamin', TRUE),
			);

			if ($this->pegawai->update(array('id_pegawai' => $this->input->post('id')), $data))
				echo json_encode(array("status" => TRUE, "code" => 1, "message" => "Update sukses"));
			else
				echo json_encode(array("status" => TRUE, "code" => 2, "message" => "Update gagal." . $this->input->post('id')));
		} else {
			echo json_encode(array("status" => TRUE, "code" => 2, "message" => "Update gagal, cek form isian."));
		}
	}

	public function ajax_delete($id)
	{
		if ($this->input->post('id', TRUE) != "")
			$id = $this->input->post('id', TRUE);

		$pegawai = $this->pegawai->get_by_id($id);
		if (file_exists('upload/pegawai/' . $pegawai->photo) && $pegawai->photo) {
			unlink('upload/pegawai/' . $pegawai->photo);
			unlink('upload/pegawai/thumbs/' . $pegawai->photo);
		}
		$this->pegawai->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_bulk_delete()
	{
		$list_id = $this->input->post('id');
		foreach ($list_id as $id) {
			$this->pegawai->delete_by_id($id);
		}
		echo json_encode(array("status" => TRUE));
	}
	private function _do_upload()
	{
		$config['upload_path']    = 'upload/pegawai/';
		$config['allowed_types']  = 'gif|jpg|png';
		$config['max_size']       = 1024; //set max size allowed in Kilobyte
		$config['max_width']      = 1000; // set max width image allowed
		$config['max_height']     = 1000; // set max height allowed
		$config['file_name']      = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('photo')) //upload and validate
		{
			$data['inputerror'][] = 'photo';
			$data['error_string'][] = 'Upload error: ' . $_FILES['photo']['type'] . ' ' . $this->upload->display_errors('', ''); //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		$file 		= $this->upload->data();
		$nama_file 	= $file['file_name'];


		$config = array(
			'source_image' 	=> $file['full_path'],
			'new_image' 		=> './upload/pegawai/thumbs/',
			'maintain_ration' => TRUE,
			'width' 			=> 110,
			'height' 			=> 82
		);

		$this->load->library('image_lib', $config);
		$this->image_lib->resize();

		return $nama_file;
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;


		if ($this->input->post('nip') == '') {
			$data['inputerror'][] = 'nip';
			$data['error_string'][] = 'Nip is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('nama_pegawai') == '') {
			$data['inputerror'][] = 'nama_pegawai';
			$data['error_string'][] = 'Nama Pegawai is required';
			$data['status'] = FALSE;
		}

		// if ($this->input->post('tempat_lahir')=='')
		// {
		// 	$data['inputerror'][] = 'tempat_lahir';
		// 	$data['error_string'][] = 'Tempat Lahir is required';
		// 	$data['status'] = FALSE;
		// }

		if ($this->input->post('tgl_lahir') == '') {
			$data['inputerror'][] = 'tgl_lahir';
			$data['error_string'][] = 'Tgl Lahir is required';
			$data['status'] = FALSE;
		}

		// if ($this->input->post('no_telp')=='')
		// {
		// 	$data['inputerror'][] = 'no_telp';
		// 	$data['error_string'][] = 'No Telp is required';
		// 	$data['status'] = FALSE;
		// }

		if ($this->input->post('id_status_pegawai') == '') {
			$data['inputerror'][] = 'id_status_pegawai';
			$data['error_string'][] = 'Status Pegawai  is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('id_instansi') == '') {
			$data['inputerror'][] = 'id_instansi';
			$data['error_string'][] = 'Instansi is required';
			$data['status'] = FALSE;
		}

		// if ($this->input->post('id_jabatan')=='')
		// {
		// 	$data['inputerror'][] = 'id_jabatan';
		// 	$data['error_string'][] = 'Jabatan is required';
		// 	$data['status'] = FALSE;
		// }

		if ($this->input->post('aktif') == '') {
			$data['inputerror'][] = 'aktif';
			$data['error_string'][] = 'Aktif is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('jenis_kelamin') == '') {
			$data['inputerror'][] = 'jenis_kelamin';
			$data['error_string'][] = 'Jenis Kelamin is required';
			$data['status'] = FALSE;
		}


		if ($data['status'] === FALSE) {
			echo json_encode($data);
			exit();
		}
	}

	function option_pegawai()
	{
		$sql = "select * from pegawai";
		if ($this->input->post('id_instansi', TRUE))
			$arr['id_instansi'] = $this->input->post('id_instansi', TRUE);
		if ($this->input->post('id_pegawai', TRUE))
			$arr['id_pegawai'] = $this->input->post('id_pegawai', TRUE);

		if (count($arr) > 0) {
			$i = 1;
			foreach ($arr as $key => $value) {
				if ($i == 1)
					$sql .= " where $key='$value' ";
				else
					$sql .= " and $key='$value'";

				$i++;
			}
		}

		$sql .= "order by nama_pegawai";

		$pegawais = $this->db->query($sql);
		$otpions = '<option value="">Pilih Pegawai</option>';
		if ($pegawais->num_rows() > 0) {
			foreach ($pegawais->result() as $pegawai) {
				$otpions .= '<option value="' . $pegawai->id_pegawai . '">' . trim($pegawai->nama_pegawai) . '</option>';
			}
		}
		echo $otpions;
	}

	function cek_pin()
	{
		$id = $this->input->post('id', TRUE);
		$pin = $this->input->post('pin', TRUE);
		$required = array();

		if ($id == "") $required['id'];
		if ($pin == "") $required['pin'];

		$jml_required = count($required);
		if ($jml_required < 1) {
			$qry = $this->db->query("select * from pegawai where id_pegawai='$id' and pin='" . md5($pin) . "'");
			if ($qry->num_rows() > 0) {
				print(json_encode(array("exists" => TRUE, "err_msg" => "")));
			} else {
				print(json_encode(array("exists" => FALSE, "err_msg" => "Data Not Found")));
			}
		} else {
			print(json_encode(array("exists" => FALSE, "err_msg" => "Required parameter Empty")));
		}
	}

	function list_pegawai_instansi()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : '';

		// $id=291;

		$sql = "
		SELECT
			pegawai.*,
			status_pegawai.nama_status_pegawai,
			instansi.nama_instansi,
			jabatan.nama_jabatan
		FROM
			pegawai
			LEFT JOIN status_pegawai ON pegawai.id_status_pegawai=status_pegawai.id_status_pegawai
			LEFT JOIN instansi on pegawai.id_instansi=instansi.id_instansi
			left join jabatan on pegawai.id_jabatan=jabatan.id_jabatan
		";
		if ($id != "") {
			$sql .= " WHERE pegawai.id_instansi='$id'";
		}

		$sql .= " ORDER BY pegawai.id_pegawai desc ";

		$qry = $this->db->query($sql);
		if ($qry->num_rows() > 0) {

			$pegawais = array();
			foreach ($qry->result() as $row) {
				array_push(
					$pegawais,
					array(
						"id" => $row->id_pegawai,
						"id_verifikator" => '',
						"nip" => $row->nip,
						"nama_pegawai" => $row->nama_pegawai,
						"tempat_lahir" => $row->tempat_lahir,
						"tgl_lahir" => $row->tgl_lahir,
						"no_telp" => $row->no_telp,
						"email" => $row->email,
						"id_status_pegawai" => $row->id_status_pegawai,
						"nama_status_pegawai" => $row->nama_status_pegawai,
						"id_instansi" => $row->id_instansi,
						"nama_instansi" => $row->nama_instansi,
						"id_jabatan" => $row->id_jabatan,
						"nama_jabatan" => $row->nama_jabatan,
						"pin" => $row->pin,
						"aktif" => $row->aktif,
						"jenis_kelamin" => $row->jenis_kelamin,
						"photo" => $row->photo
					)
				);
			}
			print(json_encode(array("code" => 1, "message" => "Success", "result" => $pegawais, "pegawais" => $pegawais)));
		} else {
			print(json_encode(array("code" => 0, "message" => "Data Not Found")));
		}
	}

	function list_pegawai()
	{
		$id = $_POST['id'];
		$query = $_POST['query'];
		$limit = $_POST['limit'];
		$start = $_POST['start'];

		// $id=291;
		// $query='';
		// $limit=5;
		// $start=0;

		$sql = "
		SELECT *
		FROM
			verifikator
			LEFT JOIN pegawai on verifikator.id_pegawai=pegawai.id_pegawai
			LEFT JOIN status_pegawai ON pegawai.id_status_pegawai=status_pegawai.id_status_pegawai
			LEFT JOIN instansi on pegawai.id_instansi=instansi.id_instansi
			left join jabatan on pegawai.id_jabatan=jabatan.id_jabatan
		WHERE
			verifikator.verifikator='$id'";

		if ($query != '') {
			$sql .= " AND pegawai.nip LIKE '%$query%' OR pegawai.nama_pegawai LIKE '%$query%' ";
		}

		$sql .= " ORDER BY pegawai.nama_pegawai ASC LIMIT $limit OFFSET $start ";

		$qry = $this->db->query($sql);
		if ($qry->num_rows() > 0) {

			$pegawais = array();
			foreach ($qry->result() as $row) {
				array_push(
					$pegawais,
					array(
						"id" => $row->id_pegawai,
						"id_verifikator" => $row->id_verifikator,
						"nip" => $row->nip,
						"nama_pegawai" => $row->nama_pegawai,
						"tempat_lahir" => $row->tempat_lahir,
						"tgl_lahir" => $row->tgl_lahir,
						"no_telp" => $row->no_telp,
						"email" => $row->email,
						"id_status_pegawai" => $row->id_status_pegawai,
						"nama_status_pegawai" => $this->status_pegawai->get_nama_status_pegawai($row->id_status_pegawai),
						"id_instansi" => $row->id_instansi,
						"nama_instansi" => $this->instansi->get_nama_instansi($row->id_instansi),
						"id_jabatan" => $row->id_jabatan,
						"nama_jabatan" => $this->jabatan->get_nama_jabatan($row->id_jabatan),
						"pin" => $row->pin,
						"aktif" => $row->aktif,
						"jenis_kelamin" => $row->jenis_kelamin,
						"photo" => $row->photo
					)
				);
			}
			print(json_encode(array("code" => 1, "message" => "Success", "result" => $pegawais)));
		} else {
			print(json_encode(array("code" => 0, "message" => "Data Not Found")));
		}
	}

	function ubah_pin()
	{
		$id_pegawai = $this->input->post('id', TRUE);
		$pin_lama = $this->input->post('pin_lama', TRUE);
		$pin_baru = $this->input->post('pin_baru', TRUE);

		$validate = array();
		if ($pin_lama == "") $validate[] = 'Masukkan PIN lama';
		if ($pin_baru == "") $validate[] = 'Masukkan PIN baru';

		$jml_validate = count($validate);
		if ($jml_validate < 1) {
			$cek = $this->db->query("select * from pegawai where id_pegawai='$id_pegawai' and pin='" . md5($pin_lama) . "'");
			if ($cek->num_rows() == 1) {
				$ubah_passwrod = $this->db->query("update pegawai set pin='" . md5($pin_baru) . "' where id_pegawai='$id_pegawai'");
				print(json_encode(array("code" => 1, "message" => "PIN Berhasil Diubah.")));
			} else {
				print(json_encode(array("code" => 0, "message" => "PIN Salah.")));
			}
		} else {
			print(json_encode(array("code" => 0, "message" => "PIN Lama atau Baru masih kosong.")));
		}
	}

	function generate_akses()
	{
		$pegawais = $this->db->query("select * from pegawai where id_instansi=16");
		$jml_pegawai = $pegawais->num_rows();
		$sql = "insert into user (user_full_name, user_name, user_password, user_level_id, user_aktif, id_pegawai, user_date_entri) value ";
		$i = 1;

		$tampil = 'USERNAME PASSWORD<BR />	';
		foreach ($pegawais->result() as $pegawai) {
			$user_name = $pegawai->nip;
			$user_password = substr($pegawai->nip, 1, 8);
			$nama_pegawai = str_replace("'", "", ucwords(strtolower($pegawai->nama_pegawai)));
			if (trim($pegawai->nip) == "") {
				// explode(delimiter, string)
				$explod = explode(" ", trim($pegawai->nama_pegawai));
				$user_name = $this->replace_value(strtolower($explod[0])) . '.' . $this->replace_value(strtolower($explod[1]));
				$user_password = $this->replace_value(strtolower($explod[0])) . '12345';
			}

			if ($i == $jml_pegawai) {
				$sql .= "('" . $nama_pegawai . "', '" . $user_name . "', '" . md5($user_password) . "', 5, 1, '" . $pegawai->id_pegawai . "', '" . date('Y-m-d') . "')";
			} else {
				$sql .= "('" . $nama_pegawai . "', '" . $user_name . "', '" . md5($user_password) . "', 5, 1, '" . $pegawai->id_pegawai . "', '" . date('Y-m-d') . "'),";
			}

			$i++;

			$tampil .= $user_name . ' ' . $user_password . '<br />';
		}
		echo $tampil;
		// $this->db->query($sql);
	}

	function replace_value($value)
	{
		$fix = $value;
		$array = array("'", ",", ".");
		foreach ($array as $value) {
			$fix = str_replace($value, "", $fix);
		}

		return $fix;
	}

	function select_pegawai()
	{
		$id = $this->input->post('id', TRUE);
		$sql = "
        select
            user.*,
            status_pegawai.nama_status_pegawai,
            instansi.nama_instansi,
            verifikator.verifikator,
            pegawai.nip, pegawai.nama_pegawai, pegawai.tempat_lahir, pegawai.tgl_lahir, pegawai.no_telp, pegawai.id_status_pegawai, pegawai.id_instansi, pegawai.photo, pegawai.aktif
        from
            user
            left join pegawai on user.id_pegawai=pegawai.id_pegawai
            left join status_pegawai  on pegawai.id_status_pegawai=status_pegawai.id_status_pegawai
            left join instansi on pegawai.id_instansi=instansi.id_instansi
            left join verifikator on pegawai.id_pegawai=verifikator.id_pegawai
        where
            user.id_pegawai='$id'";

		$result = $this->db->query($sql);
		if ($result->num_rows() > 0) {
			$pegawais = array();
			foreach ($result->result() as $row) {
				array_push(
					$pegawais,
					array(
						"id"                => $row->id_pegawai,
						"nip"               => $row->nip,
						"nama_pegawai"      => $row->nama_pegawai,
						"tempat_lahir"      => $row->tempat_lahir,
						"tgl_lahir"         => $row->tgl_lahir,
						"no_telp"           => $row->no_telp,
						"id_status_pegawai" => $row->id_status_pegawai,
						"nama_status_pegawai" => $row->nama_status_pegawai,
						"id_instansi"       => $row->id_instansi,
						"nama_instansi"     => $row->nama_instansi,
						"id_verifikator"    => $row->verifikator,
						"password"          => $row->user_password,
						"aktif"             => $row->aktif,
						"jenis_kelamin"     => $row->jenis_kelamin,
						"photo"             => $row->photo
					)
				);
			}

			print(json_encode(array('code' => 1, 'message' => 'GET Data Successfully', "result" => $pegawais)));
		} else {
			print(json_encode(array(
				'code' => 2,
				'message' => 'Unable to Login. However Connection was successful'
			)));
		}
	}

	function set_user()
	{
		$pegawais = $this->db->query("select id_pegawai, nip, nama_pegawai from pegawai");
		foreach ($pegawais->result() as $pegawai) {
			echo "insert into user set user_full_name='" . trim($pegawai->nama_pegawai) . "', user_name='" . $pegawai->nip . "', user_password='" . md5(12345) . "', user_aktif=0, status='N', id_pegawai='" . $pegawai->id_pegawai . "', user_level_id=5;<br />";
		}
	}
}
// END Pegawai Class
/* End of file pegawai.php */
/* Location: ./sytem/application/controlers/pegawai.php */
