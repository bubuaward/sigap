<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Redirection extends ST_Controller {
	
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
			'meta_title' => 'Redirection',
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => ''
		);
		
		$this->display(array('main_header','redirection/home','main_footer'), $data, 0);
	}
	
	public function plus()
	{
		if($this->input->post('form_submit')){
			$this->form_validation->set_error_delimiters('<p style="color:red;">', '</p>');
			$this->form_validation->set_rules('from_url', 'from_url', 'trim|required');
			$this->form_validation->set_rules('to_url', 'to_url', 'trim|required');
			
			$this->form_validation->set_message('required','%s Harus dilengkapi!');
			
			if($this->form_validation->run()) {
				$info = array(
					'from_url' => $this->input->post('from_url'),
					'to_url' => $this->input->post('to_url'),
					'created' => date('Y-m-d H:i:s'),
					'updated' => date('Y-m-d H:i:s'),
					'created_by' => $this->session->userdata['isloginaccount']['member_id'],
					'updated_by' => $this->session->userdata['isloginaccount']['member_id'],
				);
				
				if($this->db->insert('redirection', $info)){
					$this->session->set_flashdata('msg', 'The process was successful');
				}else{
					$this->session->set_flashdata('msg', 'Change a few things up and try submitting again.');
				}
				
				redirect(DIRADMIN.'/'.$this->router->fetch_class().'/home');
			}
		}
			
		$data = array(
			'meta_title' => 'Add Redirection',
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => '',
		);
		
		$this->display(array('main_header','redirection/plus','main_footer'), $data, 0);
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
		
		$detail = $this->Master_mod->detail_redirection($cid);
		if(! $detail){
			$this->session->set_flashdata('msg', 'Request that you want is not available!');
			redirect(DIRADMIN.'/'.$this->router->fetch_class().'/home');
		}
		
		if($this->input->post('form_submit')){
			$this->form_validation->set_error_delimiters('<p style="color:red;">', '</p>');
			$this->form_validation->set_rules('from_url', 'from_url', 'trim|required');
			$this->form_validation->set_rules('to_url', 'to_url', 'trim|required');
			
			$this->form_validation->set_message('required','%s Harus dilengkapi!');
			
			if($this->form_validation->run()) {
				$info = array(
					'from_url' => $this->input->post('from_url'),
					'to_url' => $this->input->post('to_url'),
					'updated' => date('Y-m-d H:i:s'),
					'updated_by' => $this->session->userdata['isloginaccount']['member_id'],
				);
				
				if($this->db->update('redirection', $info, array('redirection_id' => $cid))){
					$this->session->set_flashdata('msg', 'The process was successful');
				}else{
					$this->session->set_flashdata('msg', 'Change a few things up and try submitting again.');
				}
				
				redirect(DIRADMIN.'/'.$this->router->fetch_class().'/home');
			}
		}
		
		$data = array(
			'meta_title' => 'Edit Redirection',
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => '',
			'detail' => $detail
		);
		
		$this->display(array('main_header','redirection/edit','main_footer'), $data, 0);
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
		
		$detail = $this->Master_mod->detail_redirection($cid);
		if(! $detail){
			$this->session->set_flashdata('msg', 'Request that you want is not available!');
		}else{
			if($this->db->delete('redirection', array('redirection_id' => $cid))){
				$this->session->set_flashdata('msg', 'The process was successful');
			}
		}
		
		redirect(DIRADMIN.'/'.$this->router->fetch_class().'/home');
	}
	
	public function ajax_master_datatable()
	{
		if (! $this->input->is_ajax_request()) { die('denied!'); }
		
		$this->datatables->select('redirection_id, from_url, created, to_url, clicked');
		$this->datatables->add_column('actions', '$1', 'redirection_id');	
		$this->datatables->from('redirection');
		$data = json_decode($this->datatables->generate());
		
		$newjson = array();
		foreach($data->aaData AS $red){
			//button action
			$action = '<div class="text-center">
				<a href="'.base_url(DIRADMIN.'/redirection/edit/'.$red->actions).'" class="btn bg-orange btn-xs btn-block" target="_self"><i class="fa fa-edit"></i> Edit</a>
				<a onClick="return checkedbutton(\''.base_url(DIRADMIN.'/redirection/delete/'.$red->actions).'\')" href="javascript:;" class="btn bg-red btn-xs btn-block"><i class="fa fa-trash"></i> Delete</a>
			</div>';
			
			$newjson[] = array(
				'from_url' => '<input readonly="readonly" style="width: 100%;" class="form-control" value="'.base_url('r/'.$red->from_url).'"/>',
				'to_url' => $red->to_url,
				'clicked' => $red->clicked,
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
