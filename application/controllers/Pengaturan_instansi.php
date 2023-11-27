<?php
class Pengaturan_instansi extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Pengaturan_instansi_model', 'pengaturan_instansi', TRUE);

		$this->load->model('Instansi_model', 'instansi', TRUE);
		$this->load->model('Jenis_presensi_model', 'jenis_presensi', TRUE);
	}

	function index()
	{
		if ($this->session->userdata('login') != TRUE) {
			redirect('login');
		} else {
			$this->load->helper('url');
			$data = array(
				'title' 	=> 'Data Pengaturan instansi',
				'main_view' => 'pengaturan_instansi/pengaturan_instansi',
				'form_view' => 'pengaturan_instansi/pengaturan_instansi_form',
			);

			if ($this->session->userdata('user_level_id') > 1)
				$instansis = $this->instansi->get_list_instansi($this->session->userdata('instansi_id'));
			else
				$instansis = $this->instansi->get_list_instansi();

			$opt_instansi = array('' => 'All Instansi');
			foreach ($instansis as $i => $v) {
				$opt_instansi[$i] = $v;
			}

			$data['form_instansi'] = form_dropdown('id_instansi', $opt_instansi, '', 'id="id_instansi" class="form-control"');
			$data['form_instansi2'] = form_dropdown('id_instansi2', $opt_instansi, '', 'id="id_instansi2" class="form-control"');
			$data['options_instansi'] = $opt_instansi;
			$jenis_presensis = $this->jenis_presensi->get_list_jenis_presensi();
			$opt_jenis_presensi = array('' => 'All Jenis Presensi ');
			foreach ($jenis_presensis as $i => $v) {
				$opt_jenis_presensi[$i] = $v;
			}

			$data['form_jenis_presensi'] = form_dropdown('id_jenis_presensi', $opt_jenis_presensi, '', 'id="id_jenis_presensi" class="form-control"');
			$data['form_jenis_presensi2'] = form_dropdown('id_jenis_presensi2', $opt_jenis_presensi, '', 'id="id_jenis_presensi2" class="form-control"');
			$data['options_jenis_presensi'] = $opt_jenis_presensi;
			$this->load->view('admin/template', $data);
		}
	}

	public function ajax_list()
	{
		$this->load->helper('url');
		$list = $this->pengaturan_instansi->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pengaturan_instansi) {
			$no++;
			$row = array();

			$row[] = '<input type="checkbox" class="data-check" value="' . $pengaturan_instansi->id_pengaturan_instansi . '">';
			$row[] = $no;
			$row[] = $pengaturan_instansi->nama_instansi;
			$row[] = $pengaturan_instansi->nama_jenis_presensi;
			$row[] = $pengaturan_instansi->mulai;
			$row[] = $pengaturan_instansi->akhir;
			$row[] = tgl_indonesia2($pengaturan_instansi->tanggal);

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_pengaturan_instansi(' . "'" . $pengaturan_instansi->id_pengaturan_instansi . "'" . ')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah</a>
				  <a class="btn btn-sm btn-danger btn-flat" href="javascript:void(0)" title="Hapus" onclick="delete_pengaturan_instansi(' . "'" . $pengaturan_instansi->id_pengaturan_instansi . "'" . ')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a>';

			$data[] = $row;
		}

		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->pengaturan_instansi->count_all(),
			"recordsFiltered" 	=> $this->pengaturan_instansi->count_filtered(),
			"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->pengaturan_instansi->get_by_id($id);
		$data->tanggal = ($data->tanggal == '00-00-0000') ? '' : date('d-m-Y', strtotime($data->tanggal)); // if 0000-00-00 set tu empty for datepicker compatibility				

		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();


		$data = array(
			'id_instansi' => $this->input->post('id_instansi', TRUE),
			'id_jenis_presensi' => $this->input->post('id_jenis_presensi', TRUE),
			'mulai' => $this->input->post('mulai', TRUE),
			'akhir' => $this->input->post('akhir', TRUE),
			'tanggal' => date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
		);
		$insert = $this->pengaturan_instansi->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();

		$data = array(
			'id_instansi' => $this->input->post('id_instansi', TRUE),
			'id_jenis_presensi' => $this->input->post('id_jenis_presensi', TRUE),
			'mulai' => $this->input->post('mulai', TRUE),
			'akhir' => $this->input->post('akhir', TRUE),
			'tanggal' => date('Y-m-d', strtotime($this->input->post('tanggal', TRUE))),
		);
		$this->pengaturan_instansi->update(array('id_pengaturan_instansi' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		if ($this->input->post('id', TRUE) != "")
			$id = $this->input->post('id', TRUE);

		$this->pengaturan_instansi->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_bulk_delete()
	{
		$list_id = $this->input->post('id');
		foreach ($list_id as $id) {
			$this->pengaturan_instansi->delete_by_id($id);
		}
		echo json_encode(array("status" => TRUE));
	}
	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;


		if ($this->input->post('id_instansi') == '') {
			$data['inputerror'][] = 'id_instansi';
			$data['error_string'][] = 'Instansi is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('id_jenis_presensi') == '') {
			$data['inputerror'][] = 'id_jenis_presensi';
			$data['error_string'][] = 'Jenis Presensi  is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('mulai') == '') {
			$data['inputerror'][] = 'mulai';
			$data['error_string'][] = 'Mulai is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('akhir') == '') {
			$data['inputerror'][] = 'akhir';
			$data['error_string'][] = 'Akhir is required';
			$data['status'] = FALSE;
		}

		if ($this->input->post('tanggal') == '') {
			$data['inputerror'][] = 'tanggal';
			$data['error_string'][] = 'Tanggal is required';
			$data['status'] = FALSE;
		}


		if ($data['status'] === FALSE) {
			echo json_encode($data);
			exit();
		}
	}
}
// END Pengaturan_instansi Class
/* End of file pengaturan_instansi.php */
/* Location: ./sytem/application/controlers/pengaturan_instansi.php */
