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
		$data["customer"] 	= $this->customer_model->get_all_customer();
		$data["card"] 		= $this->card_model->get_all_card();
		$data["status"]		= $this->order_model->get_order_status();
		$data["view"] 		= $this->order_model->get_all_order();
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
}