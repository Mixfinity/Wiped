<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Reports extends CI_Controller {
	public function __construct()
   {
   		parent::__construct();
        $this->load->library('login');
     	$this->login->check();
        $this->load->library('session');
        $this->load->model('reports/ReportsModel', 'reports');

   }
   /**
    * Returns the overview with reports
    */
	public function index()
	{
		$this->load->model("reports/ReportsModel", "reports");
		$data = array(
			"reports" => $this->reports->getAll()
		);
		render("reports/overview", $data);
	}
	/**
	 * New contains the init of a report
	 */
	public function new(){
		if($this->input->post()){
			if(!empty($this->input->post('contact_name'))){
				$this->load->model("contacts/ModelContactsContacts", "contacts");
				$contact_id = $this->contacts->getContactId($this->input->post('contact_name'));
				if(!$contact_id){
					render('reports/wizard/step_1');
					exit;
				}
			} else {
				render('reports/wizard/step_1');
				exit();
			}
			$data = array(
				"contact_id" => $contact_id,
				"name" => empty($this->input->post('name')) ? "" : $this->input->post('name'),
				'date_created' => date('Y-m-d H:i:s'),
				'created_by' => $this->session->userdata["user_id"]
			);
			$report_id = $this->reports->insert($data);
			redirect("/reports/reports/step_2/" . $report_id);
		}
		render('reports/wizard/step_1');
	}
	/**
	 * Step 2 contains visitors
	 */
	public function step_2($f_id = false){
		if(!$f_id){
			redirect("/reports/reports");
		}
		if($this->input->post()){
			$insert_data = array(
				"name" => $this->input->post('name'),
				"prev_name" => $this->input->post('prev_name'),
				"total_visitors" => $this->input->post('total_visitors'),
				"total_visitors_prev" => $this->input->post('total_visitors_prev'),
				"unique_visitors" => $this->input->post('unique_visitors'),
				"unique_visitors_prev" => $this->input->post('unique_visitors_prev'),
				"report_id" => $this->input->post('report_id')
			);
			$this->reports->insert_visitors($insert_data);
			redirect('/reports/reports/step_3/' . $f_id );
		}
		$data = array(
			"report_id" => $f_id
		);	
		render("reports/wizard/step_2", $data);
	}
	/**
	 * Step 3 contains the chanels of a site
	 */
	public function step_3($f_id = false){
		if(!$f_id){
			redirect('/reports/reports');
		}
		$data = array(
			"report_id" => $f_id 
		);
		render("reports/wizard/step_3", $data);
	}
}