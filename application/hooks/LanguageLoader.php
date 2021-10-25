<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class LanguageLoader{
   function initialize() {
       $ci =& get_instance();
       $ci->load->helper('language');
       $lang = $ci->session->userdata('lang');
       $main_lang = $ci->db->get_where("config","id = 1")->row()->main_lang;
       if ($lang) {
           $ci->lang->load('information',$lang);
       } else {
           $ci->lang->load('information', $main_lang);
       }
   }
} 