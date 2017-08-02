<?php
	class ModelOffersOffers extends CI_Model  {
		public function getAllOffers() {
			$this->db->select('o.*, c.name as contact_name');
			$this->db->from('offers o');
			$this->db->join('contacts c', 'o.contact_id = c.id');
			//$this->db->where("offer_status =", (int)0);
			$query = $this->db->get();
			return $query->result();
		}

		public function getAllCreateOffers() {
			$this->db->select('o.*, c.name as contact_name');
			$this->db->from('offers o');
			$this->db->join('contacts c', 'o.contact_id = c.id');
			$this->db->where("offer_status =", (int)0);
			$query = $this->db->get();
			return $query->result();
		}

		public function getAllSendOffers() {
			$this->db->select('o.*, c.name as contact_name');
			$this->db->from('offers o');
			$this->db->join('contacts c', 'o.contact_id = c.id');
			$this->db->where("offer_status =", (int)1);
			$query = $this->db->get();
			return $query->result();
		}

		public function getAllArchiveOffers() {
			$this->db->select('o.*, c.name as contact_name');
			$this->db->from('offers o');
			$this->db->join('contacts c', 'o.contact_id = c.id');
			$this->db->where("offer_status =", 2);
			$query = $this->db->get();
			return $query->result();
		}



		public function getOffer($f_id){
			$this->db->select('o.*, c.name as contact_name');
			$this->db->from('offers o');
			$this->db->join('contacts c', 'o.contact_id = c.id');
			$this->db->where("o.id", $f_id);
			$query = $this->db->get();
			return $query->row();
		}

		public function getOfferCategories(){
			$this->db->order_by('name', 'asc');
			$query = $this->db->get('offer_default_categories');
			return $query->result();
		}

		public function getDefaultOfferLines($id){
			$this->db->order_by('priority', 'asc');
			$query = $this->db->get_where('offer_default_lines', array('category_id' => $id));
			return array($query->result());
		}

		public function getOfferLines($id){
			$this->db->order_by('priority', 'asc');
			$query = $this->db->get_where('offer_lines', array('offer_id' => $id));
			return $query->result();
		}

		public function getLineData($id){
			$query = $this->db->get_where('offer_default_lines', array('id' => $id));
			return $query->row();
		}

		public function getLine($id){
			$query = $this->db->get_where('offer_lines', array('id' => $id));
			return $query->row();
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

		public function getContactId($f_name){
			$this->db->select('id');
			//$this->db->like('name', $this->db->escape($f_name));
			$query = $this->db->get_where('contacts', array("name" => $f_name));
			if($query->num_rows() > 0){
				return $query->row()->id;
			} else {
				return 0;
			}

		}

		public function getHighestPrio($f_id){
			$this->db->select('priority');
			$this->db->order_by("priority", "desc"); 
			$query = $this->db->get_where('offer_lines', array('offer_id' => $f_id));
			if($query->num_rows() > 0){
				return $query->row()->priority;
			} else {
				return 0;
			}
		}

		public function removeOfferLine($f_id){
			$this->db->delete('offer_lines', array('id' => $f_id));
		}

		public function getOffersByContact($f_contact){
			$this->db->order_by("date_created desc");
			$this->db->select("name,  DATE_FORMAT(date_created, '%d-%m-%Y') as datum, id, offer_status");
			$result = $this->db->get_where("offers", array("contact_id" => $f_contact));
			return $result->result();
		}

	}
?>
