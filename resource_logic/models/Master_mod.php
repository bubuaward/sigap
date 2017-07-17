<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_mod extends CI_Model {

	function __construct(){
		parent::__construct();
	}
	
	function detail_member($cid = null){
		if(! $cid){ return FALSE; }
		
		return $this->db->limit(1)->get_where('member', array('member_id' => $cid))->row();
	}
	
	//detail WEB
	function detail_content_slug($slug = null, $content_type = null){
		if(!$slug || !$content_type){ return FALSE; }
		
		$this->db->select('content.*');
		$this->db->select('content_translation.*');
		$this->db->select('member.fullname, member.avatar');
		
		if($content_type == 'program'){
			$this->db->select('master_geography.geography_name AS geography_name');
			$this->db->select('master_location.location_name AS location_name');
			$this->db->join('master_geography', 'master_geography.geography_id = content.geography_id', 'inner');
			$this->db->join('master_location', 'master_location.location_id = content.location_id', 'inner');
		}
		
		$this->db->join('content_translation', 'content_translation.content_id = content.content_id', 'inner');
		$this->db->join('member', 'member.member_id = content.created_by', 'inner');
		$this->db->where(array('content.content_type' => $content_type, 'content.slug' => $slug, 'content_translation.language_slug' => $this->session->userdata('current_lang')));
		return $this->db->limit(1)->get_where('content', array('content.published' => 'publish'))->row();
	}
	
	function detail_content($cid = null, $content_type = null){
		if(! $cid){ return FALSE; }
		
		$this->db->select('content.*');
		if($content_type == 'program'){
			$this->db->select('master_geography.geography_name AS geography_name');
			$this->db->select('master_location.location_name AS location_name');
			$this->db->join('master_geography', 'master_geography.geography_id = content.geography_id', 'inner');
			$this->db->join('master_location', 'master_location.location_id = content.location_id', 'inner');
		}
		return $this->db->limit(1)->get_where('content', array('content.content_id' => $cid))->row();
	}
	
	function result_content_translation($cid = null){
		if(! $cid){ return FALSE; }
		
		return $this->db->get_where('content_translation', array('content_id' => $cid))->result();
	}
	
	function result_aboutvideo(){
		return $this->db->order_by('media_id', 'DESC')->get('video')->result();
	}
	
	function result_media($cid = null){
		if(! $cid){ return FALSE; }
		
		return $this->db->get_where('media', array('content_id' => $cid))->result();
	}
	
	function all_media($limit = 24){
		
		return $this->db->limit($limit)->get('media')->result();
	}
	
	function detail_category_cms($cid = null){
		if(! $cid){ return FALSE; }
		
		return $this->db->limit(1)->get_where('category', array('category_id' => $cid))->row();
	}
	
	function result_category_translation($cid = null){
		if(! $cid){ return FALSE; }
		
		return $this->db->get_where('category_translation', array('category_id' => $cid))->result();
	}
	
	function detail_master_location($cid = null){
		if(! $cid){ return FALSE; }
		
		return $this->db->limit(1)->get_where('master_location', array('location_id' => $cid))->row();
	}
	
	function detail_master_geography($cid = null){
		if(! $cid){ return FALSE; }
		
		return $this->db->limit(1)->get_where('master_geography', array('geography_id' => $cid))->row();
	}
	
	function detail_category($cid = null){
		if(! $cid){ return FALSE; }
		
		return $this->db
				->select('category.slug')
				->select('category_translation.*')
				->join('category_translation', 'category_translation.category_id = category.category_id', 'inner')
				->limit(1)
				->get_where('category', array('category_translation.language_slug' => 'id', 'category.category_id' => $cid))
				->row();
	}
	
	function detail_inbox($cid = null){
		if(! $cid){ return FALSE; }
		
		return $this->db->limit(1)->get_where('inbox', array('inbox_id' => $cid))->row();
	}
	
	function detail_campaign_banner($cid = null){
		if(! $cid){ return FALSE; }
		
		return $this->db->limit(1)->get_where('campaign_banner', array('banner_id' => $cid))->row();
	}
	
	function detail_redirection($cid = null){
		if(! $cid){ return FALSE; }
		
		return $this->db->limit(1)->get_where('redirection', array('redirection_id' => $cid))->row();
	}
	
	function detail_homeslider($cid = null){
		if(! $cid){ return FALSE; }
		
		return $this->db->limit(1)->get_where('homeslider', array('homeslider_id' => $cid))->row();
	}
	
	function result_homeslider_translation($cid = null){
		if(! $cid){ return FALSE; }
		
		return $this->db->get_where('homeslider_translation', array('homeslider_id' => $cid))->result();
	}
	
	function master_language(){
		return $this->db->get('master_language')->result();
	}
	
	//result
	function result_homeslider($limit = 5){
		$this->db->select('homeslider_translation.title, homeslider_translation.description, homeslider_translation.location');
		$this->db->select('homeslider.*');
		$this->db->join('homeslider_translation', 'homeslider_translation.homeslider_id = homeslider.homeslider_id', 'inner');
		$this->db->where(array('homeslider_translation.language_slug' => $this->session->userdata('current_lang')));
		return $this->db->limit($limit)->order_by('homeslider.ordered', 'ASC')->get_where('homeslider', array('homeslider.published' => 'publish'))->result();
	}
	
	function result_category(){
		$this->db->select('category_translation.*');
		$this->db->select('category.*');
		$this->db->join('category_translation', 'category_translation.category_id = category.category_id', 'inner');
		$this->db->where(array('category_translation.language_slug' => $this->session->userdata('current_lang')));
		return $this->db->order_by('category.ordered', 'ASC')->get_where('category', array('category.published' => 'publish', 'is_featured' => 'featured'))->result();
	}
	
	function detail_category_slug($slug = null){
		$this->db->select('category_translation.*');
		$this->db->select('category.*');
		$this->db->join('category_translation', 'category_translation.category_id = category.category_id', 'inner');
		$this->db->where(array('category_translation.language_slug' => $this->session->userdata('current_lang')));
		return $this->db->limit(1)->get_where('category', array('category.slug' => $slug,'category.published' => 'publish'))->row();
	}
	
	function result_content($limit = null, $offset = 0, $filter = array())
	{
		$this->db->select('content.*');
		$this->db->select('content_translation.*');
		$this->db->select('member.fullname, member.avatar');
		$this->db->join('content_translation', 'content_translation.content_id = content.content_id', 'inner');
		$this->db->join('member', 'member.member_id = content.created_by', 'inner');
		
		//featured content only
		if(isset($filter['featured'])){
			$this->db->where(array('content.is_featured' => 'featured'));
		}
		
		//type content
		if(isset($filter['content_type'])){
			$this->db->where(array('content.content_type' => $filter['content_type']));
		}
		
		//exclude id content
		if(isset($filter['ex_content_id'])){
			$this->db->where('content.content_id !=', $filter['ex_content_id']);
		}
		
		//type content
		if(isset($filter['category_id'])){
			$this->db->where(array('content.category_id' => $filter['category_id']));
		}
		
		$this->db->where(array('content_translation.language_slug' => $this->session->userdata('current_lang')));
		
		if($limit){
			//most view
			if(isset($filter['viewed'])){
				$this->db->order_by('content.viewed', 'DESC');
			}else{
				$this->db->order_by('content.content_id', 'DESC');
			}
			
			return $this->db->limit($limit, $offset)->get_where('content', array('content.published' => 'publish'))->result();
		}else{
			return $this->db->get_where('content', array('content.published' => 'publish'))->num_rows();
		}
	}
}