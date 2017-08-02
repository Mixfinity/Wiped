<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Passwords extends CI_Controller {
	public function __construct()
   {
   		parent::__construct();
        $this->load->library('login');
     	$this->login->check();
        $this->load->library('session');
        $this->load->library('encryption');
        $this->encryption->initialize(
	        array(
	                'cipher' => 'aes-256',
	                'driver' => 'OpenSSL',
	                'mode' => 'cbc',
	                'key' => 'xBan-aLGK)gw^pY5@N1n#0Jt*!IYBo%G' // NEVER EVER CHANGE THIS KEY ;)
	        )
		);

        //$this->encryption->encrypt($plain_text);
        //$this->encryption->decrypt($ciphertext);

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


		$this->load->model('passwords/ModelPasswordsPasswords', 'password_model');

		$overview_data = $this->password_model->getPasswordData();


		$data = array(
			"userdata" => $overview_data,
			"test" => $this->encryption->encrypt("testww")
		);





		$this->load->view('passwords/overview', $data);



		$this->load->view('common/footer');
	}

	public function showDetails($id = 0){

		if($this->login->extendCheck($this->input->post("password"))){
			
			$this->load->model('passwords/ModelPasswordsPasswords', 'password_model');
			$result = $this->password_model->getExtendedData($id);

			if($result){
				$result = $result[0];
						
				$data = array(
					"name" => $result->name,
					"servername"=>  $result->servername,
					"username"=> $result->username,
					"password"=> $this->encryption->decrypt($result->password)
				);

				
				$this->load->view('passwords/details', $data);

			
			} else {
				echo "Wachtwoord onjuist";
			}

		



		} else {
			echo "Wachtwoord onjuist";
		}

	}

	public function addPassword(){
		if($this->input->post("password")){
		$data = array(
			"name" => $this->input->post("name"),
			"servername" => $this->input->post("servername"),
			"username" => $this->input->post("username"),
			"password" => $this->encryption->encrypt($this->input->post("password")),
			"created_at" => date('Y-m-d H:i:s'),
			"created_by" => $_SESSION["user_id"]
		);

		$this->db->insert('details', $data);

		echo "ok";
	} else { echo "fail"; }

	}

	public function deletePassword($f_id = 0){
		$data = array(
			"id" => $f_id
		);

		$this->db->delete('details', $data);

		echo "OK";
	}


}
