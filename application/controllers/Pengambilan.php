<?php
class Pengambilan extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Pengambilan_model', 'pengambilan', TRUE);

		$this->load->model('Surat_masuk_model', 'surat_masuk', TRUE);
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
			'title' 	=> 'Data Pengambilan', 
			'main_view' => 'pengambilan/pengambilan', 
			'form_view' => 'pengambilan/pengambilan_form',
			);

			$surat_masuks = $this->surat_masuk->get_list_surat_masuk();		
			$opt_surat_masuk = array('' => 'All Surat Masuk ');
		    foreach ($surat_masuks as $i => $v) {
		        $opt_surat_masuk[$i] = $v;
		    }

		    $data['form_surat_masuk'] = form_dropdown('id_surat_masuk',$opt_surat_masuk,'','id="id_surat_masuk" class="form-control"');
			$data['form_surat_masuk2'] = form_dropdown('id_surat_masuk2',$opt_surat_masuk,'','id="id_surat_masuk2" class="form-control"');
				$data['options_surat_masuk'] = $opt_surat_masuk;
			$this->load->view('admin/template', $data);
		}
	}

	public function ajax_list()
	{
		$this->load->helper('url');
		$list = $this->pengambilan->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pengambilan) {
			$no++;
			$row = array();

			$row[] = '<input type="checkbox" class="data-check" value="'.$pengambilan->id_pengambilan.'">';
			$row[] = $no;
			$row[] = $pengambilan->id_surat_masuk; 
			$row[] = $pengambilan->tgl_pengambilan; 
			$row[] = $pengambilan->jam_pengambilan; 
			$row[] = $pengambilan->nama_pegawai; 
			$row[] = $pengambilan->tgl_entri; 
			$row[] = $pengambilan->jam_entri; 
			$row[] = $pengambilan->id_user_entri; 
			$row[] = $pengambilan->tgl_update; 
			$row[] = $pengambilan->jam_update; 
			$row[] = $pengambilan->id_user_update; 
			
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_pengambilan('."'".$pengambilan->id_pengambilan."'".')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah</a>
				  <a class="btn btn-sm btn-danger btn-flat" href="javascript:void(0)" title="Hapus" onclick="delete_pengambilan('."'".$pengambilan->id_pengambilan."'".')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a>';
		
			$data[] = $row;
		}

		$output = array(
		"draw" 				=> $_POST['draw'],
		"recordsTotal" 		=> $this->pengambilan->count_all(),
		"recordsFiltered" 	=> $this->pengambilan->count_filtered(),
		"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->pengambilan->get_by_id($id);
		$data->tgl_pengambilan = ($data->tgl_pengambilan == '00-00-0000') ? '' : date('d-m-Y', strtotime($data->tgl_pengambilan)); // if 0000-00-00 set tu empty for datepicker compatibility				
						
		$data->tgl_entri = ($data->tgl_entri == '00-00-0000') ? '' : date('d-m-Y', strtotime($data->tgl_entri)); // if 0000-00-00 set tu empty for datepicker compatibility				
						
		$data->tgl_update = ($data->tgl_update == '00-00-0000') ? '' : date('d-m-Y', strtotime($data->tgl_update)); // if 0000-00-00 set tu empty for datepicker compatibility				
						
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
	
		
		$data = array(
		'id_surat_masuk'=> $this->input->post('id_surat_masuk', TRUE),
		'tgl_pengambilan'=> date('Y-m-d', strtotime($this->input->post('tgl_pengambilan', TRUE))),
		'jam_pengambilan'=> $this->input->post('jam_pengambilan', TRUE),
		'nama_pegawai'=> $this->input->post('nama_pegawai', TRUE),
		'tgl_entri'=> date('Y-m-d', strtotime($this->input->post('tgl_entri', TRUE))),
		'jam_entri'=> $this->input->post('jam_entri', TRUE),
		'id_user_entri'=> $this->input->post('id_user_entri', TRUE),
		'tgl_update'=> date('Y-m-d', strtotime($this->input->post('tgl_update', TRUE))),
		'jam_update'=> $this->input->post('jam_update', TRUE),
		'id_user_update'=> $this->input->post('id_user_update', TRUE),
		);
		$insert = $this->pengambilan->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		
		$data = array(
		'id_surat_masuk'=> $this->input->post('id_surat_masuk', TRUE),
		'tgl_pengambilan'=> date('Y-m-d', strtotime($this->input->post('tgl_pengambilan', TRUE))),
		'jam_pengambilan'=> $this->input->post('jam_pengambilan', TRUE),
		'nama_pegawai'=> $this->input->post('nama_pegawai', TRUE),
		'tgl_entri'=> date('Y-m-d', strtotime($this->input->post('tgl_entri', TRUE))),
		'jam_entri'=> $this->input->post('jam_entri', TRUE),
		'id_user_entri'=> $this->input->post('id_user_entri', TRUE),
		'tgl_update'=> date('Y-m-d', strtotime($this->input->post('tgl_update', TRUE))),
		'jam_update'=> $this->input->post('jam_update', TRUE),
		'id_user_update'=> $this->input->post('id_user_update', TRUE),
		);
		$this->pengambilan->update(array('id_pengambilan' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		if ($this->input->post('id', TRUE)!="")
			$id = $this->input->post('id', TRUE);

		$this->pengambilan->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->pengambilan->delete_by_id($id);
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
		
		if ($this->input->post('tgl_pengambilan')=='')
		{
			$data['inputerror'][] = 'tgl_pengambilan';
			$data['error_string'][] = 'Tgl Pengambilan is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('jam_pengambilan')=='')
		{
			$data['inputerror'][] = 'jam_pengambilan';
			$data['error_string'][] = 'Jam Pengambilan is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('nama_pegawai')=='')
		{
			$data['inputerror'][] = 'nama_pegawai';
			$data['error_string'][] = 'Nama Pegawai is required';
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
// END Pengambilan Class
/* End of file pengambilan.php */
/* Location: ./sytem/application/controlers/pengambilan.php */		
  