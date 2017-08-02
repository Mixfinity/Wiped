<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Work extends CI_Controller {
	public function __construct()
   {
   		parent::__construct();
        $this->load->library('login');
     	$this->login->check();
        $this->load->library('session');

   }

	public function index($date = null, $f_user = null)
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

		$user = $_SESSION["user_id"];

		if($_SESSION["profile_id"] == 1){
			if($f_user != null){
				$user = $f_user;
			} 
		}

		if($date == null){
			$date = date("d-m-Y");   
		}
	
		$data = array(
			"date" => $date,
			"timestamps" => $this->project_model->getWorkReport($date, $user),
			"users" => $this->config_model->getUsers(),
			"current_user" => $user
		);

		$this->load->view('work/overview', $data);
		$this->load->view('common/footer');
	}

	
}
