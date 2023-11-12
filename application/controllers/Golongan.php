
<?php
class Golongan extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Golongan_model', 'golongan', TRUE);

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
			'title' 	=> 'Data Golongan', 
			'main_view' => 'golongan/golongan', 
			'form_view' => 'golongan/golongan_form',
			);

			$this->load->view('admin/template', $data);
		}
	}

	public function ajax_list()
	{
		$this->load->helper('url');
		$list = $this->golongan->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $golongan) {
			$no++;
			$row = array();

			$row[] = '<input type="checkbox" class="data-check" value="'.$golongan->id_golongan.'">';
			$row[] = $no;
			$row[] = $golongan->nama_golongan; 
			
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_golongan('."'".$golongan->id_golongan."'".')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah</a>
				  <a class="btn btn-sm btn-danger btn-flat" href="javascript:void(0)" title="Hapus" onclick="delete_golongan('."'".$golongan->id_golongan."'".')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a>';
		
			$data[] = $row;
		}

		$output = array(
		"draw" 				=> $_POST['draw'],
		"recordsTotal" 		=> $this->golongan->count_all(),
		"recordsFiltered" 	=> $this->golongan->count_filtered(),
		"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->golongan->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
	
		
		$data = array(
		'nama_golongan'=> $this->input->post('nama_golongan', TRUE),
		);
		$insert = $this->golongan->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		
		$data = array(
		'nama_golongan'=> $this->input->post('nama_golongan', TRUE),
		);
		$this->golongan->update(array('id_golongan' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		if ($this->input->post('id', TRUE)!="")
			$id = $this->input->post('id', TRUE);

		$this->golongan->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->golongan->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		

		if ($this->input->post('nama_golongan')=='')
		{
			$data['inputerror'][] = 'nama_golongan';
			$data['error_string'][] = 'Nama Golongan is required';
			$data['status'] = FALSE;							
		}
		

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}
// END Golongan Class
/* End of file golongan.php */
/* Location: ./sytem/application/controlers/golongan.php */		
  