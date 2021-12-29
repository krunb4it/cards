<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends CI_Model {
 
    public function __construct() {
        parent::__construct();
    } 

	function get_count_customer(){
		return $this->db->count_all("customer");
	}
	 
	function get_customer($limit, $start) {
        return $this->db->limit($limit, $start)
		->join("customer_status","customer_status.customer_status_id = customer.customer_status_id", "left")
		->get("customer")->result();
	}  
	
	function get_all_customer() {
        return $this->db
		->join("customer_status","customer_status.customer_status_id = customer.customer_status_id", "left")
		->get("customer")->result();
	}
	function get_customer_id($customer_id){
		return $this->db->where("customer_id", $customer_id)->get("customer")->row();
	} 
	
	function add_customer($post, $customer_logo, $token){
		$arr = array(
			"customer_logo"			=> $customer_logo,
			"customer_name"			=> $post["customer_name"],
			"customer_email"		=> $post["customer_email"],
			"customer_jawwal"		=> $post["customer_jawwal"],
			"customer_password"		=> $this->bcrypt->hash_password($post["customer_password"]), 
			"customer_status_id"	=> 0,
			"customer_active"		=> 0,
			"customer_create_by"	=> $this->session->userdata("user_id"),
			"customer_token"		=> $token,
		); 
		$this->db->insert("customer", $arr);
		return $this->db->insert_id();
	}
	
	function update_customer($post, $customer_logo){
		$arr = array(
			"customer_logo"		=> $customer_logo,
			"customer_name"		=> $post["customer_name"],
			"customer_email"	=> $post["customer_email"],
			"customer_jawwal"	=> $post["customer_jawwal"]
		); 
		return $this->db->where("customer_id", $post["customer_id"])->update("customer", $arr);
	}

	function update_customer_status($customer_active, $customer_id){
		return $this->db->set("customer_active", $customer_active)->where("customer_id", $customer_id)->update("customer");
	}

	function remove_customer_id($customer_id){
		return $this->db->where("customer_id", $customer_id)->delete("customer");
	}

	function customerValidateAccount($customer_id, $customer_token){
		$is_validation = $this->db
				->where("customer_id", $customer_id)
				->where("customer_token", $customer_token)
				->get("customer")->row();
		if($is_validation == true){
			$row = $this->db
					->set("customer_active", 1)
					->set("customer_token", md5(time()))
					->where("customer_id", $customer_id)
					->update("customer"); 

			if($row != false){
				$this->get_customer_id($customer_id);
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
}