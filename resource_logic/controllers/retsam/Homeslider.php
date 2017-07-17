<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Homeslider extends ST_Controller {
	
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
		$data = array(
			'meta_title' => 'Homeslider',
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => ''
		);
		
		$this->display(array('main_header','homeslider/home','main_footer'), $data, 0);
	}
	
	public function plus()
	{
		//master language
		$language = $this->Master_mod->master_language();
		
		if($this->input->post('form_submit')){
			$this->form_validation->set_error_delimiters('<p style="color:red;">', '</p>');
			$this->form_validation->set_rules('title_id', 'Title', 'trim|required');
			$this->form_validation->set_rules('description_id', 'Description', 'trim|required');
			
			$this->form_validation->set_message('required','%s Harus dilengkapi!');
			
			if($this->form_validation->run()) {
				//upload file
				$config['upload_path'] = $this->storagepath.'/homeslider';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['overwrite'] = FALSE;
				$config['max_size']    = '2000';
				$config['max_width']  = '0';
				$config['max_height']  = '0';
				$config['encrypt_name'] = TRUE;
				$this->load->library('upload', $config);
				$this->upload->initialize($config); 
				$uploads = $this->upload->do_upload('cover');
				
				if($uploads === TRUE){
					$uploaded_image = $this->upload->data();
				}
				
				$info = array(
					'cover' => (isset($uploaded_image['file_name']) ? $uploaded_image['file_name'] : 'noimage.png'),
					'copyright' => $this->input->post('copyright'),
					'url' => $this->input->post('url'),
					'ordered' => $this->input->post('ordered'),
					'published' => $this->input->post('published'),
					'created' => date('Y-m-d H:i:s'),
					'updated' => date('Y-m-d H:i:s'),
					'created_by' => $this->session->userdata['isloginaccount']['member_id'],
					'updated_by' => $this->session->userdata['isloginaccount']['member_id'],
				);
				
				if($this->db->insert('homeslider', $info)){
					$homeslider_id = $this->db->insert_id();
					
					$content = array();
					foreach($language AS $red){
						$content[] = array(
							'homeslider_id' => $homeslider_id,
							'language_slug' => $red->language_slug,
							'title' => $this->input->post('title_'.$red->language_slug),
							'location' => $this->input->post('location_'.$red->language_slug),
							'description' => $this->input->post('description_'.$red->language_slug),
						);
					}
					
					if($content){
						$this->db->insert_batch('homeslider_translation', $content);
					}
					
					$this->session->set_flashdata('msg', 'The process was successful');
				}else{
					$this->session->set_flashdata('msg', 'Change a few things up and try submitting again.');
				}
				
				redirect(DIRADMIN.'/'.$this->router->fetch_class().'/home');
			}
		}
			
		$data = array(
			'meta_title' => 'Add Homeslider',
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => '',
			'language' => $language,
		);
		
		$this->display(array('main_header','homeslider/plus','main_footer'), $data, 0);
	}
	
	public function edit($slug = null)
	{
		if(! $slug){
			$this->session->set_flashdata('msg', 'Request that you want is not available!');
			redirect(DIRADMIN.'/'.$this->router->fetch_class().'/home');
		}
		
		$url = enc_dec('d', $slug);
		$split = explode('#', $url);
		$cid = $split[0];
		
		//Check URL expired in 1 hour
		if(! url_1hour($slug)){
			$this->session->set_flashdata('msg', 'The request you want has expired!');
			redirect(DIRADMIN.'/'.$this->router->fetch_class().'/home');
		}
		
		$detail = $this->Master_mod->detail_homeslider($cid);
		if(! $detail){
			$this->session->set_flashdata('msg', 'Request that you want is not available!');
			redirect(DIRADMIN.'/'.$this->router->fetch_class().'/home');
		}
		
		//master language
		$language = $this->Master_mod->master_language();
		
		if($this->input->post('form_submit')){
			$this->form_validation->set_error_delimiters('<p style="color:red;">', '</p>');
			$this->form_validation->set_rules('title_id', 'Title', 'trim|required');
			$this->form_validation->set_rules('description_id', 'Description', 'trim|required');
			
			$this->form_validation->set_message('required','%s Harus dilengkapi!');
			
			if($this->form_validation->run()) {
				//upload file
				$config['upload_path'] 	= $this->storagepath.'/homeslider';
				$config['allowed_types']= 'jpg|png|jpeg';
				$config['overwrite']	= TRUE;
				$config['max_size']		= '2000';
				$config['max_width']	= '0';
				$config['max_height']	= '0';
				$config['file_name']	= SHA1('homeslider'.$cid);
				$config['encrypt_name'] = FALSE;
				$this->load->library('upload', $config);
				$this->upload->initialize($config); 
				$uploads = $this->upload->do_upload('cover');
				
				if($uploads === TRUE){
					$uploaded_image = $this->upload->data();
				}
				
				$info = array(
					'cover' => (isset($uploaded_image['file_name']) ? $uploaded_image['file_name'] : $detail->cover),
					'copyright' => $this->input->post('copyright'),
					'url' => $this->input->post('url'),
					'ordered' => $this->input->post('ordered'),
					'published' => $this->input->post('published'),
					'updated' => date('Y-m-d H:i:s'),
					'updated_by' => $this->session->userdata['isloginaccount']['member_id'],
				);
				
				if($this->db->update('homeslider', $info, array('homeslider_id' => $cid))){
					$content = array();
					foreach($language AS $red){
						$content[] = array(
							'slider_id' => $this->input->post('slider_id_'.$red->language_slug),
							'homeslider_id' => $detail->homeslider_id,
							'language_slug' => $red->language_slug,
							'title' => $this->input->post('title_'.$red->language_slug),
							'location' => $this->input->post('location_'.$red->language_slug),
							'description' => $this->input->post('description_'.$red->language_slug),
						);
					}
					
					if($content){
						$this->db->update_batch('homeslider_translation', $content, 'slider_id');
					}
					
					$this->session->set_flashdata('msg', 'The process was successful');
				}else{
					$this->session->set_flashdata('msg', 'Change a few things up and try submitting again.');
				}
				
				redirect(DIRADMIN.'/'.$this->router->fetch_class().'/home');
			}
		}
		
		$lang = $this->Master_mod->result_homeslider_translation($detail->homeslider_id);
		$translate = array();
		foreach($lang AS $red){
			$translate[$red->language_slug]['slider_id'] = $red->slider_id;
			$translate[$red->language_slug]['title'] = $red->title;
			$translate[$red->language_slug]['location'] = $red->location;
			$translate[$red->language_slug]['description'] = $red->description;
		}
		
		$data = array(
			'meta_title' => 'Edit Homeslider',
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => '',
			'detail' => $detail,
			'translate' => $translate,
			'language' => $language,
		);
		
		$this->display(array('main_header','homeslider/edit','main_footer'), $data, 0);
	}
	
	public function hide($slug = null)
	{
		if(! $slug){
			$this->session->set_flashdata('msg', 'Request that you want is not available!');
			redirect(DIRADMIN.'/'.$this->router->fetch_class().'/home');
		}
		
		$url = enc_dec('d', $slug);
		$split = explode('#', $url);
		$cid = $split[0];
		
		//Check URL expired in 1 hour
		if(! url_1hour($slug)){
			$this->session->set_flashdata('msg', 'The request you want has expired!');
			redirect(DIRADMIN.'/'.$this->router->fetch_class().'/home');
		}
		
		$detail = $this->Master_mod->detail_homeslider($cid);
		if(! $detail){
			$this->session->set_flashdata('msg', 'Request that you want is not available!');
		}else{
			$info = array(
				'published' => ($detail->published == 'publish' ? 'unpublish' : 'publish'),
				'updated_by' => $this->session->userdata['isloginaccount']['member_id'],
			);
			
			if($this->db->update('homeslider', $info, array('homeslider_id' => $cid))){
				$this->session->set_flashdata('msg', 'The process was successful');
			}
		}
		
		redirect(DIRADMIN.'/'.$this->router->fetch_class().'/home');
	}
	
	public function ajax_master_datatable()
	{
		if (! $this->input->is_ajax_request()) { die('denied!'); }
		
		$this->datatables->select('homeslider_id AS homeslider_id, published AS published, ordered AS ordered, created AS created, url AS url');
		$this->datatables->select("CONCAT('<img width=\"80px\" src=\"".base_url('storage/homeslider')."/',cover,'\">') AS image", FALSE);
		$this->datatables->add_column('actions', '$1', 'homeslider_id');	
		$this->datatables->from('homeslider');
		$data = json_decode($this->datatables->generate());
		
		$newjson = array();
		foreach($data->aaData AS $red){
			//button action
			$action = '<div class="text-center">
				<a href="'.base_url(DIRADMIN.'/homeslider/edit/'.$red->actions).'" class="btn bg-orange btn-xs btn-block" target="_self"><i class="fa fa-edit"></i> Edit</a>
				<a onClick="return checkedbutton(\''.base_url(DIRADMIN.'/homeslider/hide/'.$red->actions).'\')" href="javascript:;" class="btn bg-red btn-xs btn-block"><i class="fa fa-flag"></i> '.($red->published == 'publish' ? 'Unpublish' : 'Publish').'</a>
			</div>';
			
			//language
			$html = '';
			$lang = $this->db->get_where('homeslider_translation', array('homeslider_id' => $red->homeslider_id))->result();
			foreach($lang AS $sub){
				$html .= '<a href="'.prep_url($red->url).'" target="_blank">'.$sub->title.'</a><br/><span class="fa fa-map-marker"></span> '.$sub->location.'<blockquote style="font-size: 12px;">'.$sub->description.'</blockquote><hr>';
			}
			
			$newjson[] = array(
				'image' => $red->image,
				'title' => $html,
				'ordered' => $red->ordered,
				'published' => $red->published,
				'created' => $red->created,
				'actions' => $action
			);
		}
		
		$data_json = array(
			'sEcho' => $data->sEcho,
			'iTotalRecords' => $data->iTotalRecords,
			'iTotalDisplayRecords' => $data->iTotalDisplayRecords,
			'aaData' => $newjson,
			'sColumns' => $data->sColumns
		);
		
		$this->response($data_json);
	}
	
}
