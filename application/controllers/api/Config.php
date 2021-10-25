<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

use chriskacerguis\RestServer\RestController;

class Config extends RestController{
	
    public function __construct(){
        parent::__construct();
        $this->load->model('config_model');
    }
	
	// get_slider
	
	public function index(){
		echo "welcome to api controller";
	}
	
	
	public function get_slider($slider_id = 0){
		if($slider_id == 0){
			$this->db->get("slider")->result();
		} else { 
			$this->db->get_where("slider",["slider_id" => $slider_id])->row();
		} 
	}
}