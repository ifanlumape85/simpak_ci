<?php
class Pengaturan_presensi extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Pengaturan_presensi_model', 'pengaturan_presensi', TRUE);

		$this->load->model('Jenis_presensi_model', 'jenis_presensi', TRUE);
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
			'title' 	=> 'Data Pengaturan presensi', 
			'main_view' => 'pengaturan_presensi/pengaturan_presensi', 
			'form_view' => 'pengaturan_presensi/pengaturan_presensi_form',
			);

			$jenis_presensis = $this->jenis_presensi->get_list_jenis_presensi();		
			$opt_jenis_presensi = array('' => 'All Jenis Presensi ');
		    foreach ($jenis_presensis as $i => $v) {
		        $opt_jenis_presensi[$i] = $v;
		    }

		    $data['form_jenis_presensi'] = form_dropdown('id_jenis_presensi',$opt_jenis_presensi,'','id="id_jenis_presensi" class="form-control"');
			$data['form_jenis_presensi2'] = form_dropdown('id_jenis_presensi2',$opt_jenis_presensi,'','id="id_jenis_presensi2" class="form-control"');
				$data['options_jenis_presensi'] = $opt_jenis_presensi;
			$this->load->view('admin/template', $data);
		}
	}

	public function ajax_list()
	{
		$this->load->helper('url');
		$list = $this->pengaturan_presensi->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pengaturan_presensi) {
			$no++;
			$row = array();

			$row[] = '<input type="checkbox" class="data-check" value="'.$pengaturan_presensi->id_pengaturan_presensi.'">';
			$row[] = $no;
			$row[] = $pengaturan_presensi->nama_jenis_presensi; 
			$row[] = $pengaturan_presensi->mulai; 
			$row[] = $pengaturan_presensi->akhir; 
			$row[] = $pengaturan_presensi->ikut_jadwal; 
			$row[] = $pengaturan_presensi->penyesuaian_instansi; 
			$row[] = $pengaturan_presensi->cek_perangkat; 
			$row[] = $pengaturan_presensi->cek_lokasi; 
			$row[] = $pengaturan_presensi->longitude; 
			$row[] = $pengaturan_presensi->latitude; 
			
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_pengaturan_presensi('."'".$pengaturan_presensi->id_pengaturan_presensi."'".')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah</a>
				  <a class="btn btn-sm btn-danger btn-flat" href="javascript:void(0)" title="Hapus" onclick="delete_pengaturan_presensi('."'".$pengaturan_presensi->id_pengaturan_presensi."'".')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a>';
		
			$data[] = $row;
		}

		$output = array(
		"draw" 				=> $_POST['draw'],
		"recordsTotal" 		=> $this->pengaturan_presensi->count_all(),
		"recordsFiltered" 	=> $this->pengaturan_presensi->count_filtered(),
		"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->pengaturan_presensi->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
	
		
		$data = array(
		'id_jenis_presensi'=> $this->input->post('id_jenis_presensi', TRUE),
		'mulai'=> $this->input->post('mulai', TRUE),
		'akhir'=> $this->input->post('akhir', TRUE),
		'ikut_jadwal'=> $this->input->post('ikut_jadwal', TRUE),
		'penyesuaian_instansi'=> $this->input->post('penyesuaian_instansi', TRUE),
		'cek_perangkat'=> $this->input->post('cek_perangkat', TRUE),
		'cek_lokasi'=> $this->input->post('cek_lokasi', TRUE),
		'longitude'=> $this->input->post('longitude', TRUE),
		'latitude'=> $this->input->post('latitude', TRUE),
		);
		$insert = $this->pengaturan_presensi->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		
		$data = array(
		'id_jenis_presensi'=> $this->input->post('id_jenis_presensi', TRUE),
		'mulai'=> $this->input->post('mulai', TRUE),
		'akhir'=> $this->input->post('akhir', TRUE),
		'ikut_jadwal'=> $this->input->post('ikut_jadwal', TRUE),
		'penyesuaian_instansi'=> $this->input->post('penyesuaian_instansi', TRUE),
		'cek_perangkat'=> $this->input->post('cek_perangkat', TRUE),
		'cek_lokasi'=> $this->input->post('cek_lokasi', TRUE),
		'longitude'=> $this->input->post('longitude', TRUE),
		'latitude'=> $this->input->post('latitude', TRUE),
		);
		$this->pengaturan_presensi->update(array('id_pengaturan_presensi' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		if ($this->input->post('id', TRUE)!="")
			$id = $this->input->post('id', TRUE);

		$this->pengaturan_presensi->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->pengaturan_presensi->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		

		if ($this->input->post('id_jenis_presensi')=='')
		{
			$data['inputerror'][] = 'id_jenis_presensi';
			$data['error_string'][] = 'Jenis Presensi  is required';
			$data['status'] = FALSE;							
		}
		
		// if ($this->input->post('mulai')=='')
		// {
		// 	$data['inputerror'][] = 'mulai';
		// 	$data['error_string'][] = 'Mulai is required';
		// 	$data['status'] = FALSE;							
		// }
		
		// if ($this->input->post('akhir')=='')
		// {
		// 	$data['inputerror'][] = 'akhir';
		// 	$data['error_string'][] = 'Akhir is required';
		// 	$data['status'] = FALSE;							
		// }
		
		if ($this->input->post('cek_perangkat')=='')
		{
			$data['inputerror'][] = 'cek_perangkat';
			$data['error_string'][] = 'Cek Perangkat is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('cek_lokasi')=='')
		{
			$data['inputerror'][] = 'cek_lokasi';
			$data['error_string'][] = 'Cek Lokasi is required';
			$data['status'] = FALSE;							
		}
		
		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}
// END Pengaturan_presensi Class
/* End of file pengaturan_presensi.php */
/* Location: ./sytem/application/controlers/pengaturan_presensi.php */		
  