<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
/author: e_seto@ymail.com
created: 14/02/2015
*/

if ( ! function_exists('enc_dec'))
{  
  function enc_dec($action='e', $string= null) {
		if(empty($action)){ return false;}
		if(empty($string)){ return false;}
		$output = false;

		$encrypt_method = "AES-256-CBC";
		$secret_key = '2885c6d46a1e837612fa93931a89c9a496d0b355';
		$secret_iv = 'fa347649025bb32cdf182f76f1ab57253cf49ec6';
		$key = hash('sha256', $secret_key);
		$iv = substr(hash('sha256', $secret_iv), 29, 16);

		if( $action == 'e' ) {
			$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			$output = base64_encode($output);
		}elseif( $action == 'd' ){
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		}
		return $output;
	}
}

if ( ! function_exists('asset'))
{
	function asset($url) {
		if(! $url){ return false;}
		$data = APPPATH.'../static/'.$url;
		if(file_exists($data)){
			return base_url('static/'.$url);
		}else{
			return false;
		}
	}
}

if ( ! function_exists('foto'))
{
	function foto($url,$x,$y,$default = 'default.png') {
		//default cropping size
		if(is_numeric($x) == FALSE AND is_numeric($y) == FALSE){
			$lokasi = prep_url(STATICURL.'/resize/'.$default);
			return $lokasi;
		}
		
		//check dir thumbnail
		$size = $x.'_'.$y;
		$thumbnail = APPPATH .'../storage/resize/'.$size;
		if(is_dir($thumbnail) == FALSE) {
			mkdir($thumbnail, 0755, true);
			chmod($thumbnail, 0755);
			chown($thumbnail, 'www-data');
			chgrp($thumbnail, 'www-data');
		}
		
		//check file in original dir
		$splitpath = explode('/', $url);
		$data = APPPATH.'../storage/'.$url;
		if(file_exists($data)){
			$img = end($splitpath);
			$sourceimg = $url;
		}else{
			$def = explode('/',$default);
			$img = end($def);
			$sourceimg = $default;
		}
		
		//check thumbnail generated
		$gambar = $thumbnail.'/'.$img;
		if(is_file($gambar) == false){
			//croping
			$x_img = ($x ? $x : 200);
			$y_img = ($y ? $y : 130);
			$zimg = getimagesize(APPPATH .'../storage/'. $sourceimg);
			$img_width = $zimg[0];
			$img_height = $zimg[1];

			$source_ratio = $img_width / $img_height;
			$dest_ratio = $x_img / $y_img;

			if ($source_ratio > $dest_ratio) {
				$master_dim = 'height';
			} else {
				$master_dim = 'width';
			}
	      
			$CI =& get_instance();
			$image_config["image_library"] = "gd2";
			$image_config["source_image"] = APPPATH .'../storage/'. $sourceimg;
			$image_config['maintain_ratio'] = TRUE;
			$image_config['new_image'] = $thumbnail;
			$image_config['quality'] = "80%";
			$image_config['width'] = (int)$x_img;
			$image_config['height'] = (int)$y_img;
			$image_config['master_dim'] = $master_dim;
			 
			$CI->load->library('image_lib');
			$CI->image_lib->initialize($image_config);
				
			$CI->image_lib->resize();
			$CI->image_lib->clear();
			$newimg = getimagesize($gambar);
			$new_width = $newimg[0];
			$new_height = $newimg[1];
			$image_config = array();
			$image_config['image_library'] = 'gd2';
			$image_config['source_image'] = $gambar;
			$image_config['new_image'] = $thumbnail;
			$image_config['quality'] = "100%";
			$image_config['maintain_ratio'] = FALSE;
			$image_config['width'] = (int)$x_img;
			$image_config['height'] = (int)$y_img;
			$image_config['x_axis'] = round(($new_width - $x_img) / 2);
			$image_config['y_axis'] = round(($new_height - $y_img) / 2);
			$image_config['master_dim'] = 'auto';				 
			
			$CI->image_lib->initialize($image_config);
			$CI->image_lib->crop();			
			$CI->image_lib->clear();
		}
		
		$lokasi = prep_url(STATICURL.'/resize/'.$size.'/'.$img);
		return $lokasi;
	}
}

if ( ! function_exists('clean_html'))
{	
	function clean_html($string = null) {
		if(! $string){ return FALSE; }
		
		$string = str_replace('"', '', xss_clean(strip_tags(trim($string))));
		
		return $string;
	}
}

if ( ! function_exists('url_1hour'))
{	
	function url_1hour($slug = null) {
		if(! $slug){ return FALSE; }
		
		$data = enc_dec('d', $slug);
		$row = explode('#', $data);
		if((strtotime(date("Y-m-d H:i:s")) - strtotime($row[1])) <= 36000){ // change to 10 hours (expired)
			return TRUE;
		}else{
			return FALSE;
		}
	}
}

if ( ! function_exists('auto_url'))
{	
	function auto_url($slug = null) {
		if(! $slug){ return FALSE; }
		
		$data = enc_dec('e', $slug."#".date("Y-m-d H:i:s")); //$slug = id/unique
		return $data;
	}
}

if ( ! function_exists('slug'))
{
	function slug($title) {
		if(empty($title)){ return false;}
		return preg_replace('/-$/', '', preg_replace('/^-/', '', preg_replace('/\-{2,}/', '-', preg_replace('/([^a-z0-9]+)/', '-',strtolower($title)))));
	}
}

if ( ! function_exists('slug_uniqify'))
{
	function slug_uniqify($slug_candidate, $slug_possible_conflicts = array()) {
		$ci =& get_instance();
		$ci->load->helper('string');
		while (in_array($slug_candidate, $slug_possible_conflicts)) {
			$slug_candidate = increment_string($slug_candidate, '-');
		}
		return $slug_candidate;
	} 
}

if ( ! function_exists('generate_thumbnail_youtube'))
{
	function generate_thumbnail_youtube($ytid = null, $slug = null) {
		$fileimg = 'noimage.png';
		$data = APPPATH.'../storage/gallery/'.$slug. '.jpg';
		if($ytid){
			$getImage = file_get_contents('http://img.youtube.com/vi/'.$ytid.'/hqdefault.jpg');
			if($getImage){
				file_put_contents($data, $getImage);
				$fileimg = $slug.'.jpg';
			}
		}
		
		return $fileimg;
	}
}

if ( ! function_exists('base_lang'))
{
	function base_lang($slug = null) {
		$CI =& get_instance();
		if($CI->session->userdata('current_lang') == 'id'){
			return base_url($slug);
		}else{
			return base_url($CI->session->userdata('current_lang').'/'.$slug);
		}
	} 
}

if ( ! function_exists('translation'))
{
	function translation($key = null) {
		$CI =& get_instance();
		$current_lang = $CI->session->userdata('current_lang');
		$master_key = $CI->session->userdata('translation');
		if($master_key){
			return $master_key[$key];
		}else{
			return FALSE;
		}
	} 
}
/* End of file encdec_helper.php */
/* Location: ./helpers/encdec_helper.php */