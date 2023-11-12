<?php
class Kegiatan_tahunan extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Kegiatan_tahunan_model', 'kegiatan_tahunan', TRUE);
		$this->load->model('Instansi_model', 'instansi', TRUE);
		$this->load->model('Pegawai_model', 'pegawai', TRUE);
		$this->load->model('Jenis_kuantitas_model', 'jenis_kuantitas', TRUE);
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
			'title' 	=> 'Data Kegiatan tahunan', 
			'main_view' => 'kegiatan_tahunan/kegiatan_tahunan', 
			'form_view' => 'kegiatan_tahunan/kegiatan_tahunan_form',
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
			$jenis_kuantitass = $this->jenis_kuantitas->get_list_jenis_kuantitas();		
			$opt_jenis_kuantitas = array('' => 'All Jenis Kuantitas ');
		    foreach ($jenis_kuantitass as $i => $v) {
		        $opt_jenis_kuantitas[$i] = $v;
		    }

		    $data['form_jenis_kuantitas'] = form_dropdown('id_jenis_kuantitas',$opt_jenis_kuantitas,'','id="id_jenis_kuantitas" class="form-control"');
			$data['form_jenis_kuantitas2'] = form_dropdown('id_jenis_kuantitas2',$opt_jenis_kuantitas,'','id="id_jenis_kuantitas2" class="form-control"');
				$data['options_jenis_kuantitas'] = $opt_jenis_kuantitas;
			$this->load->view('admin/template', $data);
		}
	}

	function laporan()
	{
		if ($this->session->userdata('login') != TRUE)
		{
		  redirect('login');
		}
		else
		{
		    $this->load->helper('url');
		    $data = array(
			'title' 	=> 'Data Kegiatan tahunan', 
			'main_view' => 'kegiatan_tahunan/laporan', 
			'form_view' => 'kegiatan_tahunan/laporan_form',
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
			$jenis_kuantitass = $this->jenis_kuantitas->get_list_jenis_kuantitas();		
			$opt_jenis_kuantitas = array('' => 'All Jenis Kuantitas ');
		    foreach ($jenis_kuantitass as $i => $v) {
		        $opt_jenis_kuantitas[$i] = $v;
		    }

		    $data['form_jenis_kuantitas'] = form_dropdown('id_jenis_kuantitas',$opt_jenis_kuantitas,'','id="id_jenis_kuantitas" class="form-control"');
			$data['form_jenis_kuantitas2'] = form_dropdown('id_jenis_kuantitas2',$opt_jenis_kuantitas,'','id="id_jenis_kuantitas2" class="form-control"');
				$data['options_jenis_kuantitas'] = $opt_jenis_kuantitas;
			$this->load->view('admin/template', $data);
		}
	}

	function laporan_kegiatan()
	{
		if ($this->session->userdata('login')==TRUE)
		{
			$id_instansi = $this->input->post('id_instansi', TRUE);
			$id_pegawai = $this->input->post('id_pegawai', TRUE);
			$tahun = $this->input->post('tahun', TRUE);
			
			// $id_instansi = 16;
			// $id_pegawai = '';
			// $tahun = '';
			
			$arr = array();

			$kegiatan_tahunans = "select kegiatan_tahunan.*, pegawai.id_instansi, pegawai.nip, pegawai.nama_pegawai, instansi.nama_instansi, jenis_kuantitas.nama_jenis_kuantitas from kegiatan_tahunan left join pegawai on kegiatan_tahunan.id_pegawai=pegawai.id_pegawai left join instansi on pegawai.id_instansi=instansi.id_instansi left join jenis_kuantitas on kegiatan_tahunan.id_jenis_kuantitas=jenis_kuantitas.id_jenis_kuantitas";

			if ($id_instansi!="")
				$arr[] = "pegawai.id_instansi='$id_instansi'";
			if ($id_pegawai!="")
				$arr[] = "kegiatan_tahunan.id_pegawai='$id_pegawai'";
			if($tahun!="")
				$arr[] = "kegiatan_tahunan.tahun='$tahun'";


			$html = '
			<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
		 		<tr>
		 			<th>No.</th>
                    <th>Instansi</th>
					<th>Pegawai</th>
					<th>Tahun</th>
					<th>Kegiatan</th>
					<th>Kuantitas</th>
					<th>Penyelesaian</th>
				</tr>                
            </thead>
            <tbody>';
            
            if (count($arr) > 0)
            {
            	foreach ($arr as $key => $value) {
            		if ($key==0)
            			$kegiatan_tahunans .= " where $value";
            		else 
            			$kegiatan_tahunans .= " and $value";
            	}

            	$kegiatan_tahunan = $this->db->query($kegiatan_tahunans);
            	if ($kegiatan_tahunan->num_rows() > 0)
            	{
            		$i = 1;
            		foreach ($kegiatan_tahunan->result() as $value) {
            			$html .= '
            			<tr>
            				<td>'.$i.'</td>
            				<td>'.$value->nama_instansi.'</td>
            				<td>'.$value->nama_pegawai.'</td>
            				<td>'.$value->tahun.'</td>
            				<td>'.$value->kegiatan.'</td>
            				<td>'.$value->target_kuantitas.' '.$value->nama_jenis_kuantitas.'</td>
            				<td>'.$value->target_penyelesaian.' Bulan</td>
            			</tr>';
            			$i++;
            		}
            	}
            }
            $html .= '</tbody>
            <tfoot>
		 		<tr>
		 			<td></td>
		 			<td>Instansi</td>
					<td>Pegawai</td>
					<td>Tahun</td>
					<td>Kegiatan</td>
					<td>Kuantitas</td>
					<td>Penyelesaian</td>
				</tr>
           </tfoot>
       </table>';
       		echo $html;
		}
	}

	public function ajax_list()
	{
		$this->load->helper('url');
		$list = $this->kegiatan_tahunan->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $kegiatan_tahunan) {
			$no++;
			$row = array();

			$row[] = '<input type="checkbox" class="data-check" value="'.$kegiatan_tahunan->id_kegiatan_tahunan.'">';
			$row[] = $no;
			$row[] = $kegiatan_tahunan->nama_instansi;
			$row[] = $kegiatan_tahunan->nama_pegawai; 
			$row[] = $kegiatan_tahunan->tahun; 
			$row[] = $kegiatan_tahunan->kegiatan; 
			$row[] = $kegiatan_tahunan->target_kuantitas.' '.$kegiatan_tahunan->nama_jenis_kuantitas; 
			$row[] = '<a class="btn btn-sm btn-flat btn-warning" href="javascript:void(0)" title="Detail Bulan" onclick="add_kegiatan_bulanan('."'".$kegiatan_tahunan->id_kegiatan_tahunan."'".')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> '.$kegiatan_tahunan->target_penyelesaian.' Bulan</a>'; 
			
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_kegiatan_tahunan('."'".$kegiatan_tahunan->id_kegiatan_tahunan."'".')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah</a>
				  <a class="btn btn-sm btn-danger btn-flat" href="javascript:void(0)" title="Hapus" onclick="delete_kegiatan_tahunan('."'".$kegiatan_tahunan->id_kegiatan_tahunan."'".')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a>';
		
			$data[] = $row;
		}

		$output = array(
		"draw" 				=> $_POST['draw'],
		"recordsTotal" 		=> $this->kegiatan_tahunan->count_all(),
		"recordsFiltered" 	=> $this->kegiatan_tahunan->count_filtered(),
		"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	function eror_cek()
	{
		$list = $this->kegiatan_tahunan->get_datatables();
	}

	public function ajax_edit($id)
	{
		if ($this->input->post('id_kegiatan_tahunan', TRUE))
			$id = $this->input->post('id_kegiatan_tahunan', TRUE);
		
		$data = $this->kegiatan_tahunan->get_by_id($id);
		$data->tgl_input = ($data->tgl_input == '00-00-0000') ? '' : date('d-m-Y', strtotime($data->tgl_input)); // if 0000-00-00 set tu empty for datepicker compatibility				
						
		$data->tgl_update = ($data->tgl_update == '00-00-0000') ? '' : date('d-m-Y', strtotime($data->tgl_update)); // if 0000-00-00 set tu empty for datepicker compatibility				
						
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
	
		
		$data = array(
		'id_pegawai'=> $this->input->post('id_pegawai', TRUE),
		'tahun'=> $this->input->post('tahun', TRUE),
		'kegiatan'=> $this->input->post('kegiatan', TRUE),
		'target_kuantitas'=> $this->input->post('target_kuantitas', TRUE),
		'id_jenis_kuantitas'=> $this->input->post('id_jenis_kuantitas', TRUE),
		'target_penyelesaian'=> $this->input->post('target_penyelesaian', TRUE),
		'tgl_input'=> date('Y-m-d'),
		'tgl_update'=> date('Y-m-d'),
		);
		$insert = $this->kegiatan_tahunan->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		
		$data = array(
		'id_pegawai'=> $this->input->post('id_pegawai', TRUE),
		'tahun'=> $this->input->post('tahun', TRUE),
		'kegiatan'=> $this->input->post('kegiatan', TRUE),
		'target_kuantitas'=> $this->input->post('target_kuantitas', TRUE),
		'id_jenis_kuantitas'=> $this->input->post('id_jenis_kuantitas', TRUE),
		'target_penyelesaian'=> $this->input->post('target_penyelesaian', TRUE),
		'tgl_update'=> date('Y-m-d'),
		);
		$this->kegiatan_tahunan->update(array('id_kegiatan_tahunan' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		if ($this->input->post('id', TRUE)!="")
			$id = $this->input->post('id', TRUE);

		$this->kegiatan_tahunan->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->kegiatan_tahunan->delete_by_id($id);
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
		
		if ($this->input->post('tahun')=='')
		{
			$data['inputerror'][] = 'tahun';
			$data['error_string'][] = 'Tahun is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('kegiatan')=='')
		{
			$data['inputerror'][] = 'kegiatan';
			$data['error_string'][] = 'Kegiatan is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('target_kuantitas')=='')
		{
			$data['inputerror'][] = 'target_kuantitas';
			$data['error_string'][] = 'Target Kuantitas is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('id_jenis_kuantitas')=='')
		{
			$data['inputerror'][] = 'id_jenis_kuantitas';
			$data['error_string'][] = 'Jenis Kuantitas  is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('target_penyelesaian')=='')
		{
			$data['inputerror'][] = 'target_penyelesaian';
			$data['error_string'][] = 'Target Penyelesaian is required';
			$data['status'] = FALSE;							
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	function option_kegiatan()
	{
		$tahun = $this->input->post('tahun', TRUE);
		$id_pegawai = $this->input->post('id_pegawai', TRUE);
		
		$kegiatan_tahunans = $this->db->query("select * from kegiatan_tahunan where id_pegawai='$id_pegawai' and tahun='$tahun'");
		$opt_value = '<option value="">Semua Kegiatan</option>';
		if ($kegiatan_tahunans->num_rows() > 0)
		{
			foreach ($kegiatan_tahunans->result() as $kegiatan_tahunan) {
				$opt_value .= '<option value="'.$kegiatan_tahunan->id_kegiatan_tahunan.'">'.$kegiatan_tahunan->kegiatan.'</option>';
			}
		}
		echo $opt_value;
	}
}
// END Kegiatan_tahunan Class
/* End of file kegiatan_tahunan.php */
/* Location: ./sytem/application/controlers/kegiatan_tahunan.php */		
  