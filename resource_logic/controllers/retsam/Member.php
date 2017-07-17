<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends ST_Controller {
	
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
			'meta_title' => 'Member',
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => ''
		);
		
		$this->display(array('main_header','member/home','main_footer'), $data, 0);
	}
	
	public function plus()
	{
		if($this->input->post('form_submit')){
			$this->form_validation->set_error_delimiters('<p style="color:red;">', '</p>');
			$this->form_validation->set_rules('fullname', 'Fullname', 'trim|required');
			$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
			$this->form_validation->set_rules('password', 'password', 'trim|required|min_length[6]');
			
			$this->form_validation->set_message('required','%s Harus dilengkapi!');
			
			if($this->form_validation->run()) {
				//upload file
				$config['upload_path'] = $this->storagepath.'/avatar';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['overwrite'] = FALSE;
				$config['max_size']    = '2000';
				$config['max_width']  = '0';
				$config['max_height']  = '0';
				$config['encrypt_name'] = TRUE;
				$this->load->library('upload', $config);
				$this->upload->initialize($config); 
				$uploads = $this->upload->do_upload('avatar');
				
				if($uploads === TRUE){
					$uploaded_image = $this->upload->data();
				}
				
				//validation password
				$this->load->library('bcrypt'); 
				$password = $this->bcrypt->hash_password($this->input->post('password'));
				
				$info = array(
					'fullname' => $this->input->post('fullname'),
					'email' => $this->input->post('email'),
					'password' => $password,
					'phone' => $this->input->post('phone'),
					'avatar' => (isset($uploaded_image['file_name']) ? $uploaded_image['file_name'] : 'default_avatar.png'),
					'level' => $this->input->post('level'),
					'status' => $this->input->post('status'),
					'ip' => $this->input->ip_address(),
					'agent' => $this->_myagent(),
					'expired' => date('Y-m-d H:i:s', strtotime('+1year')),
					'created' => date('Y-m-d H:i:s'),
					'updated' => date('Y-m-d H:i:s'),
					'created_by' => $this->session->userdata['isloginaccount']['member_id'],
					'updated_by' => $this->session->userdata['isloginaccount']['member_id'],
				);
				
				if($this->db->insert('member', $info)){
					$this->session->set_flashdata('msg', 'The process was successful');
				}else{
					$this->session->set_flashdata('msg', 'Change a few things up and try submitting again.');
				}
				
				redirect(DIRADMIN.'/'.$this->router->fetch_class().'/home');
			}
		}
			
		$data = array(
			'meta_title' => 'Add Member',
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => '',
		);
		
		$this->display(array('main_header','member/plus','main_footer'), $data, 0);
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
		
		$detail = $this->Master_mod->detail_member($cid);
		if(! $detail){
			$this->session->set_flashdata('msg', 'Request that you want is not available!');
			redirect();
		}
		
		if($this->input->post('form_submit')){
			$this->form_validation->set_rules('fullname', 'fullname', 'trim|required|max_length[255]');
			$this->form_validation->set_rules('phone', 'phone', 'trim|required|max_length[20]');
			
			if($this->form_validation->run()) {
				$config['upload_path'] = $this->storagepath.'/avatar';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['overwrite'] = TRUE;
				$config['max_size']    = '2000';
				$config['max_width']  = '0';
				$config['max_height']  = '0';
				$config['file_name'] = SHA1($detail->member_id);
				$config['encrypt_name'] = FALSE;
				$this->load->library('upload', $config);
				$this->upload->initialize($config); 
				$uploads = $this->upload->do_upload('avatar');
				
				if($uploads === TRUE){
					$uploaded_image = $this->upload->data();
				}
				
				$info = array(
					'fullname' => $this->input->post('fullname'),
					'avatar' => (isset($uploaded_image['file_name']) ? $uploaded_image['file_name'] : $detail->avatar),
					'phone' => $this->input->post('phone'),
					'level' => ($this->input->post('level') ? $this->input->post('level') : $this->session->userdata['isloginaccount']['level']),
					'updated' => date('Y-m-d H:i:s'),
					'agent' => $this->_myagent(),
				);
				
				if($this->db->update('member', $info, array('member_id' => $detail->member_id))){
					$this->session->set_flashdata('msg', 'The process was successful');
				}else{
					$this->session->set_flashdata('msg', 'Change a few things up and try submitting again.');
				}
				
				redirect(DIRADMIN.'/home/profile');
			}
		}elseif($this->input->post('form_submit_password')){
			$this->form_validation->set_rules('password', 'password', 'trim|required|matches[password_confirmation]');
			$this->form_validation->set_rules('password_confirmation', 'password_confirmation', 'trim|required');
			
			if($this->form_validation->run()) {
				//validation password
				$this->load->library('bcrypt'); 
				$password = $this->bcrypt->hash_password($this->input->post('password'));
				
				$info = array(
					'password' => $password,
					'expired' => date('Y-m-d H:i:s', strtotime('+1year')),
					'updated' => date('Y-m-d H:i:s'),
					'agent' => $this->_myagent(),
				);
				
				if($this->db->update('member', $info, array('member_id' => $detail->member_id))){
					$this->session->set_flashdata('msg', 'The process was successful');
					redirect('auth/logout');
				}else{
					$this->session->set_flashdata('msg', 'Change a few things up and try submitting again.');
				}
				
				redirect(DIRADMIN.'/home/profile');
			}
		}elseif($this->input->post('form_submit_email')){
			$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
			
			if($this->form_validation->run()) {
				$email = $this->input->post('email');
				
				$info = array(
					'email' => $email,
					'updated' => date('Y-m-d H:i:s'),
					'agent' => $this->_myagent(),
				);
				
				if($this->db->update('member', $info, array('member_id' => $detail->member_id))){
					$this->session->set_flashdata('msg', 'The process was successful');
					redirect('auth/logout');
				}else{
					$this->session->set_flashdata('msg', 'Change a few things up and try submitting again.');
				}
				
				redirect(DIRADMIN.'/home/profile');
			}
		}
		
		$data = array(
			'meta_title' => 'Profile',
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => '',
			'detail' => $detail,
		);
		
		$this->display(array('main_header','member/edit','main_footer'), $data, 0);
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
		
		$detail = $this->Master_mod->detail_member($cid);
		if(! $detail){
			$this->session->set_flashdata('msg', 'Request that you want is not available!');
		}else{
			$info = array(
				'status' => ($detail->status == 'active' ? 'banned' : 'active'),
			);
			
			if($this->db->update('member', $info, array('member_id' => $cid))){
				$this->session->set_flashdata('msg', 'The process was successful');
			}
		}
		
		redirect(DIRADMIN.'/'.$this->router->fetch_class().'/home');
	}
	
	public function expired($slug = null)
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
		
		$detail = $this->Master_mod->detail_member($cid);
		if(! $detail){
			$this->session->set_flashdata('msg', 'Request that you want is not available!');
		}else{
			$info = array(
				'expired' => date('Y-m-d H:i:s', strtotime('+1year')),
				'status' => 'active',
			);
			
			if($this->db->update('member', $info, array('member_id' => $cid))){
				$this->session->set_flashdata('msg', 'The process was successful');
			}
		}
		
		redirect(DIRADMIN.'/'.$this->router->fetch_class().'/home');
	}
	
	public function ajax_master_datatable()
	{
		if (! $this->input->is_ajax_request()) { die('denied!'); }
		
		$this->datatables->select('member_id, email, fullname, phone, level, status, expired, ip, created');
		$this->datatables->add_column('actions', '$1', 'member_id');	
		$this->datatables->from('member');
		$data = json_decode($this->datatables->generate());
		
		$newjson = array();
		foreach($data->aaData AS $red){
			//button action
			$action = '<div class="text-center">
				<a href="'.base_url(DIRADMIN.'/member/edit/'.$red->actions).'" class="btn bg-orange btn-xs btn-block" target="_self"><i class="fa fa-edit"></i> Edit</a>
				<a onClick="return checkedbutton(\''.base_url(DIRADMIN.'/member/expired/'.$red->actions).'\')" href="javascript:;" class="btn bg-green btn-xs btn-block"><i class="fa fa-star"></i> 1y Expired</a>
				<a onClick="return checkedbutton(\''.base_url(DIRADMIN.'/member/hide/'.$red->actions).'\')" href="javascript:;" class="btn bg-red btn-xs btn-block"><i class="fa fa-flag"></i> '.($red->status == 'active' ? 'Banned' : 'Active').'</a>
			</div>';
			
			$newjson[] = array(
				'fullname' => $red->fullname,
				'email' => $red->email,
				'phone' => $red->phone,
				'level' => $red->level,
				'status' => $red->status,
				'expired' => $red->expired,
				'ip' => $red->ip,
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
