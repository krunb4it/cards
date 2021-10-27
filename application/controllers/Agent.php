<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agent extends CI_Controller {
    
    public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('agent_model');
		$this->load->model('welcome_model');
 
		if($this->session->userdata("my_token") != $this->security->get_csrf_hash()){
			redirect("welcome/login");
		}
		/*
		$permission = $this->welcome_model->have_permission();
		( $permission == 0) ? redirect("welcome/no_auth") : "";
		*/
	}
	
	public function index(){
		$data["view"] = $this->agent_model->get_all_agent();
		$data["page"] = "agent/index";
		$this->load->view('include/temp',$data); 
	} 


	/*
		agent
	*/
	
	public function new_agent(){
		$data["page"] = "agent/add";
		$this->load->view('include/temp',$data);
	}
	
	public function add_agent(){ 
		$post = $this->input->post(null, true);
		$token = bin2hex(openssl_random_pseudo_bytes(16));
		
		$this->form_validation->set_rules('agent_name', 'اسم المستخدم', 'trim|required|is_unique[agent.agent_name]');
		$this->form_validation->set_rules('agent_jawwal', 'رقم الجوال', 'trim|is_unique[agent.agent_jawwal]');
		$this->form_validation->set_rules('agent_email', 'البريد الالكتروني', 'trim|required|valid_email|is_unique[agent.agent_email]');

		if ($this->form_validation->run() == FALSE) {
			$res = validation_errors('<div class="text-danger">', '</div>');
			$status = "error";
			$link = "";
		} else {
			$config['upload_path']="./upload/agent/";
			$config['allowed_types']='gif|jpg|png|svg';
			$config['encrypt_name']= true; 
			$this->load->library('upload',$config);
			
			$agent_logo = ""; 
			
			if($_FILES['agent_logo']['name'] != ''){
				if($this->upload->do_upload("agent_logo")){
					$pic = array('upload_data' => $this->upload->data()); 
					$agent_logo = $config['upload_path'].$pic['upload_data']['file_name']; 
				}
			}
			
			$agent_id = $this->agent_model->add_agent($post, $agent_logo, $token);
			
			if($agent_id != false){
				$res = "تم انشاء حساب وكيل جديد بنجاح";
				$status = "success";
				$link = "";

				
				$data = [
					"agent_id"			=> $agent_id,
					"agent_name" 		=> $post["agent_name"],
					"agent_email" 		=> $post["agent_email"],
					"agent_password"	=> $post["agent_password"],
					"agent_token" 		=> $token,
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
				
				$message =  $this->load->view("email_send/agent/new_agent", $data ,true);

				$this->email->set_header('Content-Type', 'text/html');
				$this->email->set_newline("\r\n");
				$this->email->from('alaa.krunb@gmail.com',"krunb4it");
				$this->email->to("a.krunb@hotmail.com");
				$this->email->subject('حساب وكيل جديد');
				$this->email->message($message);
				$this->email->set_mailtype("html");

				if(!$this->email->send()) {
					$res = show_error($this->email->print_debugger());
					// echo  $this->email->print_debugger() ;
				} 
			} else {
				$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
				$status = "error";
				$link = "";
			}  
		}  
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	} 
	
	
	public function view_agent($agent_id = null){
		if($agent_id != null){ 
			$data["view"] = $this->agent_model->get_agent_id($agent_id);
			$data["page"] = "agent/view";
			$this->load->view('include/temp',$data); 
		} else {
			$this->session->set_flashdata("erorr","حدث خطأ ما اثناء التوجيه.");
			redirect("agent");
		}
	} 

	public function update_agent(){ 
		$post = $this->input->post(null, true); 
		$id = $post["agent_id"];
		
		$this->form_validation->set_rules('agent_name', 'اسم المستخدم', 'trim|required|edit_unique_agent[agent.agent_name.'. $id .']');
		$this->form_validation->set_rules('agent_jawwal', 'رقم الجوال', 'trim|edit_unique_agent[agent.agent_jawwal.'. $id .']'); 
		$this->form_validation->set_rules('agent_email', 'البريد الالكتروني', 'trim|required|valid_email|edit_unique_agent[agent.agent_email.'. $id .']');

		if ($this->form_validation->run() == FALSE) {
			$res = validation_errors('<div class="text-danger">', '</div>');
			$status = "error";
			$link = "";
		} else {
			$config['upload_path']="./upload/agent/";
			$config['allowed_types']='gif|jpg|png|svg';
			$config['encrypt_name']= true; 
			$this->load->library('upload',$config); 
			
			$agent_logo = $post["last_agent_logo"]; 
			
			if($_FILES['agent_logo']['name'] != ''){
				if($this->upload->do_upload("agent_logo")){
					$pic = array('upload_data' => $this->upload->data()); 
					$agent_logo = $config['upload_path'].$pic['upload_data']['file_name']; 
					//remove old pic
					unlink($post["last_agent_logo"]);
				}
			}
			
			$res = $this->agent_model->update_agent($post, $agent_logo);
			if($res != false){
				$res = "تم تعديل حساب المستخدم". $post['agent_name'] ." بنجاح ";
				$status = "success";
				$link = site_url()."agent";
			} else {
				$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
				$status = "error";
				$link = "";
			}  
		}  
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	} 

	public function update_agent_status(){ 
		$agent_id = $this->input->post("agent_id", true); 
		$agent_active = $this->input->post("agent_active", true);
		
		$res = $this->agent_model->update_agent_status($agent_active, $agent_id);
		if($res != false){
			$res = "تم تغيير حالة المستخدم بنجاح";
			$status = "success";
			$link = "";
		} else {
			$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
			$status = "error";
			$link = "";
		}  
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	}
	
	public function remove_agent_id(){ 
		$agent_id = $this->input->post("agent_id", true);  
		
		$res = $this->agent_model->remove_agent_id($agent_id);
		if($res != false){
			$res = " تم حذف المستخدم بنجاح.";
			$status = "success";
			$link = "";
		} else {
			$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
			$status = "error";
			$link = "";
		}  
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	}

	/*
		porfile
	*/

	
	public function update_profile(){ 
		$post = $this->input->post(null, true); 
		$id = $post["agent_id"];
		$last_email = $this->agent_model->get_agent_id($id);
	
		$this->form_validation->set_rules('jawwal', 'رقم الجوال', 'trim|edit_unique[agent.jawwal.'. $id .']'); 
		$this->form_validation->set_rules('email', 'البريد الالكتروني', 'trim|required|valid_email|edit_unique[agent.email.'. $id .']');

		if ($this->form_validation->run() == FALSE) {
			$res = validation_errors('<div class="text-danger">', '</div>');
			$status = "error";
			$link = "";
		} else {
			$config['upload_path']="./upload/agent/";
			$config['allowed_types']='gif|jpg|png|svg';
			$config['encrypt_name']= true; 
			$this->load->library('upload',$config); 
			
			$agent_logo = $post["last_agent_logo"];
			
			if($_FILES['agent_logo']['name'] != ''){
				if($this->upload->do_upload("agent_logo")){
					$pic = array('upload_data' => $this->upload->data()); 
					$agent_logo = $config['upload_path'].$pic['upload_data']['file_name']; 
				}
			}
			
			$res = $this->agent_model->update_profile($post, $agent_logo);
			if($res != false){
				$res = "تم تعديل حساب المستخدم بنجاح ";
				$status = "success";
				if($post['email'] != $last_email->email){
					$this->agent_model->inactive_agent($id);
					$token = $this->agent_model->update_token($id);
					$this->session->set_agentdata("agent_token", $token);
					$this->session->set_agentdata("agent_email", $post['email']);
					$link = "welcome/logout";

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
					
					$message =  $this->load->view("email_send/profile/change_email","",true);
			
					$this->email->set_header('Content-Type', 'text/html');
					$this->email->set_newline("\r\n");
					$this->email->from('alaa.krunb@gmail.com',"krunb4it");
					$this->email->to($post['email']);
					$this->email->subject('تغيير البريد الالكتروني');
					$this->email->message($message);
					$this->email->set_mailtype("html");
			
					if(!$this->email->send()) { 
						//$res = show_error($this->email->print_debugger());
						$res =  $this->email->print_debugger() ;
					}
				} else {
					$link = "";
					$this->session->set_agentdata("agent_logo", $agent_logo);
					$this->session->set_agentdata("agent_jawwal", $post['jawwal']);
				}
			} else {
				$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
				$status = "error";
				$link = "";
			}
		}
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	}
	 
}



