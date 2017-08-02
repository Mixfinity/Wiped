<?php
	class MProjects extends CI_Model  {
		
		public function getProjectsForUser($f_id){
			$result = $this->db->query("SELECT sp.id as id, c.name as debiteur, p.name as project_name, sp.name as sub_project_name, c.name as contact_name, pl.project_id FROM sub_projects sp INNER JOIN sub_project_to_user spu ON spu.sub_project_id = sp.id INNER JOIN project_lines pl ON sp.id = pl.category_id and pl.done = 0 INNER JOIN projects p ON p.id = pl.project_id INNER JOIN users u ON spu.user_id = u.id INNER JOIN divisions d ON d.id = pl.division_id INNER JOIN contacts c ON p.contact_id = c.id WHERE u.id = ".$this->db->escape($f_id)." and sp.visible = 1 AND (p.status_id >= 2 AND p.status_id <= 4)	group by 	c.name, 			p.name, 				sp.name, 				p.deadline, 				u.name  	,     sp.id	, pl.project_id		ORDER BY 				p.deadline, 				sp.id asc  		");
			return $result->result();
		}

		public function getWorkedMinutesByProjectLine($f_id){
			$query = "SELECT u.name as user_name, wm.minutes, DATE_FORMAT(created_at, '%d-%m-%Y') as datum FROM working_minutes wm JOIN users u ON u.id = wm.user_id WHERE project_line_id = " . $this->db->escape($f_id) . ' ORDER BY datum, user_name';
			$result = $this->db->query($query);
			return $result->result();
		}

		public function getProjectLineInfo($f_id){
			$query = "SELECT pl.id, pl.done, p.name as project_name, pl.name as line_name,sp.name as category_name,c.name as contact_name,pl.description as description,pl.internal_description as internal_description,pl.estimation as estimation, pl.project_id ,(SELECT SUM(minutes) FROM working_minutes wm WHERE wm.project_line_id = pl.id) as minutes  FROM projects p JOIN sub_projects sp on p.id = sp.project_id JOIN project_lines pl ON pl.project_id = p.id JOIN contacts c ON p.contact_id = c.id WHERE pl.id =". $this->db->escape($f_id);
			$result = $this->db->query($query);
			return $result->row();
		}

		public function getWorkedMinutes($f_project_line, $f_user){
			$query = "SELECT minutes,  DATE_FORMAT(created_at, '%d-%m-%Y') as datum FROM working_minutes WHERE project_line_id = " . $this->db->escape($f_project_line) . " AND user_id = " . $this->db->escape($f_user) . " ORDER BY created_at DESC LIMIT 0, 2";
			$result = $this->db->query($query);
			return $result->result();
		}

		public function getAllWorkedMinutes($f_project_line){
			$query = "SELECT minutes,  DATE_FORMAT(created_at, '%d-%m-%Y') as datum FROM working_minutes WHERE project_line_id = " . $this->db->escape($f_project_line) . " ORDER BY created_at DESC LIMIT 0, 2";
			$result = $this->db->query($query);
			return $result->result();
		}

		public function getAllProjectLines($f_project_id){
			$result = $this->db->query("SELECT 	(SELECT sum(minutes) FROM working_minutes wm WHERE wm.project_line_id = pl.id) as worked, c.name as contact_name,	p.name as project_name,	sp.name as sub_project_name, pl.internal_description	,pl.id as line_id,pl.name as line_name,estimation, pl.description FROM project_lines pl INNER JOIN sub_projects sp ON pl.category_id = sp.id INNER JOIN projects p ON p.id = pl.project_id INNER JOIN contacts c ON c.id = p.contact_id INNER JOIN sub_project_to_user spu ON spu.sub_project_id = sp.id WHERE  p.id = ". $this->db->escape($f_project_id));
		
			return $result->result();

			
		}


		public function getProjectStatusses(){
			$this->db->order_by("priority asc");
			$result = $this->db->get("project_status");
			return $result->result();
		}

		public function getOwnProctLines($f_project_id, $f_user){

		}


		public function createBaseProject($f_data){
			$this->db->insert('projects', $f_data);
			return $this->db->insert_id();
		}

		public function getProjectInformation($f_id){
			$result = $this->db->query("
				SELECT
					p.id as id,
					p.name as project_name,
					c.name as contact_name,
					p.status_id as status_id,
					(round(((SELECT sum(estimation) FROM project_lines WHERE  project_id = pl.project_id AND done = 1) / (SELECT sum(estimation) FROM project_lines WHERE project_id = pl.project_id)) * 100)) as percentage,
					sum(estimation) as total_estimation,
						(SELECT sum(minutes) FROM working_minutes INNER JOIN project_lines  ON working_minutes.project_line_id = project_lines.id WHERE project_lines.project_id = p.id) as total_worked
				FROM project_lines pl

				INNER JOIN projects p
				ON pl.project_id = p.id
				INNER JOIN contacts c ON
				c.id = p.contact_id
				WHERE 
					p.id = ".$this->db->escape($f_id)."
				GROUP BY 
					p.id,
					p.name,
					c.name
				ORDER BY 
					c.name, 
					percentage desc,
					p.name
			");
			return $result->row();
		}

		public function getAllSubProjects($f_id){
			$result = $this->db->query("
				SELECT
					sp.id as project_id,
					u.name as executive_name,
					c.name as contact_name,
					sp.name as project_name,
					(round(((SELECT sum(estimation) FROM project_lines WHERE  category_id = sp.id AND done = 1) / (SELECT sum(estimation) FROM project_lines WHERE category_id = sp.id)) * 100)) as percentage,
					(SELECT sum(estimation) FROM project_lines WHERE category_id = sp.id) as total_estimation,
					(SELECT sum(minutes) FROM working_minutes INNER JOIN project_lines  ON working_minutes.project_line_id = project_lines.id WHERE project_lines.category_id = sp.id) as total_worked
				FROM project_lines pl

				INNER JOIN projects p
				ON pl.project_id = p.id
				INNER JOIN contacts c ON
				c.id = p.contact_id
				INNER JOIN sub_projects sp
				ON sp.project_id = p.id

				INNER JOIN sub_project_to_user spu
				ON spu.sub_project_id = sp.id

				INNER JOIN users u
				ON u.id = spu.user_id

				WHERE 
					p.id = ".$this->db->escape($f_id)."
				GROUP BY 
					sp.id,
					p.id,
					c.name
				ORDER BY 
					c.name, 
					percentage desc,
					p.name
			");
			return $result->result();
		}

		public function getAllCurrentProjects(){
			/*if($this->session->userdata('profile_id') == "1"){*/
				$result = $this->db->query("
				SELECT
					p.id as id,
					p.name as project_name,
					c.name as contact_name,
					(round(((SELECT sum(estimation) FROM project_lines WHERE  project_id = pl.project_id AND done = 1) / (SELECT sum(estimation) FROM project_lines WHERE project_id = pl.project_id)) * 100)) as percentage,
					sum(estimation) as total_estimation,
						(SELECT sum(minutes) FROM working_minutes INNER JOIN project_lines  ON working_minutes.project_line_id = project_lines.id WHERE project_lines.project_id = p.id) as total_worked
				FROM project_lines pl

				INNER JOIN projects p
				ON pl.project_id = p.id
				INNER JOIN contacts c ON
				c.id = p.contact_id
				INNER JOIN project_status ps 
				ON p.status_id = ps.id
				WHERE 
					ps.priority >= 2 AND
					ps.priority <= 6	
				GROUP BY 
					p.id,
					p.name,
					c.name
				ORDER BY 
					c.name, 
					percentage desc,
					p.name
		");
				return $result->result();
		/*	} else {
				$result = $this->db->query("
					SELECT
						p.id as id,
						p.name as project_name,
						c.name as contact_name,
						(round(((SELECT sum(estimation) FROM project_lines WHERE  project_id = pl.project_id AND done = 1) / (SELECT sum(estimation) FROM project_lines WHERE project_id = pl.project_id)) * 100)) as percentage,
						sum(estimation) as total_estimation,
							(SELECT sum(minutes) FROM working_minutes INNER JOIN project_lines  ON working_minutes.project_line_id = project_lines.id WHERE project_lines.project_id = p.id) as total_worked
					FROM project_lines pl

					INNER JOIN projects p
					ON pl.project_id = p.id
					INNER JOIN contacts c ON
					c.id = p.contact_id
					WHERE 
						p.status_id = 4	
					GROUP BY 
						p.id,
						p.name,
						c.name
					ORDER BY 
						c.name, 
						percentage desc,
						p.name
				");
				return $result->result();
			}*/
		}

		public function saveProjectStatus(){
			if($this->input->post()){
				$this->db->update('projects', array("status_id" => $this->input->post('status_id')), array("id" => $this->input->post('project_id')));
			}
		}

		public function getSpecificationInformation($f_id = 0){
			$query = $this->db->query("
				SELECT p.name as project_name, c.name as contact_name FROM sub_projects sp
				INNER JOIN projects p ON
				p.id = sp.project_id
				INNER JOIN contacts c ON
				p.contact_id = c.id
				WHERE sp.id = " . $this->db->escape($f_id));

			return $query->row();
		}

		public function getProject($f_id = 0){
			$result = $this->db->get_where('projects', array("id" => $f_id));
			return $result->result()[0];
		}

		public function saveTrelloBoard($project_id, $trello_id, $trello_first_list){
			$this->db->update('projects', array("trello_id" => $trello_id, "trello_first_list" => $trello_first_list), array("id" => $project_id));
		}

		public function getProjectSpecifications($f_id = 0){
			$result = $this->db->query("SELECT 
				DATE_FORMAT(wm.created_at,'%d-%m-%Y') as mutation_date,
				wm.created_at,
				sum(minutes) as minutes,
				pl.name as description,
				CONCAT(sp.name, ' (', d.name, ')') as sub_project_name,
				p.name as project_name,
				sp.id as sub_project_id,
				sp.division_id,
				c.name as contact_name,
				wm.description as time_description
				FROM working_minutes wm
				INNER JOIN project_lines pl ON
				wm.project_line_id = pl.id
				INNER JOIN sub_projects sp ON
				sp.id = pl.category_id
				INNER JOIN projects p ON
				p.id = pl.project_id
				INNER JOIN contacts c ON
				c.id = p.contact_id
				INNER JOIN divisions d ON
				d.id = sp.division_id
				WHERE p.id = (SELECT project_id FROM sub_projects WHERE id = ".$this->db->escape($f_id).")
				GROUP BY  wm.created_at, pl.id, wm.description
				ORDER BY sub_project_name,sub_project_id, division_id, wm.created_at ASC, description");

			return $result->result();
		}

		public function getProjectSpecificationsAdv($f_id = 0, $from = null, $till = null){
			$result = $this->db->query("SELECT 
				DATE_FORMAT(wm.created_at,'%d-%m-%Y') as mutation_date,
				wm.created_at,
				sum(minutes) as minutes,
				pl.name as description,
				CONCAT(sp.name, ' (', d.name, ')') as sub_project_name,
				p.name as project_name,
				sp.id as sub_project_id,
				sp.division_id,
				c.name as contact_name,
				wm.description as time_description
				FROM working_minutes wm
				INNER JOIN project_lines pl ON
				wm.project_line_id = pl.id
				INNER JOIN sub_projects sp ON
				sp.id = pl.category_id
				INNER JOIN projects p ON
				p.id = pl.project_id
				INNER JOIN contacts c ON
				c.id = p.contact_id
				INNER JOIN divisions d ON
				d.id = sp.division_id
				WHERE p.id = (SELECT project_id FROM sub_projects WHERE id = ".$this->db->escape($f_id).") AND (wm.created_at >= " . $this->db->escape($from) . " AND wm.created_at <= " . $this->db->escape($till) . ")
				GROUP BY  wm.created_at, pl.id, wm.description
				ORDER BY sub_project_name,sub_project_id, division_id, wm.created_at ASC, description");

			return $result->result();
		}


	} 
?>	