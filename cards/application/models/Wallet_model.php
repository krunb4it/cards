<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wallet_model extends CI_Model {
 
    public function __construct() {
        parent::__construct();
    }
	
	function get_count(){
		return $this->db->count_all("customer_wallet");
	}
	
	function get_all_wallet($limit, $start) {
        return $this->db->limit($limit, $start) 
		->order_by("cw.customer_wallet_create_at","desc")
		->join("users u","u.user_id = cw.customer_wallet_create_by" ,"left")
		->join("payment_way p","p.payment_way_id = cw.payment_way_id" ,"left")
		->join("customer c","c.customer_id = cw.customer_id" ,"left")
		->get("customer_wallet cw")->result();
	}
	function customer_wallet($customer_id){
		return $this->db
		->where("cw.customer_id", $customer_id)
		->order_by("cw.customer_wallet_create_at","desc")
		->join("users u","u.user_id = cw.customer_wallet_create_by" ,"left")
		->join("payment_way p","p.payment_way_id = cw.payment_way_id" ,"left")
		->join("customer c","c.customer_id = cw.customer_id" ,"left")
		->get("customer_wallet cw")->result();
	}
	
	function do_charge_wallet($post, $bank_receipt, $old_balance){
		$new_balanc = $old_balance + $post["customer_wallet_new_balance"];
		$arr = array(
			"bank_receipt"					=> $bank_receipt,
			"customer_id"					=> $post["customer_id"],
			"payment_way_id"				=> $post["payment_way_id"],
			"customer_wallet_type_id"		=> $post["customer_wallet_type_id"],
			"customer_wallet_old_balance"	=> $old_balance,
			"customer_wallet_new_balance"	=> $post["customer_wallet_new_balance"],
			"customer_wallet_total_balance"	=> $new_balanc,
			"customer_wallet_create_by"		=> $this->session->userdata("user_id"),
		);
		$res = $this->db->insert("customer_wallet", $arr);
		
		$arr2 = [
			"order_id"					=> 0,
			"customer_id"				=> $post["customer_id"],
			"notification_title"		=> "شحن محفظة",
			"notification_details"		=> "تم شحن المحفظة بمبلغ قيمته ". $post["customer_wallet_new_balance"]." دينار اردني",
			"notification_create_by"	=> $this->session->userdata("user_id"),
		];
		$this->db->insert("notifications", $arr2);

		
		$customer_id = $post["customer_id"];
		$title = "شحن رصيد";
		$body = "تم شحن المحفظة بمبلغ قيمته ". $post["customer_wallet_new_balance"] ." دينار اردني";
		sendNotification($customer_id, $title, $body);
		
		if($res != false){
			return $this->db
			->set("customer_balance", $new_balanc)
			->where("customer_id", $post["customer_id"])
			->update("customer"); 
		} else {
			return false;
		}
	}
 
}


