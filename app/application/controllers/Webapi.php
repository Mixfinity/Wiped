<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webapi extends CI_Controller {

	public function __construct()
   {
   		parent::__construct();
        $this->load->library('login');
     	$this->login->check(); 
        $this->load->library('session'); 

   }

	public function changeMenuState(){
		$this->load->database();
		$query = $this->db->get_where('users', array("id" => $this->session->userdata("user_id")));
		if($query->num_rows() > 0){
			$row = $query->row();
		
			if (!is_null($row->menu_state)) {
				$this->db->update('users', array("menu_state" => NULL), array("id" => $this->session->userdata("user_id")));
				$this->session->set_userdata('menu_state', 0);
			} else {
				$this->db->update('users', array("menu_state" => "1"), array("id" => $this->session->userdata("user_id")));
				$this->session->set_userdata('menu_state', 1);
			}

		}
	}

	public function setCardToList($card_id = "", $list_id = "") {
		if(!empty($card_id) && !empty($list_id)){
			$this->load->model("trello/TrelloModel", "trello_model");
			$this->trello_model->moveCard($card_id, $list_id);			
			echo "DONE";
		} 
			else 
		{
			show_404();
		}
	}





	
}
