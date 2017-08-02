<?php
	class ModelMenu extends CI_Model  {

		public function getMenu(){
			$profile_id = $this->session->userdata('profile_id');

			$this->db->select("rights.*, rights_tree.profile_id");
			$this->db->order_by("priority");
			$this->db->join('rights_tree', 'rights.id = rights_tree.rights_id AND rights_tree.profile_id = ' . $profile_id, 'inner');
			$query = $this->db->get_where('rights', array("parent_id" => 0));
			$temp_array = array();
			foreach($query->result() as $element){
				$element = (array)$element;
				
				if($element['hasSub']==1)
			    {
			    	
			      $element['subs'] = (object)$this->getSubMenu($element['id']);
			      
			    }

			    $temp_array[] = (object)$element;
			
			}
			return (object)$temp_array;	

		}

		private function getSubMenu($f_id = -1){
			$profile_id = $this->session->userdata('profile_id');
			$this->db->select("rights.*");
			$query = $this->db->get_where('rights', array("parent_id" => $f_id));
			
			if($query->num_rows() > 0){
				return $query->result();
			} else {
				return false;
			}

		}	
		
	} 
?>	