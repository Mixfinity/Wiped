<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contacts extends CI_Controller {

	public function __construct()
   {
   		parent::__construct();
        $this->load->library('login');
     	$this->login->check();
        $this->load->library('session');

   }

   
	
	public function index()
	{
		$this->load->database();

		$this->load->view('common/header');
		$this->load->model("ModelMenu", "menu");
			$temp_menu = $this->menu->getMenu();
			$menudata = array(
				"menu" => $temp_menu
			);
			$this->load->view('common/menu', $menudata);

		$this->load->model('contacts/ModelContactsContacts', 'contact_model');

		$notfound = false;
		$deleted = false;

		if($this->input->get('notfound')){
			$notfound = true;
		}

		if($this->input->get('deleted')){
			$deleted = true;
		}


		$data = array(
			'contacts' => $this->contact_model->getAllContacts(),
			'notfound' => $notfound,
			'deleted' => $deleted
		);

		$this->load->view('contacts/overview', $data);
		$this->load->view('common/footer');
	}

	public function edit($id)
	{
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('contacts/ModelContactsContacts', 'contact_model');
		$this->load->model('offers/ModelOffersOffers', 'offer_model');

		$saved = false;
		

		if($this->input->post('id')){
			$savedata = array(
				"name" => $this->input->post('name'),
				"address" => $this->input->post('address'),
				"zip" => $this->input->post('zip'),
				"city" => $this->input->post('city'),
				"country" => $this->input->post('country'),
				"phone" => $this->input->post('phone'),
				"email" => $this->input->post('email'),
				"website" => $this->input->post('website'),
				"kvk" => $this->input->post('kvk'),
				"btw" => $this->input->post('btw'),
				"contact_name" => $this->input->post('contact_name'),
				"contact_phone" => $this->input->post('contact_phone'),
				"contact_email" => $this->input->post('contact_email'),
				"notify" => $this->input->post('notify')
			);

			$where = " id = '".$this->input->post('id')."'";

			$this->contact_model->update($savedata, 'contacts', $where);

			$saved = true;
			
		}

		if($this->input->get('saved')){
			$saved = true;
		}

		$this->load->view('common/header');
		$this->load->model("ModelMenu", "menu");
			$temp_menu = $this->menu->getMenu();
			$menudata = array(
				"menu" => $temp_menu
			);
			$this->load->view('common/menu', $menudata);

		if(!is_object($this->contact_model->getContact($id))){
			
			redirect('/contacts/contacts?notfound=1');
		}

		$offer = $this->offer_model->getOffersByContact($id);

		$data = array(
			'contact' => $this->contact_model->getContact($id),
			'offers' => $offer,
			'saved' => $saved,
		);




		$this->load->view('contacts/edit', $data);
		$this->load->view('common/footer');
	}

	public function create()
	{
		$this->load->database();
		$this->load->model('contacts/ModelContactsContacts', 'contact_model');
		$this->load->helper('url');


		if($this->input->post('name')){
			$savedata = array(
				"name" => $this->input->post('name'),
				"address" => $this->input->post('address'),
				"zip" => $this->input->post('zip'),
				"city" => $this->input->post('city'),
				"country" => $this->input->post('country'),
				"phone" => $this->input->post('phone'),
				"email" => $this->input->post('email'),
				"website" => $this->input->post('website'),
				"kvk" => $this->input->post('kvk'),
				"btw" => $this->input->post('btw'),
				"contact_name" => $this->input->post('contact_name'),
				"contact_phone" => $this->input->post('contact_phone'),
				"contact_email" => $this->input->post('contact_email'),
				"notify" => $this->input->post('notify'),
				"date_created" => date('Y-m-d H:i:s'),
				"created_by" => $this->session->userdata('user_id'),
				"active" => true
			);

			$id = $this->contact_model->insert($savedata, 'contacts');

			$saved = true;
			redirect('/contacts/contacts/edit/' . $id . "?saved=1");
			
		}
		


		$this->load->view('common/header');
		$this->load->model("ModelMenu", "menu");
			$temp_menu = $this->menu->getMenu();
			$menudata = array(
				"menu" => $temp_menu
			);
			$this->load->view('common/menu', $menudata);
	

		$data = '';

		$this->load->view('contacts/create', $data);
		$this->load->view('common/footer');
	}

	public function delete($id)
	{
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('contacts/ModelContactsContacts', 'contact_model');


		$data = array(
			"active" => false
		);

		$where = " id = '".$id."'";

		if($id != ''){
			$this->contact_model->update($data, 'contacts', $where);
		}

		redirect('/contacts/contacts?deleted=1');
		
	}

}
