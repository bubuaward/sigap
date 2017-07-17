<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends ST_Controller {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$data = array(
			'meta_title' => translation('page_contact_title'),
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => '',
			'partnership' => $this->db->get_where('partnership', array('contact_view' => 'true'))->result(),
		);
		
		$this->render(array('contact_form'), $data, 0);
	}
	
	public function add()
	{
		if($this->input->post()){
			$this->form_validation->set_rules('fullname', 'fullname', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('email', 'email', 'trim|required|max_length[100]|valid_email');
			$this->form_validation->set_rules('phone', 'phone', 'trim|required|min_length[6]|max_length[20]');
			$this->form_validation->set_rules('city', 'city', 'trim|required|min_length[3]|max_length[100]');
			
			$this->form_validation->set_message('required','%s Harus dilengkapi!');
			
			if($this->form_validation->run()) {
				//Subscribe newsletter
				if($this->input->post('subscribe')){
					//avoid multi submit in ready status
					$check = $this->db->limit(1)->get_where('subscribe', array('email' => $this->input->post('email')))->num_rows();
					if($check >= 1){
						$this->session->set_flashdata('msg', 'subscribe_success_duplicate');
					}
					
					$info = array(
						'email' => $this->input->post('email'),
						'phone' => $this->input->post('phone'),
						'city' => $this->input->post('city'),
						'created' => date('Y-m-d H:i:s'),
						'updated' => date('Y-m-d H:i:s'),
						'ip' => $this->input->ip_address(),
						'agent' => $this->_myagent(),
					);
					
					if($this->db->insert('subscribe', $info)){
						//send to email
						$message = array(
							'title' => 'YKAN Subscription',
							'message' => 'Anda telah berhasil melakukan subscribe, setiap bulannya Anda akan menerima newsletter.'
						);
						$this->_sendtoEmail('subscription', $this->input->post('email'), $message);
						
						$this->session->set_flashdata('msg', 'subscribe_success');
					}
				}
				
				//Message
				//avoid multi submit in ready status
				$check = $this->db->limit(1)->get_where('inbox', array('email' => $this->input->post('email'), 'status' => 'new'))->num_rows();
				if($check >= 1){
					$this->session->set_flashdata('msg', 'contact_waitinglist');
				}
				
				$info = array(
					'fullname' => $this->input->post('fullname'),
					'email' => $this->input->post('email'),
					'phone' => $this->input->post('phone'),
					'city' => $this->input->post('city'),
					'message' => ($this->input->post('message') ? $this->input->post('message') : 'Just subscribe newsletter or fulfillment'),
					'status' => ($this->input->post('message') ? 'new' : 'answered'),
					'created' => date('Y-m-d H:i:s'),
					'updated' => date('Y-m-d H:i:s'),
					'ip' => $this->input->ip_address(),
					'agent' => $this->_myagent(),
				);
				
				if($this->db->insert('inbox', $info)){
					$this->session->set_flashdata('msg', 'contact_success');
				}
			}
		}
		
		redirect($this->agent->referrer());
	}
}
