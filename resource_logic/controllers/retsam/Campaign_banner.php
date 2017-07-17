<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Campaign_banner extends ST_Controller {
	
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
			'meta_title' => 'Campaign Banner',
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => ''
		);
		
		$this->display(array('main_header','campaign_banner/home','main_footer'), $data, 0);
	}
	
	public function plus()
	{
		if($this->input->post('form_submit')){
			$this->form_validation->set_error_delimiters('<p style="color:red;">', '</p>');
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			
			$this->form_validation->set_message('required','%s Harus dilengkapi!');
			
			if($this->form_validation->run()) {
				//upload file
				$config['upload_path'] = $this->storagepath.'/campaign_banner';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['overwrite'] = FALSE;
				$config['max_size']    = '2000';
				$config['max_width']  = '0';
				$config['max_height']  = '0';
				$config['encrypt_name'] = TRUE;
				$config['file_ext_tolower'] = TRUE;
				$this->load->library('upload', $config);
				$this->upload->initialize($config); 
				$uploads = $this->upload->do_upload('cover');
				
				if($uploads === TRUE){
					$uploaded_image = $this->upload->data();
				}
				
				$info = array(
					'cover' => (isset($uploaded_image['file_name']) ? $uploaded_image['file_name'] : 'noimage.png'),
					'title' => $this->input->post('title'),
					'created' => date('Y-m-d H:i:s'),
					'updated' => date('Y-m-d H:i:s'),
					'created_by' => $this->session->userdata['isloginaccount']['member_id'],
					'updated_by' => $this->session->userdata['isloginaccount']['member_id'],
				);
				
				if($this->db->insert('campaign_banner', $info)){
					$this->session->set_flashdata('msg', 'The process was successful');
				}else{
					$this->session->set_flashdata('msg', 'Change a few things up and try submitting again.');
				}
				
				redirect(DIRADMIN.'/'.$this->router->fetch_class().'/home');
			}
		}
			
		$data = array(
			'meta_title' => 'Add Campaign Banner',
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => '',
		);
		
		$this->display(array('main_header','campaign_banner/plus','main_footer'), $data, 0);
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
		
		$detail = $this->Master_mod->detail_campaign_banner($cid);
		if(! $detail){
			$this->session->set_flashdata('msg', 'Request that you want is not available!');
			redirect(DIRADMIN.'/'.$this->router->fetch_class().'/home');
		}
		
		if($this->input->post('form_submit')){
			$this->form_validation->set_error_delimiters('<p style="color:red;">', '</p>');
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			
			$this->form_validation->set_message('required','%s Harus dilengkapi!');
			
			if($this->form_validation->run()) {
				//upload file
				$config['upload_path'] 	= $this->storagepath.'/campaign_banner';
				$config['allowed_types']= 'jpg|png|jpeg';
				$config['overwrite']	= TRUE;
				$config['max_size']		= '2000';
				$config['max_width']	= '0';
				$config['max_height']	= '0';
				$config['file_name']	= SHA1('Campaign_banner'.$cid);
				$config['encrypt_name'] = FALSE;
				$config['file_ext_tolower'] = TRUE;
				$this->load->library('upload', $config);
				$this->upload->initialize($config); 
				$uploads = $this->upload->do_upload('cover');
				
				if($uploads === TRUE){
					$uploaded_image = $this->upload->data();
				}
				
				$info = array(
					'cover' => (isset($uploaded_image['file_name']) ? $uploaded_image['file_name'] : $detail->cover),
					'title' => $this->input->post('title'),
					'updated' => date('Y-m-d H:i:s'),
					'updated_by' => $this->session->userdata['isloginaccount']['member_id'],
				);
				
				if($this->db->update('campaign_banner', $info, array('banner_id' => $cid))){
					$this->session->set_flashdata('msg', 'The process was successful');
				}else{
					$this->session->set_flashdata('msg', 'Change a few things up and try submitting again.');
				}
				
				redirect(DIRADMIN.'/'.$this->router->fetch_class().'/home');
			}
		}
		
		$data = array(
			'meta_title' => 'Edit Campaign Banner',
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => '',
			'detail' => $detail
		);
		
		$this->display(array('main_header','campaign_banner/edit','main_footer'), $data, 0);
	}
	
	public function delete($slug = null)
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
		
		$detail = $this->Master_mod->detail_campaign_banner($cid);
		if(! $detail){
			$this->session->set_flashdata('msg', 'Request that you want is not available!');
		}else{
			if($this->db->delete('campaign_banner', array('banner_id' => $cid))){
				$this->session->set_flashdata('msg', 'The process was successful');
			}
		}
		
		redirect(DIRADMIN.'/'.$this->router->fetch_class().'/home');
	}
	
	public function ajax_master_datatable()
	{
		if (! $this->input->is_ajax_request()) { die('denied!'); }
		
		$this->datatables->select('banner_id, title, created, cover, viewed');
		$this->datatables->select("CONCAT('<img width=\"80px\" src=\"".base_url('storage/campaign_banner')."/',cover,'\">') AS image", FALSE);
		$this->datatables->add_column('actions', '$1', 'banner_id');	
		$this->datatables->from('campaign_banner');
		$data = json_decode($this->datatables->generate());
		
		$newjson = array();
		foreach($data->aaData AS $red){
			//button action
			$action = '<div class="text-center">
				<a href="'.base_url(DIRADMIN.'/campaign_banner/edit/'.$red->actions).'" class="btn bg-orange btn-xs btn-block" target="_self"><i class="fa fa-edit"></i> Edit</a>
				<a onClick="return checkedbutton(\''.base_url(DIRADMIN.'/campaign_banner/delete/'.$red->actions).'\')" href="javascript:;" class="btn bg-red btn-xs btn-block"><i class="fa fa-trash"></i> Delete</a>
			</div>';
			
			$newjson[] = array(
				'image' => $red->image,
				'title' => $red->title,
				'source' => '<input readonly="readonly" style="width: 100%;" class="form-control" value="'.base_url('banner/'.$red->cover).'"/>',
				'viewed' => $red->viewed,
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
