<?php
class Golongan_pangkat extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Golongan_pangkat_model', 'golongan_pangkat', TRUE);
		$this->load->model('Instansi_model', 'instansi', TRUE);
		$this->load->model('Pegawai_model', 'pegawai', TRUE);
		$this->load->model('Golongan_model', 'golongan', TRUE);
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
			'title' 	=> 'Data Golongan pangkat', 
			'main_view' => 'golongan_pangkat/golongan_pangkat', 
			'form_view' => 'golongan_pangkat/golongan_pangkat_form',
			);

		    $instansis = $this->instansi->get_list_instansi();		
			$opt_instansi = array('' => 'Semua Instansi');
		    foreach ($instansis as $i => $v) {
		        $opt_instansi[$i] = $v;
		    }

		    $data['form_instansi'] = form_dropdown('id_instansi',$opt_instansi,'','id="id_instansi" class="form-control"');
			$data['form_instansi2'] = form_dropdown('id_instansi2',$opt_instansi,'','id="id_instansi2" class="form-control"');
			$data['options_instansi'] = $opt_instansi;

			$pegawais = $this->pegawai->get_list_pegawai();		
			$opt_pegawai = array('' => 'All Pegawai');
		    foreach ($pegawais as $i => $v) {
		        $opt_pegawai[$i] = $v;
		    }

		    $data['form_pegawai'] = form_dropdown('id_pegawai',$opt_pegawai,'','id="id_pegawai" class="form-control"');
			$data['form_pegawai2'] = form_dropdown('id_pegawai2',$opt_pegawai,'','id="id_pegawai2" class="form-control"');
				$data['options_pegawai'] = $opt_pegawai;
			$golongans = $this->golongan->get_list_golongan();		
			$opt_golongan = array('' => 'All Golongan');
		    foreach ($golongans as $i => $v) {
		        $opt_golongan[$i] = $v;
		    }

		    $data['form_golongan'] = form_dropdown('id_golongan',$opt_golongan,'','id="id_golongan" class="form-control"');
			$data['form_golongan2'] = form_dropdown('id_golongan2',$opt_golongan,'','id="id_golongan2" class="form-control"');
				$data['options_golongan'] = $opt_golongan;
			$pangkats = $this->pangkat->get_list_pangkat();		
			$opt_pangkat = array('' => 'All Pangkat');
		    foreach ($pangkats as $i => $v) {
		        $opt_pangkat[$i] = $v;
		    }

		    $data['form_pangkat'] = form_dropdown('id_pangkat',$opt_pangkat,'','id="id_pangkat" class="form-control"');
			$data['form_pangkat2'] = form_dropdown('id_pangkat2',$opt_pangkat,'','id="id_pangkat2" class="form-control"');
				$data['options_pangkat'] = $opt_pangkat;
			$this->load->view('admin/template', $data);
		}
	}

	public function ajax_list()
	{
		$this->load->helper('url');
		$list = $this->golongan_pangkat->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $golongan_pangkat) {
			$no++;
			$row = array();

			$row[] = '<input type="checkbox" class="data-check" value="'.$golongan_pangkat->id_golongan_pangkat.'">';
			$row[] = $no;
			$row[] = $golongan_pangkat->nama_instansi;
			$row[] = $golongan_pangkat->nama_pegawai.'<br />'.$golongan_pangkat->nip; 
			// $row[] = $golongan_pangkat->verifikator; 
			$row[] = $golongan_pangkat->nama_golongan; 
			$row[] = $golongan_pangkat->nama_pangkat; 
			
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_golongan_pangkat('."'".$golongan_pangkat->id_golongan_pangkat."'".')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah</a>
				  <a class="btn btn-sm btn-danger btn-flat" href="javascript:void(0)" title="Hapus" onclick="delete_golongan_pangkat('."'".$golongan_pangkat->id_golongan_pangkat."'".')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a>';
		
			$data[] = $row;
		}

		$output = array(
		"draw" 				=> $_POST['draw'],
		"recordsTotal" 		=> $this->golongan_pangkat->count_all(),
		"recordsFiltered" 	=> $this->golongan_pangkat->count_filtered(),
		"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->golongan_pangkat->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
	
		$data = array(
		'id_pegawai'=> $this->input->post('id_pegawai', TRUE),
		'verifikator'=> $this->input->post('verifikator', TRUE),
		'id_golongan'=> $this->input->post('id_golongan', TRUE),
		'id_pangkat'=> $this->input->post('id_pangkat', TRUE),
		);
		$insert = $this->golongan_pangkat->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		
		$data = array(
		'id_pegawai'=> $this->input->post('id_pegawai', TRUE),
		'verifikator'=> $this->input->post('verifikator', TRUE),
		'id_golongan'=> $this->input->post('id_golongan', TRUE),
		'id_pangkat'=> $this->input->post('id_pangkat', TRUE),
		);
		$this->golongan_pangkat->update(array('id_golongan_pangkat' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		if ($this->input->post('id', TRUE)!="")
			$id = $this->input->post('id', TRUE);

		$this->golongan_pangkat->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->golongan_pangkat->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		

		if ($this->input->post('id_pegawai')=='')
		{
			$data['inputerror'][] = 'id_pegawai';
			$data['error_string'][] = 'Pegawai is required';
			$data['status'] = FALSE;							
		}
		
		// if ($this->input->post('verifikator')=='')
		// {
		// 	$data['inputerror'][] = 'verifikator';
		// 	$data['error_string'][] = 'Verifikator is required';
		// 	$data['status'] = FALSE;							
		// }
		
		if ($this->input->post('id_golongan')=='')
		{
			$data['inputerror'][] = 'id_golongan';
			$data['error_string'][] = 'Golongan is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('id_pangkat')=='')
		{
			$data['inputerror'][] = 'id_pangkat';
			$data['error_string'][] = 'Pangkat is required';
			$data['status'] = FALSE;							
		}
		

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}
// END Golongan_pangkat Class
/* End of file golongan_pangkat.php */
/* Location: ./sytem/application/controlers/golongan_pangkat.php */		
  