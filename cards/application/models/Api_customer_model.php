<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_customer_model extends CI_Model {
 
    public function __construct() {
        parent::__construct();
    }
	
	function order_status_id($order_id){
	    return $this->db
	    ->join("order_status","order_status.order_status_id = orders.order_status_id","left")
	    ->where("orders.order_id", $order_id)->get("orders")->row();
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
					$this->db->set("order_status_id", 3)->where("order_id", $order_id)->update("orders");

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
					//return true;
				} else {
					//return false;
				}
			} else {
				// update status of order
				$this->db->set("order_status_id", 1)->where("order_id", $order_id)->update("orders");

				// add notifications
				$this->db
				->set("order_id", $order_id)
				->set("customer_id", $customer_id)
				->set("notification_title", "حالة الطلب")
				->set("notification_details", "تم تصنيف الطلب (". $order_id .")  كـجديد ، سيتم العمل عليه فور موافقة المدير")
				->insert("notifications");
				 
				$customer_id = $customer_id;
				$title = "حالة الطلب (". $order_id .")";
				$body = "تم تصنيف الطلب (". $order_id .") كـجديد ، سيتم العمل عليه فور موافقة المدير";
				sendNotification($customer_id, $title, $body); 
				
				//return true;
			}

			return $order_id;
			
		} else {
			return false;
		}
	}
	
	/*----------------------------------------------
		order
	----------------------------------------------*/
	
	function get_all_order($customer_id){
		return count($this->db
			->where("o.customer_id" , $customer_id)
			->get("orders o")->result());
	}
	function get_my_order($customer_id, $offset){
		return $this->db
			->limit(20, $offset)
			->order_by("o.order_create_at", "DESC")
			->where("o.customer_id" , $customer_id)
			->join("order_status os"," os.order_status_id = o.order_status_id","left")
			->join("card c"," c.card_id = o.card_id","left")
			->get("orders o")->result();
	}

	function get_my_order_id($customer_id, $order_id){
		return $this->db
			->where("o.customer_id" , $customer_id)
			->where("o.order_id" , $order_id)
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

	function print_order_item_id($order_item_id){
		return $this->db
			->set("order_item_print", 1)
			->set("order_item_print_at", date("Y-m-d H:i:s"))
			->where("order_item_id" , $order_item_id)
			->update("order_item");
	}
	
	function print_order_all_card($order_id){
		return $this->db
			->set("order_item_print", 1)
			->set("order_item_print_at", date("Y-m-d H:i:s"))
			->where("order_id" , $order_id)
			->update("order_item");
	}

	/*----------------------------------------------
		wallet
	----------------------------------------------*/
	
	function get_all_wallet($customer_id){
		return count($this->db
			->where("customer_id" , $customer_id)
			->get("customer_wallet")->result());
	}
	
	function get_my_wallet($customer_id, $offset){
		return $this->db
			->limit(20, 20 * $offset)
			->order_by("customer_wallet_create_at", "DESC")
			->where("customer_id" , $customer_id)
			->get("customer_wallet")->result();
	}

	/*----------------------------------------------
		notifications
	----------------------------------------------*/
	
	function get_all_notifications($customer_id){
		return count($this->db
			->where("customer_id" , $customer_id)
			->get("notifications")->result());
	}
	function get_my_notifications($customer_id, $offset){
		return $this->db
			->limit(20, 20 * $offset)
			->order_by("notification_create_at", "DESC")
			->where("customer_id" , $customer_id)
			->get("notifications")->result();
	}

	function set_seen_notifications($customer_id, $order_id, $notification_id){
 
		return $this->db
			->set("notification_seen", 1) 
			->where("order_id" , $order_id)
			->where("customer_id" , $customer_id)
			->where("notification_id" , $notification_id)
			->update("notifications");
	}

	function fillter_my_order($customer_id, $order_status_id, $card_id, $start_date, $end_date){
		//return 
		if(!empty($order_status_id)){
			$this->db->where("os.order_status_id", $order_status_id);
		}
		if(!empty($card_id)){
			$this->db->where("c.card_id", $card_id);
		}
		if(!empty($start_date) and !empty($end_date)){
			$this->db->where("DATE(o.order_create_at) >=", $start_date);
			$this->db->where("DATE(o.order_create_at) <=", $end_date);
		}

		$res = $this->db
		->order_by("o.order_create_at", "DESC")
		->where("o.customer_id" , $customer_id)
		->join("order_status os"," os.order_status_id = o.order_status_id","left")
		->join("card c"," c.card_id = o.card_id","left")
		->get("orders o")->result();

		return $res;
	}

	function fillter_my_wallet($customer_id, $type_id, $start_date, $end_date){
		//return  
		if(!empty($card_id)){
			$this->db->where("customer_wallet_type_id", $type_id);
		}
		if(!empty($start_date) and !empty($end_date)){
			$this->db->where("DATE(customer_wallet_create_at) >=", $start_date);
			$this->db->where("DATE(customer_wallet_create_at) <=", $end_date);
		} 
		$res = $this->db
			->order_by("customer_wallet_create_at", "DESC")
			->where("customer_id" , $customer_id)
			->get("customer_wallet")->result();

		return $res;
	}
	
	
	
	function get_not_seen($customer_id){
		
		$count = $this->db
			->where("notification_seen" , 0)
			->where("customer_id" , $customer_id)
			->get("notifications")->result();
			
			return count($count);
	}
}