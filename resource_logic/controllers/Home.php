<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends ST_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('Master_mod'));
	}
	
	public function index()
	{	//$this->output->enable_profiler(TRUE);
		
		//List program by category featured
		$featured_program = $this->Master_mod->result_category();
		if($featured_program){
			foreach($featured_program AS &$red){
				$red->program_list = $this->Master_mod->result_content(3, 0, array('content_type' => 'program', 'category_id' => $red->category_id));
			}
		}
		
		//Article Featured Stories
		//$featured_stories = $this->Master_mod->result_content(10, 0, array('content_type' => 'stories'));
		$featured_stories = $this->Master_mod->result_content(10, 0, array('content_type' => 'article'));
		
		//Artikel Featured 1
		$featured_article = $this->Master_mod->result_content(1, 0, array('content_type' => 'article', 'featured' => TRUE));
		
		//Latest Article 2
		$latest_article = $this->Master_mod->result_content(2, 0, array('content_type' => 'article'));
		
		//Most View Article 4
		$mostview_article = $this->Master_mod->result_content(4, 0, array('content_type' => 'article', 'viewed' => TRUE));
		
		$data = array(
			'meta_title' => '',
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => '',
			'active_homeslider' => $this->Master_mod->result_homeslider(5),
			'partnership' => $this->db->get_where('partnership', array('contact_view' => 'true'))->result(),
			'featured_program' => $featured_program,
			'featured_stories' => $featured_stories,
			'featured_article' => $featured_article,
			'latest_article' => $latest_article,
			'mostview_article' => $mostview_article,
		);
		
		$this->render(array('home','social_media','contact_form'), $data, 0);
		
		//$this->render(array('home','contact_form'), $data, 0);

	}
	
	public function notfound()
	{
		$data = array(
			'meta_title' => translation('title_404'),
			'meta_description' => translation('title_404'),
			'meta_picture' => '',
			'meta_tags' => '404',
		);
		
		$email = $this->input->get('email');
		if($email){
			$this->_sendtoEmail('test_debug', $email, array('title' => 'Testing SMTP YKAN', 'message' => 'Isi testing dikirim pada '.date('Y-m-d H:i:s')));
		}
		
		$this->render(array('404_notfound'), $data, 0);
	}
	
	public function translation()
	{
		$data = array(
			'meta_title' => translation('translation_404'),
			'meta_description' => translation('translation_404'),
			'meta_picture' => '',
			'meta_tags' => '404',
		);
		
		$this->render(array('404_translation'), $data, 0);
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		$this->output->set_header('cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header("cache-Control: post-check=0, pre-check=0", false);
		$this->output->set_header("Pragma: no-cache");
		$this->output->set_header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
		redirect();
	}
}
