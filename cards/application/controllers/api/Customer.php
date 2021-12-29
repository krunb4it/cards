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
	}
	
	function my_order_get($offset,$language){
		// $customer_token = "7abbdf1dc93521801be40ca5f814bb99";
      
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
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
				
				$total_row = $this->api_customer_model->get_all_order($get_customer_info->customer_id);
				$res = $this->api_customer_model->get_my_order($get_customer_info->customer_id, $offset);
			
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
				
				$this->response([
					"total_row" => $total_row,
					"total_page" => ceil( $total_row / 20 ),
					"data" => $all_data
				], 200);
				
				//$this->response($all_data, 200);
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

	function my_order_id_get($order_id, $language){
		// $customer_token = "7abbdf1dc93521801be40ca5f814bb99";
		
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        } 
        
		if (isset($headers["Authorization"])){
			$auth = explode(" ", $headers["Authorization"]);
			if (count($auth) == 2) {
				$flag = $auth[0];
				$token = $auth[1];
			}

			$get_customer_info = $this->api_customer_model->get_customer_id($token);

			if ($get_customer_info != false) {
				$res = $this->api_customer_model->get_my_order_id($get_customer_info->customer_id, $order_id);
			
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
						"need_approval"         => $response->need_approval
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
		
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
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
	
	function print_order_card_post(){
		// $customer_token = "7abbdf1dc93521801be40ca5f814bb99"; 
		
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        } 
        
		if (isset($headers["Authorization"])){
			$auth = explode(" ", $headers["Authorization"]);
			if (count($auth) == 2) {
				$flag = $auth[0];
				$token = $auth[1];
			}

			$get_customer_info = $this->api_customer_model->get_customer_id($token);

			if ($get_customer_info != false) {
				$order_item_id = $this->input->post("order_item_id", TRUE);
				$res = $this->api_customer_model->print_order_item_id($order_item_id);
				if($res != false){
					$this->response([
						"status" => TRUE,
						"message" => "تم تحديث حالة البطاقة"
					], RestController::HTTP_OK);
				} else {
					$this->response([
						"status" => FALSE,
						"message" => "حدث خطأ ما ، يرجى المحاولة مرة اخرى"
					], RestController::HTTP_BAD_REQUEST);
				}
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
		
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
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
					} elseif (($get_card_info->card_amount < $this->input->post("quantity")) and ( $get_card_info->need_approval == 0)) {
						$this->response([
							"status" => false,
							"message" => "الكمية المطلوبة غير متوفرة ، حاول تقليل الكمية او مرسلة المدير"
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
						     
							$title = "طلب جديد";
		                    $body = "هناك طلب جديد ، يرجى متابعته";
							sendAdminNotification($title, $body);
							
							$order_status_id = $this->api_customer_model->order_status_id($create_order);
							$status_id = $order_status_id->order_status_id;
							$status_name = $order_status_id->order_status_name;
							 
							$this->response([ 
								"order_id"          => $create_order,
								"order_status_id"   => (int) $status_id,
								"order_status_name" => $status_name,
								"status"            => true,
								"message"           => "تم إنشاء الطلب بنجاح"
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

	function my_wallet_get($offset){
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
		if (isset($headers["Authorization"])){
			$auth = explode(" ", $headers["Authorization"]);
			if (count($auth) == 2) {
				$flag = $auth[0];
				$token = $auth[1];
			}

			$get_customer_info = $this->api_customer_model->get_customer_id($token);

			if ($get_customer_info != false){
				
				$total_row = $this->api_customer_model->get_all_wallet($get_customer_info->customer_id); 
				$res = $this->api_customer_model->get_my_wallet($get_customer_info->customer_id , $offset);
				
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
				
				$this->response([
					"total_row" => $total_row,
					"total_page" => ceil( $total_row / 20 ),
					"data" => $all_data
				], 200);
				//$this->response(, $all_data);
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
	
	function my_notifications_get($offset){
		// $customer_token = "7abbdf1dc93521801be40ca5f814bb99";
	
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        } 

		if (isset($headers["Authorization"])){
			$auth = explode(" ", $headers["Authorization"]);
			if (count($auth) == 2) {
				$flag = $auth[0];
				$token = $auth[1];
			}

			$get_customer_info = $this->api_customer_model->get_customer_id($token);

			if ($get_customer_info != false){
			    
				$not_seen = $this->api_customer_model->get_not_seen($get_customer_info->customer_id);
				$total_row = $this->api_customer_model->get_all_notifications($get_customer_info->customer_id);
				$res = $this->api_customer_model->get_my_notifications($get_customer_info->customer_id, $offset);

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
				
				$this->response([
					"count_not_seen" => (int)$not_seen,
					"total_row" => $total_row,
					"total_page" => ceil( $total_row / 20 ),
					"data" => $all_data
				], 200);
				//$this->response($all_data, 200);
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


	function set_seen_notifications_post(){
		$headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
	
		if (isset($headers["Authorization"])){
			$auth = explode(" ", $headers["Authorization"]);
			if (count($auth) == 2) {
				$flag = $auth[0];
				$token = $auth[1];
			}

			$get_customer_info = $this->api_customer_model->get_customer_id($token);

			if ($get_customer_info != false) {
				
				$notification_id = $this->input->post("notification_id", true);
				$order_id = $this->input->post("order_id", true); 
				$row = $this->api_customer_model->set_seen_notifications($get_customer_info->customer_id, $order_id, $notification_id);
				
				if($row == true){
					$this->response([
						"status" => true,
						"message" => "تم تغيير حالة الاشعار الى مشاهدة"
					], RestController::HTTP_OK);
				} else {
					$this->response([
						"status" => false,
						"message" => "Error Try Again."
					], RestController::HTTP_BAD_REQUEST);
				}
				  
				//$this->response($all_data, 200);
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

	/*
		fillter
	*/

	function fillter_my_order_post(){

        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
	
		if (isset($headers["Authorization"])){
			$auth = explode(" ", $headers["Authorization"]);
			if (count($auth) == 2) {
				$flag = $auth[0];
				$token = $auth[1];
			}

			$get_customer_info = $this->api_customer_model->get_customer_id($token);

			if ($get_customer_info != false) {
				
				$language			= $this->input->post("language");
				$order_status_id	= $this->input->post("order_status_id");
				$card_id			= $this->input->post("card_id");
				$start_date			= $this->input->post("start_date");
				$end_date			= $this->input->post("end_date");

				if(!empty($order_status_id) or !empty($card_id) or (!empty($start_date) and !empty($end_date))){
					$res = $this->api_customer_model->fillter_my_order($get_customer_info->customer_id, $order_status_id, $card_id, $start_date, $end_date);
					
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
						"message" => "الرجاء ادخال احد معايير البحث"
					], RestController::HTTP_BAD_REQUEST);
				}  
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

	function fillter_my_wallet_post(){
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
		if (isset($headers["Authorization"])){
			$auth = explode(" ", $headers["Authorization"]);
			if (count($auth) == 2) {
				$flag = $auth[0];
				$token = $auth[1];
			}

			$get_customer_info = $this->api_customer_model->get_customer_id($token);

			if ($get_customer_info != false){ 
				
				$type_id			= $this->input->post("type_id");
				$start_date			= $this->input->post("start_date");
				$end_date			= $this->input->post("end_date"); 
				 
				if(!empty($type_id) or (!empty($start_date) and !empty($end_date))){
					$res = $this->api_customer_model->fillter_my_wallet($get_customer_info->customer_id, $type_id, $start_date, $end_date);
					
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
						"message" => "الرجاء ادخال احد معايير البحث"
					], RestController::HTTP_BAD_REQUEST);
				} 
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
	
	/*
	print_order_all_card

	*/
	function print_order_all_card_post(){
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        
		if (isset($headers["Authorization"])){
			$auth = explode(" ", $headers["Authorization"]);
			if (count($auth) == 2) {
				$flag = $auth[0];
				$token = $auth[1];
			}

			$get_customer_info = $this->api_customer_model->get_customer_id($token);

			if ($get_customer_info != false) {
				$order_id = $this->input->post("order_id", TRUE);
				$res = $this->api_customer_model->print_order_all_card($order_id);
				if($res != false){
					$this->response([
						"status" => TRUE,
						"message" => "تم تحديث حالة البطاقة"
					], RestController::HTTP_OK);
				} else {
					$this->response([
						"status" => FALSE,
						"message" => "حدث خطأ ما ، يرجى المحاولة مرة اخرى"
					], RestController::HTTP_BAD_REQUEST);
				}
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
