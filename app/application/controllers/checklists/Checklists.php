<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checklists extends CI_Controller {
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

		$this->load->model("checklists/ModelChecklist", "checklist");

		$categories = $this->checklist->getCategories();

		$data = array(
			"categories" => $categories
		);

		$this->load->view('checklists/overview', $data);
		$this->load->view('common/footer');
	}

	public function edit($f_id = 0){
		$this->load->view('common/header');
		$this->load->model("ModelMenu", "menu");
		$temp_menu = $this->menu->getMenu();
		$menudata = array(
			"menu" => $temp_menu
		);
		$this->load->view('common/menu', $menudata);
		$this->load->model("checklists/ModelChecklist", "checklist");

		$items = $this->checklist->getItemsByCategory($f_id);
		$category = $this->checklist->getCategory($f_id);

		$data = array(
			"items" => $items,
			"category" => $category
		);

		$this->load->view('checklists/edit', $data);
		$this->load->view('common/footer');

	}


	public function new(){
		$this->load->view('common/header');
		$this->load->model("ModelMenu", "menu");
		$temp_menu = $this->menu->getMenu();
		$menudata = array(
			"menu" => $temp_menu
		);
		$this->load->view('common/menu', $menudata);


		$this->load->view('checklists/new');
		$this->load->view('common/footer');

	}





	public function edititem($f_id = 0){
		$this->load->view('common/header');
		$this->load->model("ModelMenu", "menu");
		$temp_menu = $this->menu->getMenu();
		$menudata = array(
			"menu" => $temp_menu
		);
		$this->load->view('common/menu', $menudata);
		$this->load->model("checklists/ModelChecklist", "checklist");

		$item = $this->checklist->getItem($f_id);


		$data = array(
			"item" => $item
		);

		$this->load->view('checklists/edititem', $data);
		$this->load->view('common/footer');

	}


	public function newitem($f_id = 0){
		$this->load->view('common/header');
		$this->load->model("ModelMenu", "menu");
		$temp_menu = $this->menu->getMenu();
		$menudata = array(
			"menu" => $temp_menu
		);
		$this->load->view('common/menu', $menudata);
		$this->load->model("checklists/ModelChecklist", "checklist");

		$item = $this->checklist->getCategory($f_id);


		$data = array(
			"category" => $item
		);

		$this->load->view('checklists/newitem', $data);
		$this->load->view('common/footer');

	}

	public function deleteitem($f_id){
		$this->load->model("checklists/ModelChecklist", "checklist");
		$return = $this->checklist->delete_item($f_id);

		header("Location: /checklists/checklists/edit/" . $return);
	}

	public function delete($f_id){
		$this->load->model("checklists/ModelChecklist", "checklist");
		$this->checklist->delete_category($f_id);
		header("Location: /checklists/checklists");
	}

	/* ## POST ## */

	public function edititemsave(){
		if ($this->input->server('REQUEST_METHOD') == 'POST'){
			$data = array(
				"name" => $this->input->post('name'),
				"category_id" => $this->input->post('category_id')
			);

			$where = array(
				"id" => $this->input->post('id')
			);

			$this->load->model("checklists/ModelChecklist", "checklist");

			if(!$this->input->post('id') == ""){
				$this->checklist->update_item($data, $where);	
			} else {
				$this->checklist->insert_item($data);	
			}

			header('Location: /checklists/checklists/edit/' . $this->input->post('category_id'));

		}
	}


	public function newsave(){
		if ($this->input->server('REQUEST_METHOD') == 'POST'){
			if(!$this->input->post('name') == ""){
				$this->load->model("checklists/ModelChecklist", "checklist");
				$id = $this->checklist->addCategory($this->input->post('name'));
				header('Location: /checklists/checklists/edit/' . $id);
				die();
			}
			header('Location: /checklists/checklists');
		}
	}









}
