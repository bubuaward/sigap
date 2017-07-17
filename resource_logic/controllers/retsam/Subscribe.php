<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscribe extends ST_Controller {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		redirect(DIRADMIN.'/'.$this->router->fetch_class().'/home');
	}
	
	public function home()
	{
		$data = array(
			'meta_title' => 'Subscriber',
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => ''
		);
		
		$this->display(array('main_header','subscribe/home','main_footer'), $data, 0);
	}
	
	public function ajax_master_datatable()
	{
		if (! $this->input->is_ajax_request()) { die('denied!'); }
		
		$this->datatables->select('subscribe_id, email, phone, city, created, ip');	
		$this->datatables->from('subscribe');
		echo $this->datatables->generate();
	}
	
}
