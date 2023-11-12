
<?php
class Status_pegawai extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Status_pegawai_model', 'status_pegawai', TRUE);

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
			'title' 	=> 'Data Status pegawai', 
			'main_view' => 'status_pegawai/status_pegawai', 
			'form_view' => 'status_pegawai/status_pegawai_form',
			);

			$this->load->view('admin/template', $data);
		}
	}

	public function ajax_list()
	{
		$this->load->helper('url');
		$list = $this->status_pegawai->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $status_pegawai) {
			$no++;
			$row = array();

			$row[] = '<input type="checkbox" class="data-check" value="'.$status_pegawai->id_status_pegawai.'">';
			$row[] = $no;
			$row[] = $status_pegawai->nama_status_pegawai; 
			
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_status_pegawai('."'".$status_pegawai->id_status_pegawai."'".')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah</a>
				  <a class="btn btn-sm btn-danger btn-flat" href="javascript:void(0)" title="Hapus" onclick="delete_status_pegawai('."'".$status_pegawai->id_status_pegawai."'".')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a>';
		
			$data[] = $row;
		}

		$output = array(
		"draw" 				=> $_POST['draw'],
		"recordsTotal" 		=> $this->status_pegawai->count_all(),
		"recordsFiltered" 	=> $this->status_pegawai->count_filtered(),
		"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->status_pegawai->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
	
		
		$data = array(
		'nama_status_pegawai'=> $this->input->post('nama_status_pegawai', TRUE),
		);
		$insert = $this->status_pegawai->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		
		$data = array(
		'nama_status_pegawai'=> $this->input->post('nama_status_pegawai', TRUE),
		);
		$this->status_pegawai->update(array('id_status_pegawai' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		if ($this->input->post('id', TRUE)!="")
			$id = $this->input->post('id', TRUE);

		$this->status_pegawai->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->status_pegawai->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		

		if ($this->input->post('nama_status_pegawai')=='')
		{
			$data['inputerror'][] = 'nama_status_pegawai';
			$data['error_string'][] = 'Nama Status Pegawai  is required';
			$data['status'] = FALSE;							
		}
		

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}
// END Status_pegawai Class
/* End of file status_pegawai.php */
/* Location: ./sytem/application/controlers/status_pegawai.php */		
  