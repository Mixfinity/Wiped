<?php

	class ReportsModel extends CI_Model  {

		public function insert($data = false){
			if(!$data){
				return false;
			}
			$this->db->insert("reports", $data);
			return $this->db->insert_id();
		}

		public function insert_visitors($data = false){
			if(!$data){
				return false;
			}
			$this->db->insert("report_visitors", $data);
			return $this->db->insert_id();
		}

		public function getAll(){
			$this->db->select("contacts.name as contact_name, reports.*");
			$this->db->join('contacts', 'contacts.id = reports.contact_id');
			$this->db->order_by("created_by", "DESC");
			return $this->db->get("reports")->result();
		}

	}



?>