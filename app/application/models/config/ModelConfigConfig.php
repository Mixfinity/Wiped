<?php
	class ModelConfigConfig extends CI_Model  {
		public function getOfferCategories(){
			$this->db->order_by('name', 'asc');
			$query = $this->db->get('offer_default_categories');
			return $query->result();
		}

		public function getDefaultOfferLines($id){
			$this->db->order_by('priority', 'asc');
			$query = $this->db->get_where('offer_default_lines', array('category_id' => $id));
			return array($query->result());
		}

		public function getUserByUsername($f_username){
			$query = $this->db->get_where('users', array("username" => $f_username, "active" => 1));
			if($query->num_rows() != 0){
				return $query->row();
			} else {
				return false;
			}
		}

		public function getUserById($f_id){
			$query = $this->db->get_where('users', array("id" => $f_id, "active" => 1));
			if($query->num_rows() != 0){
				return $query->row();
			} else {
				return false;
			}
		}


		public function getProfiles(){
			$this->db->order_by('name', 'asc');
			$query = $this->db->get('profiles');
			return $query->result();
		}

		public function getDivisions(){
			$this->db->order_by('name', 'asc');
			$query = $this->db->get('divisions');
			return $query->result();
		}

		public function getUser($f_id){
			$query = $this->db->get_where("users", array("active" => 1, "id" => $f_id));
			return $query->row();
		}

		public function getUsers(){
			$this->db->order_by('name', 'ASC');
			$query = $this->db->get_where('users', array("active" => 1));
			return $query->result();
		}

		public function getUsersFromMixfinity(){
			$this->db->like('email', '@mixfinity.nl');
			$this->db->order_by('name');
			$query = $this->db->get('users');
			return $query->result();
		}

		public function updateContact($data, $f_id){
			// Save general user info (name, email, profile_id, division_id, startpage)

			if($this->session->userdata('profile_id') == 1){
				$updateData = array(
					"name" => $data["name"],
					"email" => $data["email"],
					"profile_id" => $data["profile_id"],
					"division_id" => $data["division_id"],
					"slogan" => $data["slogan"],
					"start_page" => $data["start_page"]
				);


				$this->db->update('users', $updateData, array("id" => $f_id));


				// Check for duplicate username
				$query = $this->db->get_where('users', array("id <>" => $f_id, "username" => $data["username"]));

				if($query->num_rows() == 0){
					$this->db->update('users', array("username" => $data["username"]), array("id" => $f_id));
				} else {
					return "DUPLICATE USERNAME";
				}

				if($data["password"] != "*************************"){
					$this->load->library('login');
					$user = $this->getUser($f_id);
					$hash = $this->login->getPasswordHash($data["password"], $user);
					$this->db->update('users', array("password" => $hash) , array("id" => $f_id));
				}





			} else {

				if($f_id == $this->session->userdata('user_id')) {

					$updateData = array(
						"name" => $data["name"],
						"email" => $data["email"],
						"slogan" => $data["slogan"]
					);


					$this->db->update('users', $updateData, array("id" => $f_id));


					if($data["password"] != "*************************"){
						$this->load->library('login');
						$user = $this->getUser($f_id);
						$hash = $this->login->getPasswordHash($data["password"], $user);
						$this->db->update('users', array("password" => $hash) , array("id" => $f_id));
					}
				}

			}
			

			



		}

		public function insertContact($data){
			$this->load->library('login');
			$updateData = array(
				"name" => $data["name"],
				"email" => $data["email"],
				"profile_id" => $data["profile_id"],
				"division_id" => $data["division_id"],
				"slogan" => $data["slogan"],
				"date_created" =>  date('Y-m-d H:i:s'),
				"active" => 1, 
				"start_page" => $data["start_page"]
			);
			$this->db->insert('users', $updateData);
			$f_id =  $this->db->insert_id();
			$query = $this->db->get_where('users', array("id <>" => $f_id, "username" => $data["username"]));
			if($query->num_rows() == 0){
				$this->db->update('users', array("username" => $data["username"]), array("id" => $f_id));
			} else {
				return "DUPLICATE USERNAME";
			}
			$user = $this->getUser($f_id);
			$hash = $this->login->getPasswordHash($data["password"], $user);
			$this->db->update('users', array("password" => $hash), array("id" => $f_id));
			return $f_id; 
		}

	} 
?>	