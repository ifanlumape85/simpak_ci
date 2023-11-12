<?php
class Jenis_peringatan extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Jenis_peringatan_model', 'jenis_peringatan', TRUE);

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
			'title' 	=> 'Data Jenis peringatan', 
			'main_view' => 'jenis_peringatan/jenis_peringatan', 
			'form_view' => 'jenis_peringatan/jenis_peringatan_form',
			);

			$this->load->view('admin/template', $data);
		}
	}

	public function ajax_list()
	{
		$this->load->helper('url');
		$list = $this->jenis_peringatan->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $jenis_peringatan) {
			$no++;
			$row = array();

			$row[] = '<input type="checkbox" class="data-check" value="'.$jenis_peringatan->id_jenis_peringatan.'">';
			$row[] = $no;
			$row[] = $jenis_peringatan->nama_jenis_peringatan; 
			
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_jenis_peringatan('."'".$jenis_peringatan->id_jenis_peringatan."'".')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah</a>
				  <a class="btn btn-sm btn-danger btn-flat" href="javascript:void(0)" title="Hapus" onclick="delete_jenis_peringatan('."'".$jenis_peringatan->id_jenis_peringatan."'".')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a>';
		
			$data[] = $row;
		}

		$output = array(
		"draw" 				=> $_POST['draw'],
		"recordsTotal" 		=> $this->jenis_peringatan->count_all(),
		"recordsFiltered" 	=> $this->jenis_peringatan->count_filtered(),
		"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->jenis_peringatan->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
	
		
		$data = array(
		'nama_jenis_peringatan'=> $this->input->post('nama_jenis_peringatan', TRUE),
		);
		$insert = $this->jenis_peringatan->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		
		$data = array(
		'nama_jenis_peringatan'=> $this->input->post('nama_jenis_peringatan', TRUE),
		);
		$this->jenis_peringatan->update(array('id_jenis_peringatan' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		if ($this->input->post('id', TRUE)!="")
			$id = $this->input->post('id', TRUE);

		$this->jenis_peringatan->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->jenis_peringatan->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		

		if ($this->input->post('nama_jenis_peringatan')=='')
		{
			$data['inputerror'][] = 'nama_jenis_peringatan';
			$data['error_string'][] = 'Nama Jenis Peringatan  is required';
			$data['status'] = FALSE;							
		}
		

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	function get_jenis_peringatan()
	{
		$qry = $this->db->query("select * from jenis_peringatan");
		foreach ($qry->result() as $key) {
			echo '"'.strtoupper($key->nama_jenis_peringatan).'", ';
		}
	}

	function list_jenis_peringatan()
	{
      	$sql="SELECT * FROM jenis_peringatan where status='1'";

        $qry = $this->db->query($sql);
       	if ($qry->num_rows() > 0)
       {

    		$jenis_peringatans=array();
            foreach($qry->result() as $row)
            {
                array_push($jenis_peringatans, 
                    array(
                    "id" => $row->id_jenis_peringatan,
                    "nama_jenis_peringatan" => $row->nama_jenis_peringatan
                    )
                );
            }
            print(json_encode(array("code" => 1, "message"=>"Success", "result"=>$jenis_peringatans, "jenis_peringatans" => $jenis_peringatans)));
        }
        else
        {
       		print(json_encode(array("code" => 2, "message"=>"Data Not Found")));
        }
	}
}
// END Jenis_peringatan Class
/* End of file jenis_peringatan.php */
/* Location: ./sytem/application/controlers/jenis_peringatan.php */		
  