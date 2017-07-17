<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stories extends ST_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('Master_mod'));
	}
	
	public function index()
	{
		redirect();
	}
	
	public function detail($slug = null)
	{	
		if(! $slug){
			redirect();
		}
		
		//Check data 404
		$detail = $this->Master_mod->detail_content_slug($slug, 'stories');
		if(! $detail){
			$data = array(
				'meta_title' => translation('title_404'),
				'meta_description' => translation('title_404'),
				'meta_picture' => '',
				'meta_tags' => '404',
			);
			
			$this->render(array('404_notfound'), $data, 0);
		}else{
			$data = array(
				'meta_title' => $detail->title,
				'meta_description' => $detail->teaser,
				'meta_picture' => base_url('storage/content/'.$detail->cover),
				'meta_tags' => '',
				'detail' => $detail,
				'gallery' => $this->Master_mod->result_media($detail->content_id),
				'related' => $this->Master_mod->result_content(3, 0, array('content_type' => 'stories', 'ex_content_id' => $detail->content_id)),
			);
			
			//Update counter view
			$this->db->where(array('content_id' => $detail->content_id))->set('viewed','viewed+1', FALSE)->update('content');
			
			$this->render(array('article/detail'), $data, 0);
		}
	}
}