<?php

	class ModelPlan extends CI_Model  {

		public function getProjectsForPlanning(){
			$this->db->select("projects.*, contacts.name as contact_name, '' as categories");
			$this->db->join('contacts', ' contacts.id = projects.contact_id'); 
			$this->db->order_by('deadline DESC');
			$result = $this->db->get_where('projects', array(
				"status_id" => 2

			));


			foreach($result->result() as $row){
				
				$sub_projects = array();

				$this->db->select('	divisions.name as division_name , sub_projects.name as category, sub_projects.id as sub_project_id, sum(estimation) as total_estimation');
				$this->db->join('divisions', 'project_lines.division_id = divisions.id');
				$this->db->join('sub_projects', 'project_lines.category_id = sub_projects.id');
				$this->db->group_by('`project_lines`.`division_id`, `divisions`.`name`, `sub_projects`.`name`,  `sub_projects`.`id`');
				$this->db->order_by('`project_lines`.`division_id` asc, `sub_projects`.`name` asc, `sub_projects`.`id`');
				$temp_val = $this->db->get_where('project_lines', array('project_lines.project_id' => $row->id, "sub_projects", "planned" => NULL));
				if ($temp_val->num_rows() > 0){
					$temp_val = (object)$temp_val->result();
					$returnVal[] = array($row->name . " - " . $row->contact_name  => $temp_val);
				}
				

			}

			return $returnVal;

		}

		public function getUsers(){
			$this->db->order_by('name');
			$result = $this->db->get_where('users', array("active" => 1));
			return $result->result();
		}

	}

?>