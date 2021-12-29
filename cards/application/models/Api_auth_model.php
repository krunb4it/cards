<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_auth_model extends CI_Model {
 
    public function __construct() {
        parent::__construct();
    }
	
	function do_auth($email, $password){
		$res = $this->db
        ->where("customer_email", $email)
        ->where("customer_password", md5($password))
        ->get("customer")->row();

        if(!empty($res)){
            $token = md5($res->customer_id * time());
            $update_token = $this->db
                    ->set("customer_token", $token)
                    ->where("customer_id", $res->customer_id)
                    ->update("customer");
            if($update_token != false){
                return $token;
            } else {
                return false;
            }
        } else {
            return false;
        }
	}

	function forget_password($email, $pin_code){
		return $this->db
        ->set("customer_pin_code", $pin_code)
        ->where("customer_email", $email)
        ->update("customer");
	}

	function change_password($email, $password){
		return $this->db
        ->set("customer_password", $this->bcrypt->hash_password($password))
        ->where("customer_email", $email)
        ->update("customer");
	}
	
	function get_my_profile($token){
		return $this->db->where("customer_token", $token)->get("customer")->result();
	}
	
	
	function is_token_device($customer_id, $fcm_token){
		
		$is_token = $this->db
				->where("customer_id", $customer_id)
				->where("token", $fcm_token)
				->get("device")->result(); 
				
		 
		if(empty($is_token)){
			$arr = array(
				"customer_id" => $customer_id,
				"token" => $fcm_token,
			);
			return $this->db->insert("device", $arr);
		} 
	}
}