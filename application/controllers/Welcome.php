<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
    
    public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');  
		$this->load->model('welcome_model');
		$this->load->model('config_model');
	}
	
	public function index(){
		if($this->session->userdata("is_logging") == false){
			redirect("welcome/login");
		} else {
    		$data["page"] = "index";
    		$this->load->view('include/temp',$data);  
    	}
	}
	
	public function login(){ 
		$this->load->view('login');
	}
	public function error404(){ 
		$this->load->view('error404');
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
	function send_msg(){
		$post = $this->input->post(NULL, TRUE);
		// API auth credentials
		$apiUser = "Elites";
		$apiPass = "258258";

		// Specify Data
		$mobile = $post["mobile"];
		$msg =  $post["msg"];
 
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
			$this->welcome_model->msg_history($post);
			echo $result; 
		} 
	}
*/

	 

	function crop_image(){
		if(isset($_POST["image"])){
			$data = $_POST["image"];
			$image_array_1 = explode(";", $data);
			
			$image_array_2 = explode(",", $image_array_1[1]);
			
			$data = base64_decode($image_array_2[1]);
			
			$imageName = "upload/". $_POST["folder"] ."/". md5(time()) . '.png';
			file_put_contents($imageName, $data);

			echo '<img data-url="'.$imageName.'" src="'.site_url().$imageName.'" class="img-fluid">';
		}
	}

	function sendMail($email_name, $to, $subject){
		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 587,
			'smtp_user' => 'alaa.krunb@gmail.com', // change it to yours
			'smtp_pass' => '411918139', // change it to yours
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'wordwrap' => TRUE
		);

		$this->load->library('email', $config); 
		
		$message =  $this->load->view("email_send/profile/change_email","",true);

		$this->email->set_header('Content-Type', 'text/html');
		$this->email->set_newline("\r\n");
		$this->email->from('alaa.krunb@gmail.com',"krunb4it");
		$this->email->to('a.krunb@hotmail.com');
		$this->email->subject('تغيير البريد الالكتروني');
		$this->email->message($message);
		$this->email->set_mailtype("html");

		if($this->email->send()) {
			echo 'Email sent.';
		} else {
			show_error($this->email->print_debugger());
		} 
	} 
}


