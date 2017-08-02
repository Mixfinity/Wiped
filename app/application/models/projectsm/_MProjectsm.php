<?php
	class MProjectsm extends CI_Model  {
		

		public function getConceptProjects() {

			$this->db->select("p.*, c.name as contact_name");

			$this->db->from('projects p');
			$this->db->join('contacts c', 'p.contact_id = c.id');
			$this->db->where("status_id =", (int)1);
			$query = $this->db->get();
			return $query->result();
		}

		public function getPlanProjects() {

			$this->db->select("p.*, c.name as contact_name");

			$this->db->from('projects p');
			$this->db->join('contacts c', 'p.contact_id = c.id');
			$this->db->where("status_id >= 2 AND status_id < 5");
			$query = $this->db->get();
			return $query->result();
		}

		public function getProefProjects(){ 

			$this->db->select("p.*, c.name as contact_name");

			$this->db->from('projects p');
			$this->db->join('contacts c', 'p.contact_id = c.id');
			$this->db->where("status_id >= 7 AND status_id <= 8");
			$query = $this->db->get();
			return $query->result();
		}


		public function getEndProjects() {

			$this->db->select("p.*, c.name as contact_name");

			$this->db->from('projects p');
			$this->db->join('contacts c', 'p.contact_id = c.id');
			$this->db->where("status_id = 6");
			$query = $this->db->get();
			return $query->result();
		}

		public function getClosedProjects() {

			$this->db->select("p.*, c.name as contact_name");

			$this->db->from('projects p');
			$this->db->join('contacts c', 'p.contact_id = c.id');
			$this->db->where("status_id = 5");
			$query = $this->db->get();
			return $query->result();
		}


		public function setSubProject($f_sub_project_name = "", $f_project_id = 0, $f_division_id){

			$result = $this->db->get_where('sub_projects', array(
				"name" => $f_sub_project_name,
				"project_id" => $f_project_id,
				"division_id" => $f_division_id
			));

			if ($result->num_rows() > 0){
				$row  = $result->row();
				$returnValue = $row->id;
			} else {
				$this->db->insert('sub_projects', array(
					"name" => $f_sub_project_name,
					"project_id" => $f_project_id,
					"division_id" => $f_division_id
				));
				$returnValue = $this->db->insert_id();
			}

			return $returnValue;
		}


		public function getProject($f_id){

			$this->db->from("projects");
			$this->db->where("id", $f_id);
			$query = $this->db->get();
			return $query->row();

		}
		
		public function getProjectLineCategoriesByDivision($f_id = 0, $project_id = 0){
			if($f_id > 0){
				$this->db->select("sub_projects.name as category");
				$this->db->group_by("sub_projects.name"); 
				$this->db->group_by("project_lines.project_id"); 
				$this->db->where("project_lines.division_id =", $f_id);
				$this->db->where("project_lines.project_id =", $project_id);
				$this->db->join('sub_projects', 'project_lines.category_id = sub_projects.id');
				$this->db->from('project_lines');
				$query = $this->db->get();

				return $query->result();
			}
		}


		public function getProjectLinesFromCategorie($cat_name, $project_id, $division_id){
			$this->db->select("project_lines.id, project_lines.name, sub_projects.name as category, project_lines.estimation, project_lines.division_id, project_lines.employee_id, project_lines.description, project_lines.internal_description, project_lines.project_id, project_lines.category_id, project_lines.done, project_lines.name as project_line_name, project_lines.id as project_line_id");
			$this->db->join( 'sub_projects', 'project_lines.category_id = sub_projects.id');
			$query = $this->db->get_where('project_lines', array("sub_projects.name" => $cat_name, "project_lines.project_id" => $project_id, "sub_projects.division_id" => $division_id));
			return $query->result();

		}

		public function getProjectLine($f_id = 0){
			$this->db->select("project_lines.id, project_lines.name, project_lines.trello_id, sub_projects.name as category, project_lines.estimation, project_lines.division_id, project_lines.employee_id, project_lines.description, project_lines.internal_description, project_lines.project_id, project_lines.category_id, project_lines.done, project_lines.name as project_line_name, project_lines.id as project_line_id");
			$this->db->join( 'sub_projects', 'project_lines.category_id = sub_projects.id');
			$returnValue = $this->db->get_where('project_lines', array("project_lines.id" => $f_id));


			
			return $returnValue->row();
		}

	} 
?>	