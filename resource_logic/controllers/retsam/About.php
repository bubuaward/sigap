<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends ST_Controller {
	
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
		if($this->input->post('form_submit')){
			$this->form_validation->set_rules('video', 'video', 'trim|required');
			
			$this->form_validation->set_message('required','%s Harus dilengkapi!');
			
			if($this->form_validation->run()) {
				//upload file
				$config['upload_path'] 	= $this->storagepath.'/content';
				$config['allowed_types']= 'jpg|png|jpeg';
				$config['overwrite']	= TRUE;
				$config['max_size']		= '2000';
				$config['max_width']	= '0';
				$config['max_height']	= '0';
				$config['encrypt_name'] = TRUE;
				$this->load->library('upload', $config);
				$this->upload->initialize($config); 
				$uploads = $this->upload->do_upload('cover');
				
				if($uploads === TRUE){
					$uploaded_image = $this->upload->data();
				}
				
				$info = array(
					'content_type' => 'about',
					'cover' => (isset($uploaded_image['file_name']) ? $uploaded_image['file_name'] : 'noimage.png'),
					'url' => $this->input->post('video'),
					'created' => date('Y-m-d H:i:s'),
					'updated' => date('Y-m-d H:i:s'),
					'ip' => $this->input->ip_address(),
					'created_by' => $this->session->userdata['isloginaccount']['member_id'],
				);
				
				if($this->db->insert('video', $info)){
					$this->session->set_flashdata('msg', 'The process was successful');
				}else{
					$this->session->set_flashdata('msg', 'Change a few things up and try submitting again.');
				}
			}
			
			redirect($this->agent->referrer());
		}
		
		$data = array(
			'meta_title' => 'Video About',
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => '',
			'list' => $this->Master_mod->result_aboutvideo(),
		);
		
		$this->display(array('main_header','about/video','main_footer'), $data, 0);
	}
	
	public function media_delete($slug = null)
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
		
		if($this->db->delete('video', array('media_id' => $cid))){
			$this->session->set_flashdata('msg', 'The process was successful');
		}else{
			$this->session->set_flashdata('msg', 'Request that you want is not available!');
		}
		
		redirect($this->agent->referrer());
	}
}
