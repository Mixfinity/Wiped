<?php
	class ModelContactsContacts extends CI_Model  {
		public function getAllContacts() {
			$query = $this->db->get_where('contacts', array('active' => '1'));
			return $query->result();
		}

		public function getContactsAjax($f_input){
			$this->db->order_by('name', 'asc');
			$this->db->like('name', $f_input);
			$query = $this->db->get_where('contacts', array("active" => "1"));
			return $query->result();
		}

		public function getContact($f_id){
			$query = $this->db->get_where('contacts', array('id' => $f_id, 'active' => '1'));
			return $query->row();
		}

		public function getContactId($f_name){
			$query = $this->db->get_where(
				'contacts', array("name" => $f_name, 'active' => '1'));
			return $query->row()->id;

		}

		public function update($data, $table, $where){
			$str = $this->db->update_string($table, $data, $where);
			$this->db->query($str);
		}

		public function insert($data, $table ){
			$str = $this->db->insert_string($table, $data);
			$this->db->query($str);
			return $this->db->insert_id();
		}

		

	} 
?>	