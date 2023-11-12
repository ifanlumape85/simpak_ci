<?php
class Pangkat extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Pangkat_model', 'pangkat', TRUE);

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
			'title' 	=> 'Data Jabatan', 
			'main_view' => 'pangkat/pangkat', 
			'form_view' => 'pangkat/pangkat_form',
			);

			$this->load->view('admin/template', $data);
		}
	}

	public function ajax_list()
	{
		$this->load->helper('url');
		$list = $this->pangkat->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pangkat) {
			$no++;
			$row = array();

			$row[] = '<input type="checkbox" class="data-check" value="'.$pangkat->id_pangkat.'">';
			$row[] = $no;
			$row[] = $pangkat->nama_pangkat; 
			
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_pangkat('."'".$pangkat->id_pangkat."'".')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah</a>
				  <a class="btn btn-sm btn-danger btn-flat" href="javascript:void(0)" title="Hapus" onclick="delete_pangkat('."'".$pangkat->id_pangkat."'".')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a>';
		
			$data[] = $row;
		}

		$output = array(
		"draw" 				=> $_POST['draw'],
		"recordsTotal" 		=> $this->pangkat->count_all(),
		"recordsFiltered" 	=> $this->pangkat->count_filtered(),
		"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->pangkat->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
	
		
		$data = array(
		'nama_pangkat'=> $this->input->post('nama_pangkat', TRUE),
		);
		$insert = $this->pangkat->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		
		$data = array(
		'nama_pangkat'=> $this->input->post('nama_pangkat', TRUE),
		);
		$this->pangkat->update(array('id_pangkat' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		if ($this->input->post('id', TRUE)!="")
			$id = $this->input->post('id', TRUE);

		$this->pangkat->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->pangkat->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		

		if ($this->input->post('nama_pangkat')=='')
		{
			$data['inputerror'][] = 'nama_pangkat';
			$data['error_string'][] = 'Nama Jabatan is required';
			$data['status'] = FALSE;							
		}
		

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}
// END Pangkat Class
/* End of file pangkat.php */
/* Location: ./sytem/application/controlers/pangkat.php */		
  