
<?php
class Banner extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Banner_model', 'banner', TRUE);

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
			'title' 	=> 'Data Banner', 
			'main_view' => 'banner/banner', 
			'form_view' => 'banner/banner_form',
			);

			$this->load->view('admin/template', $data);
		}
	}

	public function ajax_list()
	{
		$this->load->helper('url');
		$list = $this->banner->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $banner) {
			$no++;
			$row = array();

			$row[] = '<input type="checkbox" class="data-check" value="'.$banner->id_banner.'">';
			$row[] = $no;
			$row[] = $banner->judul_banner; 
			$row[] = $banner->photo; 
			$row[] = $banner->tgl_input; 
			$row[] = $banner->tgl_update; 
						
			 if($banner->photo)
			 	$row[] = '<a href="'.base_url('upload/banner/thumbs/'.$banner->photo).'" target="_blank"><img src="'.base_url('upload/banner/thumbs/'.$banner->photo).'" class="img-responsive" /></a>';
			 else
			 	$row[] = '(No photo)';
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary btn-flat" href="javascript:void(0)" title="Edit" onclick="edit_banner('."'".$banner->id_banner."'".')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah</a>
				  <a class="btn btn-sm btn-danger btn-flat" href="javascript:void(0)" title="Hapus" onclick="delete_banner('."'".$banner->id_banner."'".')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a>';
		
			$data[] = $row;
		}

		$output = array(
		"draw" 				=> $_POST['draw'],
		"recordsTotal" 		=> $this->banner->count_all(),
		"recordsFiltered" 	=> $this->banner->count_filtered(),
		"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->banner->get_by_id($id);
		$data->tgl_input = ($data->tgl_input == '00-00-0000') ? '' : date('d-m-Y', strtotime($data->tgl_input)); // if 0000-00-00 set tu empty for datepicker compatibility				
						
		$data->tgl_update = ($data->tgl_update == '00-00-0000') ? '' : date('d-m-Y', strtotime($data->tgl_update)); // if 0000-00-00 set tu empty for datepicker compatibility				
						
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
	
		
		$data = array(
		'judul_banner'=> $this->input->post('judul_banner', TRUE),
		'tgl_input'=> date('Y-m-d', strtotime($this->input->post('tgl_input', TRUE))),
		'tgl_update'=> date('Y-m-d', strtotime($this->input->post('tgl_update', TRUE))),
		);		
		if(!empty($_FILES['photo']['name']))
		{
		 	$upload = $this->_do_upload();
		 	$data['photo'] = $upload;
		}
		$insert = $this->banner->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		
		$data = array(
		'judul_banner'=> $this->input->post('judul_banner', TRUE),
		'tgl_input'=> date('Y-m-d', strtotime($this->input->post('tgl_input', TRUE))),
		'tgl_update'=> date('Y-m-d', strtotime($this->input->post('tgl_update', TRUE))),
		);		
		
		if($this->input->post('remove_photo')) // if remove photo checked
		{
		 	if(file_exists('upload/banner/'.$this->input->post('remove_photo')) && $this->input->post('remove_photo'))
		 	{
				unlink('upload/banner/'.$this->input->post('remove_photo'));
		 		unlink('upload/banner/thumbs/'.$banner->photo);
		 	}
		 	$data['photo'] = '';
		}

		if(!empty($_FILES['photo']['name']))
		{
		 	$upload = $this->_do_upload();
			
		 	//delete file
		 	$banner = $this->banner->get_by_id($this->input->post('id'));
		 	if(file_exists('upload/banner/'.$banner->photo) && $banner->photo)
		 	{
		 		unlink('upload/banner/'.$banner->photo);
		 		unlink('upload/banner/thumbs/'.$banner->photo);
		 	}

		 	$data['photo'] = $upload;
		}
		$this->banner->update(array('id_banner' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{	
		if ($this->input->post('id', TRUE)!="")
			$id = $this->input->post('id', TRUE);

		$banner = $this->banner->get_by_id($id);
		if(file_exists('upload/banner/'.$banner->photo) && $banner->photo)
		{
		 	unlink('upload/banner/'.$banner->photo);
		 	unlink('upload/banner/thumbs/'.$banner->photo);
		}
		$this->banner->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->banner->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }	
	private function _do_upload()
	{
	 	$config['upload_path']    = 'upload/banner/';
        $config['allowed_types']  = 'gif|jpg|png';
        $config['max_size']       = 1024; //set max size allowed in Kilobyte
        $config['max_width']      = 1000; // set max width image allowed
        $config['max_height']     = 1000; // set max height allowed
        $config['file_name']      = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('photo')) //upload and validate
        {
            $data['inputerror'][] = 'photo';
	 		$data['error_string'][] = 'Upload error: '.$_FILES['photo']['type'].' '.$this->upload->display_errors('',''); //show ajax error
	 		$data['status'] = FALSE;
	 		echo json_encode($data);
	 		exit();
	 	}
	 	$file 		= $this->upload->data();
	 	$nama_file 	= $file['file_name'];					
									  
		
	 	$config = array(
	 		'source_image' 	=> $file['full_path'],
	 		'new_image' 		=> './upload/banner/thumbs/',
	 		'maintain_ration' => TRUE,
	 		'width' 			=> 110,
	 		'height' 			=> 82
	 	);
							
	 	$this->load->library('image_lib', $config);
	 	$this->image_lib->resize();	
							
	 	return $nama_file;
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		

		if ($this->input->post('judul_banner')=='')
		{
			$data['inputerror'][] = 'judul_banner';
			$data['error_string'][] = 'Judul Banner is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('tgl_input')=='')
		{
			$data['inputerror'][] = 'tgl_input';
			$data['error_string'][] = 'Tgl Input is required';
			$data['status'] = FALSE;							
		}
		
		if ($this->input->post('tgl_update')=='')
		{
			$data['inputerror'][] = 'tgl_update';
			$data['error_string'][] = 'Tgl Update is required';
			$data['status'] = FALSE;							
		}
		

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	function get_banner()
	{
		$qry = $this->db->query("select * from banner order by id_banner desc");
		$banner = $qry->result();
		echo json_encode($banner);
	}
}
// END Banner Class
/* End of file banner.php */
/* Location: ./sytem/application/controlers/banner.php */		
  