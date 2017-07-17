<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends ST_Controller {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		redirect();
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
