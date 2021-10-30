<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {
    
    public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('category_model');
		$this->load->model('config_model');
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
		$data["language"] = $this->config_model->get_language();
		$data["view"] = $this->category_model->get_category(0);
		$data["page"] = "category/main/index";
		$this->load->view('include/temp',$data);
	} 

	public function view_category($category_id = null){
		if($category_id != null){
			$data["language"] = $this->config_model->get_language();
			$data["view"] = $this->category_model->get_category_id($category_id);
			$data["page"] = "category/main/view";
			$this->load->view('include/temp',$data); 
		}
	}

	public function new_category(){
		$data["language"] = $this->config_model->get_language();
		$data["page"] = "category/main/add";
		$this->load->view('include/temp',$data);  
	}

	
	public function add_category(){
		$post = $this->input->post(null, true);
		
		$category['upload_path']="./upload/category/";
		$category['allowed_types']='gif|jpg|png';
		$category['encrypt_name']= true; 
		$this->load->library('upload',$category); 
		
		$category_pic = ""; 
		if($_FILES['category_pic']['name'] != ''){
			if($this->upload->do_upload("category_pic")){
				$pic = array('upload_data' => $this->upload->data()); 
				$category_pic = $category['upload_path'].$pic['upload_data']['file_name']; 
			}
		}
		
		$res = $this->category_model->add_category($post, $category_pic);
		if($res != false){
			$res = " تم حفظ التغيرات بنجاح";
			$status = "success";
			$link = "";
		} else {
			$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
			$status = "error";
			$link = "";
		}  
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	}
	
	public function update_category(){
		$post = $this->input->post(null, true);
		
		$category['upload_path']="./upload/category/";
		$category['allowed_types']='gif|jpg|png';
		$category['encrypt_name']= true; 
		$this->load->library('upload',$category);

		$category_pic = $post["last_category_pic"];
		if($_FILES['category_pic']['name'] != ''){
			if($this->upload->do_upload("category_pic")){
				$pic = array('upload_data' => $this->upload->data()); 
				$category_pic = $category['upload_path'].$pic['upload_data']['file_name']; 
			}
		}

		$res = $this->category_model->update_category($post, $category_pic);
		if($res != false){
			$res = " تم حفظ التغيرات بنجاح";
			$status = "success";
			$link = "";
		} else {
			$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
			$status = "error";
			$link = "";
		}  
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	}
	
	public function update_category_status(){ 
		$category_id = $this->input->post("category_id", true); 
		$category_active = $this->input->post("category_active", true);
		
		$res = $this->category_model->update_category_status($category_active, $category_id);
		if($res != false){
			$res = " تم حفظ التغيرات بنجاح";
			$status = "success";
			$link = "";
		} else {
			$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
			$status = "error";
			$link = "";
		}  
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	}

	public function remove_category_id(){ 
		$category_id = $this->input->post("category_id", true);  
		
		$res = $this->category_model->remove_category_id($category_id);
		if($res != false){
			$res = " تم حذف الاعلان بنجاح.";
			$status = "success";
			$link = "";
		} else {
			$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
			$status = "error";
			$link = "";
		}  
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	}
	
	function update_category_order(){
		$id_ary = $this->input->post('s', TRUE); 
		$order = 1;
		for($i=0; $i < count($id_ary); $i++) {
			$this->db
				->set("category_order", $order)
				->where("category_id", $id_ary[$i])
				->update("category"); 
			$order++;
		} 
		echo json_encode(array("res" => " تم حفظ التغيرات بنجاح"));  
	}
	function view_sub_category($category_id = ""){ 
		if($category_id != "" and $category_id > 0){
			
			$data["language"] = $this->config_model->get_language();				// language
			$data["view"] = $this->category_model->get_category($category_id);
			$data["category"] = $this->category_model->get_category(0);
			$category_name = $this->category_model->get_category_id($category_id);
			$data["category_name"] = json_decode($category_name->category_name)->ar;
			$data["category_id"] = $category_id;
			$data["page"] = "category/sub/index";
			$this->load->view('include/temp',$data);
			/*
			if(empty($data["view"])){ 
				$this->session->set_flashdata("error_msg", " خطأ في الرابط ، يرجى التحقق من الرابط المطلوب");
				redirect("category");
			}*/
			
		} else {
			$this->session->set_flashdata("error_msg", " خطأ في الرابط ، يرجى التحقق من الرابط المطلوب");
			redirect("category");
		}
	}
	
	public function view_sub_category_id($category_id = ""){
		if($category_id != "" and $category_id > 0){
			$data["language"] = $this->config_model->get_language();
			$data["category"] = $this->category_model->get_category(0);
			$data["view"] = $this->category_model->get_category_id($category_id);
			$data["page"] = "category/sub/view";
			$this->load->view('include/temp',$data); 
			
			if(empty($data["view"])){ 
				$this->session->set_flashdata("error_msg", " خطأ في الرابط ، يرجى التحقق من الرابط المطلوب");
				redirect("category");
			}
		} else {
			$this->session->set_flashdata("error_msg", " خطأ في الرابط ، يرجى التحقق من الرابط المطلوب");
			redirect("category/");
		}
	} 
	public function new_sub_category($category_id){
		$data["category_id"] = $category_id;
		$data["language"] = $this->config_model->get_language();
		$data["category"] = $this->category_model->get_category(0);
		$data["view"] = $this->category_model->get_category_id($category_id);
		$data["page"] = "category/sub/add";
		$this->load->view('include/temp',$data);
	}
}