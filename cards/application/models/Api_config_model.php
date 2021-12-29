<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_config_model extends CI_Model {
 
    public function __construct() {
        parent::__construct();
    }
	
	/* setting */
	function get_setting(){
		return $this->db->get_where("config","config_id = 1")->result();
	}
	  
	/* page */
	function get_page(){
		return $this->db->order_by("page_order", "ASC")->get_where("page","page_active = 1")->result();
	}
	function get_page_id($page_id){
		return $this->db
		->where("page_id", $page_id)
		->where("page_active", 1)
		->get("page")->result();
	}

	/* slider */
	function get_slider(){
		return $this->db->order_by("slider_order", "ASC")->get_where("slider","slider_active = 1")->result();
	}
	function get_slider_id($slider_id){
		return $this->db
		->where("slider_id", $slider_id)
		->where("slider_active", 1)
		->get("slider")->result();
	}
	
	/* category */
	function get_category($category_id){
		return $this->db
		->where("category_root", $category_id)
		->where("category_active", 1)
		->get("category")->result();
	}

	/* card */
	function card_by_category($category_id){
		$today = date("Y-m-d");
		$where = "card_offer_start_date <   and card_offer_end_date > ". date("Y-m-d");

		return $this->db 
		->where("card.category_id", $category_id)
		->where("card.card_active", 1)
		->join("category","category.category_id = card.category_id","left")
		->get("card")->result();
	}

	function card_by_id($card_id){
		return $this->db
		->where("card.card_active", 1)
		->where("card.card_id", $card_id)
		->join("category","category.category_id = card.category_id","left")
		->get("card")->result();
	}
	
	function card_have_offer($card_id){
		return $this->db
		->where("card_id", $card_id)
		->where("card_offer_start_date <=", date("Y-m-d"))
		->where("card_offer_end_date >= ", date("Y-m-d"))
		->get("card_offer")->row();
	}
	
	
	function get_most_order_card(){
		return $this->db
				->select("card_pic, orders.card_id, sum(quantity) as s_quantity")
				->from("orders")->where("order_status_id = 3")
				->limit(10)
				->join("card","card.card_id = orders.card_id ","left")
				->group_by("orders.card_id")->get()->result();
	}

}