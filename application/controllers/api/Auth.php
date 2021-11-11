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
	
	// get info
	/*
	public function index_get($language){
		$res = $this->api_config_model->get_setting();

		echo "<pre>";
		print_r($res);
		die;

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
	*/
	
	function do_auth_post(){
		$email = $this->input->post("email", TRUE);
		$password = $this->input->post("password", TRUE);
		
		if($email != "" and $password != ""){
			$res = $this->api_auth_model->do_auth($email, $password);
			if($res != false){
				$this->response($res, 200);
			} else {
				$this->response([
					"status" => false,
					"message" => "البريد الالكتروني او كلمة المرور خاطئة"
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

		// $headers=array();
		// foreach (getallheaders() as $name => $value) {
		// 	$headers[$name] = $value;
		// }  

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