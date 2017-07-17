<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setlang extends ST_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('Master_mod'));
	}
	
	public function index()
	{
		redirect();
	}
	
	public function to($slug = null)
	{
		if($slug){
			$slug = strtolower($slug);
			$lang = $this->db->limit(1)->get_where('master_language', array('language_slug' => $slug))->row();
			if($lang){
				$this->session->set_userdata('current_lang', $slug);
				$this->_setTranslation($this->session->userdata('current_lang'));
			}
		}
		
		if($slug == 'id'){
			$slug = '';
		}
		
		if($this->input->get('ref')){
			//check language
			$oldslug = substr($this->input->get('ref'),0,2);
			if(in_array($oldslug, $this->session->userdata('masterlanguage'))){
				redirect(reduce_double_slashes($slug.'/'.substr_replace($this->input->get('ref'), '', 0, 2)));
			}else{
				redirect(reduce_double_slashes($slug.'/'.$this->input->get('ref')));
			}
		}else{
			if($slug != 'id'){
				redirect($slug);
			}else{
				redirect();
			}
		}
	}
}
