<?php
class Mesin_absensi extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mesin_absensi_model', 'mesin_absensi', TRUE);
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
			'title' 	=> 'Data Mesin absensi', 
			'main_view' => 'mesin_absensi/mesin_absensi', 
			'form_view' => 'mesin_absensi/mesin_absensi_form',
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
		$list = $this->mesin_absensi->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $mesin_absensi) {
			$no++;
			$row = array();

			$row[] = '<input type="checkbox" class="data-check" value="'.$mesin_absensi->id_mesin_absensi.'">';
			$row[] = $no;
			$row[] = $mesin_absensi->nama_instansi;
			$row[] = $mesin_absensi->nama_mesin_absensi; 
			$row[] = $mesin_absensi->serial_port; 
			$row[] = $mesin_absensi->port; 
			$row[] = $mesin_absensi->ip_address; 
			$row[] = $mesin_absensi->password; 
			$row[] = $mesin_absensi->lokasi; 
			$row[] = $mesin_absensi->aktif; 
			
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_mesin_absensi('."'".$mesin_absensi->id_mesin_absensi."'".')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah</a>
				  <a class="btn btn-sm btn-danger btn-flat" href="javascript:void(0)" title="Hapus" onclick="delete_mesin_absensi('."'".$mesin_absensi->id_mesin_absensi."'".')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a>';
		
			$data[] = $row;
		}

		$output = array(
		"draw" 				=> $_POST['draw'],
		"recordsTotal" 		=> $this->mesin_absensi->count_all(),
		"recordsFiltered" 	=> $this->mesin_absensi->count_filtered(),
		"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->mesin_absensi->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
	
		
		$data = array(
		'id_instansi'=> $this->input->post('id_instansi', TRUE),
		'nama_mesin_absensi'=> $this->input->post('nama_mesin_absensi', TRUE),
		'serial_port'=> $this->input->post('serial_port', TRUE),
		'port'=> $this->input->post('port', TRUE),
		'ip_address'=> $this->input->post('ip_address', TRUE),
		'lokasi'=> $this->input->post('lokasi', TRUE),
		'aktif'=> $this->input->post('aktif', TRUE),
		);
		if ($this->input->post('password'))
		{
			$data['password'] = md5($this->input->post('password', TRUE));							
		}				
						
		$insert = $this->mesin_absensi->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		
		$data = array(
		'id_instansi'=> $this->input->post('id_instansi', TRUE),
		'nama_mesin_absensi'=> $this->input->post('nama_mesin_absensi', TRUE),
		'serial_port'=> $this->input->post('serial_port', TRUE),
		'port'=> $this->input->post('port', TRUE),
		'ip_address'=> $this->input->post('ip_address', TRUE),
		'lokasi'=> $this->input->post('lokasi', TRUE),
		'aktif'=> $this->input->post('aktif', TRUE),
		);
		if ($this->input->post('password'))
		{
			$data['password'] = md5($this->input->post('password', TRUE));							
		}				
						
		$this->mesin_absensi->update(array('id_mesin_absensi' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		if ($this->input->post('id', TRUE)!="")
			$id = $this->input->post('id', TRUE);

		$this->mesin_absensi->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->mesin_absensi->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		

		if ($this->input->post('id_instansi')=='')
		{
			$data['inputerror'][] = 'id_instansi';
			$data['error_string'][] = 'Instansi  is required';
			$data['status'] = FALSE;							
		}

		if ($this->input->post('nama_mesin_absensi')=='')
		{
			$data['inputerror'][] = 'nama_mesin_absensi';
			$data['error_string'][] = 'Nama Mesin Absensi  is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('serial_port')=='')
		{
			$data['inputerror'][] = 'serial_port';
			$data['error_string'][] = 'Serial Port is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('port')=='')
		{
			$data['inputerror'][] = 'port';
			$data['error_string'][] = 'Port is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('ip_address')=='')
		{
			$data['inputerror'][] = 'ip_address';
			$data['error_string'][] = 'Ip Address is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('lokasi')=='')
		{
			$data['inputerror'][] = 'lokasi';
			$data['error_string'][] = 'Lokasi is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('aktif')=='')
		{
			$data['inputerror'][] = 'aktif';
			$data['error_string'][] = 'Aktif is required';
			$data['status'] = FALSE;							
		}
		

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}
// END Mesin_absensi Class
/* End of file mesin_absensi.php */
/* Location: ./sytem/application/controlers/mesin_absensi.php */		
  