<?php
	class ModelChecklist extends CI_Model  {


		public function getItem($f_id){
			$this->db->select("check_items.*, check_categories.name as cat_name");
			$this->db->join('check_categories' ,'check_categories.id = check_items.category_id');
			$query = $this->db->get_where('check_items', array("check_items.id" => $f_id, "active" => 1));
			return $query->row();
		}

		public function getCategory($f_id){
			$query = $this->db->get_where('check_categories', array("id" => $f_id, "active" => 1));
			return $query->row();
		}

		public function getCategories() {
			$query = $this->db->get_where('check_categories', array("active" => 1));
			return $query->result();
		}

		public function getItemsByCategory($cat_id){
			$query = $this->db->get_where('check_items', array("category_id" => $cat_id, "active" => 1));
			return $query->result();
		}

		public function update_item($data, $where){
			$this->db->update('check_items', $data, $where);
		}
		
		public function insert_item($data){
			$data["active"] = 1;
			$this->db->insert('check_items', $data);
		}

		public function delete_item($id){
			$current = $this->getItem($id);
			$this->db->update('check_items', array("active" => 0) ,array("id" => $id));
			return $current->category_id;
		}

		public function delete_category($id){
			$this->db->update('check_categories', array("active" => 0) ,array("id" => $id));
		}

		public function addCategory($name){
			$this->db->insert('check_categories', array("name" => $name, "active" => 1));
			return $this->db->insert_id();
		}

	} 
?>	