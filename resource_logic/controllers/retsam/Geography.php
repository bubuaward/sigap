<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Geography extends ST_Controller {
	
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
			$this->form_validation->set_error_delimiters('<p style="color:red;">', '</p>');
			$this->form_validation->set_rules('title', 'title', 'trim|required');
			
			$this->form_validation->set_message('required','%s Harus dilengkapi!');
			
			if($this->form_validation->run()) {
				//Slug Title for URL
				$slug_candidate = slug(clean_html($this->input->post('title')));
				$slug_candidate = rtrim($slug_candidate, '-0123456789');
				$possible_conflicts = array_map(
				create_function('$a', 'return $a["slug"];'),
					$this->db->like('slug', $slug_candidate)->select('slug')->get('master_geography')->result_array()
				);
				$slug_post = slug_uniqify($slug_candidate, $possible_conflicts);
				
				$info = array(
					'geography_name' => $this->input->post('title'),
					'slug' => $slug_post,
					'created' => date('Y-m-d H:i:s'),
					'updated' => date('Y-m-d H:i:s'),
					'created_by' => $this->session->userdata['isloginaccount']['member_id'],
					'updated_by' => $this->session->userdata['isloginaccount']['member_id'],
				);
				
				if($this->db->insert('master_geography', $info)){
					$this->session->set_flashdata('msg', 'The process was successful');
				}else{
					$this->session->set_flashdata('msg', 'Change a few things up and try submitting again.');
				}
				
				redirect(DIRADMIN.'/'.$this->router->fetch_class().'/home');
			}
		}
		
		$data = array(
			'meta_title' => 'Geography',
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => ''
		);
		
		$this->display(array('main_header','geography/home','main_footer'), $data, 0);
	}
	
	public function edit($slug = null)
	{
		if(! $slug){
			$this->session->set_flashdata('msg', 'Request that you want is not available!');
			redirect($this->agent->referrer());
		}
		
		$url = enc_dec('d', $slug);
		$split = explode('#', $url);
		$cid = $split[0];
		
		//Check URL expired in 1 hour
		if(! url_1hour($slug)){
			$this->session->set_flashdata('msg', 'The request you want has expired!');
			redirect($this->agent->referrer());
		}
		
		$detail = $this->Master_mod->detail_master_geography($cid);
		if(! $detail){
			$this->session->set_flashdata('msg', 'Request that you want is not available!');
			redirect($this->agent->referrer());
		}
		
		if($this->input->post('form_submit')){
			$this->form_validation->set_error_delimiters('<p style="color:red;">', '</p>');
			$this->form_validation->set_rules('title', 'title', 'trim|required');
			
			$this->form_validation->set_message('required','%s Harus dilengkapi!');
			
			if($this->form_validation->run()) {
				//Slug Title for URL
				$slug_post = $detail->slug;
				if($this->input->post('title') != $detail->title){
					$slug_candidate = slug(clean_html($this->input->post('title')));
					$slug_candidate = rtrim($slug_candidate, '-0123456789');
					$possible_conflicts = array_map(
					create_function('$a', 'return $a["slug"];'),
						$this->db->like('slug', $slug_candidate)->select('slug')->get('master_geography')->result_array()
					);
					$slug_post = slug_uniqify($slug_candidate, $possible_conflicts);
				}
				
				$info = array(
					'geography_name' => $this->input->post('title'),
					'slug' => $slug_post,
					'updated' => date('Y-m-d H:i:s'),
					'updated_by' => $this->session->userdata['isloginaccount']['member_id'],
				);
				
				if($this->db->update('master_geography', $info, array('geography_id' => $cid))){
					$this->session->set_flashdata('msg', 'The process was successful');
				}else{
					$this->session->set_flashdata('msg', 'Change a few things up and try submitting again.');
				}
				
				redirect(DIRADMIN.'/'.$this->router->fetch_class().'/home');
			}
		}
		
		$data = array(
			'meta_title' => 'Edit Geography',
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => '',
			'detail' => $detail
		);
		
		$this->display(array('main_header','geography/edit','main_footer'), $data, 0);
	}
	
	public function ajax_master_datatable()
	{
		if (! $this->input->is_ajax_request()) { die('denied!'); }
		
		$this->datatables->select('geography_id, geography_name, created, slug');
		$this->datatables->unset_column('geography_id');
		$this->datatables->add_column('actions', '$1', 'geography_id');	
		$this->datatables->from('master_geography');
		$data = json_decode($this->datatables->generate());
		
		$newjson = array();
		foreach($data->aaData AS $red){
			//button action
			$action = '<div class="text-center">
				<a href="'.base_url(DIRADMIN.'/geography/edit/'.$red->actions).'" class="btn bg-orange btn-xs btn-block" target="_self"><i class="fa fa-edit"></i> Edit</a>
			</div>';
			
			$newjson[] = array(
				'title' => $red->geography_name,
				'slug' => $red->slug,
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
