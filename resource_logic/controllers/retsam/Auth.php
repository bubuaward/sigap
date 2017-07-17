<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends ST_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('captcha'));
		$this->load->model(array('Captcha_mod'));
	}
	
	public function index()
	{
		redirect();
	}
	
	public function login()
	{
		$data = array(
			'meta_title' => 'Login',
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => '',
			'captcha' => $this->Captcha_mod->setCaptcha()
		);
		
		if($this->input->post('form-submit')){
			$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
			$this->form_validation->set_rules('umail', 'Username', 'trim|required|min_length[5]|max_length[100]|valid_email'); 
			$this->form_validation->set_rules('upass', 'Password', 'trim|required|min_length[6]|max_length[20]');
			$this->form_validation->set_rules('captcha', 'Captcha', 'trim|required|callback_valid_captcha');
			
			$this->form_validation->set_message('required','%s Harus Dilengkapi!');
			$this->form_validation->set_message('min_length','Jumalh Karakter %s Kurang!');
			
			if ($this->form_validation->run()==TRUE) {			
				$cek = 	$this->db
					->where_in('level', array('admin', 'moderator'))
					->limit(1)
					->get_where('member', array('email' => $this->input->post('umail')))
					->row();
				
				if($cek){
					//Expired
					if(strtotime(date('Y-m-d H:i:s')) >= strtotime($cek->expired)){
						//send to email
						$message = array(
							'title' => '[AUTO REMINDER] EXPIRED PASSWORD',
							'message' => 'This account <b>('.$this->input->post('umail').')</b> has already expired, please immediately processed activation or ignore!'
						);
						$this->_sendtoEmail('expired_password', EMAIL_CS, $message);
						
						$this->session->set_flashdata('msg', 'Account expired! Please sontact admin to activated your account.');
						redirect($this->agent->referrer());
					}
					
					//Status
					if($cek->status !== 'active'){
						$this->session->set_flashdata('msg', 'Account inactive! Please sontact admin to activated your account.');
						redirect($this->agent->referrer());
					}
					
					//check hash password
					$this->load->library('bcrypt');
					if($this->bcrypt->check_password($this->input->post('upass'), $cek->password) === FALSE){
						$this->session->set_flashdata('msg', 'Login failed. Please check your email or password!');
						redirect($this->agent->referrer());
					}
					
					//session maks 4kb, soo session stored database
					$this->db->select('retsam_menubar.*');
					$this->db->join('retsam_menubar','retsam_menubar.idmenu = retsam_authmenu.idmenu','inner');
					$menuauth = $this->db->order_by('retsam_menubar.ordered','ASC')->get_where('retsam_authmenu', array('retsam_authmenu.role_level' => $cek->level))->result_array();
					
					//session menu
					$this->session->set_userdata('isloginmenu', json_encode($menuauth));
					
					//session login
					$this->session->set_userdata('isloginaccount', array(
						'member_id' => $cek->member_id,
						'email' => $cek->email,
						'fullname' =>$cek->fullname,
						'level' => $cek->level,
						'status' => $cek->status,
						'avatar' => $cek->avatar,
					));
					
					redirect(DIRADMIN);
				}else{
					$this->session->set_flashdata('msg', 'Login failed. Please check your email or password!');
					redirect($this->agent->referrer());
				}
			}else{
				$this->session->set_flashdata('msg', 'Login failed. Please check your email or password!');
				redirect($this->agent->referrer());
			}
		}
		
		//home jika sudah login
		if($this->session->userdata('isloginaccount')){
			redirect();
		}
		
		$this->display(array('login'), $data, 0);
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		$this->output->set_header('cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header("cache-Control: post-check=0, pre-check=0", false);
		$this->output->set_header("Pragma: no-cache");
		$this->output->set_header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
		redirect();
	}
	
	public function valid_captcha($str)
	{
		$expiration = time()-1800; // 30 minutes
		$this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);

		$sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
		$binds = array($_POST['captcha'], $this->input->ip_address(), $expiration);
		$query = $this->db->query($sql, $binds);
		$row = $query->row();

		if ($row->count == 0){
			return FALSE;
		}else{
			return TRUE;
		}
	}
}
