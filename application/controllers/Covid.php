<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Covid extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		
	}
	var $limit = 10;
	var $api_url = 'https://api.kawalcorona.com/';
	
	function index()
	{
		echo 'COVID API (api.kawalcorona.com)';
	}

	function data_indonesia()
	{
		$url= $this->api_url.'indonesia';
		$get_url = file_get_contents($url);
		$data = json_decode($get_url);

		print(json_encode(array("result"=>$data)));
	}

	function data_provinsi_indonesia()
	{
		$url= $this->api_url.'indonesia/provinsi';
		$get_url = file_get_contents($url);
		$data = json_decode($get_url);
	
		$covid=array();
		foreach ($data as $key => $value) 
		{
			foreach ($value as $key2 => $value2) 
			{
				$v = array();
				foreach ($value2 as $key3 => $value3) 
				{
					$v[$key3] = $value3;
				}
				array_push($covid, $v);
			}
		}

		print(json_encode(array("result"=>$covid)));
	}
	
	public function data_global()
	{
		$url= $this->api_url;
		$get_url = file_get_contents($url);
		$data = json_decode($get_url);
	
		$covid=array();
		foreach ($data as $key => $value) 
		{
			foreach ($value as $key2 => $value2) 
			{
				$v = array();
				foreach ($value2 as $key3 => $value3) 
				{
					$v[$key3] = $value3;
				}
				array_push($covid, $v);
			}
		}

		print(json_encode(array("result"=>$covid)));
	}

	function data_positif()
	{
		$url= $this->api_url.'positif';
		$get_url = file_get_contents($url);
		$data = json_decode($get_url);

		$covid = array();
		$v = array();
		foreach ($data as $key => $value) {
			$v[$key] = $value;
		}
		array_push($covid, $v);
		
		print(json_encode(array("result"=>$covid)));	
	}

	function data_sembuh()
	{
		$url= $this->api_url.'sembuh';
		$get_url = file_get_contents($url);
		$data = json_decode($get_url);

		$covid = array();
		$v = array();
		foreach ($data as $key => $value) {
			$v[$key] = $value;
		}
		array_push($covid, $v);

		print(json_encode(array("result"=>$covid)));	
	}

	function data_meninggal()
	{
		$url= $this->api_url.'meninggal';
		$get_url = file_get_contents($url);
		$data = json_decode($get_url);

		$covid = array();
		$v = array();
		foreach ($data as $key => $value) {
			$v[$key] = $value;
		}
		array_push($covid, $v);
		
		print(json_encode(array("result"=>$covid)));	
	}

	function scrap()
	{

		$ch = curl_init('https://covid19.bolmongkab.go.id/');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		// execute!
		$response = curl_exec($ch);

		// close the connection, release resources used
		curl_close($ch);

		// do anything you want with your response
		var_dump($response);
	}
}
// END Covid Class
/* End of file covid.php */
/* Location: ./sytem/application/controlers/covid.php */