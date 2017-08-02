<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plan extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->load->library('login');
     	$this->login->check();
        $this->load->library('session');
        $this->load->database();
        $this->load->helper('url');
        $this->load->model('plan/ModelPlan', 'plan_model');

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

		$users = $this->plan_model->getUsers();

		$data = array(
			"users" => $users
		);

		$this->load->view('plan/overview', $data);

		$this->load->view('common/footer');
	}




	#  JSON functions

	public function getplanprojects(){
		$result = $this->plan_model->getProjectsForPlanning();
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function setProjectToUser($project_id, $user_id){
		$this->db->insert('sub_project_to_user', array(
			"user_id" => $user_id,
			"sub_project_id" => $project_id,
			"planning_date" =>  date('Y-m-d H:i:s')
		));

		$this->db->update('sub_projects', array("planned"=> (int)1, "visible" => 1), array("id" => $project_id));
	}

	public function getSubprojectDetails($f_id = 0){
		$result  = $this->db->query(
			"SELECT c.name as debiteur, p.name as project_name, sp.name as sub_project_name, sum(pl.estimation) as total_estimation, p.deadline as deadline, u.name as executive_user, (round(((SELECT sum(estimation) FROM project_lines WHERE category_id = pl.category_id AND project_id = pl.project_id AND done = 1) / (SELECT sum(estimation) FROM project_lines WHERE category_id = pl.category_id AND project_id = pl.project_id)) * 100)) as percentage FROM sub_projects sp INNER JOIN project_lines pl ON sp.id = pl.category_id INNER JOIN projects p ON p.id = pl.project_id INNER JOIN users u ON pl.employee_id = u.id INNER JOIN divisions d ON d.id = pl.division_id INNER JOIN contacts c ON p.contact_id = c.id WHERE sp.id = " . $this->db->escape($f_id)." group by c.name, p.name, sp.name, p.deadline, u.name "
		);

		$row = $result->row();
		$this->output->set_content_type('application/json')->set_output(json_encode($row));

	}

	public function getProjectlines($f_id = 0){
		$result = $this->db->query("SELECT * FROM project_lines WHERE category_id = ".$this->db->escape($f_id)." ");
		$this->output->set_content_type('application/json')->set_output(json_encode($result->result()));
	}

	public function getProjectsByUser($f_id = 0){

			$result = $this->db->query("
				SELECT 
					c.name as debiteur, 
					p.name as project_name, 
					sp.name as sub_project_name, 
					sp.id as sub_project_id,
					sp.visible as visible,
					sum(pl.estimation) as total_estimation, p.deadline as deadline, u.id as user_id ,u.name as executive_user,  (round(((SELECT sum(estimation) FROM project_lines WHERE category_id = pl.category_id AND project_id = pl.project_id AND done = 1) / (SELECT sum(estimation) FROM project_lines WHERE category_id = pl.category_id AND project_id = pl.project_id)) * 100)) as percentage  
				FROM sub_projects sp 

				INNER JOIN sub_project_to_user spu 
				ON spu.sub_project_id = sp.id


				INNER JOIN project_lines pl 
				ON sp.id = pl.category_id 

				INNER JOIN projects p 
				ON p.id = pl.project_id 

				INNER JOIN users u 
				ON spu.user_id = u.id 

				INNER JOIN divisions d 
				ON d.id = pl.division_id 

				INNER JOIN contacts c 
				ON p.contact_id = c.id 

				WHERE u.id = ".$this->db->escape($f_id)."

				AND (p.status_id >= 2   AND p.status_id <= 4)

				group by 
					c.name , 
					p.name , 
					sp.name, 
					sp.id ,
					sp.visible ,
					 p.deadline , u.id  ,u.name , percentage
				ORDER BY 
					p.deadline, 
					percentage desc, 
					sp.id asc 
			");

		$row = $result->result();
		$this->output->set_content_type('application/json')->set_output(json_encode($row));
	}

	public function setVisible($f_id = 0){
		if($result = $this->db->get_where('sub_projects', array("id" => $f_id) )->row()){
			if($result->visible == "1"){
				$this->db->update('sub_projects', array("visible" => "0"), array("id" => $f_id));
			} else {
				echo "1";
				$this->db->update('sub_projects', array("visible" => "1"), array("id" => $f_id));
			}
		}
	}

	public function removeProjectFromPlanning($f_id = 0){
		if($_SESSION["profile_id"] == 1){
			$this->db->delete('sub_project_to_user', array("sub_project_id" => $f_id));
			$this->db->update('sub_projects', array("planned" => null), array("id" => $f_id));
			echo "1";
		}
	}
}
