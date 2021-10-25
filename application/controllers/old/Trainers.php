<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trainers extends CI_Controller {
	
    public function __construct() {
        parent::__construct();

		$this->load->model('trainers_model'); 
        $this->load->library("pagination");
		
		if($this->session->userdata("is_logging") == false){
			redirect("welcome/login");
		}
    }
	
	public function index(){ 
		$config = array();
        $config["base_url"] = base_url() . "trainers";
        $config["total_rows"] = $this->trainers_model->get_count();
        $config["per_page"] = 20;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config); 
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data["links"] = $this->pagination->create_links(); 
        $data['view'] = $this->trainers_model->get_trainers($config["per_page"], $page); 

		$data["page"] = "trainers/list";
		$this->load->view('include/temp',$data);
	}

	public function view($trainer_id = null){ 
		if($trainer_id != null){ 
			$data["view"] = $this->trainers_model->get_trainer_id($trainer_id); 
			if(!empty($data["view"])){
				$data["page"] = "trainers/view";
				$this->load->view('include/temp',$data);
			} else{
				redirect("trainers");
			}
		}
	}

	public function add(){ 
		$data["page"] = "trainers/add";
		$this->load->view('include/temp',$data);
    } 
	
	public function remove($topic_id){ 
		$row = $this->db->where("topic_id = $topic_id")->delete("topics");
		if($row == true){
			$status = 1; 
			$res = 'تم حذف البيانات بنجاح';
		} else {
			$status = 0;
			$res = 'حدث خطأ ما ، يرجى المحاولة مرة أخرى !!';
		}
		echo json_encode(array("res"=>$res, "status"=> $status)); 
	}
	 
	/*
		Create topic Page Information ... 
	*/
	 
	public function add_trainers(){ 
		$post = $this->input->post(null, true); 

		$config['upload_path']="./upload/trainers/";
		$config['allowed_types']='gif|jpg|png';
		$config['encrypt_name']= true; 
		$this->load->library('upload',$config); 
		
		$trainer_pic = "";
		
		if($_FILES['trainer_pic']['name'] != ''){
			if($this->upload->do_upload("trainer_pic")){
				$pic = array('upload_data' => $this->upload->data()); 
				$trainer_pic = $config['upload_path'].$pic['upload_data']['file_name']; 
			} else { 
				$status = 0;
				$res = array('error' => $this->upload->display_errors());
				echo json_encode(array("res"=> $res, "status"=> $status)); 
				die;
			}
		} 
		$row = $this->trainers_model->add_trainer($post, $trainer_pic);  
		if($row == true){
			$status = 1; 
			$res = 'تم حفظ البيانات بنجاح';
		} else {
			$status = 0;
			$res = 'حدث خطأ ما ، يرجى المحاولة مرة أخرى !!';
		}
		echo json_encode(array("res"=>$res, "status"=> $status)); 
    }

	public function edit_trainers(){ 
		$post = $this->input->post(null, true); 

		$config['upload_path']="./upload/trainers/";
		$config['allowed_types']='gif|jpg|png';
		$config['encrypt_name']= true; 
		$this->load->library('upload',$config); 
		
		$trainer_pic = "";
		
		if($_FILES['trainer_pic']['name'] != ''){
			if($this->upload->do_upload("trainer_pic")){
				$pic = array('upload_data' => $this->upload->data()); 
				$trainer_pic = $config['upload_path'].$pic['upload_data']['file_name']; 
			} else { 
				$status = 0;
				$res = array('error' => $this->upload->display_errors());
				echo json_encode(array("res"=> $res, "status"=> $status)); 
				die;
			}
		} else {
			$trainer_pic = $post["last_trainer_pic"];
		} 
		$row = $this->trainers_model->edit_trainer($post, $trainer_pic);  
		if($row == true){
			$status = 1; 
			$res = 'تم حفظ البيانات بنجاح';
		} else {
			$status = 0;
			$res = 'حدث خطأ ما ، يرجى المحاولة مرة أخرى !!';
		}
		echo json_encode(array("res"=>$res, "status"=> $status)); 
    }
}
