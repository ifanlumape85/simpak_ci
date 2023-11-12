<?php
class Informasi_surat extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Informasi_surat_model', 'informasi_surat', TRUE);

		$this->load->model('Surat_masuk_model', 'surat_masuk', TRUE);
		$this->load->model('Status_surat_model', 'status_surat', TRUE);
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
			'title' 	=> 'Data Informasi surat', 
			'main_view' => 'informasi_surat/informasi_surat', 
			'form_view' => 'informasi_surat/informasi_surat_form',
			);

			$surat_masuks = $this->surat_masuk->get_list_surat_masuk();		
			$opt_surat_masuk = array('' => 'All Surat Masuk ');
		    foreach ($surat_masuks as $i => $v) {
		        $opt_surat_masuk[$i] = $v;
		    }

		    $data['form_surat_masuk'] = form_dropdown('id_surat_masuk',$opt_surat_masuk,'','id="id_surat_masuk" class="form-control"');
			$data['form_surat_masuk2'] = form_dropdown('id_surat_masuk2',$opt_surat_masuk,'','id="id_surat_masuk2" class="form-control"');
				$data['options_surat_masuk'] = $opt_surat_masuk;
			$status_surats = $this->status_surat->get_list_status_surat();		
			$opt_status_surat = array('' => 'All Status Surat ');
		    foreach ($status_surats as $i => $v) {
		        $opt_status_surat[$i] = $v;
		    }

		    $data['form_status_surat'] = form_dropdown('id_status_surat',$opt_status_surat,'','id="id_status_surat" class="form-control"');
			$data['form_status_surat2'] = form_dropdown('id_status_surat2',$opt_status_surat,'','id="id_status_surat2" class="form-control"');
				$data['options_status_surat'] = $opt_status_surat;
			$this->load->view('admin/template', $data);
		}
	}

	public function ajax_list()
	{
		$this->load->helper('url');
		$list = $this->informasi_surat->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $informasi_surat) {
			$no++;
			$row = array();

			$row[] = '<input type="checkbox" class="data-check" value="'.$informasi_surat->id_informasi_surat.'">';
			$row[] = $no;
			$row[] = $informasi_surat->id_surat_masuk; 
			$row[] = $informasi_surat->id_status_surat; 
			$row[] = $informasi_surat->tgl_informasi_surat; 
			$row[] = $informasi_surat->jam_informasi_surat; 
			$row[] = $informasi_surat->tgl_entri; 
			$row[] = $informasi_surat->jam_entri; 
			$row[] = $informasi_surat->id_user_entri; 
			$row[] = $informasi_surat->tgl_update; 
			$row[] = $informasi_surat->jam_update; 
			$row[] = $informasi_surat->id_user_update; 
			
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_informasi_surat('."'".$informasi_surat->id_informasi_surat."'".')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah</a>
				  <a class="btn btn-sm btn-danger btn-flat" href="javascript:void(0)" title="Hapus" onclick="delete_informasi_surat('."'".$informasi_surat->id_informasi_surat."'".')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a>';
		
			$data[] = $row;
		}

		$output = array(
		"draw" 				=> $_POST['draw'],
		"recordsTotal" 		=> $this->informasi_surat->count_all(),
		"recordsFiltered" 	=> $this->informasi_surat->count_filtered(),
		"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->informasi_surat->get_by_id($id);
		$data->tgl_informasi_surat = ($data->tgl_informasi_surat == '00-00-0000') ? '' : date('d-m-Y', strtotime($data->tgl_informasi_surat)); // if 0000-00-00 set tu empty for datepicker compatibility				
						
		$data->tgl_entri = ($data->tgl_entri == '00-00-0000') ? '' : date('d-m-Y', strtotime($data->tgl_entri)); // if 0000-00-00 set tu empty for datepicker compatibility				
						
		$data->tgl_update = ($data->tgl_update == '00-00-0000') ? '' : date('d-m-Y', strtotime($data->tgl_update)); // if 0000-00-00 set tu empty for datepicker compatibility				
						
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
	
		
		$data = array(
		'id_surat_masuk'=> $this->input->post('id_surat_masuk', TRUE),
		'id_status_surat'=> $this->input->post('id_status_surat', TRUE),
		'tgl_informasi_surat'=> date('Y-m-d', strtotime($this->input->post('tgl_informasi_surat', TRUE))),
		'jam_informasi_surat'=> $this->input->post('jam_informasi_surat', TRUE),
		'tgl_entri'=> date('Y-m-d', strtotime($this->input->post('tgl_entri', TRUE))),
		'jam_entri'=> $this->input->post('jam_entri', TRUE),
		'id_user_entri'=> $this->input->post('id_user_entri', TRUE),
		'tgl_update'=> date('Y-m-d', strtotime($this->input->post('tgl_update', TRUE))),
		'jam_update'=> $this->input->post('jam_update', TRUE),
		'id_user_update'=> $this->input->post('id_user_update', TRUE),
		);
		$insert = $this->informasi_surat->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		
		$data = array(
		'id_surat_masuk'=> $this->input->post('id_surat_masuk', TRUE),
		'id_status_surat'=> $this->input->post('id_status_surat', TRUE),
		'tgl_informasi_surat'=> date('Y-m-d', strtotime($this->input->post('tgl_informasi_surat', TRUE))),
		'jam_informasi_surat'=> $this->input->post('jam_informasi_surat', TRUE),
		'tgl_entri'=> date('Y-m-d', strtotime($this->input->post('tgl_entri', TRUE))),
		'jam_entri'=> $this->input->post('jam_entri', TRUE),
		'id_user_entri'=> $this->input->post('id_user_entri', TRUE),
		'tgl_update'=> date('Y-m-d', strtotime($this->input->post('tgl_update', TRUE))),
		'jam_update'=> $this->input->post('jam_update', TRUE),
		'id_user_update'=> $this->input->post('id_user_update', TRUE),
		);
		$this->informasi_surat->update(array('id_informasi_surat' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		if ($this->input->post('id', TRUE)!="")
			$id = $this->input->post('id', TRUE);

		$this->informasi_surat->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->informasi_surat->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		

		if ($this->input->post('id_surat_masuk')=='')
		{
			$data['inputerror'][] = 'id_surat_masuk';
			$data['error_string'][] = 'Surat Masuk  is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('id_status_surat')=='')
		{
			$data['inputerror'][] = 'id_status_surat';
			$data['error_string'][] = 'Status Surat  is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('tgl_informasi_surat')=='')
		{
			$data['inputerror'][] = 'tgl_informasi_surat';
			$data['error_string'][] = 'Tgl Informasi Surat  is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('jam_informasi_surat')=='')
		{
			$data['inputerror'][] = 'jam_informasi_surat';
			$data['error_string'][] = 'Jam Informasi Surat  is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('tgl_entri')=='')
		{
			$data['inputerror'][] = 'tgl_entri';
			$data['error_string'][] = 'Tgl Entri is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('jam_entri')=='')
		{
			$data['inputerror'][] = 'jam_entri';
			$data['error_string'][] = 'Jam Entri is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('id_user_entri')=='')
		{
			$data['inputerror'][] = 'id_user_entri';
			$data['error_string'][] = 'User Entri  is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('tgl_update')=='')
		{
			$data['inputerror'][] = 'tgl_update';
			$data['error_string'][] = 'Tgl Update is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('jam_update')=='')
		{
			$data['inputerror'][] = 'jam_update';
			$data['error_string'][] = 'Jam Update is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('id_user_update')=='')
		{
			$data['inputerror'][] = 'id_user_update';
			$data['error_string'][] = 'User Update  is required';
			$data['status'] = FALSE;							
		}
		

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}
// END Informasi_surat Class
/* End of file informasi_surat.php */
/* Location: ./sytem/application/controlers/informasi_surat.php */		
  