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
	
	// get category
	public function category_get($category_id, $language){

		if($category_id != null){ 
			$res = $this->api_config_model->get_category($category_id);
		} else {
			$res = "Data Not Found ..!!";
		}
		
		if(!empty($res)){
			$all_data = [];

			for ($i = 0; $i < count($res) ; $i++) {
				$response = $res[$i];
				$data = [
					'category_id'		=> $response->category_id,
					'category_pic' 		=> $response->category_pic,
					'category_name'		=> json_decode($response->category_name)->$language,
					'category_details' 	=> json_decode($response->category_details)->$language,
					'category_active' 	=> $response->category_active,
					'category_root' 	=> $response->category_root
				];
				$all_data[] = $data;
			}
			$this->response( $all_data, 200);
		} else {
			$this->response($res, 404);
		}
	}
	
	// get card by category
	public function card_by_category_get($category_id, $language){

		if($category_id != null and $category_id > 0){
			$res = $this->api_config_model->card_by_category($category_id);
			
			if(!empty($res)){
				$all_data = [];
				for ($i = 0; $i < count($res) ; $i++) {
					$response = $res[$i];
	
					$have_offer = $this->api_config_model->card_have_offer($response->card_id);
					if(!empty($have_offer)){
						$card_offer				= 1;
						$card_offer_start_date	= $have_offer->card_offer_start_date;
						$card_offer_end_date 	= $have_offer->card_offer_end_date;
						$card_offer_new_price 	= $have_offer->card_offer_new_price;
						$card_offer_note 		= $have_offer->card_offer_note;
					} else {
						$card_offer				= 0;
						$card_offer_start_date	= 0;
						$card_offer_end_date 	= 0;
						$card_offer_new_price 	= 0;
						$card_offer_note 		= 0;
					}
					$data = [
						'card_id'			=> $response->card_id,
						'card_pic' 			=> $response->card_pic,
						'card_name'			=> json_decode($response->card_name)->$language,
						'card_note' 		=> json_decode($response->card_note)->$language,
						'card_amount' 		=> $response->card_amount,
						'card_price' 		=> $response->card_price,
						// category 
						'category_id'		=> $response->category_id,
						'category_name'		=> json_decode($response->category_name)->$language,
						// offer 
						'card_offer' 		=> $card_offer,
						'offer_start_date' 	=> $card_offer_start_date,
						'offer_end_date' 	=> $card_offer_end_date,
						'offer_price' 		=> $card_offer_new_price,
						'offer_note' 		=> $card_offer_note,
					];
					$all_data[] = $data;
				}
				$this->response( $all_data, 200);
			} else {
				$this->response($res, 404);
			}
		} else {
			$res = "Data Not Found ..!!";
			$this->response($res, 404);
		} 
	}
	// get card by category
	public function card_get($card_id, $language){

		if($card_id != null and $card_id > 0){
			$res = $this->api_config_model->card_by_id($card_id);
			
			if(!empty($res)){
				$all_data = [];
				for ($i = 0; $i < count($res) ; $i++) {
					$response = $res[$i];

					$have_offer = $this->api_config_model->card_have_offer($card_id);
					if(!empty($have_offer)){
						$card_offer				= 1;
						$card_offer_start_date	= $have_offer->card_offer_start_date;
						$card_offer_end_date 	= $have_offer->card_offer_end_date;
						$card_offer_new_price 	= $have_offer->card_offer_new_price;
						$card_offer_note 		= $have_offer->card_offer_note;
					} else {
						$card_offer				= 0;
						$card_offer_start_date	= 0;
						$card_offer_end_date 	= 0;
						$card_offer_new_price 	= 0;
						$card_offer_note 		= 0;
					}
					$data = [
						'card_id'			=> $response->card_id,
						'card_pic' 			=> $response->card_pic,
						'card_name'			=> json_decode($response->card_name)->$language,
						'card_note' 		=> json_decode($response->card_note)->$language,
						'card_amount' 		=> $response->card_amount,
						'card_price' 		=> $response->card_price,
						// category 
						'category_id'		=> $response->category_id,
						'category_name'		=> json_decode($response->category_name)->$language,
						// offer 
						'card_offer' 		=> $card_offer,
						'offer_start_date' 	=> $card_offer_start_date,
						'offer_end_date' 	=> $card_offer_end_date,
						'offer_price' 		=> $card_offer_new_price,
						'offer_note' 		=> $card_offer_note,
					];
					$all_data[] = $data;
				}
				$this->response( $all_data, 200);
			} else {
				$this->response($res, 404);
			}
		} else {
			$res = "Data Not Found ..!!";
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