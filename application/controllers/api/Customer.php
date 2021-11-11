<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

use chriskacerguis\RestServer\RestController;

class Customer extends RestController{
	
    public function __construct(){
        parent::__construct();
		$this->load->model('api_customer_model');
		//$this->load->model('api_card_model');
    }
	 
	// get info
	public function index_get($language){
		$res = $this->api_config_model->get_setting();
 
		$all_data = []; 
		for ($i = 0; $i < count($res) ; $i++) {
			$response = $res[$i];
			$data = [
				'slider_id' 		=> $response->slider_id,
				'slider_cover' 		=> site_url().$response->slider_cover,
				'slider_title'		=> json_decode($response->slider_title)->$language,
				'slider_sub_title' 	=> json_decode($response->slider_sub_title)->$language,
				'slider_details' 	=> json_decode($response->slider_details)->$language,
				'slider_tags' 		=> json_decode($response->slider_tags)->$language,
				'slider_link' 		=> $response->slider_link,
				'slider_add_by'		=> $response->slider_add_by,
				'slider_add_at' 	=> $response->slider_add_at,
				'slider_update_by' 	=> $response->slider_update_by,
				'slider_update_at' 	=> $response->slider_update_at,
				'slider_order' 		=> $response->slider_order,
				'slider_active' 	=> $response->slider_active,
			];
			$all_data[] = $data;
		}
		$this->response( $all_data, 200); 
	}
	
	function my_order_get(){

	}

	function create_order_post(){ 
		// $customer_token = "7abbdf1dc93521801be40ca5f814bb99";
		$headers=array();
		foreach (getallheaders() as $name => $value) {
			$headers[$name] = $value;
		}
		// echo $headers["Authorization"];
		if($headers["Authorization"]){
			$auth = explode(" ", $headers["Authorization"]);
			if(count($auth)==2){
				$flag = $auth[0];
				$token = $auth[1];
			}
			
			$get_customer_info = $this->api_customer_model->get_customer_id($token);
			
			if($get_customer_info != false){

				if(		!empty( $this->input->post("card_id"))
					and !empty( $this->input->post("quantity"))
					and !empty( $this->input->post("price"))
					and !empty( $this->input->post("total"))){
					
					// get card info
					$get_card_info = $this->api_customer_model->get_card_info($this->input->post("card_id"));

					if($get_customer_info->customer_balance < $this->input->post("total")){
						$this->response([
							"status" => false,
							"message" => "رصيدك غير كافي ، الرجاء شحن رصيد لكي تتمكن من شراء المنتج"
						], RestController::HTTP_BAD_REQUEST);
					} elseif ($get_card_info->card_amount < $this->input->post("quantity")){
						$this->response([
							"status" => false,
							"message" => "الكمية المطلوبة غير متوفرة ، حاول تقليل الكمية او مراسة المدير"
						], RestController::HTTP_BAD_REQUEST);
					} else {
						$data = [
							"customer_id" 		=> $get_customer_info->customer_id,
							"card_id" 			=> $this->input->post("card_id", TRUE),
							"quantity" 			=> $this->input->post("quantity", TRUE),
							"price"				=> $this->input->post("price", TRUE),
							"total"				=> $this->input->post("total", TRUE),
							"note"				=> $this->input->post("note", TRUE),
							"card_amount"		=> $get_card_info->card_amount,				// كمية البطاقات
							"need_approval"		=> $get_card_info->need_approval,			// هل تحتاج الى موافقة
							"customer_balance"	=> $get_customer_info->customer_balance,	// رصيد المستخدم
						];
						$create_order = $this->api_customer_model->create_order($data);

						if($create_order != false){
							$this->response([
								"status" => true,
								"message" => "تم إنشاء الطلب بنجاح"
							], RestController::HTTP_OK);
						} else{
							$this->response([
								"status" => false,
								"message" => "Error when create order. Try Again"
							], RestController::HTTP_BAD_REQUEST);
						}
					}
				} else {
					$this->response([
						"status" => false,
						"message" => "No data to add the cart. Try again"
					], RestController::HTTP_BAD_REQUEST);
				}
			} else {
				$this->response([
					"status" => false,
					"message" => "No user."
				], RestController::HTTP_BAD_REQUEST);
			}
		} else {
			$this->response([
				"status" => false,
				"message" => "The token is not definde."
			], RestController::HTTP_BAD_REQUEST);
		}
	}
}