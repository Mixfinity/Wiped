<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
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

		$projects = $this->project_model->getProjectsForUser($this->session->userdata["user_id"]);

		$data["projects"] = $projects;
		$data["baseuri_agenda"] = "https://calendar.google.com/calendar/embed?mode=WEEK&src=#MAIL#&ctz=Europe/Amsterdam";
		$data["mixfinity_users"] = $this->config_model->getUsersFromMixfinity();



		$this->load->view('dashboard/overview', $data);
		$this->load->view('common/footer');
	}
}
