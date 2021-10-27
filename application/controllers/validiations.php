<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Validiations extends CI_Controller {
    
    public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');  
		$this->load->model('welcome_model');
		$this->load->model('config_model');
		$this->load->model('agent_model');
	}
	
	public function index(){
		if($this->session->userdata("is_logging") == false){
			redirect("welcome/login");
		} else {
    		$data["page"] = "index";
    		$this->load->view('include/temp',$data);  
    	}
	} 
	
	public function agentValidateAccount($agent_id = null, $agent_token = null){
		if($agent_id != null and $agent_token != null){
			$res = $this->agent_model->agentValidateAccount($agent_id, $agent_token);
			if($res != false){
				$this->sesstion->set_flashdata("success", "تم تفعيل حسابكم بنجاح");
				redirect("welcome/agent_login");
			} else {
				$this->sesstion->set_flashdata("error", "خطا في الرابط");
				redirect("welcome/error404");
			}
    	}
	} 
	
	
}


