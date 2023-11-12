<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * @author		Ifan Lumape
 * @Email		fnnight@gmail.com.
 * @Start		22 April 2014
 * @Web			http://www.ifanlumape.com
 *
 */
class Dashboard extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Jenis_presensi_model', 'jenis_presensi', TRUE);
		$this->load->model('Instansi_model', 'instansi', TRUE);
	}
	
	function index()
	{
		if ($this->session->userdata('login') == TRUE)
		{
			$this->load->helper('url');
			$data = array(
				'title' 			=> 'Dashboard', 
				'main_view' 		=> 'admin/dashboard', 
				'form_view' 		=> 'admin/dashboard_form',
			);

			if ($this->session->userdata('user_level_id') > 1)
			    $instansis = $this->instansi->get_list_instansi(array('id_instansi' => $this->session->userdata('instansi_id')));		
			else 
				$instansis = $this->instansi->get_list_instansi();		
				
			$opt_instansi = array('' => 'Pilih Instansi');
		    foreach ($instansis as $i => $v) {
		        $opt_instansi[$i] = $v;
		    }

		    $data['form_instansi'] = form_dropdown('id_instansi',$opt_instansi,'','id="id_instansi" class="form-control"');
			$data['form_instansi2'] = form_dropdown('id_instansi2',$opt_instansi,'','id="id_instansi2" class="form-control"');
			$data['options_instansi'] = $opt_instansi;
			
			$jenis_presensis = $this->jenis_presensi->get_list_jenis_presensi();		
			$opt_jenis_presensi = array('' => 'Pilih Jenis Presensi');
		    foreach ($jenis_presensis as $i => $v) {
		        $opt_jenis_presensi[$i] = $v;
		    }

		    $data['form_jenis_presensi'] = form_dropdown('id_jenis_presensi',$opt_jenis_presensi,'','id="id_jenis_presensi" class="form-control"');
			$data['form_jenis_presensi2'] = form_dropdown('id_jenis_presensi2',$opt_jenis_presensi,'','id="id_jenis_presensi2" class="form-control"');
			$data['options_jenis_presensi'] = $opt_jenis_presensi;
			
			$this->load->view('admin/template', $data);
		}
		else
		{
			redirect(base_url());
		}
	}

	function instansi($id_instansi)
	{
		if ($this->session->userdata('login') == TRUE)
		{
			$this->load->helper('url');

			$id_instansi = encode($id_instansi);

			$data = array(
				'title' 		=> 'Dashboard', 
				'main_view' 	=> 'admin/dashboard2', 
				'id_instansi'	=> $id_instansi,
				'form_view' 	=> 'admin/dashboard_form2',
			);
			

			$instansis = $this->instansi->get_list_instansi($id_instansi);		
				
			$opt_instansi = array('' => 'Pilih Instansi');
		    foreach ($instansis as $i => $v) {
		        $opt_instansi[$i] = $v;
		    }

		    $data['form_instansi'] = form_dropdown('id_instansi',$opt_instansi,'','id="id_instansi" class="form-control"');
			$data['form_instansi2'] = form_dropdown('id_instansi2',$opt_instansi,'','id="id_instansi2" class="form-control"');
			$data['options_instansi'] = $opt_instansi;
			
			$jenis_presensis = $this->jenis_presensi->get_list_jenis_presensi();		
			$opt_jenis_presensi = array('' => 'Pilih Jenis Presensi');
		    foreach ($jenis_presensis as $i => $v) {
		        $opt_jenis_presensi[$i] = $v;
		    }

		    $data['form_jenis_presensi'] = form_dropdown('id_jenis_presensi',$opt_jenis_presensi,'','id="id_jenis_presensi" class="form-control"');
			$data['form_jenis_presensi2'] = form_dropdown('id_jenis_presensi2',$opt_jenis_presensi,'','id="id_jenis_presensi2" class="form-control"');
			$data['options_jenis_presensi'] = $opt_jenis_presensi;
			
			$this->load->view('admin/template', $data);
		}
		else
		{
			redirect(base_url());
		}
	}
	
	function absensi()
	{
		$this->load->helper('url');
		$data = array(
			'title' 	=> 'Dashboard', 
			'main_view' => 'pegawai/dashboard', 
			'form_view' => 'pegawai/dashboard_form',
		);
		$this->load->view('admin/template', $data);
	}

	function kinerja()
	{
		$this->load->helper('url');
		$data = array(
			'title' 	=> 'Dashboard', 
			'main_view' => 'pegawai/dashboard', 
			'form_view' => 'pegawai/dashboard_form',
		);
		$this->load->view('admin/template', $data);
	}

	function profil()
	{
		$this->load->helper('url');
		$data = array(
			'title' 	=> 'Dashboard', 
			'main_view' => 'pegawai/dashboard', 
			'form_view' => 'pegawai/dashboard_form',
		);
		$this->load->view('admin/template', $data);
	}
}
// END Admin Class
/* End of file admin.php */
/* Location: ./sytem/application/controlers/admin.php */