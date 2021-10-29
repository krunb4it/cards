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
			"card_min_amount"	=> $post["card_min_amount"]
		); 
		return $this->db->where("card_id", $post["card_id"])->update("card", $arr);
	}

	function update_card_status($card_active, $card_id){
		return $this->db->set("card_active", $card_active)->where("card_id", $card_id)->update("card");
	}

	function remove_card_id($card_id){
		return $this->db->where("card_id", $card_id)->delete("card");
	}
}