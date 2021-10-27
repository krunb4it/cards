<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AgentProfile extends CI_Controller {
    
    public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		
		if($this->session->userdata("agent_token") != $this->security->get_csrf_hash()){
			redirect("agentProfile/login");
		}
	}
	
	public function index(){
		$data["page"] = "agentProfile/index";
		$this->load->view('include/temp',$data);   
	}
	
	public function login(){ 
		$this->load->view('agentProfile/login');
	}
	
	public function do_login(){  
		$post = $this->input->post(NULL, TRUE);
		$arr = array(
	        "email"     => $post['email'],
           "password"   => md5($post['password'])
		);
		$row = $this->db->get_where("agent",$arr)->row();
		if(!empty($row)){
		    if($row->agent_active == 1){ 

				$this->config_model->update_token($row->agent_id, $this->security->get_csrf_hash());
    	        $data = array(
    	                "agent_id" 		=> $row->agent_id
    	            ,   "agent_name" 	=> $row->agent_name
    	            ,   "agent_logo"	=> $row->agent_logo
    	            ,   "agent_email"	=> $row->agent_email
    	            ,   "agent_jawwal"	=> $row->agent_jawwal
    	            ,   "agent_active"	=> $row->agent_active
					,	"agent_token"	=> $this->security->get_csrf_hash()
				);
	            $this->session->set_userdata($data);
    		    $status = 1;
				$res    = "تم تسجيل الدخول بنجاح";
				
		    } else {
    		    $status = 0;
    		    $res    = "هذاالحساب غير مفعّل ، يرجى مراسلة الادارة لمعرفة السبب.";
		    }
		} else {
		    $status = 0;
		    $res    = " خطأ في اسم المستخدم أو كلمة المرور";
		}
		echo json_encode(array("res"=>$res, "status"=> $status));
	}
	
	public function logOut(){  
		$this->session->sess_destroy();
		redirect();	
	}
}


