<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inbox extends ST_Controller {
	
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
			'meta_title' => 'Inbox',
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => ''
		);
		
		$this->display(array('main_header','inbox/home','main_footer'), $data, 0);
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
		
		$detail = $this->Master_mod->detail_inbox($cid);
		if(! $detail){
			$this->session->set_flashdata('msg', 'Request that you want is not available!');
			redirect(DIRADMIN.'/'.$this->router->fetch_class().'/home');
		}
		
		if($this->input->post('form_submit')){
			$this->form_validation->set_error_delimiters('<p style="color:red;">', '</p>');
			$this->form_validation->set_rules('answer', 'Content', 'trim|required');
			
			$this->form_validation->set_message('required','%s Harus dilengkapi!');
			
			if($this->form_validation->run()) {
				$info = array(
					'answer' => $this->input->post('answer'),
					'status' => 'answered',
					'updated' => date('Y-m-d H:i:s'),
				);
				
				//send to email
				$message = array(
					'title' => '[REPLY] YKAN',
					'message' => $this->input->post('answer')
				);
				$this->_sendtoEmail('inbox', $detail->email, $message);
				
				if($this->db->update('inbox', $info, array('inbox_id' => $cid))){
					$this->session->set_flashdata('msg', 'The process was successful');
				}else{
					$this->session->set_flashdata('msg', 'Change a few things up and try submitting again.');
				}
				
				redirect(DIRADMIN.'/'.$this->router->fetch_class().'/home');
			}
		}
		
		$data = array(
			'meta_title' => 'Reply Message',
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => '',
			'detail' => $detail,
		);
		
		$this->display(array('main_header','inbox/edit','main_footer'), $data, 0);
	}
	
	public function ajax_master_datatable()
	{
		if (! $this->input->is_ajax_request()) { die('denied!'); }
		
		$this->datatables->select('inbox_id, message, answer, ip');
		$this->datatables->select("CONCAT('<b>',fullname,'</b><br/>Email: ', email,'<br/>Phone: ', phone,'<br/>City: ', city) AS fullname", FALSE);
		$this->datatables->select("CONCAT(created, '<br/><b class=\"badge bg-green\">',status,'</b>') AS created", FALSE);
		$this->datatables->unset_column('inbox_id');
		$this->datatables->add_column('actions', '$1', 'inbox_id');	
		$this->datatables->from('inbox');
		$data = json_decode($this->datatables->generate());
		
		$newjson = array();
		foreach($data->aaData AS $red){
			//button action
			$action = '<div class="text-center">
				<a href="'.base_url(DIRADMIN.'/inbox/edit/'.$red->actions).'" class="btn bg-orange btn-xs btn-block" target="_self"><i class="fa fa-reply"></i> Reply</a>
			</div>';
			
			$newjson[] = array(
				'message' => $red->message.($red->answer ? '<blockquote style="font-size: 12px !important;">'.$red->answer.'</blockquote>' :''),
				'fullname' => $red->fullname,
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
