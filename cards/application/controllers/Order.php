<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {
    
    public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('order_model');
		$this->load->model('customer_model');
		$this->load->model('card_model');
 
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
        $config["base_url"] 	= base_url() . "order/index";
        $config["total_rows"] 	= $this->order_model->get_count_order();
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
		$data["view"] = $this->order_model->get_all_order($config["per_page"], $page); 
		$data["customer"] 	= $this->customer_model->get_all_customer();
		$data["card"] 		= $this->card_model->get_all_card();
		$data["status"]		= $this->order_model->get_order_status();

		$data["page"] 		= "back/order/index";
		$this->load->view('include/temp',$data);
	}

	public function fillter_order(){
		$post = $this->input->post(null, TRUE);
		$data["view"] = $this->order_model->fillter_order($post);
		$data["page"] = "back/order/index";
		$this->load->view('include/temp',$data);
	}

	public function view_order($order_id){
		if($order_id != "" and $order_id > 0){
			$data["notifications"] = $this->order_model->get_order_notifications($order_id);
			$data["action"] = $this->order_model->get_order_action($order_id);
			$data["order_status"] = $this->order_model->get_order_status();
			$data["view"] = $this->order_model->get_order_id($order_id);
			$data["page"] = "back/order/view";
			$this->load->view('include/temp',$data);
		} else {
			$this->session->set_flashdata("error","توجيه خطأ ، الرجاء التاكد من الرابط المطلوب");
			redirect("order");
		}
	}

	public function get_order_filtter(){
		$post = $this->input->post(null, TRUE);
		if(!empty($post["order_status_id"])
			or !empty($post["customer_id"])
			or !empty($post["card_id"])
			or !empty($post["date_from"])
			or !empty($post["date_to"])){
			$data["view"] = $this->order_model->get_order_filtter($post);
			$this->load->view("back/order/fillter_tr", $data);
		} else {
			$this->session->set_flashdata("error", "الرجاء اختيار احد المعايير لاتمام طلب بحث ناجح");
			redirect("order");
		}
	}

	function order_change_status(){
		$post = $this->input->post(null, TRUE); 
		$res = $this->order_model->order_change_status($post);
		if($res != false){
			$res = "تم تغيير حالة الطلب بنجاح";
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