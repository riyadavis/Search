<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SearchApi extends CI_Controller {

	public function __construct()
	{
		parent :: __construct();
		$this->load->model('SearchDatabase');
		// if($this->session->has_userdata('userauth') == FALSE)
        // {
		// 	$this->AddToCartDatabase->SaltData();
		// 	if($this->session->has_userdata('userauth') == FALSE)
		// 	{
		// 		echo json_encode("error");
		// 		die();
		// 	}
		// }
	}

	public function index()
	{
		// redirect('SearchApi/search');
		//get values from user
		//call model
		//call any supporting modules
		$data['items'] = [['id'=>1, 'name'=>'TV', 'price'=>12000],['id'=>2, 'name'=>'Smart Phone', 'price'=>2000]];
		$this->load->view('API/json_data',$data);
	}

	public function distance()
	{
		$long1 = deg2rad(76.318351); 
		$long2 = deg2rad(76.299840); 
		$lat1 = deg2rad(9.991033); 
		$lat2 = deg2rad(9.982746); 
		   
		//Haversine Formula 
		$dlong = $long2 - $long1; 
		$dlati = $lat2 - $lat1; 
		   
		$val = pow(sin($dlati/2),2)+cos($lat1)*cos($lat2)*pow(sin($dlong/2),2); 
		   
		$res = 2 * asin(sqrt($val)); 
		   
		$radius = 6373; 
		   
		echo ($res*$radius); 		
	}
	public function search()
	{
		$this->load->view('Search');
	}

	public function searchResult()
	{
		$data['items'] = $this->SearchDatabase->searchResult();
		$this->load->view('API/json_data',$data);
	}

	public function shop()
	{
		$data = $this->SearchDatabase->shop();
		$this->load->view('API/json_data',$data);
	}

	public function addCoord()
	{
		$this->load->view('shop');
	}

	public function locCoordinates()
	{
		$data = $this->SearchDatabase->locCoordinates();
		$this->load->view('API/json_data',$data);
	}

	public function shopDetails()
	{
		$data = $this->SearchDatabase->shopDetails();
		$this->load->view('API/json_data',$data);
	}
	public function c()
	{
		$data = $this->SearchDatabase->c();
		// echo $data;
		// print_r($data);
		$this->load->view('API/json_data',$data);
	}

}
