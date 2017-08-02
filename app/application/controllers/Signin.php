<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signin extends CI_Controller {

	public function index()
	{
		$usererror = false;
		$this->load->library('login');
		if($this->input->post()){
			
			$result = $this->login->doLogin($this->input->post("username"), $this->input->post('password'));
			if(!$result){
				$usererror = true;
			}

		
		}
		$data = array(
			"usererror" => $usererror
		);

		$this->load->view("login/login", $data);
	}

	public function logout(){
		$this->load->library('session');
		$sessiondata = array(
			"name" => '',
			"user_id" =>'',
			"profile_id" => '',
			"division_id" => '',
			"profile_image" => '',
			"email" => ''
		);

		$this->session->set_userdata($sessiondata);
		session_unset();
		session_destroy();
		$this->load->helper("url");
		redirect("/signin");
	}
}

