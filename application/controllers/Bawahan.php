<?php
class Bawahan extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Bawahan_model', 'bawahan', TRUE);
		$this->load->model('Instansi_model', 'instansi', TRUE);
		$this->load->model('Pegawai_model', 'pegawai', TRUE);
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
			'title' 	=> 'Data Bawahan', 
			'main_view' => 'bawahan/bawahan', 
			'form_view' => 'bawahan/bawahan_form',
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
			$this->load->view('admin/template', $data);
		}
	}

	public function ajax_list()
	{
		$this->load->helper('url');
		$list = $this->bawahan->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $bawahan) {
			$no++;
			$row = array();

			$row[] = '<input type="checkbox" class="data-check" value="'.$bawahan->id_bawahan.'">';
			$row[] = $no;
			$row[] = $bawahan->nama_instansi;
			$row[] = $bawahan->nama_pegawai; 
			$row[] = $this->pegawai->get_nama_pegawai($bawahan->bawahan); 
			$row[] = $bawahan->tgl_entri; 
			$row[] = $bawahan->tgl_update; 
			
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_bawahan('."'".$bawahan->id_bawahan."'".')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah</a>
				  <a class="btn btn-sm btn-danger btn-flat" href="javascript:void(0)" title="Hapus" onclick="delete_bawahan('."'".$bawahan->id_bawahan."'".')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a>';
		
			$data[] = $row;
		}

		$output = array(
		"draw" 				=> $_POST['draw'],
		"recordsTotal" 		=> $this->bawahan->count_all(),
		"recordsFiltered" 	=> $this->bawahan->count_filtered(),
		"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->bawahan->get_by_id($id);
		$data->tgl_entri = ($data->tgl_entri == '00-00-0000') ? '' : date('d-m-Y', strtotime($data->tgl_entri)); // if 0000-00-00 set tu empty for datepicker compatibility				
						
		$data->tgl_update = ($data->tgl_update == '00-00-0000') ? '' : date('d-m-Y', strtotime($data->tgl_update)); // if 0000-00-00 set tu empty for datepicker compatibility				
						
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
	
		$data = array(
		'id_pegawai'=> $this->input->post('id_pegawai', TRUE),
		'bawahan'=> $this->input->post('bawahan', TRUE),
		'tgl_entri'=> date('Y-m-d'),
		'tgl_update'=> date('Y-m-d'),
		);
		$insert = $this->bawahan->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		
		$data = array(
		'id_pegawai'=> $this->input->post('id_pegawai', TRUE),
		'bawahan'=> $this->input->post('bawahan', TRUE),
		'tgl_update'=> date('Y-m-d'),
		);
		$this->bawahan->update(array('id_bawahan' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		if ($this->input->post('id', TRUE)!="")
			$id = $this->input->post('id', TRUE);

		$this->bawahan->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->bawahan->delete_by_id($id);
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
		
		if ($this->input->post('bawahan')=='')
		{
			$data['inputerror'][] = 'bawahan';
			$data['error_string'][] = 'Bawahan is required';
			$data['status'] = FALSE;							
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}
// END Bawahan Class
/* End of file bawahan.php */
/* Location: ./sytem/application/controlers/bawahan.php */		
  