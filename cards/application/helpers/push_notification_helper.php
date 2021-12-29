<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
 
	function sendNotification($customer_id, $title, $body){


		$customer_token = get_fcm_token($customer_id);
	//	$SERVER_API_KEY = 'AAAAS_fUe4M:APA91bFPmqnHL_8pIjeisqkKt1TlU4RfJ0V32igctDispzng6OJ7x1rjR8Dg11SHOhODs3JSnOjJToNqM_UoiiKGrfutXvpx66TP71PJoLFBIOob5JBBGJQZ-lpuG7Gc1PNm0sKRjYLD';
		$SERVER_API_KEY = "AAAArpHgETI:APA91bEHZwiSqDW8pYu7jBcff4Xb9REK2_EOMZ4RpH01pMaNWCNdW-LFpwMdX1KlmLmd7AuD66Ka2EfX3qJsQgJBMBywEYkTcHSzRDcBEXMFJwzY7J-gX5aryZ7DcVTFX8ZuXiWi-Ro0";
        
		$array = [];
		for($i = 0 ; $i < count($customer_token) ; $i++){
			$array[$i] = $customer_token[$i]->token;
		} 
		$data = [
			"registration_ids" => $array,
            "notification" => [
                "title" => $title,
                "body" => $body,
				'icon'	=> site_url().'assets/images/extra_cards_icon.png',/*Default Icon*/
              	'sound' => 'mySound'/*Default sound*/
            ]
        ];
        $dataString = json_encode($data);
    
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        $response = curl_exec($ch);
		return $response;
/*
		echo "<per>";
        print_r($response);
		*/
        
    }
	
	
	function get_fcm_token($customer_id){ 
		$ci=& get_instance();
		$ci->load->database();
		
		return $ci->db->where("customer_id = $customer_id")->get("device")->result();
	} 
	
	if(!function_exists('SendEmail')){
		function SendEmail($options = array()){

			//get SMTP Details
			$CI =& get_instance();
			
			$config = Array(
				'protocol' => 'smtp',
				'smtp_host' => 'ssl://smtp.googlemail.com',
			//	'smtp_host' => 'ssl://ssmtp.googlemail.com',
				'smtp_port' => 465,
				'smtp_user' => 'alaa.krunb@gmail.com', // change it to yours
				'smtp_pass' => 'alaa@411918139', // change it to yours
				'mailtype' => 'html',
				'charset' => 'utf-8',
				'wordwrap' => TRUE
			); 
			
			$CI->load->library('email', $config);
			//$CI->email->initialize();
		#	$CI->email->set_header('Content-Type', 'text/html');
			$CI->email->set_newline("\r\n");
			$CI->email->set_mailtype("html");
			$CI->email->from("alaa.krunb@gmail.com", $options["subject"]);
			$CI->email->to($options["to"]);
			$CI->email->subject('ExtaCards | '.$options["subject"]);
			$CI->email->message($options["message"]); 
			
		    $e = $CI->email->send();
            $CI->email->clear(TRUE);
            return $e;
		}
	}
	
	if(!function_exists('get_new_order')){
    	function get_new_order(){
    	    $CI =& get_instance();
			$row = $CI->db->where("order_status_id = 1 or order_status_id = 2")->get("orders")->result();
			return $row;
    	} 
	}
	
	function sendAdminNotification($title, $body){
	    $CI =& get_instance();
		$admin_token = $CI->db->where("group_id = 1")->get("users")->result();
        $SERVER_API_KEY = "AAAArpHgETI:APA91bEHZwiSqDW8pYu7jBcff4Xb9REK2_EOMZ4RpH01pMaNWCNdW-LFpwMdX1KlmLmd7AuD66Ka2EfX3qJsQgJBMBywEYkTcHSzRDcBEXMFJwzY7J-gX5aryZ7DcVTFX8ZuXiWi-Ro0";
        
		$array = [];
		for($i = 0 ; $i < count($admin_token) ; $i++){
			$array[$i] = $admin_token[$i]->fmc_token;
		} 
		$data = [
			"registration_ids" => $array,
            "notification" => [
                "title" => $title,
                "body" => $body,
				'icon'	=> site_url().'assets/images/extra_cards_icon.png',/*Default Icon*/
              	'sound' => 'mySound'/*Default sound*/
            ]
        ];
        $dataString = json_encode($data);
    
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        $response = curl_exec($ch);
		return $response; 
        
    }