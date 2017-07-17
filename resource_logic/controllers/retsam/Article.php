<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Article extends ST_Controller {

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
			'meta_title' => 'Article',
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => ''
		);

		$this->display(array('main_header','article/home','main_footer'), $data, 0);
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
				//Slug Title for URL
				$slug_candidate = slug(clean_html($this->input->post('title_id')));
				$slug_candidate = rtrim($slug_candidate, '-0123456789');
				$possible_conflicts = array_map(
				create_function('$a', 'return $a["slug"];'),
					$this->db->like('slug', $slug_candidate)->select('slug')->get('content')->result_array()
				);
				$slug_post = slug_uniqify($slug_candidate, $possible_conflicts);

				//upload file
				$config['upload_path'] = $this->storagepath.'/content';
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
					'content_type' => 'article',
					'slug' => $slug_post,
					'is_featured' => $this->input->post('is_featured'),
					'cover' => (isset($uploaded_image['file_name']) ? $uploaded_image['file_name'] : 'noimage.png'),
					'copyright' => $this->input->post('copyright'),
					'video' => $this->input->post('video'),
					'published' => $this->input->post('published'),
					'created' => date('Y-m-d H:i:s'),
					'updated' => date('Y-m-d H:i:s'),
					'ip' => $this->input->ip_address(),
					'created_by' => $this->session->userdata['isloginaccount']['member_id'],
					'updated_by' => $this->session->userdata['isloginaccount']['member_id'],
				);

				if($this->db->insert('content', $info)){
					$content_id = $this->db->insert_id();

					$content = array();
					foreach($language AS $red){
						$content[] = array(
							'content_id' => $content_id,
							'language_slug' => $red->language_slug,
							'title' => $this->input->post('title_'.$red->language_slug),
							'teaser' => $this->input->post('teaser_'.$red->language_slug),
							'description' => $this->input->post('description_'.$red->language_slug),
						);
					}

					if($content){
						$this->db->insert_batch('content_translation', $content);
					}

					$this->session->set_flashdata('msg', 'The process was successful');
					redirect(DIRADMIN.'/'.$this->router->fetch_class().'/media/'.auto_url($content_id));
				}else{
					$this->session->set_flashdata('msg', 'Change a few things up and try submitting again.');
				}

				redirect(DIRADMIN.'/'.$this->router->fetch_class().'/home');
			}
		}

		$data = array(
			'meta_title' => 'Add Article',
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => '',
			'language' => $language,
		);

		$this->display(array('main_header','article/plus','main_footer'), $data, 0);
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

		$detail = $this->Master_mod->detail_content($cid, 'article');
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
				//Slug Title for URL
				$slug_post = $detail->slug;
				$slug_candidate = slug(clean_html($this->input->post('title_id')));
				if($slug_post != $slug_candidate){
					$slug_candidate = rtrim($slug_candidate, '-0123456789');
					$possible_conflicts = array_map(
					create_function('$a', 'return $a["slug"];'),
						$this->db->like('slug', $slug_candidate)->select('slug')->get('content')->result_array()
					);
					$slug_post = slug_uniqify($slug_candidate, $possible_conflicts);
				}

				//upload file
				$config['upload_path'] 	= $this->storagepath.'/content';
				$config['allowed_types']= 'jpg|png|jpeg';
				$config['overwrite']	= TRUE;
				$config['max_size']		= '2000';
				$config['max_width']	= '0';
				$config['max_height']	= '0';
				$config['file_name']	= SHA1('content'.$cid);
				$config['encrypt_name'] = FALSE;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				$uploads = $this->upload->do_upload('cover');

				if($uploads === TRUE){
					$uploaded_image = $this->upload->data();
				}

				$info = array(
					'content_type' => 'article',
					'slug' => $slug_post,
					'is_featured' => $this->input->post('is_featured'),
					'cover' => (isset($uploaded_image['file_name']) ? $uploaded_image['file_name'] : $detail->cover),
					'copyright' => $this->input->post('copyright'),
					'video' => $this->input->post('video'),
					'published' => $this->input->post('published'),
					'updated' => date('Y-m-d H:i:s'),
					'ip' => $this->input->ip_address(),
					'updated_by' => $this->session->userdata['isloginaccount']['member_id'],
				);

				if($this->db->update('content', $info, array('content_id' => $cid))){
					$content = array();
					foreach($language AS $red){
						$content[] = array(
							'translate_id' => $this->input->post('translate_id_'.$red->language_slug),
							'content_id' => $detail->content_id,
							'language_slug' => $red->language_slug,
							'title' => $this->input->post('title_'.$red->language_slug),
							'teaser' => $this->input->post('teaser_'.$red->language_slug),
							'description' => $this->input->post('description_'.$red->language_slug),
						);
					}

					if($content){
						$this->db->update_batch('content_translation', $content, 'translate_id');
					}

					$this->session->set_flashdata('msg', 'The process was successful');
				}else{
					$this->session->set_flashdata('msg', 'Change a few things up and try submitting again.');
				}

				redirect(DIRADMIN.'/'.$this->router->fetch_class().'/home');
			}
		}

		$lang = $this->Master_mod->result_content_translation($detail->content_id);
		$translate = array();
		foreach($lang AS $red){
			$translate[$red->language_slug]['translate_id'] = $red->translate_id;
			$translate[$red->language_slug]['title'] = $red->title;
			$translate[$red->language_slug]['teaser'] = $red->teaser;
			$translate[$red->language_slug]['description'] = $red->description;
		}

		$data = array(
			'meta_title' => 'Edit Article',
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => '',
			'detail' => $detail,
			'translate' => $translate,
			'language' => $language,
			'category' => $this->Master_mod->detail_category($detail->category_id),
		);

		$this->display(array('main_header','article/edit','main_footer'), $data, 0);
	}

	public function media($slug = null)
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

		$detail = $this->Master_mod->detail_content($cid, 'article');
		if(! $detail){
			$this->session->set_flashdata('msg', 'Request that you want is not available!');
			redirect(DIRADMIN.'/'.$this->router->fetch_class().'/home');
		}

		if($this->input->post('form_submit')){
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
				'content_id' => $cid,
				'cover' => (isset($uploaded_image['file_name']) ? $uploaded_image['file_name'] : $detail->cover),
				'copyright' => $this->input->post('copyright'),
				'video' => $this->input->post('video'),
				'created' => date('Y-m-d H:i:s'),
				'updated' => date('Y-m-d H:i:s'),
				'ip' => $this->input->ip_address(),
				'created_by' => $this->session->userdata['isloginaccount']['member_id'],
			);

			if($this->db->insert('media', $info)){
				$this->session->set_flashdata('msg', 'The process was successful');
			}else{
				$this->session->set_flashdata('msg', 'Change a few things up and try submitting again.');
			}

			redirect($this->agent->referrer());
		}

		$lang = $this->Master_mod->result_content_translation($detail->content_id);
		$translate = array();
		foreach($lang AS $red){
			$translate[$red->language_slug]['translate_id'] = $red->translate_id;
			$translate[$red->language_slug]['title'] = $red->title;
			$translate[$red->language_slug]['teaser'] = $red->teaser;
			$translate[$red->language_slug]['description'] = $red->description;
		}

		$data = array(
			'meta_title' => 'Gallery Article',
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => '',
			'detail' => $detail,
			'list' => $this->Master_mod->result_media($detail->content_id),
			'translate' => $translate,
		);

		$this->display(array('main_header','article/gallery','main_footer'), $data, 0);
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

		$detail = $this->Master_mod->detail_content($cid, 'article');
		if(! $detail){
			$this->session->set_flashdata('msg', 'Request that you want is not available!');
		}else{
			$info = array(
				'published' => ($detail->published == 'publish' ? 'unpublish' : 'publish'),
				'updated_by' => $this->session->userdata['isloginaccount']['member_id'],
			);

			if($this->db->update('content', $info, array('content_id' => $cid))){
				$this->session->set_flashdata('msg', 'The process was successful');
			}
		}

		redirect(DIRADMIN.'/'.$this->router->fetch_class().'/home');
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

		$detail = $this->Master_mod->detail_content($cid, 'article');
		if(! $detail){
			$this->session->set_flashdata('msg', 'Request that you want is not available!');
		}else{
			if($this->db->delete('content', array('content_id' => $cid))){
				unlink($this->storagepath.'/content/'.$detail->cover);
				$this->session->set_flashdata('msg', 'The process was successful' );
			}
		}

		redirect(DIRADMIN.'/'.$this->router->fetch_class().'/home');
	}

	public function featured($slug = null)
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

		$detail = $this->Master_mod->detail_content($cid, 'article');
		if(! $detail){
			$this->session->set_flashdata('msg', 'Request that you want is not available!');
		}else{
			$info = array(
				'is_featured' => ($detail->is_featured == 'featured' ? 'unfeatured' : 'featured'),
				'updated_by' => $this->session->userdata['isloginaccount']['member_id'],
			);

			if($this->db->update('content', $info, array('content_id' => $cid))){
				$this->session->set_flashdata('msg', 'The process was successful');
			}
		}

		redirect(DIRADMIN.'/'.$this->router->fetch_class().'/home');
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

		if($this->db->delete('media', array('media_id' => $cid))){
			$this->session->set_flashdata('msg', 'The process was successful');
		}else{
			$this->session->set_flashdata('msg', 'Request that you want is not available!');
		}

		redirect($this->agent->referrer());
	}

	public function ajax_master_datatable()
	{
		if (! $this->input->is_ajax_request()) { die('denied!'); }

		$this->datatables->select('content_id, slug, content.*');
		$this->datatables->select("CONCAT('<img width=\"80px\" src=\"".base_url('storage/content')."/',cover,'\">') AS image", FALSE);
		$this->datatables->where('content_type', 'article');
		$this->datatables->add_column('actions', '$1', 'content_id');
		$this->datatables->from('content');
		$data = json_decode($this->datatables->generate());

		$newjson = array();
		foreach($data->aaData AS $red){
			//button action
			$action = '<div class="text-center">
				<a href="'.base_url(DIRADMIN.'/article/media/'.$red->actions).'" class="btn bg-black btn-xs btn-block" target="_self"><i class="fa fa-image"></i> Gallery</a>
				<a href="'.base_url(DIRADMIN.'/article/edit/'.$red->actions).'" class="btn bg-orange btn-xs btn-block" target="_self"><i class="fa fa-edit"></i> Edit</a>
				<a href="'.base_url(DIRADMIN.'/article/featured/'.$red->actions).'" class="btn bg-green btn-xs btn-block" target="_self"><i class="fa fa-star"></i> '.($red->is_featured == 'featured' ? 'UnFeatured' : 'Featured').'</a>
				<a onClick="return checkedbutton(\''.base_url(DIRADMIN.'/article/hide/'.$red->actions).'\')" href="javascript:;" class="btn bg-red btn-xs btn-block"><i class="fa fa-flag"></i> '.($red->published == 'publish' ? 'Unpublish' : 'Publish').'</a>
				<a onClick="return checkedbutton(\''.base_url(DIRADMIN.'/article/delete/'.$red->actions).'\')" href="javascript:;" class="btn bg-maroon btn-xs btn-block"><i class="fa fa-times"></i> Delete</a>
			</div>';

			//Category
			$cat = $this->Master_mod->detail_category($red->category_id);

			//language
			$html = '';
			$lang = $this->db->get_where('content_translation', array('content_id' => $red->content_id))->result();
			foreach($lang AS $sub){
				$html .= '<a href="'.base_url($sub->language_slug.'/artikel/'.$red->slug).'" target="_blank">'.$sub->title.'</a>
					<br/>
					<blockquote style="font-size: 12px;">'.word_limiter(clean_html($sub->description), 30).'</blockquote><hr>';
			}

			$newjson[] = array(
				'image' => $red->image,
				'title' => $html,
				'published' => $red->published.'<hr>'.$red->is_featured,
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
