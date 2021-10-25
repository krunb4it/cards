<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

use chriskacerguis\RestServer\RestController;

class Config extends RestController{
	
    public function __construct(){
        parent::__construct();
        $this->load->model('api_config_model');
    }
	
	// get info
	public function index_get(){
		$res = $this->api_config_model->get_setting(); 
		$this->response($res, 200);
	}	
	
	// get Slider
	public function slider_get($slider_id = 0){
		if($slider_id == 0){
			$res = $this->api_config_model->get_slider();
		} else {
			$res = $this->api_config_model->get_slider_id($slider_id);
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
			$res = $this->api_config_model->get_paeg();
		} else {
			$res = $this->api_config_model->get_paeg($page_id);
		}
		$this->response($res, 200);
	}
	
}