<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Card extends CI_Controller {
    
    public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('card_model');
		$this->load->model('welcome_model');
		$this->load->model('config_model');
		$this->load->model('category_model');
 
		if($this->session->userdata("my_token") != $this->security->get_csrf_hash()){
			redirect("welcome/login");
		}
		/*
		$permission = $this->welcome_model->have_permission();
		( $permission == 0) ? redirect("welcome/no_auth") : "";
		*/
	}
	
	public function index(){
		$data["view"] = $this->card_model->get_all_card();
		$data["page"] = "card/index";
		$this->load->view('include/temp',$data); 
	}
	
	public function new_card(){
		$data["category"] = $this->category_model->get_category(0);
		$data["language"] = $this->config_model->get_language();
		$data["page"] = "card/add";
		$this->load->view('include/temp',$data);
	}
	
	public function add_card(){
		$post = $this->input->post(null, true);
		
		$config['upload_path']="./upload/card/";
		$config['allowed_types']='gif|jpg|png|svg';
		$config['encrypt_name']= true; 
		$this->load->library('upload',$config);
		
		$card_pic = ""; 
		
		if($_FILES['card_pic']['name'] != ''){
			if($this->upload->do_upload("card_pic")){
				$pic = array('upload_data' => $this->upload->data()); 
				$card_pic = $config['upload_path'].$pic['upload_data']['file_name']; 
			}
		}
		
		$card_id = $this->card_model->add_card($post, $card_pic);
		if($card_id != false){
			$res = "تم اضافة بطاقة جديدة بنجاح";
			$status = "success";
			$link = "";
		} else {
			$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
			$status = "error";
			$link = "";
		}
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	}
	
	public function view_card($card_id = null){
		if($card_id != null and $card_id > 0){ 

			$data["category"] = $this->category_model->get_category(0);
			$data["language"] = $this->config_model->get_language();
			$data["view"] = $this->card_model->get_card_id($card_id);
			$data["page"] = "card/view";
			$this->load->view('include/temp',$data); 
		} else {
			$this->session->set_flashdata("erorr","حدث خطأ ما اثناء التوجيه.");
			redirect("card");
		}
	} 

	public function update_card(){
		$post = $this->input->post(null, true);

		$config['upload_path']="./upload/card/";
		$config['allowed_types']='gif|jpg|png|svg';
		$config['encrypt_name']= true; 
		$this->load->library('upload',$config); 
		
		$card_pic = $post["last_card_pic"]; 
		
		if($_FILES['card_pic']['name'] != ''){
			if($this->upload->do_upload("card_pic")){
				$pic = array('upload_data' => $this->upload->data()); 
				$card_pic = $config['upload_path'].$pic['upload_data']['file_name']; 
				//remove old pic
				unlink($post["last_card_pic"]);
			}
		}
		
		$res = $this->card_model->update_card($post, $card_pic);
		if($res != false){
			$res = "تم تعديل البطاقة الالكترونية". json_decode($post['card_name'])->ar ." بنجاح ";
			$status = "success";
			$link = site_url()."card";
		} else {
			$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
			$status = "error";
			$link = "";
		}
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	} 

	public function update_card_status(){ 
		$card_id = $this->input->post("card_id", true); 
		$card_active = $this->input->post("card_active", true);
		
		$res = $this->card_model->update_card_status($card_active, $card_id);
		if($res != false){
			$res = "تم تغيير حالة البطاقة الالكترونية بنجاح";
			$status = "success";
			$link = "";
		} else {
			$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
			$status = "error";
			$link = "";
		}  
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	}
	
	public function remove_card_id(){ 
		$card_id = $this->input->post("card_id", true);  
		
		$res = $this->card_model->remove_card_id($card_id);
		if($res != false){
			$res = " تم حذف البطاقة الالكترونية بنجاح.";
			$status = "success";
			$link = "";
		} else {
			$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
			$status = "error";
			$link = "";
		}  
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	}

	function get_sub_category(){
		$category_id = $this->input->post("category_id", true);
		$view = $this->category_model->get_category($category_id); 
		if(!empty($view)){
			$res = '<option value="" seleted disabled></option>';
			foreach($view as $v){ 
				$res .= '<option value="'. $v->category_id .'"> '. json_decode($v->category_name)->ar .' </option>';
			}
		} else {
			$res = false;
		}
		echo $res;
	}
}




