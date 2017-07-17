<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
* Session key exist:
* - isloginaccount
* - isloginmenu
* - current_lang
* - masterlanguage
*
*/

class ST_Controller extends CI_Controller {
	
	var $storagepath;
	
	public function __construct() {
		parent::__construct();
		
		$this->storagepath = realpath(APPPATH . '../storage');
		
		if($this->uri->segment(1) == DIRADMIN){
			if(! $this->session->userdata('isloginaccount')){
				if($this->router->fetch_class() != 'auth'){
					redirect(DIRADMIN.'/auth/login');
				}
			}else{
				if(!in_array($this->session->userdata['isloginaccount']['level'], array('admin', 'moderator'))){
					redirect('logout');
				}
			}
		}
		
		if(! $this->session->userdata('current_lang')){
			//all language
			$lang = $this->db->get('master_language')->result();
			if($lang){
				$language_slug = array();
				foreach($lang AS $red){
					array_push($language_slug, $red->language_slug);
				}
			}else{
				$language_slug = array('id');
			}
			
			$this->session->set_userdata('masterlanguage', $language_slug);
			$this->session->set_userdata('current_lang', 'id');
		}
		
		//force lang switch
		if(in_array($this->uri->segment(1), $this->session->userdata('masterlanguage'))){
			$this->session->set_userdata('current_lang', $this->uri->segment(1));
		}
	}
	
	//website view
	function render($view = array(), $data = null, $menit = 0) 
	{
		if(empty($view)) { show_404(); }
		
		if($menit >= 1){ $this->output->cache($menit); }
		
		//avoid access no language slug
		if($this->session->userdata('current_lang')){
			$segment = $this->uri->segment(1);
			if(strlen($segment) == 2){
				$lang = $this->db->limit(1)->get_where('master_language', array('language_slug' => $segment))->row();
				if(! $lang){
					$this->session->set_userdata('current_lang', 'id');
					redirect();
				}
			}
		}
		
		//Avoid default language in URL
		$segment = $this->uri->segment(1);
		if(strlen($segment) == 2 && $segment == 'id'){
			redirect(base_url(str_replace('id/','', uri_string())));
		}
		
		if(empty($data['meta_title'])){ $data['meta_title'] = '';}
		if(empty($data['meta_description'])){ $data['meta_description'] = '';}
		if(empty($data['meta_picture'])){ $data['meta_picture'] = '';}
		if(empty($data['meta_tags'])){ $data['meta_tags'] = '';}
		
		//query
		$this->load->model(array('Master_mod'));
		$data['current_class'] = $this->router->fetch_class();
		$data['masterlanguage'] = $this->session->userdata('masterlanguage');
		$data['menu_category'] = $this->Master_mod->result_category();
		
		//default translation
		$this->_setTranslation($this->session->userdata('current_lang'));
		
		$this->load->view('meta_header', $data);
		foreach($view AS $red){
			$this->load->view($red, $data);
		}
		$this->load->view('meta_footer', $data);
		
		return FALSE;
	}
	
	function _setTranslation($current_lang = null){
		//translation
		$master =  $this->db->get_where('sitemap_translation', array('language_slug' => ($current_lang ? $current_lang : 'id')))->result();
		if(! $master){
			redirect('home/translation');
		}else{
			$translation = array();
			foreach($master AS $red){
				$translation[$red->variable_sitemap] = $red->word;
			}
		}
		
		return $this->session->set_userdata('translation', $translation);
	}
	
	//admin view
	function display($view = array(), $data = null, $menit = 0) 
	{
		if(empty($view)) { show_404(); }
		
		if($menit >= 1){ $this->output->cache($menit); }
		
		if(empty($data['meta_title'])){ $data['meta_title'] = '';}
		if(empty($data['meta_description'])){ $data['meta_description'] = '';}
		if(empty($data['meta_picture'])){ $data['meta_picture'] = '';}
		if(empty($data['meta_tags'])){ $data['meta_tags'] = '';}
		
		//query
		$data['sidemenu'] = ($this->session->userdata('isloginaccount') ? json_decode($this->session->userdata('isloginmenu')) : array());
		$data['current_class'] = $this->router->fetch_class();
		
		$this->load->view('retsam/meta_header', $data);
		foreach($view AS $red){
			$this->load->view('retsam/'.$red, $data);
		}
		$this->load->view('retsam/meta_footer', $data);
		
		return FALSE;
	}
	
