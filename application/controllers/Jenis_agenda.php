
<?php
class Jenis_agenda extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Jenis_agenda_model', 'jenis_agenda', TRUE);

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
			'title' 	=> 'Data Jenis agenda', 
			'main_view' => 'jenis_agenda/jenis_agenda', 
			'form_view' => 'jenis_agenda/jenis_agenda_form',
			);

			$this->load->view('admin/template', $data);
		}
	}

	public function ajax_list()
	{
		$this->load->helper('url');
		$list = $this->jenis_agenda->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $jenis_agenda) {
			$no++;
			$row = array();

			$row[] = '<input type="checkbox" class="data-check" value="'.$jenis_agenda->id_jenis_agenda.'">';
			$row[] = $no;
			$row[] = $jenis_agenda->nama_jenis_agenda; 
			
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_jenis_agenda('."'".$jenis_agenda->id_jenis_agenda."'".')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah</a>
				  <a class="btn btn-sm btn-danger btn-flat" href="javascript:void(0)" title="Hapus" onclick="delete_jenis_agenda('."'".$jenis_agenda->id_jenis_agenda."'".')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a>';
		
			$data[] = $row;
		}

		$output = array(
		"draw" 				=> $_POST['draw'],
		"recordsTotal" 		=> $this->jenis_agenda->count_all(),
		"recordsFiltered" 	=> $this->jenis_agenda->count_filtered(),
		"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->jenis_agenda->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
	
		
		$data = array(
		'nama_jenis_agenda'=> $this->input->post('nama_jenis_agenda', TRUE),
		);
		$insert = $this->jenis_agenda->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		
		$data = array(
		'nama_jenis_agenda'=> $this->input->post('nama_jenis_agenda', TRUE),
		);
		$this->jenis_agenda->update(array('id_jenis_agenda' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		if ($this->input->post('id', TRUE)!="")
			$id = $this->input->post('id', TRUE);

		$this->jenis_agenda->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->jenis_agenda->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		

		if ($this->input->post('nama_jenis_agenda')=='')
		{
			$data['inputerror'][] = 'nama_jenis_agenda';
			$data['error_string'][] = 'Nama Jenis Agenda  is required';
			$data['status'] = FALSE;							
		}
		

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}
// END Jenis_agenda Class
/* End of file jenis_agenda.php */
/* Location: ./sytem/application/controlers/jenis_agenda.php */		
  