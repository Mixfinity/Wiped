<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offers extends CI_Controller {
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
		$this->load->model('offers/ModelOffersOffers', 'offer_model');
		$notfound = false;
		$deleted = false;
		if($this->input->get('notfound')){
			$notfound = true;
		}
		if($this->input->get('deleted')){
			$deleted = true;
		}
		$data = array(
			'offers' => $this->offer_model->getAllCreateOffers(),
			'sendoffers' => $this->offer_model->getAllSendOffers(),
			'archiveoffers' => $this->offer_model->getAllArchiveOffers(),
			'notfound' => $notfound,
			'deleted' => $deleted
		);
		$this->load->view('offers/overview', $data);
		$this->load->view('common/footer');
	}

	public function delete($f_id)
	{
		$this->load->database();
		$this->load->helper('url');
		$this->db->update('offers', array("offer_status" => -1), array("id" => $f_id));
		redirect("/offers/offers?deleted=1");
	}


	public function create()
	{
		$this->load->database();
		$this->load->helper('url');
		$this->load->view('common/header');
		$this->load->model("ModelMenu", "menu");
			$temp_menu = $this->menu->getMenu();
			$menudata = array(
				"menu" => $temp_menu
			);
			$this->load->view('common/menu', $menudata);
		$this->load->model('offers/ModelOffersOffers', 'offer_model');
		if($this->input->post('contact_name')){
			$contact_id = $this->offer_model->getContactId($this->input->post('contact_name'));
			$insert_data = array(
				'contact_id' => $contact_id,
				'expiration_date' => $this->input->post('expiration_date'),
				'name' => $this->input->post('name'),
				'sended' => false,
				'offer_status' => 0,
				'date_created' => date('Y-m-d H:i:s'),
				'created_by' => $this->session->userdata('user_id')
			);
			$return_id = $this->offer_model->insert($insert_data, 'offers');
			redirect('/offers/offers/edit/' . $return_id . "?saved=1");
		}
		$this->load->view('offers/create');
		$this->load->view('common/footer');
	}


	public function edit($id)
	{
		$this->load->database();
		$this->load->view('common/header');
		$this->load->model("ModelMenu", "menu");
			$temp_menu = $this->menu->getMenu();
			$menudata = array(
				"menu" => $temp_menu
			);
			$this->load->view('common/menu', $menudata);
		$this->load->model('offers/ModelOffersOffers', 'offer_model');
		$offer = $this->offer_model->getOffer($id);
		if($offer){
			$categories = $this->offer_model->getOfferCategories();
			$category_data = array();
			foreach($categories as $category){
				$offer_lines = $this->offer_model->getDefaultOfferLines($category->id);
				$category_data[]=array($category->name => $offer_lines);
			}
			$current_offer_lines = $this->offer_model->getOfferLines($id);

			$sended = false;
			if($this->input->get("sended")){
				$sended = true;
			}



			$data = array(
				'categories' => (object)$category_data,
				'current_lines' => $current_offer_lines,
				'offer' => $offer,
				'sended' => $sended,
				'offer_id' => $id
			);
			$this->load->view('offers/edit', $data);
			$this->load->view('common/footer');
		} else {
			$this->load->helper('url');
			redirect("/offer/offer");
		}
	}

	public function addOfferLine($default_line, $offer_id)
	{
		$this->load->database();
		$this->load->model('offers/ModelOffersOffers', 'offer_model');
		$line_data = $this->offer_model->getLineData($default_line);

		$save = array(
			"offer_id" => $offer_id,
			"name"	=> $line_data->name,
			"description" => $line_data->description,
			"image" => $line_data->image,
			"work_hour" => $line_data->work_hour,
			"price" => $line_data->price,
			"show_price_on_end" => $line_data->show_price_on_end,
			"date_created" => date('Y-m-d H:i:s') ,
			"date_lastupdate" => date('Y-m-d H:i:s') ,
			"priority" => ($this->offer_model->getHighestPrio($offer_id) + 1),
			"created_by" => $this->session->userdata('user_id'), //current user
			"fixed_price" => $line_data->fixed_price
		);
		$last_id = $this->offer_model->insert($save, 'offer_lines');
		echo $last_id;
	}

	public function setOfferLinesPriority()
	{
		$this->load->database();
		$this->load->model('offers/ModelOffersOffers', 'offer_model');
		$priority = 1;
		if($this->input->post('line')){
			foreach($this->input->post('line') as $line){
				$update = array(
					'priority' => $priority
				);
				$where = "id = '".$line."'";
				$this->offer_model->update($update, 'offer_lines', $where);
				$priority++;
			}
		}
	}

	public function removeOfferLine($line_id)
	{
		$this->load->database();
		$this->load->model('offers/ModelOffersOffers', 'offer_model');
		$this->offer_model->removeOfferLine($line_id);
	}

	public function generatePreview($offer_id)
	{
		$this->load->database();
		$this->load->model('offers/ModelOffersOffers', 'offer_model');
		$current_offer_lines = $this->offer_model->getOfferLines($offer_id);
		$data = array('lines' => $current_offer_lines);
		$this->load->view('offers/preview.php', $data);
	}

	public function getOfferLineEditFrm($id)
	{
		$this->load->database();
		$this->load->model('offers/ModelOffersOffers', 'offer_model');
		$line = $this->offer_model->getLine($id);
		$data = array(
			'line' => $line
		);
		$this->load->view('offers/editline', $data);
	}

	public function saveOfferLine()
	{
		$this->load->database();
		$this->load->model('offers/ModelOffersOffers', 'offer_model');
		if($this->input->post()){
			$data = array(
				'name' => $this->input->post('name'),
				'description' => $this->input->post('description'),
				'image' => $this->input->post('image'),
				'work_hour' => $this->input->post('work_hour'),
				'price' => $this->input->post('price'),
				'show_price_on_end' => $this->input->post('show_price_on_end'),
				'date_lastupdate' => date('Y-m-d H:i:s'),
				'fixed_price' => $this->input->post('fixed_price')
			);
			$where = "id = " . $this->db->escape($this->input->post("id"));
			$this->offer_model->update($data, 'offer_lines', $where);
			echo "OK";
		} else {
			echo "UNKNOWN";
		}
	}

	public function pdf($offer_id)
	{
	    $this->load->helper(array('dompdf', 'file'));  
	    $this->load->database();
		$this->load->model('offers/ModelOffersOffers', 'offer_model');
		$current_offer_lines = $this->offer_model->getOfferLines($offer_id);
		$data = array('lines' => $current_offer_lines);
		$html = $this->load->view('offers/preview.php', $data, true);
	    $data = pdf_create($html, '', false);
	    $this->output->set_header("Content-Disposition:attachment;filename=offerte_" . $offer_id . ".pdf");
	    $this->output->set_content_type('pdf')->set_output($data);
	}

	public function contactAjax($f_input){
		$this->load->database();
		$this->load->model("contacts/ModelContactsContacts","contact_model");
		$contacts = $this->contact_model->getContactsAjax($f_input);
		$this->output->set_content_type('json');
		echo "[";
			$data = "";
			foreach($contacts as $contact){
				$data = $data . "{";
					$data = $data . '"name": "' . $contact->name . '", "id": "' . $contact->id . '"';
				$data = $data .  "},";
			}
			$data = substr_replace($data, "", -1);
			echo $data;
		echo "]";

	}

	public function offerSended($f_id = 0){
		$this->load->database();
		if($f_id > 0){
			$data = array(
				"offer_status" => 1,
				"date_sended" => date('Y-m-d H:i:s')
			);
			$this->db->update('offers', $data, array("id" => $f_id));
		}
	}

	public function offerApprove($f_id = 0){
		$this->load->database();
		if($f_id > 0){
			$this->load->model("offers/ModelOffersOffers", "offer_model");
			$offer = $this->offer_model->getOffer($f_id);

		

				$data = array(
					"contact_id" => $offer->contact_id,
					"user_id" => $this->session->userdata("user_id"),
					"offer_id" => $offer->id,
					"status_id" => (int)1,
					"name" => $offer->name,
					"date_created" =>  date('Y-m-d H:i:s')
				);

				$this->db->insert("projects", $data);

				echo $this->db->insert_id();

				$this->db->update('offers', array("offer_status" => 2), array("id" => $f_id));
			
		}
	}	
}

