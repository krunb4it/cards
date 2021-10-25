<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Drug_type extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
		
		$this->load->model('drug_type_model');
        $this->load->library("pagination");  
		if($this->session->userdata("is_logging") == false){
			redirect("welcome/login");
		}
    }
	
	public function index(){ 
		$data["language"] = $this->db->get("language")->result();
		$config = array();
        $config["base_url"] = base_url() . "drug_type/index/";
        $config["total_rows"] = $this->drug_type_model->get_count();
        $config["per_page"] = 20;
        $config["uri_segment"] = 3;
		
		$config['full_tag_open'] = "<ul class='pagination pagination-primary'>";
		$config['full_tag_close'] = '</ul>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';

		$config['prev_link'] = '<i class="fa fa-long-arrow-left"></i> السابق';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';


		$config['next_link'] = 'التالي <i class="fa fa-long-arrow-right"></i>';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';
		
        $this->pagination->initialize($config); 
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data["links"] = $this->pagination->create_links(); 
        $data['view'] = $this->drug_type_model->get_drug_type($config["per_page"], $page); 

		$data["page"] = "drug_type/list";
		$this->load->view('include/temp',$data);
	}

	/*------------------------------------------------
		Add Drug type
	------------------------------------------------*/
	
	public function add(){
		$data["language"] = $this->db->get("language")->result();
		$data["page"] = "drug_type/add";
		$this->load->view('include/temp',$data);
    }
	
	public function add_drug_type(){ 
		$post = $this->input->post(null, true); 
		$row = $this->drug_type_model->add_drug_type($post);  
		if($row == true){
			$status = 1; 
			$res = 'تم حفظ البيانات بنجاح';
		} else {
			$status = 0;
			$res = 'حدث خطأ ما ، يرجى المحاولة مرة أخرى !!';
		}
		echo json_encode(array("res"=>$res, "status"=> $status)); 
    } 
	
	/*------------------------------------------------
		Update Drug type
	------------------------------------------------*/
	
	public function view($drug_type_id = null){ 
		if($drug_type_id != null){
			$data["language"] = $this->db->get("language")->result();
			$data["view"] = $this->drug_type_model->get_drug_type_id($drug_type_id);
			if(!empty($data["view"])){
				$data["page"] = "drug_type/view";
				$this->load->view('include/temp',$data);
			} else {
				$this->session->set_flashdata("error","خطأ في ادخال البيانات.");
				redirect("drug_type");
			}
		}
	}
	
	public function edit_drug_type(){ 
		$post = $this->input->post(null, true); 
		$row = $this->drug_type_model->edit_drug_type($post);  
		if($row == true){
			$status = 1; 
			$res = 'تم حفظ البيانات بنجاح';
		} else {
			$status = 0;
			$res = 'حدث خطأ ما ، يرجى المحاولة مرة أخرى !!';
		}
		echo json_encode(array("res"=>$res, "status"=> $status)); 
    } 
	
	/*------------------------------------------------
		Remove Drug type
	------------------------------------------------*/
	
	public function remove($drug_type_id = null){ 
		$row = $this->drug_type_model->remove_drug_type($drug_type_id);
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
