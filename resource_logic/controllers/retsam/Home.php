<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends ST_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('Master_mod'));
	}
	
	public function index()
	{
		$data = array(
			'meta_title' => 'Homepage',
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => '',
		);
		
		$this->display(array('main_header','home','main_footer'), $data, 0);
	}
}
