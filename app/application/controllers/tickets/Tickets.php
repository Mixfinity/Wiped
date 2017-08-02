<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets extends CI_Controller {
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

		$this->load->view('tickets/overview');
		$this->load->view('common/footer');
	}
}
