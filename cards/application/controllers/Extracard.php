<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Extracard extends CI_Controller {
    
    public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('cart');
		$this->load->model('extracard_model');
		
		$this->session->set_userdata("website_lang","ar");
	}
	
	public function index(){ 
		$this->main_lang();
		$data["info"] 		=  $this->extracard_model->get_info();
		$data["slider"]		=  $this->extracard_model->get_slider();
		$data["category"] 	=  $this->extracard_model->get_category(0);

		$data["page"] = "front/index";
		$this->load->view('front/include/temp',$data);
	}
	
	// view main category 
	public function view_category(){
		$this->main_lang();
		$data["category"] 	= $this->extracard_model->get_category(0);
		$data["page"] 		= "front/category/category_main";
		$this->load->view('front/include/temp',$data);
		
	}

	// view sub category 
	public function view_sub_category($category_id){ 
		if($category_id != null and $category_id > 0){
			$this->main_lang();
			$data["category"] 		= $this->extracard_model->get_category($category_id);
			$data["category_main"]	= $this->extracard_model->get_category_id($category_id);
			$data["page"] 			= "front/category/category_sub";
			$this->load->view('front/include/temp',$data);
		} else {
			redirect("extracard/error404");
		}
	}

	// view card of category 
	public function view_card($category_id){ 
		if($category_id != null and $category_id > 0){
			$this->main_lang(); 
			$language = $this->session->userdata("website_lang");
			
			$res = $this->extracard_model->get_category_card($category_id);
			
			$all_data = [];
			if(!empty($res)){
				for ($i = 0; $i < count($res) ; $i++) {
					$response = $res[$i];

					$have_offer = $this->extracard_model->get_card_have_offer($response->card_id);
				
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
			}
			
			$data["category_sub"]	= $this->extracard_model->get_category_id($category_id);
			if($data["category_sub"]->category_root != 0){
				$data["category_main"]	= $this->extracard_model->get_category_id($data["category_sub"]->category_root);
			}
			$data["cards"]	= $all_data; 
			$data["page"]	= "front/card/card";
			$this->load->view('front/include/temp',$data);
		} else {
			redirect("extracard/error404");
		}
	}

	function main_lang(){ 
		$this->session->set_userdata("website_lang","ar");
	}
	
	public function login(){ 
		$this->load->view('login');
	}
	public function no_auth(){ 
		$this->load->view('no_auth');
	}
	public function error404(){ 
		$this->load->view('front/error404');
	}
	
	public function do_login(){  
		$post = $this->input->post(NULL, TRUE);
		$arr = array(
	        "email"     => $post['email'],
           "password"   => md5($post['password'])
		);
		$row = $this->db->get_where("users",$arr)->row();
		if(!empty($row)){
		    if($row->user_status == 1){ 

				$this->config_model->update_token($row->user_id, $this->security->get_csrf_hash());
    	        $data = array(
    	                "user_id" 		=> $row->user_id
    	            ,   "user_name" 	=> $row->user_name
    	            ,   "user_pic"		=> $row->user_pic
    	            ,   "user_email"	=> $row->email
    	            ,   "user_jawwal"	=> $row->jawwal
    	            ,   "user_status"	=> $row->user_status
    	            ,   "group_id"		=> $row->group_id
                    ,   "is_logging"	=> true
					,	"my_token" 		=> $this->security->get_csrf_hash()
				);
	            $this->session->set_userdata($data);
    		    $status = 1;
				$res    = "تم تسجيل الدخول بنجاح ، سيتم تحويلكم الان الى لوحة التحكم";
				
				$activity = array(
						"user_id" 	=> $this->session->userdata("user_id")
					,	"type_id" 	=> 1
					,	"title" 	=> "قام ".$this->session->userdata("user_name")."بتسجيل الدخول الى لوحة التحكم"
					,	"ip" 		=> $this->input->ip_address()
				);
				$this->db->insert("activites", $activity);
		    } else {
    		    $status = 0;
    		    $res    = "هذاالحساب محظور ، يرجى مراسلة الادارة لمعرفة السبب .";
		    }
		} else {
		    $status = 0;
		    $res    = " خطأ في اسم المستخدم أو كلمة المرور";
		}
		echo json_encode(array("res"=>$res, "status"=> $status));
	}
	
	public function logOut(){  
		$this->session->sess_destroy();
		redirect();	
	}
	
	
	/*
		Cart user
	*/

	function viewCart(){ 
		$data["page"]	= "front/cart/view_cart";
		$this->load->view('front/include/temp',$data);
	}
	function addToCart(){
		$post = $this->input->post("", true);
		$data = array(
			'id'      => $this->input->post("card_id", true),
			'qty'     => $this->input->post("card_qty", true),
			'price'   => $this->input->post("card_price", true),
			'name'    => $this->input->post("card_name", true),
			'pic'    => $this->input->post("card_pic", true)
		);
		$res = $this->cart->insert($data);
		if($res != false){
			$res = " تم اضافة المنتج ". $this->input->post("card_name", true) ." الى السلة بنجاح ";
			$status = "success";
			$link = "";
			$cart_count = count($this->cart->contents());
		} else {
			$res = "حدث خطأ اثناء اضافة المنتج ، يرجى المحاولة مرة اخرى";
			$status = "error";
			$link = "";
			$cart_count = "";
		}   
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link, "cart_count" => $cart_count));
	}
	
	function removeFromCart(){
		$data = array(
			'rowid'	=> $this->input->post("row_id", true),
			'qty'  	=> 0
		);
		$res = $this->cart->update($data); 
		if($res != false){
			$res = " تم حذف المنتج  من السلة بنجاح ";
			$status = "success";
			$link = "";
			$cart_count = count($this->cart->contents());
		} else {
			$res = "حدث خطأ اثناء اضافة المنتج ، يرجى المحاولة مرة اخرى";
			$status = "error";
			$link = "";
			$cart_count = "";
		}   
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link, "cart_count" => $cart_count));
	}
	
	function clearCart() { 
		$res = $this->cart->destroy(); 
		if($res != false){
			$res = " تم حذف السلة بنجاح";
			$status = "success";
			$link = "";
		} else {
			$res = "حدث خطأ ، حاول مرة اخرى";
			$status = "error";
			$link = "";
		}   
		echo json_encode(array("res" => $res, "status" => $status, "link" => $link));
	}
}


