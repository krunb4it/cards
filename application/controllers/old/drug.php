<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class drug extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
		
		$this->load->model('drug_model');
        $this->load->library("pagination");  
		if($this->session->userdata("is_logging") == false){
			redirect("welcome/login");
		}
    }
	
	public function index(){ 
		$data["language"] = $this->db->get("language")->result();
		$config = array();
        $config["base_url"] = base_url() . "drug/index/";
        $config["total_rows"] = $this->drug_model->get_count();
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
        $data['view'] = $this->drug_model->get_drug($config["per_page"], $page); 

		$data["page"] = "drug/list";
		$this->load->view('include/temp',$data);
	}

	/*------------------------------------------------
		Add Drug Category
	------------------------------------------------*/
	
	public function add(){
		 
		$data["drug_scientific"]	= $this->db->get("drug_scientific")->result();
		$data["drug_disease"] 		= $this->db->get("drug_disease")->result();
		$data["drug_company"] 		= $this->db->get("drug_company")->result();
		$data["drug_category"] 		= $this->db->get("drug_category")->result();
		$data["drug_type"] 			= $this->db->get("drug_type")->result();
		
		$data["language"]			= $this->db->get("language")->result();
		$data["page"] = "drug/add";
		$this->load->view('include/temp',$data);
    }
	
	public function add_drug(){ 
		$post = $this->input->post(null, true); 
		$row = $this->drug_model->add_drug($post);  
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
		Update Drug Category
	------------------------------------------------*/
	
	public function view($drug_id = null){ 
		if($drug_id != null){ 
			$data["drug_scientific"]	= $this->db->get("drug_scientific")->result();
			$data["drug_disease"] 		= $this->db->get("drug_disease")->result();
			$data["drug_company"] 		= $this->db->get("drug_company")->result();
			$data["drug_category"] 		= $this->db->get("drug_category")->result();
			$data["drug_type"] 			= $this->db->get("drug_type")->result();
			
			$data["language"]			= $this->db->get("language")->result(); 
			$data["view"] = $this->drug_model->get_drug_id($drug_id);
			if(!empty($data["view"])){
				$data["page"] = "drug/view";
				$this->load->view('include/temp',$data);
			} else {
				$this->session->set_flashdata("error","خطأ في ادخال البيانات.");
				redirect("drug");
			}
		}
	}
	
	public function edit_drug(){ 
		$post = $this->input->post(null, true); 
		$row = $this->drug_model->edit_drug($post);  
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
		Remove Drug Category
	------------------------------------------------*/
	
	public function remove($drug_id = null){ 
		$row = $this->drug_model->remove_drug($drug_id);
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
