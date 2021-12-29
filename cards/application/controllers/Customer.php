<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {
    
    public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('customer_model');
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
		$config = array();
        $config["base_url"] 	= base_url() . "customer/index";
        $config["total_rows"] 	= $this->customer_model->get_count_customer();
        $config["per_page"] 	= 20;
        $config["uri_segment"] 	= 3;
		
		$config['full_tag_open'] = '<ul class="pagination pagination-lg justify-content-center mt-4">';        
		$config['full_tag_close'] = '</ul>';        
		$config['first_link'] = 'الصفحة الاولى';        
		$config['last_link'] = 'الصفحة الاخيرة';        
		$config['first_tag_open'] = '<li class="page-item">';        
		$config['first_tag_close'] = '</li>';        
		$config['prev_link'] = 'السابق';        
		$config['prev_tag_open'] = '<li class="page-item">';        
		$config['prev_tag_close'] = '</li>';        
		$config['next_link'] = 'التالي';        
		$config['next_tag_open'] = '<li class="page-item">';        
		$config['next_tag_close'] = '</li>';        
		$config['last_tag_open'] = '<li class="page-item">';        
		$config['last_tag_close'] = '</li>';        
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';        
		$config['cur_tag_close'] = '</a></li>';        
		$config['num_tag_open'] = '<li class="page-item">';        
		$config['num_tag_close'] = '</span></li>';
		
        $this->pagination->initialize($config); 
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
        $data["links"] = $this->pagination->create_links(); 
		$data["view"] = $this->customer_model->get_customer($config["per_page"], $page); 
		$data["page"] = "back/customer/index";
		$this->load->view('include/temp',$data); 
	} 


	/*
		customer
	*/
	
	public function new_customer(){
		$data["page"] = "back/customer/add";
		$this->load->view('include/temp',$data);
	}
	
	public function add_customer(){ 
		$post = $this->input->post(null, true);
		$token = bin2hex(openssl_random_pseudo_bytes(16));
		
		$this->form_validation->set_rules('customer_name', 'اسم المستخدم', 'trim|required|is_unique[customer.customer_name]');
		$this->form_validation->set_rules('customer_jawwal', 'رقم الجوال', 'trim|is_unique[customer.customer_jawwal]');
		$this->form_validation->set_rules('customer_email', 'البريد الالكتروني', 'trim|required|valid_email|is_unique[customer.customer_email]');

		if ($this->form_validation->run() == FALSE) {
			$res = validation_errors('<div class="text-danger">', '</div>');
			$status = "error";
			$link = "";
		} else {
			$config['upload_path']="./upload/customer/";
			$config['allowed_types']='gif|jpg|png|svg';
			$config['encrypt_name']= true; 
			$this->load->library('upload',$config);
			
			$customer_logo = ""; 
			
			if($_FILES['customer_logo']['name'] != ''){
				if($this->upload->do_upload("customer_logo")){
					$pic = array('upload_data' => $this->upload->data()); 
					$customer_logo = $config['upload_path'].$pic['upload_data']['file_name']; 
				}
			}
			
			$customer_id = $this->customer_model->add_customer($post, $customer_logo, $token);
			
			if($customer_id != false){
				$res = "تم انشاء حساب زبون جديد بنجاح";
				$status = "success";
				$link = "";
				
				$data = [
					"customer_id"			=> $customer_id,
					"customer_name" 		=> $post["customer_name"],
					"customer_email" 		=> $post["customer_email"],
					"customer_password"		=> $post['customer_password'],
					"customer_token" 		=> $token,
				]; 
 
				$opation = array(
					"subject" => "إنشاء حساب زبون جديد",
					"to" => $post["customer_email"], 
					"message" =>  $this->load->view("email_send/customer/new_customer", $data ,true)
				);
				SendEmail($opation);
				
			} else {
				$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
				$status = "error";
				$link = "";
			}  
		}  
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	} 
	
	
	public function view_customer($customer_id = null){
		if($customer_id != null){ 
			$data["view"] = $this->customer_model->get_customer_id($customer_id);
			$data["page"] = "back/customer/view";
			$this->load->view('include/temp',$data); 
		} else {
			$this->session->set_flashdata("erorr","حدث خطأ ما اثناء التوجيه.");
			redirect("customer");
		}
	} 

	public function update_customer(){
		$post = $this->input->post(null, true); 
		$id = $post["customer_id"];
		
		$this->form_validation->set_rules('customer_name', 'اسم المستخدم', 'trim|required|edit_unique_customer[customer.customer_name.'. $id .']');
		$this->form_validation->set_rules('customer_jawwal', 'رقم الجوال', 'trim|edit_unique_customer[customer.customer_jawwal.'. $id .']'); 
		$this->form_validation->set_rules('customer_email', 'البريد الالكتروني', 'trim|required|valid_email|edit_unique_customer[customer.customer_email.'. $id .']');

		if ($this->form_validation->run() == FALSE) {
			$res = validation_errors('<div class="text-danger">', '</div>');
			$status = "error";
			$link = "";
		} else {
			$config['upload_path']="./upload/customer/";
			$config['allowed_types']='gif|jpg|png|svg';
			$config['encrypt_name']= true; 
			$this->load->library('upload',$config); 
			
			$customer_logo = $post["last_customer_logo"]; 
			
			if($_FILES['customer_logo']['name'] != ''){
				if($this->upload->do_upload("customer_logo")){
					$pic = array('upload_data' => $this->upload->data()); 
					$customer_logo = $config['upload_path'].$pic['upload_data']['file_name']; 
					//remove old pic
					//unlink($post["last_customer_logo"]);
				}
			}

			$res = $this->customer_model->update_customer($post, $customer_logo);
			if($res != false){
				$res = "تم تعديل حساب المستخدم". $post['customer_name'] ." بنجاح ";
				$status = "success";
				$link = site_url()."customer";
			} else {
				$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
				$status = "error";
				$link = "";
			}  
		}  
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	}

	public function update_customer_status(){ 
		$customer_id = $this->input->post("customer_id", true); 
		$customer_active = $this->input->post("customer_active", true);
		
		$res = $this->customer_model->update_customer_status($customer_active, $customer_id);
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
	
	public function remove_customer_id(){ 
		$customer_id = $this->input->post("customer_id", true);  
		
		$res = $this->customer_model->remove_customer_id($customer_id);
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
}