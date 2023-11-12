<?php
class Jabatan extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Jabatan_model', 'jabatan', TRUE);

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
			'main_view' => 'jabatan/jabatan', 
			'form_view' => 'jabatan/jabatan_form',
			);

			$this->load->view('admin/template', $data);
		}
	}

	public function ajax_list()
	{
		$this->load->helper('url');
		$list = $this->jabatan->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $jabatan) {
			$no++;
			$row = array();

			$row[] = '<input type="checkbox" class="data-check" value="'.$jabatan->id_jabatan.'">';
			$row[] = $no;
			$row[] = $jabatan->nama_jabatan; 
			$row[] = $jabatan->urutan; 
			
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_jabatan('."'".$jabatan->id_jabatan."'".')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah</a>
				  <a class="btn btn-sm btn-danger btn-flat" href="javascript:void(0)" title="Hapus" onclick="delete_jabatan('."'".$jabatan->id_jabatan."'".')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a>';
		
			$data[] = $row;
		}

		$output = array(
		"draw" 				=> $_POST['draw'],
		"recordsTotal" 		=> $this->jabatan->count_all(),
		"recordsFiltered" 	=> $this->jabatan->count_filtered(),
		"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->jabatan->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
	
		
		$data = array(
		'nama_jabatan'=> $this->input->post('nama_jabatan', TRUE),
		'urutan'=> $this->input->post('urutan', TRUE),
		);
		$insert = $this->jabatan->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		
		$data = array(
		'nama_jabatan'=> $this->input->post('nama_jabatan', TRUE),
		'urutan'=> $this->input->post('urutan', TRUE),
		);
		$this->jabatan->update(array('id_jabatan' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		if ($this->input->post('id', TRUE)!="")
			$id = $this->input->post('id', TRUE);

		$this->jabatan->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->jabatan->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		

		if ($this->input->post('nama_jabatan')=='')
		{
			$data['inputerror'][] = 'nama_jabatan';
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
// END Jabatan Class
/* End of file jabatan.php */
/* Location: ./sytem/application/controlers/jabatan.php */		
  