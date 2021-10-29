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
		->get_where("category")->result();
	}

}