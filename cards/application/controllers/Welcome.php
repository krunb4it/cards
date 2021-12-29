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
	/*	echo $this->bcrypt->hash_password("123456");
		die;*/
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
	public function no_auth(){ 
		$this->load->view('no_auth');
	}
	public function error404(){ 
		$this->load->view('error404');
	}
	
	public function do_login(){  
		$post = $this->input->post(NULL, TRUE);
		$arr = array(
	        "email"     => $post['email']
		//	"password"	=> $this->bcrypt->hash_password($post['password'])
		);
		$row = $this->db->get_where("users",$arr)->row();
		if(!empty($row)){
			if ($this->bcrypt->check_password($post['password'], $row->password)){
				if($row->user_status == 1){
					$this->config_model->update_token($row->user_id, $this->security->get_csrf_hash(), $post['fmc_token']);
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
	
	function do_noti(){
		$customer_id = 1;
		$title = "شحن المحفظة";
		$body = "تم شحن المحفظة بنجاح ، شكرا لك";
		
		sendNotification($customer_id, $title, $body);
		
		// $this->sendNotification($customer_id, $title, $body);	
	}
	
	public function sendNotification($customer_id, $title, $body){
		
		$customer_token = $this->db->where("customer_id = $customer_id")->get("device")->result();
		$SERVER_API_KEY = 'AAAAS_fUe4M:APA91bFPmqnHL_8pIjeisqkKt1TlU4RfJ0V32igctDispzng6OJ7x1rjR8Dg11SHOhODs3JSnOjJToNqM_UoiiKGrfutXvpx66TP71PJoLFBIOob5JBBGJQZ-lpuG7Gc1PNm0sKRjYLD';
        
		$array = [];
		for($i = 0 ; $i < count($customer_token) ; $i++){
			$array[$i] = $customer_token[$i]->token;
		} 
		$data = [
			"registration_ids" => $array,
            "notification" => [
                "title" => $title,
                "body" => $body,
				'icon'	=> site_url().'assets/images/logo/logo.png',/*Default Icon*/
              	'sound' => 'mySound'/*Default sound*/
            ]
        ];
        $dataString = json_encode($data);
    
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        $response = curl_exec($ch);
		
		echo "<per>";
        var_dump($response);
       // var_dump($customer_token);
    }


	function send_email(){
		$opation = array(
			"subject" => "تغيير كلمة المرور",
			"to" => "a.krunb@hotmail.com", 
			"message" =>  $this->load->view("email_send/profile/change_password","",true)
		);
		$res = SendEmail($opation);
		var_dump($res);
	}	
}


