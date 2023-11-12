<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * @author		Ifan Lumape
 * @Email		ifanlumape@yahoo.co.id
 * @Start		11 Agustus 2016
 * @Web			http://www.ifanlumape.com
 *
 */
class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Login_model', '', TRUE);
		$this->load->model('User_model', '', TRUE);
	}

	function admin()
	{
		$this->load->helper('download');
		if($this->session->userdata('login') == TRUE)
		{
			redirect(base_url('dashboard'));
		}
		else
		{
			$this->load->view('login/login_view');
		}
	}

	function index()
	{
		if($this->session->userdata('login') == TRUE)
		{
			redirect(base_url('login/admin'));
		}
		else
		{
			redirect(base_url());
		}
	}

	function process_login()
	{
		$user_name = $this->input->post('username', TRUE);
		$user_password = $this->input->post('password', TRUE);

		if ($user_name!="" && $user_password!="")
		{

		}
	}

	function process_logout()
	{
		$this->session->sess_destroy();
		redirect(base_url(), 'refresh');
	}

	function download()
	{
		$this->load->helper('download');
		force_download ('/upload/apk/apk-release.apk', null);
	}
}

// END Login Class
/* End of file login.php */
/* Location : ./system/appliction/controlers/login.php */