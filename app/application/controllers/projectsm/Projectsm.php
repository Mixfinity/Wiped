<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projectsm extends CI_Controller {
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
		$this->load->model("projectsm/MProjectsm", "project_model");
		$projects = $this->project_model->getConceptProjects();
		$plan_projects = $this->project_model->getPlanProjects();
		$proef_projects = $this->project_model->getProefProjects();
		$end_projects = $this->project_model->getEndProjects();
		$data = array(
			"concept_projects" => $projects,
			"end_projects" => $end_projects,
			"proef_projects" => $proef_projects,
			"plan_projects" => $plan_projects
		);
		$this->load->view('projectsm/overview', $data);
		$this->load->view('common/footer');
	}

	public function archive()
	{
		$this->load->database();
		$this->load->view('common/header');
		$this->load->model("ModelMenu", "menu");
		$temp_menu = $this->menu->getMenu();
		$menudata = array(
			"menu" => $temp_menu
		);
		$this->load->view('common/menu', $menudata);
		$this->load->model("projectsm/MProjectsm", "project_model");
		$projects = $this->project_model->getClosedProjects();

		$data = array(
			"projects" => $projects
			
		);
		$this->load->view('projectsm/archive', $data);
		$this->load->view('common/footer');
	}

	public function edit($f_id = 0){
		$this->load->database();
		$this->load->view('common/header');
		$this->load->model("ModelMenu", "menu");
		$temp_menu = $this->menu->getMenu();
		$menudata = array(
			"menu" => $temp_menu
		);
		$this->load->view('common/menu', $menudata);
		$this->load->model("projectsm/MProjectsm", "project_model");
		if($f_id > 0){
			$type = "Bewerken";
		} else {
			$type = "Nieuw";
		}
		$project = $this->project_model->getProject($f_id);
		$this->db->order_by('name');
		$query = $this->db->get('divisions');
		$divisions = $query->result();
		$this->db->order_by('name');
		$query = $this->db->get_where('users', array("active" => 1));
		$users = $query->result();
		$data = array(
			"project" => $project,
			"divisions" => $divisions,
			"users" => $users,
			"type" => $type,
			"project_id" => $f_id
		);
		$this->load->view('projectsm/edit', $data);
		$this->load->view('common/footer');
	}



	public function saveProjectLine(){
		if($this->input->post()){
			$this->load->database();
			$this->load->model("projectsm/MProjectsm", "project_model");
			$this->load->model("trello/TrelloModel", "trello_model");
		
			if($this->input->post('line_id')){
				$returnID = $this->input->post('line_id');
				$current_data = $this->project_model->getProjectLine($returnID);

				$data = array(
					"name" => $this->input->post('name'),
					"estimation" =>  $this->input->post('estimation'),
					"project_id" =>  $this->input->post('project_id'),
					"division_id" =>  $this->input->post('division_id'),
					"employee_id" =>   $this->input->post('employee_id'),
					"description" =>  $this->input->post('description'),
					"internal_description" =>$this->input->post('internal_description')
				);

	
				$trello = array(
					"name" => $data["name"],
					"desc" => $data["description"],
					"trello_id" => $current_data->trello_id
				);

				$this->trello_model->updateCard($trello);



				$this->db->update('project_lines', $data, array("id" => $this->input->post('line_id')));
				$returnID = $this->input->post('line_id');

				if($this->input->post('category')){
					$category_id = $this->project_model->setSubProject($this->input->post('category'),$this->input->post('project_id'), $this->input->post('division_id')); 
				}
			} else {
				$data = array(
					"name" => $this->input->post('name'),
					"estimation" =>  $this->input->post('estimation'),
					"project_id" =>  $this->input->post('project_id'),
					"division_id" =>  $this->input->post('division_id'),
					"employee_id" =>   $this->input->post('employee_id'),
					"description" =>  $this->input->post('description'),
					"internal_description" =>$this->input->post('internal_description')
				);

				




				$this->db->insert('project_lines', $data);
				$returnID = $this->db->insert_id();
				$current_data = $this->project_model->getProject($data["project_id"]);
				$trello = array(
					"name" => $data["name"],
					"desc" => $data["description"],
					"idList" => $current_data->trello_first_list
				);

				$trello_card_id = $this->trello_model->createCard($trello);

				$this->db->update("project_lines", array("trello_id" => $trello_card_id),array("id"=> $returnID) );

				$data["trello_id"] = $trello_card_id;

				if($this->input->post('category')){
					$category_id = $this->project_model->setSubProject($this->input->post('category'),$this->input->post('project_id'), $this->input->post('division_id')); 
				}
			}
			$this->db->update("project_lines", array("category_id" => $category_id)	, array("id"=> $returnID));
			echo $returnID;
		}
	}

	public function prepareEditProjectLine($f_id = 0){
		$this->load->database();
		$this->load->model("projectsm/MProjectsm", "project_model");
		$data = $this->project_model->getProjectLine($f_id);
		echo json_encode($data);
	}

	public function removeProjectLine($f_id = 0, $proj_id = 0){
		$this->load->database();
		$this->load->helper('url');

		if($f_id > 0){

			$this->load->model("projectsm/MProjectsm", "project_model");
			$this->load->model("trello/TrelloModel", "trello_model");
			$current_data = $this->project_model->getProjectLine($f_id);

			$this->trello_model->deleteCard($current_data->trello_id);



			$this->db->delete('project_lines', array("id" => $f_id));
		}
		redirect('/projectsm/projectsm/edit/' . $proj_id);
	}


	public function getCurrentProjectLines($project_id = 0){
			$this->load->database();
			$project_lines = array();
			// Load config models for getting divisions and project lines
			$this->load->model("config/ModelConfigConfig", "config_model");
			$this->load->model("projectsm/MProjectsm", "project_model");
			// Get all division categories
			$divisions = $this->config_model->getDivisions();
			// foreach division, get current project lines
			foreach($divisions as $division){
				// put project line in object
				$category_dataobj = $this->project_model->getProjectLineCategoriesByDivision($division->id, $project_id);
				$project_lines_sub = array();
				foreach($category_dataobj as $category){
					$temp_project_lines = $this->project_model->getProjectLinesFromCategorie($category->category, $project_id, $division->id);
					$project_lines_sub[] = array($category->category => $temp_project_lines);
				}
				$project_lines[] = array($division->name => $project_lines_sub);
			}
			echo json_encode($project_lines);
		}

	public function setProjectPlanning($f_id = 0){
		$this->load->database();
		$this->load->helper('url');
		if($f_id > 0){
			$this->db->update('projects', array('status_id' => 2), array("id" => $f_id));
		}
		redirect('/plan/plan/');
	}

	public function delete($f_id = 0){
		$this->load->database();
		$this->load->helper('url');
		if($f_id > 0){
			$this->db->update('projects', array('status_id' => 9), array("id" => $f_id));
		}
		redirect('/projectsm/projectsm/archive/');
	}
}