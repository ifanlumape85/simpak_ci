<?php
class Router1 extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Router1_model', 'router1', TRUE);
		$this->load->model('Instansi_model', 'instansi', TRUE);
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
			'title' 	=> 'Data Router', 
			'main_view' => 'router1/router1', 
			'form_view' => 'router1/router1_form',
			);

			$instansis = $this->instansi->get_list_instansi();		
			$opt_instansi = array('' => 'All Instansi');
		    foreach ($instansis as $i => $v) {
		        $opt_instansi[$i] = $v;
		    }

		    $data['form_instansi'] = form_dropdown('id_instansi',$opt_instansi,'','id="id_instansi" class="form-control"');
			$data['form_instansi2'] = form_dropdown('id_instansi2',$opt_instansi,'','id="id_instansi2" class="form-control"');
				$data['options_instansi'] = $opt_instansi;
			$this->load->view('admin/template', $data);
		}
	}

	public function ajax_list()
	{
		$this->load->helper('url');
		$list = $this->router1->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $router1) {
			$no++;
			$row = array();

			$row[] = '<input type="checkbox" class="data-check" value="'.$router1->id_router1.'">';
			$row[] = $no;
			$row[] = $router1->nama_router1; 
			$row[] = $router1->ip_address; 
			$row[] = $router1->mac_address; 
			$row[] = $router1->nama_instansi; 
			
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_router1('."'".$router1->id_router1."'".')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah</a>
				  <a class="btn btn-sm btn-danger btn-flat" href="javascript:void(0)" title="Hapus" onclick="delete_router1('."'".$router1->id_router1."'".')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a>';
		
			$data[] = $row;
		}

		$output = array(
		"draw" 				=> $_POST['draw'],
		"recordsTotal" 		=> $this->router1->count_all(),
		"recordsFiltered" 	=> $this->router1->count_filtered(),
		"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->router1->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
	
		
		$data = array(
		'nama_router1'=> $this->input->post('nama_router1', TRUE),
		'ip_address'=> $this->input->post('ip_address', TRUE),
		'mac_address'=> $this->input->post('mac_address', TRUE),
		'id_instansi'=> $this->input->post('id_instansi', TRUE),
		);
		$insert = $this->router1->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		
		$data = array(
		'nama_router1'=> $this->input->post('nama_router1', TRUE),
		'ip_address'=> $this->input->post('ip_address', TRUE),
		'mac_address'=> $this->input->post('mac_address', TRUE),
		'id_instansi'=> $this->input->post('id_instansi', TRUE),
		);
		$this->router1->update(array('id_router1' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		if ($this->input->post('id', TRUE)!="")
			$id = $this->input->post('id', TRUE);

		$this->router1->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->router1->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		

		if ($this->input->post('nama_router1')=='')
		{
			$data['inputerror'][] = 'nama_router1';
			$data['error_string'][] = 'Nama Router1 is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('ip_address')=='')
		{
			$data['inputerror'][] = 'ip_address';
			$data['error_string'][] = 'Ip Address is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('mac_address')=='')
		{
			$data['inputerror'][] = 'mac_address';
			$data['error_string'][] = 'Mac Address is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('id_instansi')=='')
		{
			$data['inputerror'][] = 'id_instansi';
			$data['error_string'][] = 'Instansi is required';
			$data['status'] = FALSE;							
		}
		

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}
// END Router1 Class
/* End of file router1.php */
/* Location: ./sytem/application/controlers/router1.php */		
  