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
				$data = [
					"agent_name"		=> $res->agent_name, 
					"agent_email" 		=> $res->agent_email
				];

				$config = Array(
					'protocol' => 'smtp',
					'smtp_host' => 'ssl://smtp.googlemail.com',
					//'smtp_port' => 587,
					'smtp_port' => 465,
					'smtp_agent' => 'alaa.krunb@gmail.com', // change it to yours
					'smtp_pass' => '411918139', // change it to yours
					'mailtype' => 'html',
					'charset' => 'utf-8',
					'wordwrap' => TRUE
				);
				$this->load->library("email", $config);
				
				$message =  $this->load->view("email_send/agent/active_agent", $data ,true);

				$this->email->set_header('Content-Type', 'text/html');
				$this->email->set_newline("\r\n");
				$this->email->from('alaa.krunb@gmail.com',"krunb4it");
				$this->email->to($res->agent_email);
				$this->email->subject('تم تفعيل حسابكم');
				$this->email->message($message);
				$this->email->set_mailtype("html");

				if(!$this->email->send()) {
					$res = show_error($this->email->print_debugger());
					// echo  $this->email->print_debugger();
				} 
 
				$this->session->set_flashdata("success", "تم تفعيل حسابكم بنجاح");
				redirect("agentProfile");
			} else {
				$this->session->set_flashdata("error", "خطا في الرابط");
				redirect("welcome/error404");
			}
    	}
	} 
	
	
}


