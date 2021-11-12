<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

use chriskacerguis\RestServer\RestController;

class Customer extends RestController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('api_customer_model');
		//$this->load->model('api_card_model');
	}

	// get info
	public function index_get($language){
		$res = $this->api_config_model->get_setting();

		$all_data = [];
		for ($i = 0; $i < count($res); $i++) {
			$response = $res[$i];
			$data = [
				'slider_id' 		=> $response->slider_id,
				'slider_cover' 		=> site_url() . $response->slider_cover,
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
		$this->response($all_data, 200);
	}

	function my_order_get($language){
		// $customer_token = "7abbdf1dc93521801be40ca5f814bb99";
		$headers = array();
		foreach (getallheaders() as $name => $value) {
			$headers[$name] = $value;
		}
		if (isset($headers["Authorization"])){
			$auth = explode(" ", $headers["Authorization"]);
			if (count($auth) == 2) {
				$flag = $auth[0];
				$token = $auth[1];
			}

			$get_customer_info = $this->api_customer_model->get_customer_id($token);

			if ($get_customer_info != false) {
				//$res = $this->api_customer_model->get_my_order($get_customer_info->customer_id, $limit, $offset);
				$res = $this->api_customer_model->get_my_order($get_customer_info->customer_id);
			
				$all_data = [];
				for ($i = 0; $i < count($res); $i++) {
					$response = $res[$i];
					$data = [
						'order_id' 				=> $response->order_id,
						'order_create_at' 		=> $response->order_create_at,
						'order_status_id'		=> $response->order_status_id,
						'order_status_name' 	=> $response->order_status_name,
						'customer_id' 			=> $response->customer_id,
						'card_id' 				=> $response->card_id,
						'card_pic' 				=> site_url().$response->card_pic,
						'card_name'				=> json_decode($response->card_name)->$language,
						'card_note' 			=> json_decode($response->card_note)->$language,
						'quantity'				=> $response->quantity,
						'price' 				=> $response->price,
						'total' 				=> $response->total,
						'note' 					=> $response->note,
					];
					$all_data[] = $data;
				}
				$this->response($all_data, 200);
			} else {
				$this->response([
					"status" => false,
					"message" => "The token is not definde."
				], RestController::HTTP_BAD_REQUEST);
			}
		} else {
			$this->response([
				"status" => false,
				"message" => "The token is required."
			], RestController::HTTP_BAD_REQUEST);
		}
	}

	function my_order_card_get($order_id){
		// $customer_token = "7abbdf1dc93521801be40ca5f814bb99";
		$headers = array();
		foreach (getallheaders() as $name => $value) {
			$headers[$name] = $value;
		}
		if (isset($headers["Authorization"])){
			$auth = explode(" ", $headers["Authorization"]);
			if (count($auth) == 2) {
				$flag = $auth[0];
				$token = $auth[1];
			}

			$get_customer_info = $this->api_customer_model->get_customer_id($token);

			if ($get_customer_info != false) {
				//$res = $this->api_customer_model->get_my_order($get_customer_info->customer_id, $limit, $offset);
				$res = $this->api_customer_model->get_my_order_card($get_customer_info->customer_id, $order_id);

				$all_data = [];
				for ($i = 0; $i < count($res); $i++) {
					$response = $res[$i];
					$data = [
						'order_id'				=> $order_id,
						'order_item_id'			=> $response->order_item_id,
						'card_item_id'			=> $response->card_item_id,
						'card_item_code'		=> $response->card_item_code,
						'card_item_reference'	=> $response->card_item_reference,
						'card_item_serial'		=> $response->card_item_serial,
						'card_item_end'			=> $response->card_item_end,
						'order_item_print'		=> $response->order_item_print,
						'order_item_print_at'	=> $response->order_item_print_at,
					];
					$all_data[] = $data;
				}
				$this->response($all_data, 200);
			} else {
				$this->response([
					"status" => false,
					"message" => "The token is not definde."
				], RestController::HTTP_BAD_REQUEST);
			}
		} else {
			$this->response([
				"status" => false,
				"message" => "The token is required."
			], RestController::HTTP_BAD_REQUEST);
		}
	}

	function create_order_post(){
		// $customer_token = "7abbdf1dc93521801be40ca5f814bb99";
		$headers = array();
		foreach (getallheaders() as $name => $value) {
			$headers[$name] = $value;
		}
		// echo $headers["Authorization"];
		if (isset($headers["Authorization"])){
			$auth = explode(" ", $headers["Authorization"]);
			if (count($auth) == 2) {
				$flag = $auth[0];
				$token = $auth[1];
			}

			$get_customer_info = $this->api_customer_model->get_customer_id($token);

			if ($get_customer_info != false) {

				if (
					!empty($this->input->post("card_id"))
					and !empty($this->input->post("quantity"))
					and !empty($this->input->post("price"))
					and !empty($this->input->post("total"))
				) {

					// get card info
					$get_card_info = $this->api_customer_model->get_card_info($this->input->post("card_id"));

					if ($get_customer_info->customer_balance < $this->input->post("total")) {
						$this->response([
							"status" => false,
							"message" => "رصيدك غير كافي ، الرجاء شحن رصيد لكي تتمكن من شراء المنتج"
						], RestController::HTTP_BAD_REQUEST);
					} elseif ($get_card_info->card_amount < $this->input->post("quantity")) {
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

						if ($create_order != false) {
							$this->response([
								"status" => true,
								"message" => "تم إنشاء الطلب بنجاح"
							], RestController::HTTP_OK);
						} else {
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

	
	function my_wallet_get(){
		// $customer_token = "7abbdf1dc93521801be40ca5f814bb99";
		$headers = array();
		foreach (getallheaders() as $name => $value) {
			$headers[$name] = $value;
		}

		if (isset($headers["Authorization"])){
			$auth = explode(" ", $headers["Authorization"]);
			if (count($auth) == 2) {
				$flag = $auth[0];
				$token = $auth[1];
			}

			$get_customer_info = $this->api_customer_model->get_customer_id($token);

			if ($get_customer_info != false){
				$res = $this->api_customer_model->get_my_wallet($get_customer_info->customer_id);
				
				$all_data = [];
				for ($i = 0; $i < count($res); $i++) {
					$response = $res[$i];
					if( $response->customer_wallet_type_id == 1 ){
						$type_name = "شحن";
					} else {
						$type_name = "شراء";
					}
					$data = [
						'type_name'			=> $type_name,
						'type_id'			=> $response->customer_wallet_type_id,
						'old_balance'		=> $response->customer_wallet_old_balance,
						'new_balance'		=> $response->customer_wallet_new_balance,
						'total_balance'		=> $response->customer_wallet_total_balance,
						'create_at'			=> $response->customer_wallet_create_at,
						'order_id'			=> $response->order_id
					];
					$all_data[] = $data;
				}
				$this->response($all_data, 200);
			} else {
				$this->response([
					"status" => false,
					"message" => "The token is not definde."
				], RestController::HTTP_BAD_REQUEST);
			}
		} else {
			$this->response([
				"status" => false,
				"message" => "The token is required."
			], RestController::HTTP_BAD_REQUEST);
		}
	}
	
	function my_notifications_get(){
		// $customer_token = "7abbdf1dc93521801be40ca5f814bb99";
		$headers = array();
		foreach (getallheaders() as $name => $value) {
			$headers[$name] = $value;
		}

		if (isset($headers["Authorization"])){
			$auth = explode(" ", $headers["Authorization"]);
			if (count($auth) == 2) {
				$flag = $auth[0];
				$token = $auth[1];
			}

			$get_customer_info = $this->api_customer_model->get_customer_id($token);

			if ($get_customer_info != false){
				$res = $this->api_customer_model->get_my_notifications($get_customer_info->customer_id);

				$all_data = [];
				for ($i = 0; $i < count($res); $i++) {
					$response = $res[$i];
					 
					$data = [
						'notification_id'			=> $response->notification_id, 
						'order_id'					=> $response->order_id,
						'notification_title'		=> $response->notification_title,
						'notification_details'		=> $response->notification_details,
						'notification_create_at'	=> $response->notification_create_at,
						'notification_seen'			=> $response->notification_seen,
					];
					$all_data[] = $data;
				}
				$this->response($all_data, 200);
			} else {
				$this->response([
					"status" => false,
					"message" => "The token is not definde."
				], RestController::HTTP_BAD_REQUEST);
			}
		} else {
			$this->response([
				"status" => false,
				"message" => "The token is required."
			], RestController::HTTP_BAD_REQUEST);
		}
	}
}
