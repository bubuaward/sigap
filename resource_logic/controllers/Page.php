<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends ST_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('Master_mod'));
	}
	
	public function index()
	{
		redirect();
	}
	
	public function about()
	{
		$data = array(
			'meta_title' => translation('page_about_title'),
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => '',
			'video' => $this->db->order_by('media_id', 'DESC')->limit(1)->get_where('video', array('content_type' => 'about'))->row(),
			'gallery' => $this->Master_mod->all_media(60),
			'sosialmedia' => array(),
		);
		
		$this->render(array('staticpage/about','social_media'), $data, 0);
	}
	
	public function mitraalam()
	{
		$data = array(
			'meta_title' => translation('page_mitra_alam_title'),
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => '',
			'video' => $this->db->order_by('media_id', 'DESC')->limit(1)->get_where('video', array('content_type' => 'about'))->row(),
			'gallery' => $this->Master_mod->all_media(60),
			'partnership' => $this->db->get_where('partnership', array('contact_view' => 'true'))->result(),
			'mitraalam' => $this->db->get_where('partnership', array('contact_view' => 'false'))->result(),
		);
		
		$this->render(array('staticpage/mitraalam','contact_form'), $data, 0);
	}
	
	public function tnc()
	{
		$data = array(
			'meta_title' => translation('page_term_and_condition_title'),
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => '',
		);
		
		$this->render(array('staticpage/tnc'), $data, 0);
	}
	
	public function policy()
	{
		$data = array(
			'meta_title' => translation('kebijakan-privasi'),
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => '',
		);
		
		$this->render(array('staticpage/policy'), $data, 0);
	}
}
