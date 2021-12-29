<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {
 
    public function __construct() {
        parent::__construct();
    }

	function get_count_order(){
		return $this->db->count_all("orders");
	}

	function get_order_status(){
		return $this->db->get("order_status")->result();
	}

	function get_all_order($limit, $start) {
        return $this->db->limit($limit, $start)
		->order_by("orders.order_create_at", "DESC")
		->join("customer","customer.customer_id = orders.customer_id","left")
		->join("card","card.card_id = orders.card_id","left")
		->join("order_status","order_status.order_status_id = orders.order_status_id","left")
		->get("orders")->result();
	}

	function get_order_id($order_id){
		return $this->db 
		->where("orders.order_id", $order_id)
		->join("customer","customer.customer_id = orders.customer_id","left")
		->join("card","card.card_id = orders.card_id","left")
		->join("order_status","order_status.order_status_id = orders.order_status_id","left")
		->get("orders")->row();
	}

	function get_order_filtter($data){
		
		if(!empty($data["order_status_id"])){
			$this->db->where("orders.order_status_id", $data["order_status_id"]);
		}
		if(!empty($data["customer_id"])){
			$this->db->where("orders.customer_id", $data["customer_id"]);
		}
		if(!empty($data["card_id"])){
			$this->db->where("orders.card_id", $data["card_id"]);
		}
		if(!empty($data["date_from"]) and !empty($data["date_to"])){
			$this->db->where("DATE(orders.order_create_at) >= ", $data["date_from"]);
			$this->db->where("DATE(orders.order_create_at) <= ", $data["date_to"]);
		}

		$this->db->join("customer","customer.customer_id = orders.customer_id","left");
		$this->db->join("card","card.card_id = orders.card_id","left");
		$this->db->join("order_status","order_status.order_status_id = orders.order_status_id","left");
		return $this->db->get("orders")->result();
	}

	function order_change_status($post){
		$arr = array(
			"order_id"			=> $post["order_id"],
			"order_status_id"	=> $post["order_status_id"],
			"order_action_note"	=> $post["order_action_note"],
			"order_action_by"	=> $this->session->userdata("user_id"),
		);
		$status_name = $this->db->get_where("order_status", "order_status_id = ". $post["order_status_id"] ."")->row();
		
		$arr2 = [
			"order_id"					=> $post["order_id"],
			"customer_id"				=> $post["customer_id"],
			"notification_title"		=> "حالة الطلب",
			"notification_details"		=> "تم تحويل حالة الطلب الى ". $status_name->order_status_name,
			"notification_create_by"	=> $this->session->userdata("user_id"),
		];
		$this->db->insert("notifications", $arr2);
		
		$customer_id = $post["customer_id"];
		$title = "حالة الطلب (". $post["order_id"] .")";
		$body = "تم تحويل حالة الطلب الى ". $status_name->order_status_name;
		sendNotification($customer_id, $title, $body); 
		
		
		if($post["order_status_id"] == 3){ 
		    /*
		    $real_amout = $post["card_amount"] - $post["quantity"];
    		$this->db->set("card_amount", $real_amout)->where("card_id", $post["card_id"])->update("card"); 
    		*/
    		$new_balance = $post["customer_balance"] - $post["total"];
			$this->db->set("customer_balance", $new_balance)->where("customer_id", $post["customer_id"])->update("customer");
			
			$arr3 = [
					"customer_id"					=> 	$post["customer_id"],
					"customer_wallet_type_id"		=> 	2,
					"customer_wallet_old_balance"	=>	$post["customer_balance"],
					"customer_wallet_new_balance"	=>	$post["total"],
					"customer_wallet_total_balance"	=>	$new_balance,
					"order_id"						=>	$post["order_id"],
				];
			$this->db->insert("customer_wallet", $arr3); 
		}
		
		$this->db->insert("order_action", $arr);
		return $this->db->set("order_status_id", $post["order_status_id"])->where("order_id", $post["order_id"])->update("orders");
		
	}

	
	function get_order_notifications($order_id){ 
		return $this->db
		->join("users", "users.user_id = notifications.notification_create_by", "left")
		->where("order_id", $order_id)->get("notifications")->result();
	}
	function get_order_action($order_id){ 
		return $this->db
		->join("order_status", "order_status.order_status_id = order_action.order_status_id", "left")
		->join("users", "users.user_id = order_action.order_action_by", "left")
		->where("order_id", $order_id)->get("order_action")->result();
	}
}