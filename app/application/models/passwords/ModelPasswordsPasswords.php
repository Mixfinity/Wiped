<?php
	class ModelPasswordsPasswords extends CI_Model  {
		public function getPasswordData() {
			$this->db->order_by("name");
			$this->db->select("id, name, username, servername");
			$query = $this->db->get('details');
			return $query->result();
		}

		public function getExtendedData($f_id = 0){
			$result = $this->db->get_where('details', array("id" => $f_id));
			return $result->result();
		}
		

	} 
?>	