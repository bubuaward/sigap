<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Redirection extends ST_Controller {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		redirect();
	}
	
	public function detail($slug = null)
	{
		if(! $slug){ redirect(); }
		
		$check = $this->db->limit(1)->get_where('redirection', array('from_url' => $slug))->row();
		if($check){
			//Tracking
			$this->db->where(array('from_url' => $slug))->set('clicked','clicked+1', FALSE)->update('redirection');
			
			redirect(prep_url($check->to_url));
		}
		
		redirect();
	}
	
	public function banner($slug = null)
	{
		if(! $slug){ echo 'No image';  }
		
		$check = $this->db->limit(1)->get_where('campaign_banner', array('cover' => $slug))->row();
		if($check){
			$filename = APPPATH . "../storage/campaign_banner/".$check->cover;
			if(file_exists($filename)){
				//Tracking
				$this->db->where(array('cover' => $slug))->set('viewed','viewed+1', FALSE)->update('campaign_banner');
				ob_end_clean();
				$this->output
					->set_status_header(200)					
					->set_header('Content-Length: '.filesize($filename))
					->set_header('Content-Disposition: inline; filename="'.$check->cover.'";')
					->set_header('Expires: Sat, 26 Jul 2020 05:00:00 GMT')
					->set_content_type(get_mime_by_extension($check->cover))
					->set_output(file_get_contents($filename))
					->_display();
				exit;
			}
		}
		
		echo 'No image';
	}
}
