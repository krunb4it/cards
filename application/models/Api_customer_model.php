<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_customer_model extends CI_Model {
 
    public function __construct() {
        parent::__construct();
    }
	
	function get_card_info($card_id){
		$res = $this->db->where("card_id", $card_id)->get("card")->row();
		if(!empty($res)){
			return $res;
		} else {
			return false;
		}
	}

	function get_customer_id($token){
		$res = $this->db->where("customer_token", $token)->get("customer")->row();
		if(!empty($res)){
			return $res;
		} else {
			return false;
		}
	}

	function create_order($data){
		$customer_id 	= $data["customer_id"];
		$card_id 		= $data["card_id"];
		$need_approval	= $data["need_approval"];
		$customer_balance	= $data["customer_balance"];

		$arr = [
			"customer_id" 	=> $data["customer_id"],
			"card_id" 		=> $data["card_id"],
			"quantity" 		=> $data["quantity"],
			"price" 		=> $data["price"],
			"total" 		=> $data["total"],
			"note" 			=> $data["note"],
		];
		
		$this->db->insert("orders", $arr);
		$order_id = $this->db->insert_id();

		if($order_id != false){
			if($need_approval == 0){

				$card_item = $this->db
					->limit($data["quantity"])
					->where("card_id", $data["card_id"])
					->where("card_item_used", 0)
					->get("card_item")->result();

				if(!empty($card_item)){
					foreach($card_item as $ci){
						$arr = [
							"order_id"		=> $order_id,
							"card_item_id"	=> $ci->card_item_id
						];
						$this->db->insert("order_item", $arr);
						$this->db->set("card_item_used", 1)->where("card_item_id", $ci->card_item_id)->update("card_item");
					}
					
					// update status of order
					$this->db->set("order_status_id", "3")->where("order_id", $order_id)->update("orders");

					// update amount of cards
					$real_amout = ($data["card_amount"] - $data["quantity"]);
					$this->db
						->set("card_amount", $real_amout)
						->where("card_id", $card_id)
						->update("card");
					
					// update balance customer
					$new_balance = ($customer_balance - $data["total"]);
					$this->db
						->set("customer_balance", $new_balance)
						->where("customer_id", $customer_id)
						->update("customer");

					// add action to customer wallet
					$arr = [
						"customer_id"					=> 	$customer_id,
						"customer_wallet_type_id"		=> 	2,
						"customer_wallet_old_balance"	=>	$customer_balance,
						"customer_wallet_new_balance"	=>	$data["total"],
						"customer_wallet_total_balance"	=>	$new_balance,
						"order_id"						=>	$order_id,
					];
					$this->db->insert("customer_wallet", $arr);
					return true;
				} else {
					return false;
				}
			} else {
				// update status of order
				$this->db->set("order_status_id", "1" )->where("order_id", $order_id)->update("orders");

				// add notifications
				$this->db
				->set("order_id", $order_id)
				->set("customer_id", $customer_id)
				->set("notification_title", "حالة الطلب")
				->set("notification_details", "تم تصنيف الطلب كـجديد ، سيتم العمل عليه فور موافقة المدير")
				->insert("notifications");
				
				return true;
			}
		} else {
			return false;
		}
	}


	function get_my_order($customer_id){
		return $this->db
			//->limit($limit, $offset)
			->order_by("o.order_create_at", "DESC")
			->where("o.customer_id" , $customer_id)
			->join("order_status os"," os.order_status_id = o.order_status_id","left")
			->join("card c"," c.card_id = o.card_id","left")
			->get("orders o")->result();
	}
	
	function get_my_order_card($customer_id, $order_id){
		return $this->db
			->where("o.customer_id" , $customer_id)
			->where("oi.order_id" , $order_id)
			->join("orders o"," o.order_id = oi.order_id","left")
			->join("card_item ci"," oi.card_item_id = ci.card_item_id","left")
			->get("order_item oi")->result();
	}

	function get_my_wallet($customer_id){
		return $this->db
			->order_by("customer_wallet_create_at", "DESC")
			->where("customer_id" , $customer_id)
			->get("customer_wallet")->result();
	}

	function get_my_notifications($customer_id){
		return $this->db
			->order_by("notification_create_at", "DESC")
			->where("customer_id" , $customer_id)
			->get("notifications")->result();
	}
}