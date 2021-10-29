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
	public function index_get($language){
		$res = $this->api_config_model->get_setting();

		echo "<pre>";
		print_r($res);
		die;

		$all_data = []; 
		for ($i = 0; $i < count($res) ; $i++) {
			$response = $res[$i];
			$data = [
				'slider_id' 		=> $response->slider_id,
				'slider_cover' 		=> $response->slider_cover,
				'slider_title'		=> json_decode($response->slider_title)->$language,
				'slider_sub_title' 	=> json_decode($response->slider_sub_title)->$language,
				'slider_details' 	=> json_decode($response->slider_details)->$language,
				'slider_tags' 		=> json_decode($response->slider_tags)->$language,
				'slider_link' 		=> $response->slider_link,
				'slider_add_by'		=> $response->slider_add_by,
				'slider_add_at' 	=> $response->slider_add_at,
				'slider_update_by' 	=> $response->slider_update_by,
				'slider_update_at' 	=> $response->slider_update_at,
				'slider_order' 		=> $response->slider_order,
				'slider_active' 	=> $response->slider_active,
			];
			$all_data[] = $data;
		}
		$this->response( $all_data, 200); 
	}	

	public function info_get($language){
		$res = $this->api_config_model->get_setting();

	 
		$all_data = []; 
		for ($i = 0; $i < count($res) ; $i++) {
			$response = $res[$i];
			$data = [
				'config_id' 			=> $response->config_id,
				'website_logo' 			=> $response->website_logo,
				'website_icon' 			=> $response->website_icon,
				'website_cover'			=> $response->website_cover,
				'website_name'			=> json_decode($response->website_name)->$language,
				'website_keyword' 		=> json_decode($response->website_keyword)->$language,
				'website_description'	=> json_decode($response->website_description)->$language,
				'app_ios_link' 			=> $response->app_ios_link,
				'app_andorid_link'		=> $response->app_andorid_link,
				'email' 				=> $response->email,
				'jawwal' 				=> $response->jawwal,
				'phone' 				=> $response->phone,
				'facebook_link' 		=> $response->facebook_link,
				'twitter_link' 			=> $response->twitter_link,
				'instagram_link'		=> $response->instagram_link,
				'youtube_link' 			=> $response->youtube_link,
				'whatsapp_link'			=> $response->whatsapp_link,
			];
			$all_data[] = $data;
		}
		$this->response( $all_data, 200); 
	}
	
	// get Slider
	public function slider_get($slider_id,$language){
		if($slider_id == 0 and $slider_id != null){
			$res = $this->api_config_model->get_slider();
		} else {
			$res = $this->api_config_model->get_slider_id($slider_id);
		} 

		if(!empty($res)){
			$all_data = [];

			for ($i = 0; $i < count($res) ; $i++) {
				$response = $res[$i];
				$data = [
					'slider_id' 		=> $response->slider_id,
					'slider_cover' 		=> $response->slider_cover,
					'slider_title'		=> json_decode($response->slider_title)->$language,
					'slider_sub_title' 	=> json_decode($response->slider_sub_title)->$language,
					'slider_details' 	=> json_decode($response->slider_details)->$language,
					'slider_tags' 		=> json_decode($response->slider_tags)->$language,
					'slider_link' 		=> $response->slider_link,
					'slider_add_by'		=> $response->slider_add_by,
					'slider_add_at' 	=> $response->slider_add_at,
					'slider_update_by' 	=> $response->slider_update_by,
					'slider_update_at' 	=> $response->slider_update_at,
					'slider_order' 		=> $response->slider_order,
					'slider_active' 	=> $response->slider_active,
				];
				$all_data[] = $data;
			}
			$this->response( $all_data, 200);
		} else {
			$this->response($res, 404);
		}
	}

	// get page
	public function page_get($page_id, $language){

		if($page_id == 0 and $page_id != null){ 
			$res = $this->api_config_model->get_page();
		} else {
			$res = $this->api_config_model->get_page_id($page_id);
		}
		
		if(!empty($res)){
			$all_data = [];

			for ($i = 0; $i < count($res) ; $i++) {
				$response = $res[$i];
				$data = [
					'page_id'			=> $response->page_id,
					'page_cover' 		=> $response->page_cover,
					'page_title'		=> json_decode($response->page_title)->$language,
					'page_sub_title' 	=> json_decode($response->page_sub_title)->$language,
					'page_details'		=> json_decode($response->page_details)->$language,
					'page_tags' 		=> json_decode($response->page_tags)->$language,
					'page_update_by' 	=> $response->page_update_by,
					'page_update_at' 	=> $response->page_update_at,
					'page_order' 		=> $response->page_order,
					'page_active'		=> $response->page_active,
				];
				$all_data[] = $data;
			}
			$this->response( $all_data, 200);
		} else {
			$this->response($res, 404);
		}
		
	}
	
}


/*
	 curl_setopt_array($curl, array(
            CURLOPT_URL => "http://krunb4it.com/cards/api/slider/0",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        ));

        $response = curl_exec($curl);
        $response_data = json_decode($response);
        $language = $request->get('language');
        $all_data = [];
        $count = count($response_data);

        for ($i = 0; $i < $count; $i++) {

            $response = $response_data[$i];

            $data = [
                'slider_id' => $response->slider_id,
                'slider_cover' => $response->slider_cover,
                'slider_title' => json_decode($response->slider_title)->$language,
                'slider_sub_title' => json_decode($response->slider_sub_title)->$language,
                'slider_details' => json_decode($response->slider_details)->$language,
                'slider_tags' => json_decode($response->slider_tags)->$language,
                'slider_link' => $response->slider_link,
                'slider_add_by' => $response->slider_add_by,
                'slider_add_at' => $response->slider_add_at,
                'slider_update_by' => $response->slider_update_by,
                'slider_update_at' => $response->slider_update_at,
                'slider_order' => $response->slider_order,
                'slider_active' => $response->slider_active,
            ];

            $all_data[] = $data;
        }
		
        return json_encode($all_data); 
 
*/