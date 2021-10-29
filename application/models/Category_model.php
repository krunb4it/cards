<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {
 
    public function __construct() {
        parent::__construct();
    }
	
	function get_category($root){
		return $this->db->where("category_root", $root)->get("category")->result(); 
	}

	function get_category_id($category_id){
		return $this->db->where("category_id", $category_id)->get("category")->row();
	}
	
	function add_category($post, $category_pic){
		$arr = array(
			"category_pic"		=> $category_pic,
			"category_name"		=> json_encode($post["category_name"]),
			"category_details"	=> json_encode($post["category_details"]),
			"category_root"		=> $post["category_root"]
		); 
		return $this->db->insert("category", $arr);
	}

	function update_category($post, $category_pic){
		$arr = array(
			"category_pic"		=> $category_pic,
			"category_name"		=> json_encode($post["category_name"]),
			"category_details"	=> json_encode($post["category_details"]),
			"category_root"		=> $post["category_root"]
		); 
		return $this->db->where("category_id", $post["category_id"])->update("category", $arr);
	}
	
	function update_category_status($category_active, $category_id){
		return $this->db->set("category_active", $category_active)->where("category_id", $category_id)->update("category");
	}
	
	function remove_category_id($category_id){
		return $this->db->where("category_id", $category_id)->delete("category");
	}
}