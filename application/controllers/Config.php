<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends CI_Controller {
    
    public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');  
		$this->load->model('config_model');
 
		if($this->session->userdata("my_token") != $this->security->get_csrf_hash()){
			redirect("welcome/login");
		}
	}
	
	public function index(){
		$data["page"] = "config/index";
		$this->load->view('include/temp',$data); 
	}
	public function profile(){
		$data["admin_group"] = $this->config_model->get_admin_group();
		$data["page"] = "config/profile/index";
		$this->load->view('include/temp',$data);
	}
	public function setting(){ 
		$data["language"] = $this->config_model->get_language();
		$data["view"] = $this->config_model->get_setting();
		$data["page"] = "config/setting/index";
		$this->load->view('include/temp',$data);  
	}
	public function contact(){
		$data["language"] = $this->config_model->get_language();
		$data["view"] = $this->config_model->get_setting();
		$data["page"] = "config/contact/index";
		$this->load->view('include/temp',$data);  
	}
	public function social_media(){
		$data["language"] = $this->config_model->get_language();
		$data["view"] = $this->config_model->get_setting();
		$data["page"] = "config/social_media/index";
		$this->load->view('include/temp',$data);  
	}
	public function page(){
		$data["language"] = $this->config_model->get_language();
		$data["view"] = $this->config_model->get_page();
		$data["page"] = "config/page/index";
		$this->load->view('include/temp',$data);  
	}
	public function payment_way(){
		$data["language"] = $this->config_model->get_language();
		$data["view"] = $this->config_model->get_payment_way();
		$data["page"] = "config/payment_way/index";
		$this->load->view('include/temp',$data);  
	}
	public function slider(){
		$data["language"] = $this->config_model->get_language();
		$data["view"] = $this->config_model->get_slider();
		$data["page"] = "config/slider/index";
		$this->load->view('include/temp',$data);  
	}
	public function language(){
		$data["language"] = $this->config_model->get_language();
		$data["view"] = $this->config_model->get_language();
		$data["page"] = "config/language/index";
		$this->load->view('include/temp',$data);  
	}
	
	public function users(){
		$data["language"] = $this->config_model->get_language();
		$data["view"] = $this->config_model->get_users();
		$data["page"] = "config/users/index";
		$this->load->view('include/temp',$data);  
	}
	public function currency(){ 
		$data["view"] = $this->config_model->get_currency();
		$data["page"] = "config/currency/index";
		$this->load->view('include/temp',$data);
	}
	
	public function activites(){
		$data["language"] = $this->config_model->get_language();
		$data["view"] = $this->config_model->get_activites();
		$data["page"] = "config/activites/index";
		$this->load->view('include/temp',$data);  
	}
	
	/* website_last_update */
	
	public function update_setting(){ 
		$post = $this->input->post(null, true);
		if(!empty($post)){ 
			$res = $this->config_model->update_setting($post);
			if($res != false){
				$res = " تم حفظ التغيرات بنجاح";
				$status = "success";
				$link = "";
			} else {
				$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
				$status = "error";
				$link = "";
			} 
		} else {
			$res = "لا يمكن حفظ بيانات فارغة ، الرجاء ادخال البيانات المطلوبة";
			$status = "error";
			$link = "";
		}
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	}
	
	public function update_contact(){ 
		$post = $this->input->post(null, true);
		if(!empty($post)){ 
			$res = $this->config_model->update_contact($post);
			if($res != false){
				$res = " تم حفظ التغيرات بنجاح";
				$status = "success";
				$link = "";
			} else {
				$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
				$status = "error";
				$link = "";
			} 
		} else {
			$res = "لا يمكن حفظ بيانات فارغة ، الرجاء ادخال البيانات المطلوبة";
			$status = "error";
			$link = "";
		}
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	}
	
	public function update_social_media(){ 
		$post = $this->input->post(null, true); 
		if(!empty($post)){ 
			$res = $this->config_model->update_social_media($post);
			if($res != false){
				$res = " تم حفظ التغيرات بنجاح";
				$status = "success";
				$link = "";
			} else {
				$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
				$status = "error";
				$link = "";
			} 
		} else {
			$res = "لا يمكن حفظ بيانات فارغة ، الرجاء ادخال البيانات المطلوبة";
			$status = "error";
			$link = "";
		}
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	}
	
	public function update_language(){ 
		$lang_id = $this->input->post("lang_id", true); 
		$lang_active = $this->input->post("lang_active", true);
		
		$res = $this->config_model->update_language($lang_active, $lang_id);
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
	
	public function view_page($page_id = null){ 
		
		if($page_id != null){
			$data["language"] = $this->config_model->get_language();
			$data["view"] = $this->config_model->get_page_id($page_id);
			$data["page"] = "config/page/view";
			$this->load->view('include/temp',$data); 
		}
	} 
	public function update_page(){ 
		$post = $this->input->post(null, false); 
		
		$config['upload_path']="./upload/page/";
		$config['allowed_types']='gif|jpg|png';
		$config['encrypt_name']= true; 
		$this->load->library('upload',$config); 
		
		$page_cover = $post["last_page_cover"]; 
		if($_FILES['page_cover']['name'] != ''){
			if($this->upload->do_upload("page_cover")){
				$pic = array('upload_data' => $this->upload->data()); 
				$page_cover = $config['upload_path'].$pic['upload_data']['file_name']; 
			}
		} 
		
		$res = $this->config_model->update_page($post, $page_cover, $page_details);
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
	
	public function update_page_status(){ 
		$page_id = $this->input->post("page_id", true); 
		$page_active = $this->input->post("page_active", true);
		
		$res = $this->config_model->update_page_status($page_active, $page_id);
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
	/*
	function update_page_order(){  
		$id_ary = $this->input->post('s', TRUE); 
		$order = 1;
		for($i=0; $i < count($id_ary); $i++) {
			$this->db
				->set("page_order", $order)
				->where("page_id", $id_ary[$i])
				->update("page");
				
			$order++;
		} 
		echo json_encode(array("res" => " تم حفظ التغيرات بنجاح"));  
	}
	*/
	
	/*
		Slider 
	*/
	
	public function new_slider(){  
		$data["language"] = $this->config_model->get_language();
		$data["page"] = "config/slider/add";
		$this->load->view('include/temp',$data);  
	}
	
	public function view_slider($slider_id = null){
		if($slider_id != null){
			$data["language"] = $this->config_model->get_language();
			$data["view"] = $this->config_model->get_slider_id($slider_id);
			$data["page"] = "config/slider/view";
			$this->load->view('include/temp',$data); 
		}
	}
	
	public function add_slider(){ 
		$post = $this->input->post(null, true); 
		
		$config['upload_path']="./upload/slider/";
		$config['allowed_types']='gif|jpg|png';
		$config['encrypt_name']= true; 
		$this->load->library('upload',$config); 
		
		$slider_cover = ""; 
		if($_FILES['slider_cover']['name'] != ''){
			if($this->upload->do_upload("slider_cover")){
				$pic = array('upload_data' => $this->upload->data()); 
				$slider_cover = $config['upload_path'].$pic['upload_data']['file_name']; 
			}
		}
		
		$res = $this->config_model->add_slider($post, $slider_cover);
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
	
	public function update_slider(){ 
		$post = $this->input->post(null, true); 
		
		$config['upload_path']="./upload/slider/";
		$config['allowed_types']='gif|jpg|png';
		$config['encrypt_name']= true; 
		$this->load->library('upload',$config); 
		
		$slider_cover = $post["last_slider_cover"]; 
		if($_FILES['slider_cover']['name'] != ''){
			if($this->upload->do_upload("slider_cover")){
				$pic = array('upload_data' => $this->upload->data()); 
				$slider_cover = $config['upload_path'].$pic['upload_data']['file_name']; 
			}
		}  
		$res = $this->config_model->update_slider($post, $slider_cover);
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
	
	public function update_slider_status(){ 
		$slider_id = $this->input->post("slider_id", true); 
		$slider_active = $this->input->post("slider_active", true);
		
		$res = $this->config_model->update_slider_status($slider_active, $slider_id);
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
	public function remove_slider_id(){ 
		$slider_id = $this->input->post("slider_id", true);  
		
		$res = $this->config_model->remove_slider_id($slider_id);
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
	
	function update_slider_order(){  
		$id_ary = $this->input->post('s', TRUE); 
		$order = 1;
		for($i=0; $i < count($id_ary); $i++) {
			$this->db
				->set("slider_order", $order)
				->where("slider_id", $id_ary[$i])
				->update("slider"); 
			$order++;
		} 
		echo json_encode(array("res" => " تم حفظ التغيرات بنجاح"));  
	}
	
	
	/*
		payment way 
	*/
	
	public function new_payment_way(){  
		$data["language"] = $this->config_model->get_language();
		$data["page"] = "config/payment_way/add";
		$this->load->view('include/temp',$data);  
	}
	
	public function view_payment_way($payment_way_id = null){
		if($payment_way_id != null){
			$data["language"] = $this->config_model->get_language();
			$data["view"] = $this->config_model->get_payment_way_id($payment_way_id);
			$data["page"] = "config/payment_way/view";
			$this->load->view('include/temp',$data); 
		}
	}
	
	public function add_payment_way(){ 
		$post = $this->input->post(null, true); 
		
		$config['upload_path']="./upload/payment_way/";
		$config['allowed_types']='gif|jpg|png|svg';
		$config['encrypt_name']= true; 
		$this->load->library('upload',$config); 
		
		$payment_way_pic = ""; 
		if($_FILES['payment_way_pic']['name'] != ''){
			if($this->upload->do_upload("payment_way_pic")){
				$pic = array('upload_data' => $this->upload->data()); 
				$payment_way_pic = $config['upload_path'].$pic['upload_data']['file_name']; 
			}
		}
		
		$res = $this->config_model->add_payment_way($post, $payment_way_pic);
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
	
	public function update_payment_way(){ 
		$post = $this->input->post(null, true); 
		
		$config['upload_path']="./upload/payment_way/";
		$config['allowed_types']='gif|jpg|png|svg';
		$config['encrypt_name']= true; 
		$this->load->library('upload',$config); 
		
		$payment_way_pic = $post["last_payment_way_pic"]; 
		if($_FILES['payment_way_pic']['name'] != ''){
			if($this->upload->do_upload("payment_way_pic")){
				$pic = array('upload_data' => $this->upload->data()); 
				$payment_way_pic = $config['upload_path'].$pic['upload_data']['file_name']; 
			}
		}  
		$res = $this->config_model->update_payment_way($post, $payment_way_pic);
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
	
	public function update_payment_way_status(){ 
		$payment_way_id = $this->input->post("payment_way_id", true); 
		$payment_way_active = $this->input->post("payment_way_active", true);
		
		$res = $this->config_model->update_payment_way_status($payment_way_active, $payment_way_id);
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
	public function remove_payment_way_id(){ 
		$payment_way_id = $this->input->post("payment_way_id", true);  
		
		$res = $this->config_model->remove_payment_way_id($payment_way_id);
		if($res != false){
			$res = " تم حذف طريقة الدفع بنجاح.";
			$status = "success";
			$link = "";
		} else {
			$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
			$status = "error";
			$link = "";
		}  
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	}
	
	function update_payment_way_order(){  
		$id_ary = $this->input->post('s', TRUE); 
		$order = 1;
		for($i=0; $i < count($id_ary); $i++) {
			$this->db
				->set("payment_way_order", $order)
				->where("payment_way_id", $id_ary[$i])
				->update("payment_way"); 
			$order++;
		} 
		echo json_encode(array("res" => " تم حفظ التغيرات بنجاح"));  
	}
	
	
	/*
		users
	*/
	
	public function new_user(){
		$data["admin_group"] = $this->config_model->get_admin_group();
		$data["page"] = "config/users/add";
		$this->load->view('include/temp',$data);  
	}
	
	public function view_user($user_id = null){
		if($user_id != null){
			$data["admin_group"] = $this->config_model->get_admin_group();
			$data["view"] = $this->config_model->get_user_id($user_id);
			$data["page"] = "config/users/view";
			$this->load->view('include/temp',$data); 
		}
	} 
	public function add_user(){ 
		$post = $this->input->post(null, true); 
		
		$this->form_validation->set_rules('user_name', 'اسم المستخدم', 'trim|required|is_unique[users.user_name]');
		$this->form_validation->set_rules('jawwal', 'رقم الجوال', 'trim|is_unique[users.jawwal]'); 
		$this->form_validation->set_rules('email', 'البريد الالكتروني', 'trim|required|valid_email|is_unique[users.email]');

		if ($this->form_validation->run() == FALSE) {
			$res = validation_errors('<div class="text-danger">', '</div>');
			$status = "error";
			$link = "";
		} else {
			$config['upload_path']="./upload/users/";
			$config['allowed_types']='gif|jpg|png|svg';
			$config['encrypt_name']= true; 
			$this->load->library('upload',$config);
			
			$user_pic = ""; 
			
			if($_FILES['user_pic']['name'] != ''){
				if($this->upload->do_upload("user_pic")){
					$pic = array('upload_data' => $this->upload->data()); 
					$user_pic = $config['upload_path'].$pic['upload_data']['file_name']; 
				}
			}
			
			$res = $this->config_model->add_user($post, $user_pic);
			if($res != false){
				$res = "تم انشاء حساب مستخدم جديد بنجاح";
				$status = "success";
				$link = "";
			} else {
				$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
				$status = "error";
				$link = "";
			}  
		}  
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	} 
	
	public function update_user(){ 
		$post = $this->input->post(null, true); 
		$id = $post["user_id"];
		
		$this->form_validation->set_rules('user_name', 'اسم المستخدم', 'trim|required|edit_unique[users.user_name.'. $id .']');
		$this->form_validation->set_rules('jawwal', 'رقم الجوال', 'trim|edit_unique[users.jawwal.'. $id .']'); 
		$this->form_validation->set_rules('email', 'البريد الالكتروني', 'trim|required|valid_email|edit_unique[users.email.'. $id .']');

		if ($this->form_validation->run() == FALSE) {
			$res = validation_errors('<div class="text-danger">', '</div>');
			$status = "error";
			$link = "";
		} else {
			$config['upload_path']="./upload/users/";
			$config['allowed_types']='gif|jpg|png|svg';
			$config['encrypt_name']= true; 
			$this->load->library('upload',$config); 
			
			$user_pic = $post["last_user_pic"]; 
			
			if($_FILES['user_pic']['name'] != ''){
				if($this->upload->do_upload("user_pic")){
					$pic = array('upload_data' => $this->upload->data()); 
					$user_pic = $config['upload_path'].$pic['upload_data']['file_name']; 
				}
			}
			
			$res = $this->config_model->update_user($post, $user_pic);
			if($res != false){
				$res = "تم تعديل حساب المستخدم". $post['user_name'] ." بنجاح ";
				$status = "success";
				$link = "";
			} else {
				$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
				$status = "error";
				$link = "";
			}  
		}  
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	} 
	public function update_user_status(){ 
		$user_id = $this->input->post("user_id", true); 
		$user_active = $this->input->post("user_active", true);
		
		$res = $this->config_model->update_user_status($user_active, $user_id);
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
	
	public function remove_user_id(){ 
		$user_id = $this->input->post("user_id", true);  
		
		$res = $this->config_model->remove_user_id($user_id);
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
		$id = $post["user_id"];
		$last_email = $this->config_model->get_user_id($id);
	
		$this->form_validation->set_rules('jawwal', 'رقم الجوال', 'trim|edit_unique[users.jawwal.'. $id .']'); 
		$this->form_validation->set_rules('email', 'البريد الالكتروني', 'trim|required|valid_email|edit_unique[users.email.'. $id .']');

		if ($this->form_validation->run() == FALSE) {
			$res = validation_errors('<div class="text-danger">', '</div>');
			$status = "error";
			$link = "";
		} else {
			$config['upload_path']="./upload/users/";
			$config['allowed_types']='gif|jpg|png|svg';
			$config['encrypt_name']= true; 
			$this->load->library('upload',$config); 
			
			$user_pic = $post["last_user_pic"];
			
			if($_FILES['user_pic']['name'] != ''){
				if($this->upload->do_upload("user_pic")){
					$pic = array('upload_data' => $this->upload->data()); 
					$user_pic = $config['upload_path'].$pic['upload_data']['file_name']; 
				}
			}
			
			$res = $this->config_model->update_profile($post, $user_pic);
			if($res != false){
				$res = "تم تعديل حساب المستخدم بنجاح ";
				$status = "success";
				if($post['email'] != $last_email->email){
					$this->config_model->inactive_user($id);
					$token = $this->config_model->update_token($id);
					$this->session->set_userdata("user_token", $token);
					$this->session->set_userdata("user_email", $post['email']);
					$link = "welcome/logout";

					$config = Array(
						'protocol' => 'smtp',
						'smtp_host' => 'ssl://smtp.googlemail.com',
						//'smtp_port' => 587,
						'smtp_port' => 465,
						'smtp_user' => 'alaa.krunb@gmail.com', // change it to yours
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
					$this->session->set_userdata("user_pic", $user_pic);
					$this->session->set_userdata("user_jawwal", $post['jawwal']);
				}
			} else {
				$res = "حدث خطأ اثناء حفظ التغيرات ، يرجى المحاولة مرة اخرى";
				$status = "error";
				$link = "";
			}
		}
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	}
	
	/*
		currency
	*/
	
	public function add_currency(){
        $data["language"] = $this->config_model->get_language(); 
        $data["page"] = "config/currency/add";
        $this->load->view('include/temp',$data); 
	} 
	public function view_currency($currency_id = null){ 
		if($currency_id != null){
			$data["language"] = $this->config_model->get_language();
			$data["view"] = $this->config_model->get_currency_id($currency_id);
			$data["page"] = "config/currency/view";
			$this->load->view('include/temp',$data); 
		} else {
            redirect("congif/currency");
        }
	} 
	public function new_currency(){
		$post = $this->input->post(null, false);
        
		$res = $this->config_model->add_currency($post);
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
	
	public function update_currency(){ 
		$post = $this->input->post(null, false);
        
		$res = $this->config_model->update_currency($post);
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
	
	public function update_currency_status(){ 
		$currency_id = $this->input->post("currency_id", true); 
		$currency_active = $this->input->post("currency_active", true);
		
		$res = $this->config_model->update_currency_status($currency_active, $currency_id);
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
	
	public function remove_currency_id(){ 
		$currency_id = $this->input->post("currency_id", true);  
		
		$res = $this->config_model->remove_currency_id($currency_id);
		if($res != false){
			$res = " تم حذف العملة بنجاح.";
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



