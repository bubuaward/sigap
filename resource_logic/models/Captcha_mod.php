<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Captcha_mod extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	function setCaptcha(){
		$this->load->helper('captcha');
		$vals = array(
			'word'          => random_string('numeric', 6),
			'img_path'      => './cache/captcha/',
			'img_url'       => base_url().'cache/captcha/',
			'font_path'     => './static/master/fonts/SourceSansPro-Regular.ttf',
			'img_width'     => '140',
			'img_height'    => 34,
			'expiration'    => 7200,
			'word_length'   => 6,
			'font_size'     => 16,
			'img_id'        => 'captchakey',
			'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
			
			// White background and border, black text and red grid
			'colors'        => array(
				'background' => array(100, 0, 0),
				'border' => array(255, 255, 255),
				'text' => array(255, 40, 40),
				'grid' => array(200, 40, 40)
			)
		);
		
		$cap = create_captcha($vals);
		if($cap){
			$capdb = array(
				'captcha_time'	=> $cap['time'],
				'ip_address'	=> $this->input->ip_address(),
				'word'			=> $cap['word']
			);
			
			$query = $this->db->insert_string('captcha', $capdb);
			$this->db->query($query);
		}else{
			return "Captcha not work" ;
		}
		
		return $cap['image'];
	}       
}
?>