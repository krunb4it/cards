<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Drug_company extends CI_Controller {
	
    public function __construct(){
        parent::__construct();
		
		$this->load->model('drug_company_model');
        $this->load->library("pagination");  
		if($this->session->userdata("is_logging") == false){
			redirect("welcome/login");
		}
    }
	
	public function index(){ 
		$data["language"] = $this->db->get("language")->result();
		$config = array();
        $config["base_url"] = base_url() . "drug_company/index/";
        $config["total_rows"] = $this->drug_company_model->get_count(); 
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
        $data['view'] = $this->drug_company_model->get_drug_company($config["per_page"], $page); 

		$data["all_company"] = $this->drug_company_model->get_count();
		$data["active_company"] = $this->drug_company_model->get_active_company();
		$data["inactive_company"] = $this->drug_company_model->get_inactive_company();
		
		$data["page"] = "drug_company/list";
		$this->load->view('include/temp',$data);
	}

	/*------------------------------------------------
		Add Drug company
	------------------------------------------------*/
	
	public function add(){
		$data["language"] = $this->db->get("language")->result();
		$data["page"] = "drug_company/add";
		$this->load->view('include/temp',$data);
    }
	
	public function add_drug_company(){ 
		$post = $this->input->post(null, true); 
		if(!empty($post)){
			$row = $this->drug_company_model->add_drug_company($post);  
			if($row == true){
				$status = 1; 
				$res = 'تم حفظ البيانات بنجاح';
			} else {
				$status = 0;
				$res = 'حدث خطأ ما ، يرجى المحاولة مرة أخرى !!';
			}
		} else {
			$status = 0;
			$res = 'يرجى ادخال البيانات المطلوبة';
		}
		echo json_encode(array("res"=>$res, "status"=> $status)); 
    } 
	
	/*------------------------------------------------
		Update Drug company
	------------------------------------------------*/
	
	public function view($drug_company_id = null){ 
		if($drug_company_id != null){
			$data["language"] = $this->db->get("language")->result();
			$data["view"] = $this->drug_company_model->get_drug_company_id($drug_company_id);
			if(!empty($data["view"])){
				$data["page"] = "drug_company/view";
				$this->load->view('include/temp',$data);
			} else {
				$this->session->set_flashdata("error","خطأ في ادخال البيانات.");
				redirect("drug_company");
			}
		}
	}
	
	public function edit_drug_company(){ 
		$post = $this->input->post(null, true); 
		$row = $this->drug_company_model->edit_drug_company($post);  
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
		Remove Drug company
	------------------------------------------------*/
	
	public function remove($drug_company_id = null){ 
		$row = $this->drug_company_model->remove_drug_company($drug_company_id);
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
