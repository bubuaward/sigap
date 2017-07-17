<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Program extends ST_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('Master_mod'));
	}
	
	public function index()
	{
		//pagination
		$page   = (is_numeric($this->input->get('halaman')) ? (int)$this->input->get('halaman') : 1);
		$limit  = 9;
		$offset = ($page-1) * $limit;
		
		$config = array(
			'base_url'         => base_url('program'),
			'page_query_string'=> true,
			'query_string_segment'=> 'halaman',
			'num_links'        => 5,
			'total_rows'       => $this->Master_mod->result_content(NULL, 0, array('content_type' => 'program')),
			'per_page'         => $limit,
			'use_page_numbers' => TRUE,
			'full_tag_open'    => '<ul>',
			'first_link'       => '&lt;&lt;',
			'first_tag_open'   => '<li>',
			'first_tag_close'  => '</li>',
			'last_link'        => '&gt;&gt;',
			'last_tag_open'    => '<li>',
			'last_tag_close'   => '</li>',
			'next_link'        => '&gt;',
			'next_tag_open'    => '<li>',
			'next_tag_close'   => '</li>',
			'prev_link'        => '&lt;',
			'prev_tag_open'    => '<li>',
			'prev_tag_close'   => '</li>',
			'num_tag_open'     => '<li>',
			'num_tag_close'    => '</li>',
			'cur_tag_open'     => '<li class="current"><a href="javascript:;">',
			'cur_tag_close'    => '</a></li>',
			'full_tag_close'   => '</ul>'
		);
		$this->pagination->initialize($config);
		
		$data = array(
			'meta_title' => translation('page_program_title'),
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => '',
			'alldata' => $this->Master_mod->result_content($limit, $offset, array('content_type' => 'program')),
		);
		
		$this->render(array('program/home'), $data, 0);
	}
	
	public function detail($slug = null)
	{	
		if(! $slug){
			redirect();
		}
		
		//Category Or Detail Program
		//Check Category
		$detail = $this->Master_mod->detail_category_slug($slug);
		if($detail){
			//pagination
			$page   = (is_numeric($this->input->get('halaman')) ? (int)$this->input->get('halaman') : 1);
			$limit  = 9;
			$offset = ($page-1) * $limit;
			
			$config = array(
				'base_url'         => base_url('program/'.$slug),
				'page_query_string'=> true,
				'query_string_segment'=> 'halaman',
				'num_links'        => 5,
				'total_rows'       => $this->Master_mod->result_content(NULL, 0, array('content_type' => 'program', 'category_id' => $detail->category_id)),
				'per_page'         => $limit,
				'use_page_numbers' => TRUE,
				'full_tag_open'    => '<ul>',
				'first_link'       => '&lt;&lt;',
				'first_tag_open'   => '<li>',
				'first_tag_close'  => '</li>',
				'last_link'        => '&gt;&gt;',
				'last_tag_open'    => '<li>',
				'last_tag_close'   => '</li>',
				'next_link'        => '&gt;',
				'next_tag_open'    => '<li>',
				'next_tag_close'   => '</li>',
				'prev_link'        => '&lt;',
				'prev_tag_open'    => '<li>',
				'prev_tag_close'   => '</li>',
				'num_tag_open'     => '<li>',
				'num_tag_close'    => '</li>',
				'cur_tag_open'     => '<li class="current"><a href="javascript:;">',
				'cur_tag_close'    => '</a></li>',
				'full_tag_close'   => '</ul>'
			);
			$this->pagination->initialize($config);
			
			$data = array(
				'meta_title' => $detail->title,
				'meta_description' => $detail->description,
				'meta_picture' => base_url('storage/category/'.$detail->cover),
				'meta_tags' => '',
				'detail' => $detail,
				'alldata' => $this->Master_mod->result_content($limit, $offset, array('content_type' => 'program', 'category_id' => $detail->category_id)),
			);
			
			$this->render(array('program/category'), $data, 0);
		}else{
			//Detail Program
			//Check data 404
			$detail = $this->Master_mod->detail_content_slug($slug, 'program');
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
					'related' => $this->Master_mod->result_content(3, 0, array('content_type' => 'program', 'ex_content_id' => $detail->content_id, 'category_id' => $detail->category_id)),
				);
				
				//Update counter view
				$this->db->where(array('content_id' => $detail->content_id))->set('viewed','viewed+1', FALSE)->update('content');
				
				$this->render(array('program/detail'), $data, 0);
			}
		}
	}
}