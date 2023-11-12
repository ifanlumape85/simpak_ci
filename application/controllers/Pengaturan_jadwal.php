
<?php
class Pengaturan_jadwal extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Pengaturan_jadwal_model', 'pengaturan_jadwal', TRUE);

		$this->load->model('Jenis_presensi_model', 'jenis_presensi', TRUE);
	}

	function index()
	{
		if ($this->session->userdata('login') != TRUE)
		{
		  redirect('login');
		}
		else
		{
		    $this->load->helper('url');
		    $data = array(
			'title' 	=> 'Data Pengaturan jadwal', 
			'main_view' => 'pengaturan_jadwal/pengaturan_jadwal', 
			'form_view' => 'pengaturan_jadwal/pengaturan_jadwal_form',
			);

			$jenis_presensis = $this->jenis_presensi->get_list_jenis_presensi();		
			$opt_jenis_presensi = array('' => 'All Jenis Presensi ');
		    foreach ($jenis_presensis as $i => $v) {
		        $opt_jenis_presensi[$i] = $v;
		    }

		    $data['form_jenis_presensi'] = form_dropdown('id_jenis_presensi',$opt_jenis_presensi,'','id="id_jenis_presensi" class="form-control"');
			$data['form_jenis_presensi2'] = form_dropdown('id_jenis_presensi2',$opt_jenis_presensi,'','id="id_jenis_presensi2" class="form-control"');
				$data['options_jenis_presensi'] = $opt_jenis_presensi;
			$this->load->view('admin/template', $data);
		}
	}

	public function ajax_list()
	{
		$this->load->helper('url');
		$list = $this->pengaturan_jadwal->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pengaturan_jadwal) {
			$no++;
			$row = array();

			$row[] = '<input type="checkbox" class="data-check" value="'.$pengaturan_jadwal->id_pengaturan_jadwal.'">';
			$row[] = $no;
			$row[] = $pengaturan_jadwal->nama_jenis_presensi; 
			$row[] = tgl_indonesia2($pengaturan_jadwal->tgl_presensi); 
			$row[] = $pengaturan_jadwal->mulai; 
			$row[] = $pengaturan_jadwal->akhir; 
			
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_pengaturan_jadwal('."'".$pengaturan_jadwal->id_pengaturan_jadwal."'".')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah</a>
				  <a class="btn btn-sm btn-danger btn-flat" href="javascript:void(0)" title="Hapus" onclick="delete_pengaturan_jadwal('."'".$pengaturan_jadwal->id_pengaturan_jadwal."'".')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a>';
		
			$data[] = $row;
		}

		$output = array(
		"draw" 				=> $_POST['draw'],
		"recordsTotal" 		=> $this->pengaturan_jadwal->count_all(),
		"recordsFiltered" 	=> $this->pengaturan_jadwal->count_filtered(),
		"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->pengaturan_jadwal->get_by_id($id);
		$data->tgl_presensi = ($data->tgl_presensi == '00-00-0000') ? '' : date('d-m-Y', strtotime($data->tgl_presensi)); // if 0000-00-00 set tu empty for datepicker compatibility				
						
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
	
		
		$data = array(
		'id_jenis_presensi'=> $this->input->post('id_jenis_presensi', TRUE),
		'tgl_presensi'=> date('Y-m-d', strtotime($this->input->post('tgl_presensi', TRUE))),
		'mulai'=> $this->input->post('mulai', TRUE),
		'akhir'=> $this->input->post('akhir', TRUE),
		);
		$insert = $this->pengaturan_jadwal->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		
		$data = array(
		'id_jenis_presensi'=> $this->input->post('id_jenis_presensi', TRUE),
		'tgl_presensi'=> date('Y-m-d', strtotime($this->input->post('tgl_presensi', TRUE))),
		'mulai'=> $this->input->post('mulai', TRUE),
		'akhir'=> $this->input->post('akhir', TRUE),
		);
		$this->pengaturan_jadwal->update(array('id_pengaturan_jadwal' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		if ($this->input->post('id', TRUE)!="")
			$id = $this->input->post('id', TRUE);

		$this->pengaturan_jadwal->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->pengaturan_jadwal->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		

		if ($this->input->post('id_jenis_presensi')=='')
		{
			$data['inputerror'][] = 'id_jenis_presensi';
			$data['error_string'][] = 'Jenis Presensi  is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('tgl_presensi')=='')
		{
			$data['inputerror'][] = 'tgl_presensi';
			$data['error_string'][] = 'Tgl Presensi is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('mulai')=='')
		{
			$data['inputerror'][] = 'mulai';
			$data['error_string'][] = 'Mulai is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('akhir')=='')
		{
			$data['inputerror'][] = 'akhir';
			$data['error_string'][] = 'Akhir is required';
			$data['status'] = FALSE;							
		}
		

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}
// END Pengaturan_jadwal Class
/* End of file pengaturan_jadwal.php */
/* Location: ./sytem/application/controlers/pengaturan_jadwal.php */		
  