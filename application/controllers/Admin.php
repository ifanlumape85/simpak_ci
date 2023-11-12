<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	var $limit = 10;
	var $title = 'admin';

	function index()
	{
		if ($this->session->userdata('login') == TRUE) {
			$this->get_welcome_message();
		} else {
			redirect(base_url());
		}
	}

	function get_welcome_message()
	{
		$data['title'] 	 	= $this->title;
		$data['h2_title'] 	= 'Welcome';
		$data['main_view'] 	= 'admin/welcome_message';
		if ($this->session->userdata('login') == TRUE) {
			$this->load->view('admin/template', $data);
		}
	}

	function login()
	{
		if ($this->session->userdata('login') == TRUE) {
			redirect(base_url());
		} else {
			$this->load->view('login/login_view');
		}
	}

	function process_login()
	{
		$this->load->model('User_model', 'user_model', TRUE);
		$this->form_validation->set_rules('user_name', 'User Name', 'required');
		$this->form_validation->set_rules('user_password', 'User Password', 'required|md5');

		if ($this->form_validation->run() == TRUE) {
			$user_name = $this->input->post('user_name', TRUE);
			$user_password = $this->input->post('user_password', TRUE);

			if ($this->user_model->count_all(array('user_name' => $user_name, 'user_password' => $user_password)) == TRUE) {
				$user = $this->user_model->get_by_id(array('user.user_name' => $user_name));
				$data = array(
					'user_id' 		=> $user->user_id,
					'pegawai_id' 	=> $user->id_pegawai,
					'pegawai_nip' 	=> $user->nip,
					'instansi_id' 	=> $user->id_instansi,
					'instansi_name' => $user->nama_instansi,
					'user_name' 	=> $user->nama_pegawai,
					'user_full_name' => $user->nama_pegawai,
					'user_email'	=> $user->user_email,
					'user_level_id' => $user->user_level_id,
					'user_level_name' => $user->user_level_name,
					'user_photo'	=> $user->photo,
					'user_date_entri' => $user->user_date_entri,
					'login'			=> TRUE,
				);
				$this->session->set_userdata($data);

				if ($data['user_level_id'] == 1)
					redirect('dashboard');
				elseif ($data['user_level_id'] == 3)
					redirect('dashboard/instansi/' . decode($data['instansi_id']) . '/' . url_title($data['instansi_name']));
				else
					redirect('presensi/v_pegawai/' . decode($data['pegawai_id']) . '/' . url_title($data['user_full_name']));
			} else {

				$this->session->set_flashdata('message', 'Maaf, username atau password anda salah');
				redirect('login/admin');
			}
		}
		$this->load->view('login/login_view');
	}
}
// END Admin Class
/* End of file admin.php */
/* Location: ./sytem/application/controlers/admin.php */