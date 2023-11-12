
<?php
class Jadwal_presensi extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Jadwal_presensi_model', 'jadwal_presensi', TRUE);

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
			'title' 	=> 'Data Jadwal presensi', 
			'main_view' => 'jadwal_presensi/jadwal_presensi', 
			'form_view' => 'jadwal_presensi/jadwal_presensi_form',
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
		$list = $this->jadwal_presensi->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $jadwal_presensi) {
			$no++;
			$row = array();

			$row[] = '<input type="checkbox" class="data-check" value="'.$jadwal_presensi->id_jadwal_presensi.'">';
			$row[] = $no;
			$row[] = $jadwal_presensi->nama_jenis_presensi; 
			$row[] = tgl_indonesia2($jadwal_presensi->tgl_presensi); 
			$row[] = $jadwal_presensi->mulai; 
			$row[] = $jadwal_presensi->akhir; 
			
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_jadwal_presensi('."'".$jadwal_presensi->id_jadwal_presensi."'".')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah</a>
				  <a class="btn btn-sm btn-danger btn-flat" href="javascript:void(0)" title="Hapus" onclick="delete_jadwal_presensi('."'".$jadwal_presensi->id_jadwal_presensi."'".')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a>';
		
			$data[] = $row;
		}

		$output = array(
		"draw" 				=> $_POST['draw'],
		"recordsTotal" 		=> $this->jadwal_presensi->count_all(),
		"recordsFiltered" 	=> $this->jadwal_presensi->count_filtered(),
		"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->jadwal_presensi->get_by_id($id);
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
		$insert = $this->jadwal_presensi->save($data);
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
		$this->jadwal_presensi->update(array('id_jadwal_presensi' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		if ($this->input->post('id', TRUE)!="")
			$id = $this->input->post('id', TRUE);

		$this->jadwal_presensi->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->jadwal_presensi->delete_by_id($id);
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
// END Jadwal_presensi Class
/* End of file jadwal_presensi.php */
/* Location: ./sytem/application/controlers/jadwal_presensi.php */		
  