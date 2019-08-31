<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SearchApi extends CI_Controller {

	public function __construct()
	{
		parent :: __construct();
		$this->load->model('SearchDatabase');
	}

	public function index()
	{
		redirect('SearchApi/search');
	}

	public function search()
	{
		$this->load->view('Search');
	}

	public function searchResult()
	{
		$data = $this->SearchDatabase->searchResult();
		echo json_encode($data);
	}

	public function shop()
	{
		$data = $this->SearchDatabase->shop();
		echo json_encode($data);
	}

	public function addCoord()
	{
		$this->load->view('shop');
	}

	public function locCoordinates()
	{
		$data = $this->SearchDatabase->locCoordinates();
		echo json_encode($data);
		// echo $data;
	}

	public function shopDetails()
	{
		$data = $this->SearchDatabase->shopDetails();
		echo json_encode($data);
	}
	public function c()
	{
		$data = $this->SearchDatabase->c();
		// echo $data;
		// print_r($data);
		echo json_encode($data);
	}
	public function b()
	{
		$data = $this->SearchDatabase->b();
		echo $data;
	}

}
