<?php
class Kegiatan_bulanan extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Kegiatan_bulanan_model', 'kegiatan_bulanan', TRUE);
		$this->load->model('Kegiatan_tahunan_model', 'kegiatan_tahunan', TRUE);
		$this->load->model('Jenis_kuantitas_model', 'jenis_kuantitas', TRUE);
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
			'title' 	=> 'Data Kegiatan bulanan', 
			'main_view' => 'kegiatan_bulanan/kegiatan_bulanan', 
			'form_view' => 'kegiatan_bulanan/kegiatan_bulanan_form',
			);

		    $instansis = $this->instansi->get_list_instansi();		
			$opt_instansi = array('' => 'Semua Instansi');
		    foreach ($instansis as $i => $v) {
		        $opt_instansi[$i] = $v;
		    }

		    $data['form_instansi'] = form_dropdown('id_instansi',$opt_instansi,'','id="id_instansi" class="form-control"');
			$data['form_instansi2'] = form_dropdown('id_instansi2',$opt_instansi,'','id="id_instansi2" class="form-control"');
			$data['options_instansi'] = $opt_instansi;
			
			$kegiatan_tahunans = $this->kegiatan_tahunan->get_list_kegiatan_tahunan();		
			$opt_kegiatan_tahunan = array('' => 'All Kegiatan Tahunan ');
		    foreach ($kegiatan_tahunans as $i => $v) {
		        $opt_kegiatan_tahunan[$i] = $v;
		    }

		    $data['form_kegiatan_tahunan'] = form_dropdown('id_kegiatan_tahunan',$opt_kegiatan_tahunan,'','id="id_kegiatan_tahunan" class="form-control"');
			$data['form_kegiatan_tahunan2'] = form_dropdown('id_kegiatan_tahunan2',$opt_kegiatan_tahunan,'','id="id_kegiatan_tahunan2" class="form-control"');
			$data['options_kegiatan_tahunan'] = $opt_kegiatan_tahunan;
			
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

	function bawahan()
	{
		if ($this->session->userdata('login') != TRUE)
		{
		  redirect('login');
		}
		else
		{
		    $this->load->helper('url');
		    $data = array(
			'title' 	=> 'Data Kegiatan bulanan', 
			'main_view' => 'kegiatan_bulanan/kegiatan_bulanan_bawahan', 
			'form_view' => 'kegiatan_bulanan/kegiatan_bulanan_bawahan_form',
			);

		    $instansis = $this->instansi->get_list_instansi();		
			$opt_instansi = array('' => 'Semua Instansi');
		    foreach ($instansis as $i => $v) {
		        $opt_instansi[$i] = $v;
		    }

		    $data['form_instansi'] = form_dropdown('id_instansi',$opt_instansi,'','id="id_instansi" class="form-control"');
			$data['form_instansi2'] = form_dropdown('id_instansi2',$opt_instansi,'','id="id_instansi2" class="form-control"');
			$data['options_instansi'] = $opt_instansi;
			
			$kegiatan_tahunans = $this->kegiatan_tahunan->get_list_kegiatan_tahunan();		
			$opt_kegiatan_tahunan = array('' => 'All Kegiatan Tahunan ');
		    foreach ($kegiatan_tahunans as $i => $v) {
		        $opt_kegiatan_tahunan[$i] = $v;
		    }

		    $data['form_kegiatan_tahunan'] = form_dropdown('id_kegiatan_tahunan',$opt_kegiatan_tahunan,'','id="id_kegiatan_tahunan" class="form-control"');
			$data['form_kegiatan_tahunan2'] = form_dropdown('id_kegiatan_tahunan2',$opt_kegiatan_tahunan,'','id="id_kegiatan_tahunan2" class="form-control"');
			$data['options_kegiatan_tahunan'] = $opt_kegiatan_tahunan;
			
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
			'title' 	=> 'Data Kegiatan bulanan', 
			'main_view' => 'kegiatan_bulanan/laporan', 
			'form_view' => 'kegiatan_bulanan/laporan_form',
			);

		    $instansis = $this->instansi->get_list_instansi();		
			$opt_instansi = array('' => 'Semua Instansi');
		    foreach ($instansis as $i => $v) {
		        $opt_instansi[$i] = $v;
		    }

		    $data['form_instansi'] = form_dropdown('id_instansi',$opt_instansi,'','id="id_instansi" class="form-control"');
			$data['form_instansi2'] = form_dropdown('id_instansi2',$opt_instansi,'','id="id_instansi2" class="form-control"');
			$data['options_instansi'] = $opt_instansi;
			
			$kegiatan_tahunans = $this->kegiatan_tahunan->get_list_kegiatan_tahunan();		
			$opt_kegiatan_tahunan = array('' => 'All Kegiatan Tahunan ');
		    foreach ($kegiatan_tahunans as $i => $v) {
		        $opt_kegiatan_tahunan[$i] = $v;
		    }

		    $data['form_kegiatan_tahunan'] = form_dropdown('id_kegiatan_tahunan',$opt_kegiatan_tahunan,'','id="id_kegiatan_tahunan" class="form-control"');
			$data['form_kegiatan_tahunan2'] = form_dropdown('id_kegiatan_tahunan2',$opt_kegiatan_tahunan,'','id="id_kegiatan_tahunan2" class="form-control"');
			$data['options_kegiatan_tahunan'] = $opt_kegiatan_tahunan;
			
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
			$id_kegiatan_tahunan = $this->input->post('id_kegiatan_tahunan', TRUE);

			$sql = "select kegiatan_bulanan.*, kegiatan_tahunan.id_pegawai, kegiatan_tahunan.kegiatan as kegiatan_tahunan, kegiatan_tahunan.tahun, pegawai.id_instansi, pegawai.nip, pegawai.nama_pegawai, instansi.nama_instansi, jenis_kuantitas.nama_jenis_kuantitas from kegiatan_bulanan left join kegiatan_tahunan on kegiatan_bulanan.id_kegiatan_tahunan=kegiatan_tahunan.id_kegiatan_tahunan left join pegawai on kegiatan_tahunan.id_pegawai=pegawai.id_pegawai left join instansi on pegawai.id_instansi=instansi.id_instansi left join jenis_kuantitas on kegiatan_bulanan.id_jenis_kuantitas=jenis_kuantitas.id_jenis_kuantitas";

			$arr = array();
			if ($id_instansi!="")
				$arr[] = "pegawai.id_instansi='$id_instansi'";
			if ($id_pegawai!="")
				$arr[] = "kegiatan_tahunan.id_pegawai='$id_pegawai'";
			if ($tahun!="")
				$arr[] = "kegiatan_tahunan.tahun='$tahun'";
			if ($id_kegiatan_tahunan!="")
				$arr[] = "kegiatan_bulanan.id_kegiatan_tahunan='$id_kegiatan_tahunan'";

			$html = '
			<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
    		 		<tr>
    		 			<th>No.</th>
                        <th>Tahun</th>
                        <th>Instansi</th>
                        <th>Pegawai</th>
    					<th>Kegiatan Tahunan</th>
    					<th>Bulan</th>
    					<th>Kegiatan</th>
    					<th>Kuantitas</th>
    				</tr>                
                </thead>
                <tbody>';

            if (count($arr) > 0)
            {
            	foreach ($arr as $key => $value) {
            		if ($key==0)
            			$sql .= " where $value";
            		else 
            			$sql .= " and $value";
            	}

            	$query = $this->db->query($sql);
            	if ($query->num_rows() > 0)
            	{
            		$i=1;
            		foreach ($query->result() as $value) {
            			$html .= '
            			<tr>
            				<td>'.$i.'</td>
            				<td>'.$value->tahun.'</td>
            				<td>'.$value->nama_instansi.'</td>
            				<td>'.$value->nama_pegawai.'</td>
            				<td>'.$value->kegiatan_tahunan.'</td>
            				<td>'.get_bulan($value->bulan).'</td>
            				<td>'.$value->kegiatan.'</td>
            				<td>'.$value->kuantitas.' '.$value->nama_jenis_kuantitas.'</td>
            			</tr>';
            			$i++;
            		}
            	}
            }
            $html .='
	            </tbody>
                <tfoot>
    		 		<tr>
    		 			<td></td>
                        <td>Tahun</td>
                        <td>Instansi</td>
                        <td>Pegawai</td>
    					<td>Kegiatan Tahunan </td>
    					<td>Bulan</td>
    					<td>Kegiatan</td>
    					<td>Kuantitas</td>
    				</tr>
               </tfoot>
           </table>
			';

			echo $html;
		}
	}

	public function ajax_list()
	{
		$this->load->helper('url');
		$list = $this->kegiatan_bulanan->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $kegiatan_bulanan) {
			$no++;
			$row = array();

			$row[] = '<input type="checkbox" class="data-check" value="'.$kegiatan_bulanan->id_kegiatan_bulanan.'">';
			$row[] = $no;
			$row[] = $kegiatan_bulanan->tahun;
			$row[] = $kegiatan_bulanan->nama_instansi;
			$row[] = $kegiatan_bulanan->nama_pegawai;
			$row[] = $kegiatan_bulanan->kegiatan_tahunan; 
			$row[] = get_bulan($kegiatan_bulanan->bulan); 
			$row[] = $kegiatan_bulanan->kegiatan; 
			$row[] = $kegiatan_bulanan->kuantitas.' '.$kegiatan_bulanan->nama_jenis_kuantitas; 
			
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_kegiatan_bulanan('."'".$kegiatan_bulanan->id_kegiatan_bulanan."'".')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah</a>
				  <a class="btn btn-sm btn-danger btn-flat" href="javascript:void(0)" title="Hapus" onclick="delete_kegiatan_bulanan('."'".$kegiatan_bulanan->id_kegiatan_bulanan."'".')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a>';
		
			$data[] = $row;
		}

		$output = array(
		"draw" 				=> $_POST['draw'],
		"recordsTotal" 		=> $this->kegiatan_bulanan->count_all(),
		"recordsFiltered" 	=> $this->kegiatan_bulanan->count_filtered(),
		"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_list_bawahan()
	{
		$this->load->helper('url');
		$list = $this->kegiatan_bulanan->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $kegiatan_bulanan) {
			$no++;
			$row = array();

			$row[] = '<input type="checkbox" class="data-check" value="'.$kegiatan_bulanan->id_kegiatan_bulanan.'">';
			$row[] = $no;
			$row[] = $kegiatan_bulanan->tahun;
			$row[] = $kegiatan_bulanan->nama_instansi;
			$row[] = $kegiatan_bulanan->nama_pegawai;
			$row[] = $kegiatan_bulanan->kegiatan_tahunan; 
			$row[] = get_bulan($kegiatan_bulanan->bulan); 
			$row[] = $kegiatan_bulanan->kegiatan; 
			$row[] = $kegiatan_bulanan->kuantitas.' '.$kegiatan_bulanan->nama_jenis_kuantitas; 
			$row[] = $kegiatan_bulanan->realisasi;
			$row[] = $kegiatan_bulanan->hasil;
			$row[] = $kegiatan_bulanan->kualitas;
			$row[] = $kegiatan_bulanan->nilai;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_kegiatan_bulanan('."'".$kegiatan_bulanan->id_kegiatan_bulanan."'".')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Validasi</a>';
		
			$data[] = $row;
		}

		$output = array(
		"draw" 				=> $_POST['draw'],
		"recordsTotal" 		=> $this->kegiatan_bulanan->count_all(),
		"recordsFiltered" 	=> $this->kegiatan_bulanan->count_filtered(),
		"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->kegiatan_bulanan->get_by_id($id);
		$data->tgl_input = ($data->tgl_input == '00-00-0000') ? '' : date('d-m-Y', strtotime($data->tgl_input)); // if 0000-00-00 set tu empty for datepicker compatibility				
						
		$data->tgl_update = ($data->tgl_update == '00-00-0000') ? '' : date('d-m-Y', strtotime($data->tgl_update)); // if 0000-00-00 set tu empty for datepicker compatibility				
						
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
	
		
		$data = array(
		'id_kegiatan_tahunan'=> $this->input->post('id_kegiatan_tahunan', TRUE),
		'bulan'=> $this->input->post('bulan', TRUE),
		'kegiatan'=> $this->input->post('kegiatan', TRUE),
		'kuantitas'=> $this->input->post('kuantitas', TRUE),
		'id_jenis_kuantitas'=> $this->input->post('id_jenis_kuantitas', TRUE),
		'tgl_input'=> date('Y-m-d'),
		'tgl_update'=> date('Y-m-d'),
		);
		$insert = $this->kegiatan_bulanan->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		
		$data = array(
		'id_kegiatan_tahunan'=> $this->input->post('id_kegiatan_tahunan', TRUE),
		'bulan'=> $this->input->post('bulan', TRUE),
		'kegiatan'=> $this->input->post('kegiatan', TRUE),
		'kuantitas'=> $this->input->post('kuantitas', TRUE),
		'id_jenis_kuantitas'=> $this->input->post('id_jenis_kuantitas', TRUE),
		'tgl_update'=> date('Y-m-d'),
		);
		$this->kegiatan_bulanan->update(array('id_kegiatan_bulanan' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		if ($this->input->post('id', TRUE)!="")
			$id = $this->input->post('id', TRUE);

		$this->kegiatan_bulanan->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->kegiatan_bulanan->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		

		if ($this->input->post('id_kegiatan_tahunan')=='')
		{
			$data['inputerror'][] = 'id_kegiatan_tahunan';
			$data['error_string'][] = 'Kegiatan Tahunan  is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('bulan')=='')
		{
			$data['inputerror'][] = 'bulan';
			$data['error_string'][] = 'Bulan is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('kegiatan')=='')
		{
			$data['inputerror'][] = 'kegiatan';
			$data['error_string'][] = 'Kegiatan is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('kuantitas')=='')
		{
			$data['inputerror'][] = 'kuantitas';
			$data['error_string'][] = 'Kuantitas is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('id_jenis_kuantitas')=='')
		{
			$data['inputerror'][] = 'id_jenis_kuantitas';
			$data['error_string'][] = 'Jenis Kuantitas  is required';
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
		$id_kegiatan_tahunan = $this->input->post('id_kegiatan_tahunan', TRUE);
		
		$kegiatan_bulanans = $this->db->query("select * from kegiatan_bulanan where id_kegiatan_tahunan='$id_kegiatan_tahunan'");
		$option = '<option value=""></option>';
		if ($kegiatan_bulanans->num_rows() > 0)
		{
			foreach ($kegiatan_bulanans->result() as $kegiatan_bulanan) {
				$option .= '<option value="'.$kegiatan_bulanan->id_kegiatan_bulanan.'">'.$kegiatan_bulanan->kegiatan.'</option>';
			}
		}
		echo $option;
	}
}
// END Kegiatan_bulanan Class
/* End of file kegiatan_bulanan.php */
/* Location: ./sytem/application/controlers/kegiatan_bulanan.php */		
  