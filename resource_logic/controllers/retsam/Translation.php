<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Translation extends ST_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('Master_mod'));
	}
	
	public function index()
	{
		redirect(DIRADMIN.'/'.$this->router->fetch_class().'/home');
	}
	
	public function home()
	{
		$result = $this->db->order_by('variable_sitemap, language_slug', 'ASC')->get('sitemap_translation')->result();
		
		if($this->input->post('form_submit')){
			$post = $this->input->post();
			
			$info = array();
			foreach($post AS $id => $red){
				$info[] = array(
					'sitemap_id' => $id,
					'word' => $red,
				);
			}
			
			if($this->db->update_batch('sitemap_translation', $info, 'sitemap_id')){
				$this->session->set_flashdata('msg', 'The process was successful');
			}else{
				$this->session->set_flashdata('msg', 'Change a few things up and try submitting again.');
			}
			
			redirect(DIRADMIN.'/'.$this->router->fetch_class().'/home');
		}
		
		$data = array(
			'meta_title' => 'Translation',
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => '',
			'result' => $result,
		);
		
		$this->display(array('main_header','translation/home','main_footer'), $data, 0);
	}
}
