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
	
	// get info
	public function index(){
		$res = $this->db->get_where("slider",["slider_id" => 1])->row();
		$this->response($res, 200);
	} 
	
	// get Slider
	public function slider_get($slider_id = 0){
		if($slider_id == 0){
			$res = $this->db->order_by("slider_order","acs")->get("slider")->result();
		} else { 
			$res = $this->db->get_where("slider",["slider_id" => $slider_id])->row();
		} 
		if(!empty($res)){
			$this->response($res, 200);
		} else {
			$this->response($res, 404);
		}
	}
	
	// get page
	public function page_get($page_id = 0){
		if($page_id == 0){
			$res = $this->db->get("page")->result();
		} else { 
			$res = $this->db->get_where("page",["page_id" => $page_id])->row();
		}
		$this->response($res, 200);
	}
}