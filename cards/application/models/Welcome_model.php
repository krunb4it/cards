<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome_model extends CI_Model {
 
    public function __construct() {
        parent::__construct();
    }
    
    // is_permission

    function have_permission(){ 
        (!empty($this->uri->segment(2))) ? $method = $this->uri->segment(2) : $method = "index"; 
        $methodID = $this->db
                        ->where("controller", $this->uri->segment(1))
                        ->where("method", $method)
                        ->get("permission_method")->row();

        if(!empty($methodID)){
            return $this->db
                        ->where("user_id", $this->session->userdata("user_id"))
                        ->where("method_id", $methodID->method_id)
                        ->get("permission_user")->row()->permission_active; 
        } else {
            return FALSE;
        }
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