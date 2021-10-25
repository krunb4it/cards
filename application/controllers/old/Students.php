<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Students extends CI_Controller {
	
    public function __construct() {
        parent::__construct();

		$this->load->model('students_model');
		$this->load->model('welcome_model');
        $this->load->library("pagination");
		
		if($this->session->userdata("is_logging") == false){
			redirect("welcome/login");
		}
    }
	
	public function index(){ 
		$config = array();
        $config["base_url"] = base_url() . "students";
        $config["total_rows"] = $this->students_model->get_count();
        $config["per_page"] = 20;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config); 
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data["links"] = $this->pagination->create_links(); 
        $data['view'] = $this->students_model->get_students($config["per_page"], $page); 

		$data["page"] = "students/list";
		$this->load->view('include/temp',$data);
	}

	public function view($student_id = null){ 
		if($student_id != null){
			$data["qualifications"] = $this->welcome_model->get_qualifications();
			$data["city"] = $this->welcome_model->get_city(); 
			$data["view"] = $this->students_model->get_student_id($student_id);
			$data["msg_history"] = $this->students_model->msg_history($student_id );
			if(!empty($data["view"])){
				$data["page"] = "students/view";
				$this->load->view('include/temp',$data);
			} else{
				redirect("students");
			}
		}
	}

	public function add(){ 
		$data["qualifications"] = $this->welcome_model->get_qualifications();
		$data["city"] = $this->welcome_model->get_city();
		
		$data["page"] = "students/add";
		$this->load->view('include/temp',$data);
    } 
	
	public function remove($topic_id){
		if($this->session->userdata("is_logging") == false){
			$this->load->view('back/login');
		} else {  
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
	}
	 
	/*
		Create topic Page Information ... 
	*/
	 
	public function add_students(){ 
		$post = $this->input->post(null, true); 

		$config['upload_path']="./upload/student/";
		$config['allowed_types']='gif|jpg|png';
		$config['encrypt_name']= true; 
		$this->load->library('upload',$config); 
		
		$student_pic = "";
		
		if($_FILES['student_pic']['name'] != ''){
			if($this->upload->do_upload("student_pic")){
				$pic = array('upload_data' => $this->upload->data()); 
				$student_pic = $config['upload_path'].$pic['upload_data']['file_name']; 
			} else { 
				$status = 0;
				$res = array('error' => $this->upload->display_errors());
				echo json_encode(array("res"=> $res, "status"=> $status)); 
				die;
			}
		} 
		$row = $this->students_model->add_student($post, $student_pic);  
		if($row == true){
			$status = 1; 
			$res = 'تم حفظ البيانات بنجاح';
		} else {
			$status = 0;
			$res = 'حدث خطأ ما ، يرجى المحاولة مرة أخرى !!';
		}
		echo json_encode(array("res"=>$res, "status"=> $status)); 
    }

	public function edit_students(){ 
		$post = $this->input->post(null, true); 

		$config['upload_path']="./upload/student/";
		$config['allowed_types']='gif|jpg|png';
		$config['encrypt_name']= true; 
		$this->load->library('upload',$config); 
		
		$student_pic = "";
		
		if($_FILES['student_pic']['name'] != ''){
			if($this->upload->do_upload("student_pic")){
				$pic = array('upload_data' => $this->upload->data()); 
				$student_pic = $config['upload_path'].$pic['upload_data']['file_name']; 
			} else { 
				$status = 0;
				$res = array('error' => $this->upload->display_errors());
				echo json_encode(array("res"=> $res, "status"=> $status)); 
				die;
			}
		} else {
			$student_pic = $post["last_student_pic"];
		} 
		$row = $this->students_model->edit_student($post, $student_pic);  
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
