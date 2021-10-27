<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agent_model extends CI_Model {
 
    public function __construct() {
        parent::__construct();
    } 

	function get_count_agent(){
		return $this->db->count_all("agent");
	}
	function get_agent($limit, $offset){
		return $this->db
		->limit($limit, $offset) 
		->join("agent_status","agent_status.agent_status_id = agent.agent_status_id", "left")
		->get("agent")->result();
	}
	function get_all_agent( ){
		return $this->db
		->join("agent_status","agent_status.agent_status_id = agent.agent_status_id", "left")
		->get("agent")->result();
	}
	function get_agent_id($agent_id){
		return $this->db->where("agent_id", $agent_id)->get("agent")->row();
	} 
	
	function add_agent($post, $agent_logo, $token){
		$arr = array(
			"agent_logo"		=> $agent_logo,
			"agent_name"		=> $post["agent_name"],
			"agent_email"		=> $post["agent_email"],
			"agent_jawwal"		=> $post["agent_jawwal"],
			"agent_password"	=> md5($post["agent_password"]), 
			"agent_status_id"	=> 0,
			"agent_active"		=> 0,
			"agent_create_by"	=> $this->session->userdata("user_id"),
			"agent_token"		=> $token,
		); 
		$this->db->insert("agent", $arr);
		return $this->db->insert_id();
	}
	
	function update_agent($post, $agent_logo){
		$arr = array(
			"agent_logo"		=> $agent_logo,
			"agent_name"		=> $post["agent_name"],
			"agent_email"		=> $post["agent_email"],
			"agent_jawwal"		=> $post["agent_jawwal"]
		); 
		return $this->db->where("agent_id", $post["agent_id"])->update("agent", $arr);
	}

	function update_agent_status($agent_active, $agent_id){
		return $this->db->set("agent_active", $agent_active)->where("agent_id", $agent_id)->update("agent");
	}

	function remove_agent_id($agent_id){
		return $this->db->where("agent_id", $agent_id)->delete("agent");
	}
	
}