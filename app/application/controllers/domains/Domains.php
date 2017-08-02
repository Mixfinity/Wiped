<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Domains extends CI_Controller {
	public function __construct()
   {
   		parent::__construct();
        $this->load->library('login');
     	$this->login->check();
        $this->load->library('session');

   }

	public function index()
	{
		$this->load->view('common/header');
		$this->load->model("ModelMenu", "menu");
		$temp_menu = $this->menu->getMenu();
		$menudata = array(
			"menu" => $temp_menu
		);
		$this->load->view('common/menu', $menudata);

		$this->load->model("projects/MProjects", "project_model");
		$this->load->model("config/config", "config_model");

		$url = "https://www.mixfinity.nl/json_feed.php";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL,$url);
		$result=curl_exec($ch);
		curl_close($ch);


		$list = json_decode($result, true);
				




		$this->load->view('domains/overview', array("list" => $list));
		$this->load->view('common/footer');
	}
}
