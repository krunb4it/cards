<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wallet extends CI_Controller {
    
    public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('wallet_model');
		$this->load->model('customer_model');
		$this->load->model('config_model');
 
		if($this->session->userdata("my_token") != $this->security->get_csrf_hash()){
			redirect("welcome/login");
		}
		/*
		$permission = $this->welcome_model->have_permission();
		( $permission == 0) ? redirect("welcome/no_auth") : "";
		*/
	}
	
	public function index(){
		$data["view"] = $this->wallet_model->get_all_wallet();
		$data["customer"] 	= $this->customer_model->get_all_customer();
		$data["page"] = "back/wallet/index";
		$this->load->view('include/temp',$data); 
	} 
	
	public function charge_wallet(){
		$data["payment_way"] = $this->config_model->get_payment_way();
		$data["customer"] 	= $this->customer_model->get_all_customer();
		$data["page"] = "back/wallet/charge_wallet";
		$this->load->view('include/temp',$data); 
	}

	public function customer_wallet(){
		$customer_id = $this->input->post("customer_id", true);
		if($customer_id != "" and $customer_id > 0){
			$data["view"] = $this->wallet_model->customer_wallet($customer_id); 
			$this->load->view("back/wallet/customer_wallet", $data); 
		} else {
			$this->session->set_flashdata("error", " توجيه خاطئ الرجاء التاكد من الرابط المطلوب");
			redirect("wallet");
		}
	}

	public function do_charge_wallet(){
		$post = $this->input->post(null, true);
		
		$old_balance = $this->customer_model->get_customer_id($post["customer_id"]);
		$config['upload_path']="./upload/bank_receipt/";
		$config['allowed_types']='gif|jpg|png|svg';
		$config['encrypt_name']= true; 
		$this->load->library('upload',$config);
		
		$bank_receipt = "";
		
		if($_FILES['bank_receipt']['name'] != ''){
			if($this->upload->do_upload("bank_receipt")){
				$pic = array('upload_data' => $this->upload->data()); 
				$bank_receipt = $config['upload_path'].$pic['upload_data']['file_name']; 
			}
		}
		
		$wallet_id = $this->wallet_model->do_charge_wallet($post, $bank_receipt, $old_balance->customer_balance);
		
		if($wallet_id != false){
			$res = "تم شحن المحفظة بنجاح";
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



