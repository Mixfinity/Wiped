<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Config extends CI_Controller {

		public function __construct()
	   {
	   		parent::__construct();
	        $this->load->library('login');
	     	$this->login->check();
	        $this->load->library('session');	

	   }

		public function index(){
		 
		}

		public function offerlines(){
			$deleted = false;
			$this->load->database();
			$this->load->view('common/header');
			$this->load->model("ModelMenu", "menu");
			$temp_menu = $this->menu->getMenu();
			$menudata = array(
				"menu" => $temp_menu
			);
			$this->load->view('common/menu', $menudata);
			$data = array();

			if($this->input->get('deleted')){
				$deleted = true;
			}

			$this->load->model("config/ModelConfigConfig", "config_model");


			$categories = $this->config_model->getOfferCategories();
			$category_data = array();
			foreach($categories as $category){
				$offer_lines = $this->config_model->getDefaultOfferLines($category->id);
				$category_data[]=array($category->name => $offer_lines);
			}
		
			$data = array(
				'categories' => (object)$category_data,
				'deleted' => $deleted
			);




			$this->load->view('config/offerlines', $data);
			$this->load->view('common/footer');
		}

		public function offerline_edit($f_id = 0){
			$this->load->database();
			$this->load->view('common/header');
			$this->load->model("ModelMenu", "menu");
			$temp_menu = $this->menu->getMenu();
			$menudata = array(
				"menu" => $temp_menu
			);
			$this->load->view('common/menu', $menudata);
			$saved = false; 

			if($this->input->post()){
				if($this->input->post('id')){
					$saved = true;
					$strdata = array(
						"category_id"		=> $this->input->post('category_id'),
						"name" 				=> $this->input->post('name'),
						"description" 		=> $this->input->post('description'),
						"image"				=> $this->input->post('image'),
						"work_hour" 		=> $this->input->post('work_hour'),
						"price" 			=> $this->input->post('price'),
						"show_price_on_end" => $this->input->post('show_price_on_end'),
						"date_lastupdate" 	=> date('Y-m-d H:i:s'),
						"fixed_price" 		=> $this->input->post('fixed_price')
					);
					$where = "id = ". $this->db->escape($this->input->post('id'));
					$this->db->update('offer_default_lines', $strdata, $where);
				} else {
					$saved = true;
					$strdata = array(
						"category_id"		=> $this->input->post('category_id'),
						"name" 				=> $this->input->post('name'),
						"description" 		=> $this->input->post('description'),
						"image"				=> $this->input->post('image'),
						"work_hour" 		=> $this->input->post('work_hour'),
						"price" 			=> $this->input->post('price'),
						"show_price_on_end" => $this->input->post('show_price_on_end'),
						"date_lastupdate" 	=> date('Y-m-d H:i:s'),
						"date_created" 		=> date('Y-m-d H:i:s'),
						"created_by"		=> $this->session->userdata('user_id'),
						"fixed_price" 		=> $this->input->post('fixed_price')
					);
					$this->db->insert('offer_default_lines', $strdata);
					$this->load->helper('url');
					redirect("/config/config/offerline_edit/" .  $this->db->insert_id() . "?saved=1");
				}
			}
			$line = false;

			$this->load->model('offers/ModelOffersOffers', "offer_model");
			$line = $this->offer_model->getLineData($f_id);
			$this->load->model("config/ModelConfigConfig", "config_model");
			$categories = $this->config_model->getOfferCategories();

			if($line){
				$pageType = "Bewerken";
			} else {
				$pageType = "Nieuw";
				
			}

			$data = array(
				"id" => $f_id,
				"line" => $line,
				"saved" => $saved,
				"categories" => $categories,
				"type" => $pageType
			);

			$this->load->view('config/offerline_edit', $data);
			$this->load->view('common/footer');
		}


		public function offerline_delete($f_id){
			if($f_id > 0){
				$this->load->database();

				$this->db->delete("offer_default_lines", array("id" =>  $f_id));
				$this->load->helper("url");
				redirect("/config/config/offerlines?deleted=1");
			}
		}


		public function users(){
			$this->load->database();
			$this->load->view('common/header');
			$this->load->model("ModelMenu", "menu");
			$temp_menu = $this->menu->getMenu();
			$menudata = array(
				"menu" => $temp_menu
			);

			$deleted = false;

			if($this->input->get('deleted')){
				$deleted = true;
			}

			$this->load->view('common/menu', $menudata);
			$this->db->order_by('name');
			$query = $this->db->get_where('users', array("active" => 1));
			$data = array(
				"users" => $query->result(),
				"deleted" => $deleted
			);
			$this->load->view('config/users', $data);
			$this->load->view('common/footer');
		}

		public function user_edit($f_id = 0){

			if($this->session->userdata('profile_id') > 1 ){
				if($f_id != $this->session->userdata('user_id')) {
					$this->load->helper('url');
					redirect("/");
				}
			}

			$this->load->database();
			$this->load->view('common/header');
			$this->load->model("ModelMenu", "menu");
			$temp_menu = $this->menu->getMenu();
			$menudata = array(
				"menu" => $temp_menu
			);
			$this->load->view('common/menu', $menudata);

			$line = "";
			$saved = false;
			$id = $f_id;

			$this->load->model("config/ModelConfigConfig", "config_model");



			if($this->input->post()){
				if($this->input->post('id')){
					$saved = true;

					$saveData = array(
						"name" => $this->input->post('name'),
						"username" => $this->input->post('username'),
						"password" => $this->input->post('password'),
						"email" => $this->input->post('email'),
						"profile_id" => $this->input->post('profile_id'),
						"division_id" => $this->input->post('division_id'),
						"slogan" => $this->input->post('slogan'),
						"start_page" => $this->input->post('start_page')
					);

					$this->config_model->updateContact($saveData, $f_id);

				} else {
					$saved = true;
			
						$saveData = array(
							"name" => $this->input->post('name'),
							"username" => $this->input->post('username'),
							"password" => $this->input->post('password'),
							"email" => $this->input->post('email'),
							"profile_id" => $this->input->post('profile_id'),
							"division_id" => $this->input->post('division_id'),
							"slogan" => $this->input->post('slogan'),
							"start_page" => $this->input->post('start_page')
						);

						$id = $this->config_model->insertContact($saveData);
						$this->load->helper('url');
						redirect('/config/config/user_edit/' . $id );


				}
			}



			$line = $this->config_model->getUser($f_id);

			if($line){
				$pageType = "Bewerken";
			} else {
				$pageType = "Nieuw";
			}

			$profiles = $this->config_model->getProfiles();
			$divisions = $this->config_model->getDivisions();




			$this->db->join('availability a', "ad.id = a.day_id AND a.user_id = '".$f_id."'", "left" );
			$query = $this->db->get('availability_days ad ');

			$workdays = $query->result();

			$data = array(
				"id" => $id,
				"line" => $line,
				"saved" => $saved,
				"type" => $pageType,
				"profiles" => $profiles,
				"workdays" => $workdays,
				"divisions" => $divisions
			);



			$this->load->view('config/user_edit', $data);
			$this->load->view('common/footer');
		}

		public function user_delete($f_id = 0){
			$this->load->database();

			$this->db->update('users', array("active" => 0), array("id" => $f_id));

			$this->load->helper('url');

			redirect("/config/config/users?deleted=1");
		}


		public function rights(){

			$this->load->database();

			$this->load->view('common/header');
			$this->load->model("ModelMenu", "menu");
			$temp_menu = $this->menu->getMenu();
			$menudata = array(
				"menu" => $temp_menu
			);
			$this->load->view('common/menu', $menudata);

			$this->db->order_by("name");
			$profiles = "";

			$query = $this->db->get('profiles');

			if($query->num_rows() > 0){
				$profiles = $query->result();
			}

			$data = array(
				"profiles" => $profiles
			);

			$this->load->view('config/rights', $data);
			$this->load->view('common/footer');
		}

		public function rights_edit($f_id = 0){
			$this->load->database();
			


			if($this->input->post()){

					$profile_id = $this->input->post('profile_id');

					$this->db->delete('rights_tree', array("profile_id" => $profile_id));

					foreach($this->input->post('right') as $key => $value){
						$insertData = array(
							"profile_id" => $profile_id,
							"rights_id" => $value
						);
						$this->db->insert('rights_tree', $insertData);
					}

			}


			$this->load->view('common/header');



			$this->load->model("ModelMenu", "menu");
			$temp_menu = $this->menu->getMenu();
			$menudata = array(
				"menu" => $temp_menu
			);
			$this->load->view('common/menu', $menudata);


			$this->db->select("rights.*, rights_tree.profile_id");
			$this->db->order_by("name");
			$rights = "";
			$this->db->join('rights_tree', 'rights.id = rights_tree.rights_id AND rights_tree.profile_id = ' . $f_id, 'left');
			$query = $this->db->get_where('rights', array("parent_id" => 0));


			if($query->num_rows() > 0){
				$rights = $query->result();
			}

			$data = array(
				"rights" => $rights,
				"profile_id" => $f_id
			);



			$this->load->view('config/rights_edit', $data);
			$this->load->view('common/footer');
		}

		public function saveprofile(){
			$this->load->database();
			if($this->input->post()){
				$this->db->insert('profiles', array("name" => $this->input->post('profile_name')));
			}

		}

		public function general(){
			echo "Hang tight! Feature done soon!";
		}


		public function saveAvailability(){
			$this->load->database();
			if($this->session->userdata('profile_id') == 1){
				if($this->input->post('availability')){
					$this->db->delete("availability", array("user_id" => $this->input->post('user_id')));
					foreach($this->input->post('availability') as $input => $value){
						$data = array(
							"day_id" => $value ,
							"user_id" => $this->input->post('user_id')
						);
						$this->db->insert('availability', $data);
					}
				}
			}
		}



	}
?>