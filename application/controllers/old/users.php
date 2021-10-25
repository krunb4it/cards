<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
    }
	
	public function index(){ 
		if($this->session->userdata("is_logging") == false){
			$this->load->view('back/login');
		} else { 
			$activity = array(
					"user_id" 	=> $this->session->userdata("user_id")
				,	"type_id" 	=> 1
				,	"title" 	=> "قام ".$this->session->userdata("user_name")." بإستعراض المستخدمين"
				,	"ip" 		=> $this->input->ip_address()
			);
			$this->db->insert("activites", $activity);
			
			$data["view"] = $this->db->get("users")->result();
			$data["page"] = "back/users/view";
			$this->load->view('back/include/temp',$data); 
		}
	} 

	public function add(){
		if($this->session->userdata("is_logging") == false){
			$this->load->view('back/login');
		} else { 
			$data["page"] = "back/users/add";
			$this->load->view('back/include/temp',$data);
		}
    } 
     
	public function edit($user_id){
		if($this->session->userdata("is_logging") == false){
			$this->load->view('back/login');
		} else { 
            $data["view"] = $this->db->get_where("users","user_id = $user_id")->row();
			$data["page"] = "back/users/edit";
			$this->load->view('back/include/temp',$data); 
		}
	}
	
	public function remove($user_id){
		if($this->session->userdata("is_logging") == false){
			$this->load->view('back/login');
		} else {  
			$user_name = $this->db->get_where("users","user_id = $user_id")->row()->user_name;
            $row = $this->db->where("user_id = $user_id")->delete("users");
			if($row == true){
				$status = 1; 
				$res = 'تم حذف البيانات بنجاح';
				
				$activity = array(
						"user_id" 	=> $this->session->userdata("user_id")
					,	"type_id" 	=> 4
					,	"title" 	=> "قام ".$this->session->userdata("user_name")." بحذف المستخدم ". $user_name
					,	"ip" 		=> $this->input->ip_address()
				);
				$this->db->insert("activites", $activity);
				
			} else {
				$status = 0;
				$res = 'حدث خطأ ما ، يرجى المحاولة مرة أخرى !!';
			}
			echo json_encode(array("res"=>$res, "status"=> $status));
		}
	}  
	 
	/*
		Create user Page Information ... 
	*/
	
	public function update_user(){
		if($this->session->userdata("is_logging") == false){
			$this->load->view('back/login');
		} else { 
            $post = $this->input->post(null, true); 
			 
			$config['upload_path']="./upload/user/";
			$config['allowed_types']='gif|jpg|png|jpeg';
			$config['encrypt_name']= true; 
			$this->load->library('upload',$config);
			
			if($this->upload->do_upload("pic")){
				$img = array('upload_data' => $this->upload->data()); 
				$pic = $config['upload_path'].$img['upload_data']['file_name'] ;
			} else {
				$pic = $post["last_pic"];
			}
			$arr = array(
				"user_name"	=> $post["user_name"]
				,"user_pic"	=> $pic
				,"status"	=> $post["status"]  
				,"email"	=> $post["email"]  
				,"jawwal"	=> $post["jawwal"]  
			);  
			$row = $this->db->where("user_id", $post["user_id"])->update("users", $arr);
			
			if($row == true){
				$status = 1; 
				$res = 'تم حفظ البيانات بنجاح';
				$activity = array(
						"user_id" 	=> $this->session->userdata("user_id")
					,	"type_id" 	=> 3
					,	"title" 	=> "قام ".$this->session->userdata("user_name")." بتعديل بيانات المستخدم ". $post["user_name"]
					,	"ip" 		=> $this->input->ip_address()
				);
				$this->db->insert("activites", $activity);
			} else {
				$status = 0;
				$res = 'حدث خطأ ما ، يرجى المحاولة مرة أخرى !!';
			} 
            echo json_encode(array("res"=>$res, "status"=> $status));
		}
    }
	 
	public function def_user(){
		if($this->session->userdata("is_logging") == false){
			$this->load->view('back/login');
		} else { 
            $post = $this->input->post(null, true); 
			 
			$config['upload_path']="./upload/user/";
			$config['allowed_types']='gif|jpg|png|jpeg';
			$config['encrypt_name']= true; 
			$this->load->library('upload',$config);
			
			if($this->upload->do_upload("pic")){
				$pic = array('upload_data' => $this->upload->data()); 
				$arr = array(
					"user_name"		=> $post["user_name"]
					,"user_pic"		=> $config['upload_path'].$pic['upload_data']['file_name'] 
					,"status"		=> $post["status"]  
					,"email"		=> $post["email"]  
					,"jawwal"		=> $post["jawwal"]  
					,"password"		=> md5($post["password"]) 
				);  
				$row = $this->db->insert("users", $arr);
				
				if($row == true){
					$status = 1; 
					$res = 'تم حفظ البيانات بنجاح';
					$activity = array(
							"user_id" 	=> $this->session->userdata("user_id")
						,	"type_id" 	=> 2
						,	"title" 	=> "قام ".$this->session->userdata("user_name")." اضافة المستخدم ".  $post["user_name"]
						,	"ip" 		=> $this->input->ip_address()
					);
					$this->db->insert("activites", $activity);
				} else {
					$status = 0;
					$res = 'حدث خطأ ما ، يرجى المحاولة مرة أخرى !!';
				}
			} else {
				$status = 0;
				$res = array('error' => $this->upload->display_errors());
			}
            echo json_encode(array("res"=>$res, "status"=> $status));
		}
	}
	
	public function change_password(){
		if($this->session->userdata("is_logging") == false){
			$this->load->view('back/login');
		} else { 
            $post = $this->input->post(null, true);  
			$arr = array( "password"	=> md5($post["password"]));  
			$row = $this->db->where("user_id", $post["user_id"])->update("users", $arr);
			
			if($row == true){
				$status = 1; 
				$res = 'تم حفظ البيانات بنجاح';
				$activity = array(
						"user_id" 	=> $this->session->userdata("user_id")
					,	"type_id" 	=> 2
					,	"title" 	=> "قام ".$this->session->userdata("user_name")." تغيير كلمة المرور حساب المستخدم  ".  $post["user_name"]
					,	"ip" 		=> $this->input->ip_address()
				);
				$this->db->insert("activites", $activity);
			} else {
				$status = 0;
				$res = 'حدث خطأ ما ، يرجى المحاولة مرة أخرى !!';
			} 
            echo json_encode(array("res"=>$res, "status"=> $status));
		}
    }
	
	
	/*-----------
		# Profile
	-----------------------------------*/
	public function profile(){ 
		if($this->session->userdata("is_logging") == false){
			$this->load->view('back/login');
		} else {
			$data["page"] = "back/users/profile";
			$this->load->view('back/include/temp',$data); 
		}
	}
  
	public function update_profile(){
		if($this->session->userdata("is_logging") == false){
			$this->load->view('back/login');
		} else { 
            $post = $this->input->post(null, true); 
			 
			$config['upload_path']="./upload/user/";
			$config['allowed_types']='gif|jpg|png|jpeg';
			$config['encrypt_name']= true; 
			$this->load->library('upload',$config);
			
			if($this->upload->do_upload("pic")){
				$img = array('upload_data' => $this->upload->data()); 
				$pic = $config['upload_path'].$img['upload_data']['file_name'] ;
			} else {
				$pic = $post["last_pic"];
			}
			$arr = array( 
				"user_pic"	=> $pic 
				,"email"	=> $post["email"]  
				,"jawwal"	=> $post["jawwal"]  
			);  
			$row = $this->db->where("user_id", $this->session->userdata("user_id"))->update("users", $arr);
			
			if($row == true){
				$status = 1; 
				$res = 'تم حفظ البيانات بنجاح';
				$activity = array(
						"user_id" 	=> $this->session->userdata("user_id")
					,	"type_id" 	=> 3
					,	"title" 	=> "قام ".$this->session->userdata("user_name")." بتعديل  بياناته"
					,	"ip" 		=> $this->input->ip_address()
				);
				$this->db->insert("activites", $activity);
			} else {
				$status = 0;
				$res = 'حدث خطأ ما ، يرجى المحاولة مرة أخرى !!';
			} 
            echo json_encode(array("res"=>$res, "status"=> $status));
		}
	}
	
	public function change_password_profile(){
		if($this->session->userdata("is_logging") == false){
			$this->load->view('back/login');
		} else { 
            $post = $this->input->post(null, true);  
			$arr = array( "password"	=> md5($post["password"]));  
			$row = $this->db->where("user_id",$this->session->userdata("user_id"))->update("users", $arr);
			
			if($row == true){
				$status = 1; 
				$res = 'تم حفظ البيانات بنجاح';
				$activity = array(
						"user_id" 	=> $this->session->userdata("user_id")
					,	"type_id" 	=> 2
					,	"title" 	=> "قام ".$this->session->userdata("user_name")." تغيير كلمة المرور حسابه"
					,	"ip" 		=> $this->input->ip_address()
				);
				$this->db->insert("activites", $activity);
			} else {
				$status = 0;
				$res = 'حدث خطأ ما ، يرجى المحاولة مرة أخرى !!';
			} 
            echo json_encode(array("res"=>$res, "status"=> $status));
		}
	}
	

	function send_msg(){
		echo "Welcome :D <br>"; 
		// API auth credentials
		$apiUser = "Elites";
		$apiPass = "258258";

		// Specify Data 
		# $mobile = "972598416841";
		$mobile = "972594454443";
		$msg = "تم تفعيل حسابكم في نظام ايلتس الالكتروني ";
 
		$query = array(
			'comm'		=> 'sendsms',
			'user' 		=> $apiUser,
			'pass' 		=> $apiPass,
			'to' 		=> $mobile,
			'message'   => $msg,
			'sender'   	=> 'Elites',
		);
		$endpoint = 'http://www.tweetsms.ps/api.php';
		$url = $endpoint . '?' . http_build_query($query);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		$result = curl_exec($ch); 
		curl_close($ch);
 
		if (!$result) {  
			echo "message not sent!"; 
		}	else { 
			echo $result; 
		} 
	}
}
