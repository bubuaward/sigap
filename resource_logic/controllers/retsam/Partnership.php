<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Partnership extends ST_Controller {
	
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
		if($this->input->post('form_submit')){
			$this->form_validation->set_error_delimiters('<p style="color:red;">', '</p>');
			$this->form_validation->set_rules('url', 'URL', 'trim|required');
			
			$this->form_validation->set_message('required','%s Harus dilengkapi!');
			
			if($this->form_validation->run()) {
				//upload file
				$config['upload_path'] = $this->storagepath.'/partnership';
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
					'ordered' => $this->input->post('ordered'),
					'url' => $this->input->post('url'),
					'contact_view' => $this->input->post('contact_view'),
					'created' => date('Y-m-d H:i:s'),
					'updated' => date('Y-m-d H:i:s'),
				);
				
				if($this->db->insert('partnership', $info)){
					$this->session->set_flashdata('msg', 'The process was successful');
				}else{
					$this->session->set_flashdata('msg', 'Change a few things up and try submitting again.');
				}
				
				redirect(DIRADMIN.'/'.$this->router->fetch_class().'/home');
			}
		}
		
		$data = array(
			'meta_title' => 'Partnership',
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => ''
		);
		
		$this->display(array('main_header','partnership/home','main_footer'), $data, 0);
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
		
		if($this->db->delete('partnership', array('partnership_id' => $cid))){
			$this->session->set_flashdata('msg', 'The process was successful');
		}else{
			$this->session->set_flashdata('msg', 'Request that you want is not available!');
		}
		
		redirect($this->agent->referrer());
	}
	
	public function ajax_master_datatable()
	{
		if (! $this->input->is_ajax_request()) { die('denied!'); }
		
		$this->datatables->select('partnership_id, url, contact_view, created, ordered');	
		$this->datatables->select("CONCAT('<img width=\"80px\" src=\"".base_url('storage/partnership')."/',cover,'\">') AS image", FALSE);
		$this->datatables->add_column('actions', $this->_button('$1'), 'partnership_id');
		$this->datatables->from('partnership');
		echo $this->datatables->generate();
	}
	
	private function _button($id)
	{
		return '<a onClick="return checkedbutton(\''.base_url(DIRADMIN.'/partnership/hide/'.$id).'\')" href="javascript:;" class="btn bg-red btn-xs btn-block"><i class="fa fa-flag"></i> Delete</a>';
	}
}
