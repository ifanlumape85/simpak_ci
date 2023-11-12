<?php
class Agenda extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Agenda_model', 'agenda', TRUE);

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
			'title' 	=> 'Data Agenda', 
			'main_view' => 'agenda/agenda', 
			'form_view' => 'agenda/agenda_form',
			);

			$jenis_agendas = $this->jenis_agenda->get_list_jenis_agenda();		
			$opt_jenis_agenda = array('' => 'All Jenis Agenda ');
		    foreach ($jenis_agendas as $i => $v) {
		        $opt_jenis_agenda[$i] = $v;
		    }

		    $data['form_jenis_agenda'] = form_dropdown('id_jenis_agenda',$opt_jenis_agenda,'','id="id_jenis_agenda" class="form-control"');
			$data['form_jenis_agenda2'] = form_dropdown('id_jenis_agenda2',$opt_jenis_agenda,'','id="id_jenis_agenda2" class="form-control"');
				$data['options_jenis_agenda'] = $opt_jenis_agenda;
			$this->load->view('admin/template', $data);
		}
	}

	public function ajax_list()
	{
		$this->load->helper('url');
		$list = $this->agenda->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $agenda) {
			$no++;
			$row = array();

			$row[] = '<input type="checkbox" class="data-check" value="'.$agenda->id_agenda.'">';
			$row[] = $no;
			$row[] = $agenda->nama_jenis_agenda; 
			$row[] = tgl_indonesia($agenda->tgl_agenda); 
			$row[] = $agenda->jam_agenda; 
			$row[] = $agenda->detail_agenda; 
			
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_agenda('."'".$agenda->id_agenda."'".')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah</a>
				  <a class="btn btn-sm btn-danger btn-flat" href="javascript:void(0)" title="Hapus" onclick="delete_agenda('."'".$agenda->id_agenda."'".')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a>';
		
			$data[] = $row;
		}

		$output = array(
		"draw" 				=> $_POST['draw'],
		"recordsTotal" 		=> $this->agenda->count_all(),
		"recordsFiltered" 	=> $this->agenda->count_filtered(),
		"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->agenda->get_by_id($id);
		$data->tgl_agenda = ($data->tgl_agenda == '00-00-0000') ? '' : date('d-m-Y', strtotime($data->tgl_agenda)); // if 0000-00-00 set tu empty for datepicker compatibility				
						
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
	
		
		$data = array(
		'id_jenis_agenda'=> $this->input->post('id_jenis_agenda', TRUE),
		'tgl_agenda'=> date('Y-m-d', strtotime($this->input->post('tgl_agenda', TRUE))),
		'jam_agenda'=> $this->input->post('jam_agenda', TRUE),
		'detail_agenda'=> $this->input->post('detail_agenda', TRUE),
		);
		$insert = $this->agenda->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		
		$data = array(
		'id_jenis_agenda'=> $this->input->post('id_jenis_agenda', TRUE),
		'tgl_agenda'=> date('Y-m-d', strtotime($this->input->post('tgl_agenda', TRUE))),
		'jam_agenda'=> $this->input->post('jam_agenda', TRUE),
		'detail_agenda'=> $this->input->post('detail_agenda', TRUE),
		);
		$this->agenda->update(array('id_agenda' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		if ($this->input->post('id', TRUE)!="")
			$id = $this->input->post('id', TRUE);

		$this->agenda->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->agenda->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		

		if ($this->input->post('id_jenis_agenda')=='')
		{
			$data['inputerror'][] = 'id_jenis_agenda';
			$data['error_string'][] = 'Jenis Agenda  is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('tgl_agenda')=='')
		{
			$data['inputerror'][] = 'tgl_agenda';
			$data['error_string'][] = 'Tgl Agenda is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('jam_agenda')=='')
		{
			$data['inputerror'][] = 'jam_agenda';
			$data['error_string'][] = 'Jam Agenda is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('detail_agenda')=='')
		{
			$data['inputerror'][] = 'detail_agenda';
			$data['error_string'][] = 'Detail Agenda is required';
			$data['status'] = FALSE;							
		}
		

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	function get_agenda()
	{
		$agendas = $this->db->query("select * from agenda order by id_agenda desc");
		$agenda = $agendas->result();
		echo json_encode($agenda);
	}
}
// END Agenda Class
/* End of file agenda.php */
/* Location: ./sytem/application/controlers/agenda.php */		
  