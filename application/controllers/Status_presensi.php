<?php
class Status_presensi extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Status_presensi_model', 'status_presensi', TRUE);

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
			'title' 	=> 'Data Status presensi', 
			'main_view' => 'status_presensi/status_presensi', 
			'form_view' => 'status_presensi/status_presensi_form',
			);

			$this->load->view('admin/template', $data);
		}
	}

	public function ajax_list()
	{
		$this->load->helper('url');
		$list = $this->status_presensi->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $status_presensi) {
			$no++;
			$row = array();

			$row[] = '<input type="checkbox" class="data-check" value="'.$status_presensi->id_status_presensi.'">';
			$row[] = $no;
			$row[] = $status_presensi->nama_status_presensi; 
			
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_status_presensi('."'".$status_presensi->id_status_presensi."'".')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah</a>
				  <a class="btn btn-sm btn-danger btn-flat" href="javascript:void(0)" title="Hapus" onclick="delete_status_presensi('."'".$status_presensi->id_status_presensi."'".')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a>';
		
			$data[] = $row;
		}

		$output = array(
		"draw" 				=> $_POST['draw'],
		"recordsTotal" 		=> $this->status_presensi->count_all(),
		"recordsFiltered" 	=> $this->status_presensi->count_filtered(),
		"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->status_presensi->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
	
		
		$data = array(
		'nama_status_presensi'=> $this->input->post('nama_status_presensi', TRUE),
		);
		$insert = $this->status_presensi->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		
		$data = array(
		'nama_status_presensi'=> $this->input->post('nama_status_presensi', TRUE),
		);
		$this->status_presensi->update(array('id_status_presensi' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		if ($this->input->post('id', TRUE)!="")
			$id = $this->input->post('id', TRUE);

		$this->status_presensi->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->status_presensi->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		

		if ($this->input->post('nama_status_presensi')=='')
		{
			$data['inputerror'][] = 'nama_status_presensi';
			$data['error_string'][] = 'Nama Status Presensi  is required';
			$data['status'] = FALSE;							
		}
		

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	function list_status_presensi()
	{
      	$sql="SELECT * FROM status_presensi";

        $qry = $this->db->query($sql);
       	if ($qry->num_rows() > 0)
       {

    		$status_presensis=array();
            foreach($qry->result() as $row)
            {
                array_push($status_presensis, 
                    array(
                    "id" => $row->id_status_presensi,
                    "nama_status_presensi" => $row->nama_status_presensi
                    )
                );
            }
            print(json_encode(array("code" => 1, "message"=>"Success", "result"=>$status_presensis)));
        }
        else
        {
       		print(json_encode(array("code" => 2, "message"=>"Data Not Found")));
        }
	}
}
// END Status_presensi Class
/* End of file status_presensi.php */
/* Location: ./sytem/application/controlers/status_presensi.php */		
  