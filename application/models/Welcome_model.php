<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome_model extends CI_Model {
 
    public function __construct() {
        parent::__construct();
    }
    
    //get message history
    function msg_history($post){
        $arr = array( 
			"from"      => $this->session->userdata("user_id")
			,"to"       => $post["to"]
            ,"number"   => $post["mobile"]
            ,"msg_text" => $post["msg"] 
		);  
        return $this->db->insert("msg_history", $arr);
    }

    //get qualifications
    public function get_qualifications() {
        return $this->db->get("qualifications")->result();
    }

    //get city
    public function get_city() {
        return $this->db->get("city")->result();
    }

    //get day
    public function get_day() {
        return $this->db->get("day")->result();
    }

    //get students
    public function get_students($full_name) {
        return $this->db
        ->where("full_name like '%$full_name%'")
        ->get("students")->result();
    }
}