	function response($result = null) 
	{
		$this->output
			->set_status_header(200)
			->enable_profiler(FALSE)
			->set_content_type('application/json', 'utf-8')
			->set_output($this->_jsonPretty(json_encode($result)))
			->_display();
		exit;
	}
	
	function _jsonPretty($json, $istr='  ')
	{
		$result = '';
		for($p=$q=$i=0; isset($json[$p]); $p++)
		{
			$json[$p] == '"' && ($p>0?$json[$p-1]:'') != '\\' && $q=!$q;
			if(!$q && strchr(" \t\n\r", $json[$p])){continue;}
			if(strchr('}]', $json[$p]) && !$q && $i--)
			{
				strchr('{[', $json[$p-1]) || $result .= "\n".str_repeat($istr, $i);
			}
			$result .= $json[$p];
			if(strchr(',{[', $json[$p]) && !$q)
			{
				$i += strchr('{[', $json[$p])===FALSE?0:1;
				strchr('}]', $json[$p+1]) || $result .= "\n".str_repeat($istr, $i);
			}
		}
		return $result;
	}
	
	private function __crypto_rand_secure($min, $max)
	{
		$range = $max - $min;
		if ($range < 1) return $min;
		$log = ceil(log($range, 2));
		$bytes = (int) ($log / 8) + 1;
		$bits = (int) $log + 1;
		$filter = (int) (1 << $bits) - 1;
		do {
			$rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
			$rnd = $rnd & $filter;
		} while ($rnd >= $range);
		return $min + $rnd;
	}
	
	function _genToken($length = 6)
	{
		$token = "";
		$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
		$codeAlphabet.= "0123456789";
		$max = strlen($codeAlphabet) - 1;
		for ($i=0; $i < $length; $i++) {
			$token .= $codeAlphabet[$this->__crypto_rand_secure(0, $max)];
		}
		return $token;
	}
	
	function _myagent()
	{
		return json_encode(array(						
			'ip' => $this->input->ip_address(),
			'agents' => $this->agent->agent,
			'platform' => $this->agent->platform(),
			'version' => $this->agent->version(),
			'mobile' => $this->agent->mobile(),
			'robot' => $this->agent->robot(),
			'browser' => $this->agent->browser(),
			'languages' => $this->agent->languages(),
		));
	}
	
	function _saveLog($category = null, $info = null)
	{
		if($category == NULL || $info == NULL){
			return TRUE;
		}
		
		$data = array(
			'category' => $category,
			'info' => $info,
			'created' => date('Y-m-d H:i:s'),
			'ip' => $this->input->ip_address(),
			'agent' => json_encode(array(						
				'agents' => $this->agent->agent,
				'platform' => $this->agent->platform(),
				'version' => $this->agent->version(),
				'mobile' => $this->agent->mobile(),
				'robot' => $this->agent->robot(),
				'browser' => $this->agent->browser(),
				'languages' => $this->agent->languages(),
			)),
		);
		$this->db->insert('log_error', $data);
		
		return TRUE;
	}
	
	function _sendtoEmail($category = 'all', $email = null, $info = array())
	{
		if($info){
			require_once realpath(APPPATH . 'third_party/swiftmailer/swift_required.php');

			 //Create the Transport
			$transport = Swift_SmtpTransport::newInstance('email.tnc.org', 587)
				->setUsername('sayasigap.webadmin@tnc.org')
				->setPassword('sNPE6VT_i2');
			$mailer = Swift_Mailer::newInstance($transport);

			//Create a message
			$title = (isset($info['title']) ? $info['title'] : 'YKAN');
			$html = $this->load->view('email_template', $info, TRUE);
			$message = Swift_Message::newInstance($title)
				->setFrom(array('sayasigap.webadmin@tnc.org' => 'YKAN'))
				->setTo($email)
				->setBody($html, 'text/html');
			
			/*
			//Create the Transport
			$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
				->setUsername('ykanindonesia@gmail.com')
				->setPassword('asdqwe123@');
			$mailer = Swift_Mailer::newInstance($transport);

			//Create a message
			$title = (isset($info['title']) ? $info['title'] : 'YKAN');
			$html = $this->load->view('email_template', $info, TRUE);
			$message = Swift_Message::newInstance($title)
				->setFrom(array('ykanindonesia@gmail.com' => 'YKAN'))
				->setTo($email)
				->setBody($html, 'text/html');
			 */


			//Send the message
			if(! $mailer->send($message, $failures)){
				$this->_saveLog($category, json_encode($failures));
			}
		}

		return TRUE;
	}
}

/* End of file core */