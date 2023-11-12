<?php
class Jenis_kuantitas extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
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
			'title' 	=> 'Data Jenis kuantitas', 
			'main_view' => 'jenis_kuantitas/jenis_kuantitas', 
			'form_view' => 'jenis_kuantitas/jenis_kuantitas_form',
			);

			$this->load->view('admin/template', $data);
		}
	}

	public function ajax_list()
	{
		$this->load->helper('url');
		$list = $this->jenis_kuantitas->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $jenis_kuantitas) {
			$no++;
			$row = array();

			$row[] = '<input type="checkbox" class="data-check" value="'.$jenis_kuantitas->id_jenis_kuantitas.'">';
			$row[] = $no;
			$row[] = $jenis_kuantitas->nama_jenis_kuantitas; 
			
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_jenis_kuantitas('."'".$jenis_kuantitas->id_jenis_kuantitas."'".')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah</a>
				  <a class="btn btn-sm btn-danger btn-flat" href="javascript:void(0)" title="Hapus" onclick="delete_jenis_kuantitas('."'".$jenis_kuantitas->id_jenis_kuantitas."'".')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a>';
		
			$data[] = $row;
		}

		$output = array(
		"draw" 				=> $_POST['draw'],
		"recordsTotal" 		=> $this->jenis_kuantitas->count_all(),
		"recordsFiltered" 	=> $this->jenis_kuantitas->count_filtered(),
		"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->jenis_kuantitas->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
	
		
		$data = array(
		'nama_jenis_kuantitas'=> $this->input->post('nama_jenis_kuantitas', TRUE),
		);
		$insert = $this->jenis_kuantitas->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		
		$data = array(
		'nama_jenis_kuantitas'=> $this->input->post('nama_jenis_kuantitas', TRUE),
		);
		$this->jenis_kuantitas->update(array('id_jenis_kuantitas' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		if ($this->input->post('id', TRUE)!="")
			$id = $this->input->post('id', TRUE);

		$this->jenis_kuantitas->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->jenis_kuantitas->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }
	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		

		if ($this->input->post('nama_jenis_kuantitas')=='')
		{
			$data['inputerror'][] = 'nama_jenis_kuantitas';
			$data['error_string'][] = 'Nama Jenis Kuantitas  is required';
			$data['status'] = FALSE;							
		}
		

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	function list_jenis_kuantitas()
	{
      	$sql="SELECT * FROM jenis_kuantitas";

        $qry = $this->db->query($sql);
       	if ($qry->num_rows() > 0)
       {

    		$jenis_kuantitass=array();
            foreach($qry->result() as $row)
            {
                array_push($jenis_kuantitass, 
                    array(
                    "id" => $row->id_jenis_kuantitas,
                    "nama_jenis_kuantitas" => $row->nama_jenis_kuantitas
                    )
                );
            }
            print(json_encode(array("code" => 1, "message"=>"Success", "result"=>$jenis_kuantitass, "jenis_kuantitas" => $jenis_kuantitass)));
        }
        else
        {
       		print(json_encode(array("code" => 2, "message"=>"Data Not Found")));
        }
	}
}
// END Jenis_kuantitas Class
/* End of file jenis_kuantitas.php */
/* Location: ./sytem/application/controlers/jenis_kuantitas.php */		
  