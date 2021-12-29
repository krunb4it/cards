<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

use chriskacerguis\RestServer\RestController;

class Auth extends RestController{
	
    public function __construct(){
        parent::__construct();
        $this->load->model('api_auth_model');
    }
	
	function do_auth_post(){
		$email = $this->input->post("email", TRUE);
		$password = $this->input->post("password", TRUE);
		$fcm_token = $this->input->post("fcm_token", TRUE);
		
		if($email != "" and $password != "" and $fcm_token != ""){
			$row = $this->db->where("customer_email", $email)->get("customer")->result();
			if(!empty($row)){
				if ($this->bcrypt->check_password($password, $row[0]->customer_password)){
					if($row[0]->customer_active == 1){
						$token = $this->bcrypt->hash_password(time());
						$this->db->where("customer_email", $email)->set("customer_token", $token)->update("customer");
						
						if($fcm_token != ""){
							$customer_id = $row[0]->customer_id;
							$this->api_auth_model->is_token_device($customer_id, $fcm_token);
						}
						
						$all_data = []; 
						for ($i = 0; $i < count($row) ; $i++) {
							$response = $row[$i];
							if (! file_exists($response->customer_logo)) { 
                                    site_url()."assets/images/user.png";
                                } else {
                                    $img = site_url().$response->customer_logo;
                                }
							$data = [
								'customer_id' 		=> $response->customer_id,
								'customer_logo'		=> $img,
								'customer_name'		=> $response->customer_name,
								'customer_email'	=> $response->customer_email,
								'customer_jawwal' 	=> $response->customer_jawwal,
								'customer_balance' 	=> $response->customer_balance,
								'customer_token' 	=> $token,
							];
							$all_data[] = $data;
						}
						
						$this->response($all_data, 200);
						
						
					} else {
						$this->response([
							"status" => false,
							"message" => "هذاالحساب محظور ، يرجى مراسلة الادارة لمعرفة السبب ."
						], RestController::HTTP_BAD_REQUEST);
					}
				} else { 
					$this->response([
						"status" => false,
						"message" => "خطأ في اسم المستخدم أو كلمة المرور"
					], RestController::HTTP_BAD_REQUEST); 
				} 
			} else {
				$this->response([
					"status" => false,
					"message" => "خطأ في اسم المستخدم أو كلمة المرور"
				], RestController::HTTP_BAD_REQUEST); 
			}
		} else {
			$this->response([
				"status" => false,
				"message" => "الرجاء ادخال البريد الالكتروني وكلمة المرور !"
			], RestController::HTTP_BAD_REQUEST);
		}
	}

	// send code to email to chagne password
	function forget_password_post(){
		$email = $this->input->post("email", TRUE);
		$pin_code = $this->generatePIN(6);
		
		if($email != ""){
			$res = $this->api_auth_model->forget_password($email, $pin_code);
			if($res != false){
				$this->response([
					"status" => true,
					"message" => "الرجاء ادخال الكود المرسل الى بريدك الالكتروني"
				], RestController::HTTP_OK);
			} else {
				$this->response([
					"status" => false,
					"message" => "البريد الالكتروني او كلمة المرور خاطئة"
				], RestController::HTTP_BAD_REQUEST);
			}
		} else {
			$this->response([
				"status" => false,
				"message" => "الرجاء كتابة البريد الالكتروني."
			], RestController::HTTP_BAD_REQUEST);
		}
	}

	// change password
	function change_password_post(){
		$email = $this->input->post("email", TRUE); 
		$password = $this->input->post("password", TRUE);
		
		if($email != "" and $password != ""){
			$res = $this->api_auth_model->change_password($email, $password);
			if($res != false){
				$this->response([
					"status" => true,
					"message" => "تم تغيير كلمة المرور بنجاح"
				], RestController::HTTP_OK);
			} else {
				$this->response([
					"status" => false,
					"message" => "هناك خطأ ما ، حاول مرة اخرى"
				], RestController::HTTP_BAD_REQUEST);
			}
		} else {
			$this->response([
				"status" => false,
				"message" => "الرجاء ادخال كلمة المرور"
			], RestController::HTTP_BAD_REQUEST);
		}
	}

	function generatePIN($digits = 4){
		$i = 0; //counter
		$pin = ""; //our default pin is blank.
		while($i < $digits){
			//generate a random number between 0 and 9.
			$pin .= mt_rand(0, 9);
			$i++;
		}
		return $pin;
	}
	
	function my_profile_get(){
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

			$row = $this->api_auth_model->get_my_profile($token);
			if ($row != false) {
				$all_data = []; 
				for ($i = 0; $i < count($row) ; $i++) {
					$response = $row[$i];
					$data = [
						'customer_id' 		=> $response->customer_id,
						'customer_logo'		=> site_url().$response->customer_logo,
						'customer_name'		=> $response->customer_name,
						'customer_email'	=> $response->customer_email,
						'customer_jawwal' 	=> $response->customer_jawwal,
						'customer_balance' 	=> $response->customer_balance,
						'customer_token' 	=> $token,
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
	
	
	/*
	function save_token_post(){
		$token 			= $this->input->post("token", TRUE); 
		$customer_id 	= $this->input->post("customer_id", TRUE);
		
		if($token != "" and $customer_id != ""){
			$res = $this->api_auth_model->save_token_post($token, $customer_id);
			if($res != false){
				$this->response([
					"status" => true,
					"message" => "تم حفظ التوكن الجديد بنجاح"
				], RestController::HTTP_OK);
			} else {
				$this->response([
					"status" => false,
					"message" => "هناك خطأ ما ، حاول مرة اخرى"
				], RestController::HTTP_BAD_REQUEST);
			}
		} else {
			$this->response([
				"status" => false,
				"message" => "الرجاء ادخال البيانات المطلوبة"
			], RestController::HTTP_BAD_REQUEST);
		}
	}
	*/
}


/*
	 curl_setopt_array($curl, array(
            CURLOPT_URL => "http://krunb4it.com/cards/api/slider/0",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        ));

        $response = curl_exec($curl);
        $response_data = json_decode($response);
        $language = $request->get('language');
        $all_data = [];
        $count = count($response_data);

        for ($i = 0; $i < $count; $i++) {

            $response = $response_data[$i];

            $data = [
                'slider_id' => $response->slider_id,
                'slider_cover' => $response->slider_cover,
                'slider_title' => json_decode($response->slider_title)->$language,
                'slider_sub_title' => json_decode($response->slider_sub_title)->$language,
                'slider_details' => json_decode($response->slider_details)->$language,
                'slider_tags' => json_decode($response->slider_tags)->$language,
                'slider_link' => $response->slider_link,
                'slider_add_by' => $response->slider_add_by,
                'slider_add_at' => $response->slider_add_at,
                'slider_update_by' => $response->slider_update_by,
                'slider_update_at' => $response->slider_update_at,
                'slider_order' => $response->slider_order,
                'slider_active' => $response->slider_active,
            ];

            $all_data[] = $data;
        }
		
        return json_encode($all_data); 
 
*/