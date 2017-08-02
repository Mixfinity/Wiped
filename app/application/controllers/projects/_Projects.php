<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends CI_Controller {
	public function __construct()
   {
   		parent::__construct();
        $this->load->library('login');
     	$this->login->check();
        $this->load->library('session');
        $this->load->helper('functions_helper');
        $this->load->database();

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

		$this->load->model("projects/MProjects", "project_model");

		$projects = $this->project_model->getProjectsForUser($this->session->userdata["user_id"]);

		$data = array(
 			"projects" => $projects
		);

		$this->load->view('projects/overview', $data);
		$this->load->view('common/footer');
	}

	public function projectLineDetail($f_project_line){
		$this->load->view('common/header');
		$this->load->model("ModelMenu", "menu");
		$temp_menu = $this->menu->getMenu();
		$menudata = array(
			"menu" => $temp_menu
		);
		$this->load->view('common/menu', $menudata);

		$this->load->model("projects/MProjects", "project_model");

		$project_line = $this->project_model->getProjectLineInfo($f_project_line);
		$minutes = $this->project_model->getWorkedMinutesByProjectLine($f_project_line);

		switch($this->session->userdata("profile_id") == "1"){

			case "1":
				$all_project_lines = $this->project_model->getAllProjectLines($project_line->project_id);
				break;
			case "2":
				$all_project_lines = "";
				break;
			case "3":
				$all_project_lines = "";
				break;
		}
		


		$data = array(
			"project_line" => $project_line,
			"minutes" => $minutes,
			"all_project_lines" => $all_project_lines,
			"project_line_id" => $f_project_line
		);

		$this->load->view('projects/detail', $data);
		$this->load->view('common/footer');

	}

	public function allProjects(){
		$this->load->view('common/header');
		$this->load->model("ModelMenu", "menu");
		$temp_menu = $this->menu->getMenu();
		$menudata = array(
			"menu" => $temp_menu
		);
		$this->load->view('common/menu', $menudata);

		$this->load->model("projects/MProjects", "project_model");

		$all_projects = $this->project_model->getAllCurrentProjects();

		$data = array("projects" => $all_projects);

		$this->load->view('projects/all', $data);
		$this->load->view('common/footer');

	}


	public function projectDetails($f_id = 0) {
		$this->load->view('common/header'); 
		$this->load->model("ModelMenu", "menu");
		$temp_menu = $this->menu->getMenu();
		$menudata = array(
			"menu" => $temp_menu
		);
		$this->load->view('common/menu', $menudata);

		$this->load->model("projects/MProjects", "project_model");
		$this->load->model("trello/TrelloModel", "trello_model");

		$project_info =  $this->project_model->getProjectInformation($f_id);

		$project =  $this->project_model->getProject($f_id);

		$project_lines = $this->project_model->getAllSubProjects($f_id);
		$trello_items = $this->trello_model->getCardsByList($project->trello_id);

		$userarray = false;

		//$userarray = array(
		//	$rights_fix, $rights_fix2, $rights_fix3
		//);

		$this->trello_model->addMember($userarray, $project->trello_id);

		$data = array(
			"project_info" => $project_info,
			"project_lines" => $project_lines,
			"project_nr" => $f_id,
			"project_statusses" => $this->project_model->getProjectStatusses(),
			"trello_items" =>  $trello_items
		);

		$this->load->view("projects/detail_full", $data);
		
		$this->load->view('common/footer');

	}

	public function getAllProjectLines($f_id){

		$this->load->model("projects/MProjects", "project_model");

		$totalvar = array();

		$result = $this->db->query("SELECT 	(SELECT sum(minutes) FROM working_minutes wm WHERE wm.project_line_id = pl.id) as worked, c.name as contact_name,	p.name as project_name,	sp.name as sub_project_name, pl.internal_description	,pl.id as line_id,pl.name as line_name,estimation, pl.description FROM project_lines pl INNER JOIN sub_projects sp ON pl.category_id = sp.id INNER JOIN projects p ON p.id = pl.project_id INNER JOIN contacts c ON c.id = p.contact_id INNER JOIN sub_project_to_user spu ON spu.sub_project_id = sp.id WHERE sp.id = ". $this->db->escape($f_id));
		
		foreach($result->result() as $res):
			$tempvar = array();
			$tempvar = (array)$res;

			$minutes = $this->project_model->getAllWorkedMinutes( $res->line_id );
			$tempvar["minutes"] = (object)$minutes;

			$totalvar[] = (object)$tempvar;
		endforeach;
		$returnVal = (object)$totalvar;


		$this->output->set_content_type('application/json')->set_output("[" . json_encode($returnVal) . "]");
	}

	#GET FUNCTIONS
	public function setUserMinutes($f_minutes, $f_project_line){
		if(is_numeric($f_minutes) && is_numeric($f_project_line)){


	

			$current = $this->db->get_where("project_lines", array("id" => $f_project_line))->row();

			echo "<pre>";
				print_r($current);
			echo "</pre>";
					$this->db->select("trello_id");
			$result = $this->db->get_where("projects", array("id" => $current->project_id))->row();

			$board_id = NULL;

			if($result->trello_id != NULL && !empty($result->trello_id)){
				$board_id = $result->trello_id;
			}

			

			if($current->trello_id != NULL && !empty($current->trello_id) && $board_id != NULL){
				$this->load->model("trello/TrelloModel", "trello_model");

				$lists = $this->trello_model->getLists($board_id);

				$list_id = $lists[1]->id;

				$this->trello_model->moveCard($current->trello_id, $list_id);

				if(!empty($this->input->post('description'))){
					$this->trello_model->addComment($current->trello_id, $this->input->post('description'));
				}

			}




			$data = array(
				"minutes" => $f_minutes,
				"project_line_id" => $f_project_line,
				"created_at" =>  date('Y-m-d H:i:s'),
				'user_id' => $this->session->userdata["user_id"],
				"description" => !empty($this->input->post('description')) ? $this->input->post('description') : NULL
			);
			$this->db->insert('working_minutes', $data);
		} 
	}

	public function updateInternaLDescription($f_project_line){
		if($this->input->post("internal_description")){
			$data = array(
				'internal_description' => $this->input->post("internal_description")
			);
			$update = array(
				"id" => $f_project_line
			);
			$this->db->update('project_lines', $data, $update);
		}	
	}

	public function setWorkDone($f_project_line){
		$data = array(
			"done" => 1,
			"done_by" => $this->session->userdata["user_id"]
		);

		$where = array(
			"id" => $f_project_line
		);

		$this->db->update('project_lines', $data, $where);

		$current = $this->db->get_where('project_lines', array("id" => $f_project_line))->row();

		$this->db->select("trello_id");
		$result = $this->db->get_where("projects", array("id" => $current->project_id))->row();

		$board_id = NULL;

		if($result->trello_id != NULL && !empty($result->trello_id)){
			$board_id = $result->trello_id;

		}

		$result = $this->db->query("select * from projects p left join sub_projects sp on sp.project_id = p.id left join project_lines pl on pl.category_id = sp.id where p.id = ".$current->project_id." and pl.done = 0");

		if($result->num_rows() < 1){
			$this->db->update('projects', array("status_id" => 6), array("id" => $current->project_id));
		}


		if($current->trello_id != NULL && !empty($current->trello_id) && $board_id != NULL){
			$this->load->model("trello/TrelloModel", "trello_model");

			$lists = $this->trello_model->getLists($board_id);

			$list_id = $lists[2]->id;

			$this->trello_model->moveCard($current->trello_id, $list_id);

		}

	}

	public function setWorkDoneWithCheck($f_project_line){
		$current = $this->db->get_where('project_lines', array("id" => $f_project_line))->row();
		if($current->done != '1'){
			$data = array(
				"done" => 1,
				"done_by" => $this->session->userdata["user_id"]
			);
		} else {
			$data = array(
				"done" => 0,
				"done_by" => $this->session->userdata["user_id"]
			);
		}
		$where = array(
			"id" => $f_project_line
		);
		$this->db->update('project_lines', $data, $where);
	}

	public function drukwerk(){
		$this->load->database();
		$this->load->view('common/header');
		$this->load->model("ModelMenu", "menu");
		$temp_menu = $this->menu->getMenu();
		$menudata = array(
			"menu" => $temp_menu
		);
		$this->load->view('common/menu', $menudata);
		$this->load->view('projects/no_offer');
		$this->load->view('common/footer');
	}


	public function newProject(){
		$this->load->database();
		$this->load->view('common/header');
		$this->load->model("ModelMenu", "menu");
		$temp_menu = $this->menu->getMenu();
		$menudata = array(
			"menu" => $temp_menu
		);
		$this->load->view('common/menu', $menudata);

		// Custom view code
		$this->load->model("config/ModelConfigConfig", "project_model");
		$data["users"] = $this->config_model->getUsers();
		$data["divisions"] = $this->config_model->getDivisions();







		$this->load->view('projects/new', $data);
		$this->load->view('common/footer');
	}


	public function pdf($f_id = 0, $f_from = NULL, $f_till = NULL)
	{

	    $this->load->helper(array('dompdf', 'file'));  
	    $this->load->database();
		$this->load->model("projects/MProjects", "project_model");

		$from = "";
		$till = "";


			if(!empty($f_from) && !empty($f_till)){

				$date = date_create($f_from);
				$from = date_format($date, 'Y-m-d');

				$date = date_create($f_till);
				$till = date_format($date, 'Y-m-d');
				
				$specifications = $this->project_model->getProjectSpecificationsAdv($f_id, $from, $till);


				$date = date_create($f_from);
				$from = date_format($date, 'd-m-Y');
				$date = date_create($f_till);
				$till = date_format($date, 'd-m-Y');


			} else {
			$specifications = $this->project_model->getProjectSpecifications($f_id);
		}


		$extrainfo = $this->project_model->getSpecificationInformation($f_id);

		$data = array(
			"specifications" => $specifications,
			"project" => $extrainfo->project_name,
			"contact" => $extrainfo->contact_name,
			"from" => $from,
			"till" => $till
		);


		$html = $this->load->view('projects/pdf', $data, true);

	    $data = pdf_create($html, '', false);
	    $this->output->set_header("Content-Disposition:attachment;filename=" . urlencode($extrainfo->contact_name) . "-" . urlencode($extrainfo->project_name) . ".pdf");
	    $this->output->set_content_type('pdf')->set_output($data);
	}


	public function specifications($f_id = 0){
		$this->load->database();
		$this->load->view('common/header');
		$this->load->model("ModelMenu", "menu");
		$temp_menu = $this->menu->getMenu();
		$menudata = array(
			"menu" => $temp_menu
		);
		$this->load->view('common/menu', $menudata);

		$this->load->model("projects/MProjects", "project_model");

		$from = "";
		$till = "";

		if ($this->input->server('REQUEST_METHOD') == 'POST'){

			if(!empty($this->input->post('from')) && !empty($this->input->post('till'))){

				$date = date_create($this->input->post('from'));
				$from = date_format($date, 'Y-m-d');

				$date = date_create($this->input->post('till'));
				$till = date_format($date, 'Y-m-d');
				
			

				$specifications = $this->project_model->getProjectSpecificationsAdv($f_id, $from, $till);
			}
			else{
				$specifications = $this->project_model->getProjectSpecifications($f_id);
			}

			
		} else {
			$specifications = $this->project_model->getProjectSpecifications($f_id);
		}

		$extrainfo = $this->project_model->getSpecificationInformation($f_id);

		$data = array(
			"specifications" => $specifications,
			"project" => $extrainfo->project_name,
			"contact" => $extrainfo->contact_name,
			"from" => $from,
			"till" => $till,
			"id" => $f_id
		);

		$this->load->view('projects/specifications', $data);

		$this->load->view('common/footer');
	}



	#JSON FUNCTIONS

	function createBaseProject(){
		if($this->input->post('project_name') && $this->input->post('contact_name')){
			$this->load->model("projects/MProjects", "project_model");
			$this->load->model('offers/ModelOffersOffers', 'offer_model');
			$this->load->model("trello/TrelloModel", "trello_model");
			$data = array();

			$data["name"] = $this->input->post('project_name') ;
			$data["contact_id"] = $this->offer_model->getContactId($this->input->post('contact_name'));
			$data["user_id"] = $this->session->userdata("user_id");
			$data["offer_id"] = -1;
			$data["status_id"] = 1;
			$data["date_created"] = date("Y-m-d H:i:s");  
			$data["deadline"] = date("Y-m-d H:i:s");  

			if($data["contact_id"] >= 1){
				$project_id = $this->project_model->createBaseProject($data);	
				echo $project_id;

				$trello = array();

				$trello['name'] = $this->input->post('contact_name') . " | " . $data["name"];
				//echo "Hellow, is it me you lookink four!";
				$trello_id = $this->trello_model->createBoard($trello);

				$trello_first_list = $this->trello_model->getBacklog($trello_id);

				$this->project_model->saveTrelloBoard($project_id, $trello_id, $trello_first_list);
				die();



			} else {
				echo "nope";
			}




		} else {
			echo 'nope';
		}
	}

	public function getProjectLines($f_sub_proj){
	
		$this->load->model("projects/MProjects", "project_model");

		$totalvar = array();

		$result = $this->db->query("SELECT 	(SELECT sum(minutes) FROM working_minutes wm WHERE wm.project_line_id = pl.id) as worked, c.name as contact_name, p.id as project_nr,	p.name as project_name,	sp.name as sub_project_name, pl.internal_description	,pl.id as line_id,pl.name as line_name,estimation, pl.description FROM project_lines pl INNER JOIN sub_projects sp ON pl.category_id = sp.id INNER JOIN projects p ON p.id = pl.project_id INNER JOIN contacts c ON c.id = p.contact_id INNER JOIN sub_project_to_user spu ON spu.sub_project_id = sp.id WHERE spu.user_id = ".$this->db->escape($this->session->userdata['user_id'])." and pl.done != 1 and sp.id = ". $this->db->escape($f_sub_proj));
		
		foreach($result->result() as $res):
			$tempvar = array();
			$tempvar = (array)$res;

			$minutes = $this->project_model->getWorkedMinutes( $res->line_id , $this->session->userdata["user_id"]);
			$tempvar["minutes"] = (object)$minutes;

			$totalvar[] = (object)$tempvar;
		endforeach;
		$returnVal = (object)$totalvar;


		$this->output->set_content_type('application/json')->set_output("[" . json_encode($returnVal) . "]");
	}



	public function getProjectLinesFromAll($f_sub_proj){
	
		$this->load->model("projects/MProjects", "project_model");

		$totalvar = array();

		$result = $this->db->query("SELECT 	(SELECT sum(minutes) FROM working_minutes wm WHERE wm.project_line_id = pl.id) as worked, c.name as contact_name,	p.name as project_name,	sp.name as sub_project_name, pl.internal_description	,pl.id as line_id,pl.name as line_name,estimation, pl.description FROM project_lines pl INNER JOIN sub_projects sp ON pl.category_id = sp.id INNER JOIN projects p ON p.id = pl.project_id INNER JOIN contacts c ON c.id = p.contact_id INNER JOIN sub_project_to_user spu ON spu.sub_project_id = sp.id WHERE pl.done != 1 and sp.id = ". $this->db->escape($f_sub_proj));
		
		foreach($result->result() as $res):
			$tempvar = array();
			$tempvar = (array)$res;

			$minutes = $this->project_model->getWorkedMinutes( $res->line_id , $this->session->userdata["user_id"]);
			$tempvar["minutes"] = (object)$minutes;

			$totalvar[] = (object)$tempvar;
		endforeach;
		$returnVal = (object)$totalvar;


		$this->output->set_content_type('application/json')->set_output("[" . json_encode($returnVal) . "]");
	}

	public function saveProjectStatus(){
		$this->load->model("projects/MProjects", "project_model");
		$this->project_model->saveProjectStatus();
	}

	public function testTrello(){
		$this->load->model("trello/TrelloModel", "trello_model");
		$this->trello_model->createChecklist();

	}

	public function createChecklistItem($first_list, $project_id){
		$this->load->model("trello/TrelloModel", "trello_model");
		$this->trello_model->createChecklist($first_list, $project_id);
		echo "<script type='text/javascript'>window.close();</script>";
	}


}

?>