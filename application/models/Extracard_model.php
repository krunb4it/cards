<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Extracard_model extends CI_Model {
 
    public function __construct() {
        parent::__construct();
    }
      

    //get info
    public function get_info() {
        return $this->db
        ->where("config_id", 1)
        ->get("config")->row();
    }

    //get slider
    public function get_slider(){
        return $this->db
        ->order_by("slider_order","ASC")
        ->where("slider_active", 1)
        ->get("slider")->result();
    }

    //get paeg
    public function get_page($page_id){
        return $this->db
        ->where("page_id", $page_id)
        ->get("paeg")->result();
    }

    //get category
    public function get_category($category_id){
        return $this->db
        ->where("category_root", $category_id)
        ->where("category_active", 1)
        ->get("category")->result();
    }
	
    public function get_category_id($category_id){
        return $this->db
        ->where("category_id", $category_id)
        ->where("category_active", 1)
        ->get("category")->row();
    }

    //get category cards
    public function get_category_card($category_id){
        return $this->db
        ->where("card.category_id", $category_id)
        ->where("card_active", 1)
        ->join("category", "category.category_id = card.category_id", "left")
        ->get("card")->result();
    }

    //get cards by id
    public function get_card_id($card_id){
        return $this->db
        ->where("card.card_id", $card_id)
        ->where("card.card_active", 1)
        ->join("category", "category.category_id = card.category_id", "left")
        ->get("card")->result();
    }

    //get card have offer
    public function get_card_have_offer($card_id){
        return $this->db
        ->where("card.card_id", $card_id)
        ->where("card.card_active", 1)
        ->where("card_offer.card_offer_start_date <= ", date("Y-m-d"))
        ->where("card_offer.card_offer_end_date >= ", date("Y-m-d"))
        ->join("card_offer", "card_offer.card_id = card.card_id", "left")
        ->get("card")->row();
    }
}