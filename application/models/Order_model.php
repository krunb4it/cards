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

	function get_all_order(){
		return $this->db 
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

	function fillter_order($data){
		
		if(!empty($data["customer_id"])){
			$this->db->where("orders.customer_id", $data["customer_id"]);
		}
		if(!empty($data["card_id"])){
			$this->db->where("orders.card_id", $data["card_id"]);
		}
		if(!empty($data["from_date"]) and !empty($data["to_date"])){
			$this->db->where("DATE(orders.order_create_at) <= ", $data["from_date"]);
			$this->db->where("DATE(orders.order_create_at) >= ", $data["to_date"]);
		}

		$this->db->join("customer","customer.customer_id = orders.customer_id","left");
		$this->db->join("card","card.card_id = orders.card_id","left");
		$this->db->join("order_status","order_status.order_status_id = orders.order_status_id","left");
		$this->db->get("orders")->result();
	}
}