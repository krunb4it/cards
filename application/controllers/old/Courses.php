<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Courses extends CI_Controller {
	
    public function __construct() {
        parent::__construct();

		$this->load->model('welcome_model');
		$this->load->model('courses_model');
		$this->load->model('students_model');
		$this->load->model('trainers_model');
        $this->load->library("pagination");
		
		if($this->session->userdata("is_logging") == false){
			redirect("welcome/login");
		}
    }
	
	public function index(){
		$this->courses_available();
		/*
			$data['view'] = $this->courses_model->get_courses();
			$data["page"] = "courses/list";
			$this->load->view('include/temp',$data);
		*/
	}

	public function view($course_id = null){ 
		if($course_id != null){
			$data["view"] = $this->courses_model->get_student_id($courses_id); 
			if(!empty($data["view"])){
				$data["page"] = "courses/view";
				$this->load->view('include/temp',$data);
			} else{
				redirect("courses");
			}
		}
	}

	public function add(){
		$data["page"] = "courses/add";
		$this->load->view('include/temp',$data);
    }
	 
	public function add_courses(){ 
		$post = $this->input->post(null, true);  
		$row = $this->courses_model->add_course($post);  
		if($row == true){
			$status = 1; 
			$res = 'تم حفظ البيانات بنجاح';
		} else {
			$status = 0;
			$res = 'حدث خطأ ما ، يرجى المحاولة مرة أخرى !!';
		}
		echo json_encode(array("res"=>$res, "status"=> $status)); 
    } 
	public function edit_courses(){ 
		$post = $this->input->post(null, true);
		$row = $this->courses_model->edit_course($post);  
		if($row == true){
			$status = 1; 
			$res = 'تم حفظ البيانات بنجاح';
		} else {
			$status = 0;
			$res = 'حدث خطأ ما ، يرجى المحاولة مرة أخرى !!';
		}
		echo json_encode(array("res"=>$res, "status"=> $status)); 
    }

	/*
		courses_available
	*/

	function courses_available(){
		$data["view"] = $this->courses_model->get_courses_available();
		$data["page"] = "courses/courses_available/list";
		$this->load->view('include/temp',$data);
	}
	function view_courses_available($courses_available_id){ 
		$data["city"] 		= $this->welcome_model->get_city();
		$data["day"] 		= $this->welcome_model->get_day();
		$data["trainers"] 	= $this->trainers_model->get_all_trainers();

		$data["dates"] 		= $this->courses_model->get_courses_available_dates($courses_available_id);
		$data["students"] 	= $this->courses_model->get_courses_students($courses_available_id);
		$data["view"] 		= $this->courses_model->view_courses_available($courses_available_id);

		$data["page"] = "courses/courses_available/view";
		$this->load->view('include/temp',$data);
	}
	function new_courses_available(){
		$data["city"] 		= $this->welcome_model->get_city();
		$data["day"] 		= $this->welcome_model->get_day();
		$data["trainers"] 	= $this->trainers_model->get_all_trainers();
		$data["courses"] 	= $this->courses_model->get_all_courses();
		$data["page"] 		= "courses/courses_available/add";
		$this->load->view('include/temp',$data);
	}
	
	function get_courses_levels($course_id){
		$data = $this->courses_model->get_courses_levels($course_id);
		if(!empty($data)){
			$row = '';
			foreach($data as $d){
				$row .='<option value="'. $d->level_id .'">'. $d->level_name .'</option>';
			}
			echo $row;
		} else {
			echo null;
		}
	}

	public function add_courses_available(){  
		$post = $this->input->post(null, true);  
		
		$course_day			= $this->input->post("course_day", true);
		$course_from_time	= $this->input->post("course_from_time", true);
		$course_to_time		= $this->input->post("course_to_time", true);
		 
		$row = $this->courses_model->add_courses_available($post); 

		if($row != false){ 
            for($i=0; $i < count($course_day); $i++){
                $day = array(
                    "course_available_id"   => $row,
                    "course_day"            => $course_day[$i],
                    "course_from_time"      => $course_from_time[$i],
                    "course_to_time"        => $course_to_time[$i]
                );
				$this->courses_model->add_courses_dates($day); 
            }

			$status = 1; 
			$res = 'تم حفظ البيانات بنجاح';
		} else {
			$status = 0;
			$res = 'حدث خطأ ما ، يرجى المحاولة مرة أخرى !!';
		}
		echo json_encode(array("res"=>$res, "status"=> $status)); 
    } 

	public function edit_courses_available(){  
		$post = $this->input->post(null, true);
		 
		$row = $this->courses_model->edit_courses_available($post);  
		if($row != false){
			$status = 1; 
			$res = 'تم حفظ البيانات بنجاح';
		} else {
			$status = 0;
			$res = 'حدث خطأ ما ، يرجى المحاولة مرة أخرى !!';
		}
		echo json_encode(array("res"=>$res, "status"=> $status)); 
    } 


	/********************************************************
        dates courses
    *********************************************************/
	
	public function get_courses_available_dates($courses_available_id){ 
		$data["dates"]	= $this->courses_model->get_courses_available_dates($courses_available_id); 
		$data["view"]	= $this->courses_model->view_courses_available($courses_available_id);
		$data["day"]	= $this->welcome_model->get_day();
		$data["page"]	= "courses/courses_available/dates";
		$this->load->view('include/temp',$data);
    }
	public function get_courses_available_dates_id($course_date_id){
		$data["view"]	= $this->courses_model->get_courses_available_dates_id($course_date_id); 
		$data["day"]	= $this->welcome_model->get_day();
		$this->load->view('courses/courses_available/dates_view',$data);
    }

	public function add_courses_dates(){  
		$post = $this->input->post(null, true);   
		$course_day			= $this->input->post("course_day", true);
		$course_from_time	= $this->input->post("course_from_time", true);
		$course_to_time		= $this->input->post("course_to_time", true); 
		
		for($i=0; $i < count($course_day); $i++){
			$day = array(
				"course_available_id"   => $post["course_available_id"],
				"course_day"            => $course_day[$i],
				"course_from_time"      => $course_from_time[$i],
				"course_to_time"        => $course_to_time[$i]
			);
			$row = $this->courses_model->add_courses_dates($day); 
		}
		if($row != false){ 
			$status = 1; 
			$res = 'تم حفظ البيانات بنجاح';
		} else {
			$status = 0;
			$res = 'حدث خطأ ما ، يرجى المحاولة مرة أخرى !!';
		}
		echo json_encode(array("res"=>$res, "status"=> $status)); 
    } 

	public function edit_courses_dates(){  
		$post = $this->input->post(null, true);
		$row = $this->courses_model->edit_courses_dates($post); 
		if($row != false){ 
			$status = 1; 
			$res = 'تم حفظ البيانات بنجاح';
		} else {
			$status = 0;
			$res = 'حدث خطأ ما ، يرجى المحاولة مرة أخرى !!';
		}
		echo json_encode(array("res"=>$res, "status"=> $status)); 
    }

	public function remove_courses_dates(){  
		$post = $this->input->post(null, true);
		$row = $this->courses_model->remove_courses_dates($post["course_date_id"]); 
		if($row != false){ 
			$status = 1; 
			$res = 'تم حفظ البيانات بنجاح';
		} else {
			$status = 0;
			$res = 'حدث خطأ ما ، يرجى المحاولة مرة أخرى !!';
		}
		echo json_encode(array("res"=>$res, "status"=> $status)); 
    }

	/********************************************************
        Studetns Courses
    *********************************************************/
	
	public function get_courses_students($courses_available_id){
		$data["students"]	= $this->courses_model->get_courses_students($courses_available_id);
		$data["view"]	= $this->courses_model->view_courses_available($courses_available_id); 
		$data["page"]	= "courses/courses_available/students";
		$this->load->view('include/temp',$data);
    }

	public function add_student_to_courses(){  
		$post = $this->input->post(null, true);
		$is_reg = $this->courses_model->student_is_reg_courses($post['student_id'], $post['courses_available_id']);  
		if($is_reg == false){
			$row = $this->courses_model->add_student_to_courses($post);  
			if($row != false){ 
				$status = 1; 
				$res = 'تم اضافة الطالب بنجاح';
			} else {
				$status = 0;
				$res = 'حدث خطأ ما ، يرجى المحاولة مرة أخرى !!';
			}
		} else {
			$status = 0;
			$res = 'هذا الطلب مسجل في الدورة ، يرجى التأكد من البيانات المدخلة';
		}  
		echo json_encode(array("res"=>$res, "status"=> $status)); 
    } 
 
	public function remove_student_from_course(){  
		$post = $this->input->post(null, true);
		$row = $this->courses_model->remove_student_from_course($post["course_student_id"]); 
		if($row != false){ 
			$status = 1; 
			$res = 'تم حذف الطالب من الدورة بنجاح';
		} else {
			$status = 0;
			$res = 'حدث خطأ ما ، يرجى المحاولة مرة أخرى !!';
		}
		echo json_encode(array("res"=>$res, "status"=> $status)); 
    }

	

	/********************************************************
        Payments Courses
    *********************************************************/
	
	public function get_courses_payments($courses_available_id){
		$data["payments"]	= $this->courses_model->get_courses_payments($courses_available_id);
		$data["view"]	= $this->courses_model->view_courses_available($courses_available_id); 
		$data["page"]	= "courses/courses_available/payments";
		$this->load->view('include/temp',$data);
    }
}
