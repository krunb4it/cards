<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Card_model extends CI_Model {
 
    public function __construct() {
        parent::__construct();
    } 

	function get_count_card(){
		return $this->db->count_all("card");
	}

	function get_all_card(){
		return $this->db 
		->join("category","category.category_id = card.category_id","left")
		->get("card")->result();
	}

	function get_card_id($card_id){
		return $this->db
		->join("category","category.category_id = card.category_id","left")
		->where("card_id", $card_id)->get("card")->row();
	}
	
	function add_card($post, $card_pic){
		$arr = array(
			"card_pic"			=> $card_pic,
			"card_name"			=> json_encode($post["card_name"]),
			"card_note"			=> json_encode($post["card_note"]),
			"card_time_to_do"	=> $post["card_time_to_do"],
			"category_id"		=> $post["category_id"],
			"card_min_amount"	=> $post["card_min_amount"],
			"card_price"		=> $post["card_price"],
			"need_approval"		=> $post["need_approval"],
			"card_active"		=> 0,
			"card_create_by"	=> $this->session->userdata("user_id"),
		); 
		$this->db->insert("card", $arr);
		return $this->db->insert_id();
	}
	
	function update_card($post, $card_pic){
		$arr = array(
			"card_pic"			=> $card_pic,
			"card_name"			=> json_encode($post["card_name"]),
			"card_note"			=> json_encode($post["card_note"]),
			"card_time_to_do"	=> $post["card_time_to_do"],
			"category_id"		=> $post["category_id"],
			"card_min_amount"	=> $post["card_min_amount"],
			"card_price"		=> $post["card_price"],
			"need_approval"		=> $post["need_approval"],
		); 
		return $this->db->where("card_id", $post["card_id"])->update("card", $arr);
	}

	function update_card_status($card_active, $card_id){
		return $this->db->set("card_active", $card_active)->where("card_id", $card_id)->update("card");
	}

	function remove_card_id($card_id){
		return $this->db->where("card_id", $card_id)->delete("card");
	}

	/*----------------------------------------
		Charge card amount
	----------------------------------------
	
	function get_card_charge($card_id){
		return $this->db
		//->order_by("card_charge.card_charge_create_at","DESC")
		->join("users","users.user_id = card_charge.card_charge_create_by","left")
		->join("card","card_charge.card_id = card.card_id","left")
		->where("card_charge.card_id", $card_id)
		->get("card_charge")->result();
	}
	
	function new_charge($post, $old_amount, $old_price){
		$arr = array(
			"card_id"					=> $post["card_id"],
			"card_charge_amount"		=> $post["card_charge_amount"], 
			"card_charge_price"			=> $post["card_charge_price"], 
			"card_charge_total_price"	=> ($post["card_charge_amount"] * $post["card_charge_price"]), 
			"card_charge_note"			=> nl2br($post["card_charge_note"]),
			"card_charge_create_by"		=> $this->session->userdata("user_id"), 
			"card_charge_old_amount"	=> $old_amount, 
			"card_charge_old_price"		=> $old_price, 
		);

		$this->db
			->set("card_amount", ($old_amount + $post["card_charge_amount"]))
			->set("card_price", $post["card_charge_price"])
			->where("card_id", $post["card_id"])
			->update("card");

		return $this->db->insert("card_charge", $arr);
	}
*/ 
	/*----------------------------------------
		Offer card 
	----------------------------------------*/ 
	
	function get_card_offer($card_id){
		return $this->db
		//->order_by("card_charge.card_charge_create_at","DESC")
		->join("users","users.user_id = card_offer.card_offer_create_by","left")
		->join("card","card_offer.card_id = card.card_id","left")
		->where("card_offer.card_id", $card_id)
		->get("card_offer")->result();
	}
	
	function card_have_offer($card_id){
		return $this->db
		->where("card_id", $card_id)
		->where("card_offer_end_date > ", date("Y-m-d"))
		->get("card_offer")->result();
	}

	function new_offer($post){
		$arr = array(
			"card_id"					=> $post["card_id"],
			"card_offer_start_date"		=> $post["card_offer_start_date"],
			"card_offer_end_date"		=> $post["card_offer_end_date"],
			"card_offer_old_price"		=> $post["card_offer_old_price"],
			"card_offer_new_price"		=> $post["card_offer_new_price"],
			"card_offer_note"			=> $post["card_offer_note"],
			"card_offer_create_by"		=> $this->session->userdata("user_id")
		);
		return $this->db->insert("card_offer", $arr);
	}

	/*----------------------------------------
		item card 
	----------------------------------------*/ 
	
	function get_card_item($card_id){
		return $this->db
		->order_by("card_item.card_item_at","DESC")
		->join("users","users.user_id = card_item.card_item_by","left")
		->join("card","card_item.card_id = card.card_id","left")
		->where("card_item.card_id", $card_id)
		->get("card_item")->result();
	}

	function add_card_item($post){

		$old_amount = $this->db->where("card_id", $post["card_id"])->get("card")->row()->card_amount;
		$this->db
			->set("card_amount", ($old_amount + 1))
			->where("card_id", $post["card_id"])
			->update("card");

		$arr = array(
			"card_id"				=> $post["card_id"],
			"card_item_code"		=> $post["card_item_code"],
			"card_item_reference"	=> $post["card_item_reference"],
			"card_item_serial"		=> $post["card_item_serial"],
			"card_item_end"			=> $post["card_item_end"],
			"card_item_used"		=> 0,
			"card_item_by"			=> $this->session->userdata("user_id")
		);
		return $this->db->insert("card_item", $arr);
		 
		
	}
}