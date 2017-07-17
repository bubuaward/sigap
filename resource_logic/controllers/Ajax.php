<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends ST_Controller {

	public function __construct()
	{
		parent::__construct();
		if (! $this->input->is_ajax_request()) { $this->response(array('success' => FALSE)); }
	}

	public function index()
	{
		$this->response(array('success' => FALSE));
	}
	
	public function category()
	{
		$term = $this->input->get('term');
		//if(! $term) return FALSE;
		
		$data = $this->db
			->select('category_translation.*')
			->join('category_translation', 'category_translation.category_id = category.category_id', 'inner')
			->like('category_translation.title', $term , 'both')
			->order_by('category_translation.title', 'ASC')
			->limit(30)
			->get_where('category', array('category_translation.language_slug' => 'id'))
			->result();
		
		$json_data = array();
		foreach($data as $pro){
			$json_data[] = array(
				'id'     => $pro->category_id,
				'value'  => $pro->title
			);
		}
		
		$this->response($json_data);
	}
	
	public function master_geography()
	{
		$term = $this->input->get('term');
		//if(! $term) return FALSE;
		
		$data = $this->db
			->like('geography_name', $term , 'both')
			->order_by('geography_name', 'ASC')
			->limit(30)
			->get('master_geography')
			->result();
		
		$json_data = array();
		foreach($data as $pro){
			$json_data[] = array(
				'id'     => $pro->geography_id,
				'value'  => $pro->geography_name
			);
		}
		
		$this->response($json_data);
	}
	
	public function master_location()
	{
		$term = $this->input->get('term');
		//if(! $term) return FALSE;
		
		$data = $this->db
			->like('location_name', $term , 'both')
			->order_by('location_name', 'ASC')
			->limit(30)
			->get('master_location')
			->result();
		
		$json_data = array();
		foreach($data as $pro){
			$json_data[] = array(
				'id'     => $pro->location_id,
				'value'  => $pro->location_name
			);
		}
		
		$this->response($json_data);
	}
	
	public function tweetfeed()
	{
		require_once(APPPATH . "third_party/oauth_twitter/twitteroauth.php");
		
		// Check if keys are in place
		if (CONSUMER_KEY === '' || CONSUMER_SECRET === '' || CONSUMER_KEY === 'CONSUMER_KEY_HERE' || CONSUMER_SECRET === 'CONSUMER_SECRET_HERE') {
			echo 'You need a consumer key and secret keys. Get one from <a href="https://apps.twitter.com/">apps.twitter.com</a>';
			exit;
		}
		
		// If count of tweets is not fall back to default setting
		$username = filter_input(INPUT_GET, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
		$number = filter_input(INPUT_GET, 'count', FILTER_SANITIZE_NUMBER_INT);
		$exclude_replies = filter_input(INPUT_GET, 'exclude_replies', FILTER_SANITIZE_SPECIAL_CHARS);
		$list_slug = filter_input(INPUT_GET, 'list', FILTER_SANITIZE_SPECIAL_CHARS);
		$hashtag = filter_input(INPUT_GET, 'hashtag', FILTER_SANITIZE_SPECIAL_CHARS);

		/* if(CACHE_ENABLED) {
			// Generate cache key from query data
			$cache_key = md5(
				var_export(array($username, $number, $exclude_replies, $list_slug, $hashtag), true) . HASH_SALT
			);

			// Remove old files from cache dir
			$cache_path  = dirname(__FILE__) . '/cache/';
			foreach (glob($cache_path . '*') as $file) {
				if (filemtime($file) < time() - CACHE_LIFETIME) {
					unlink($file);
				}
			}
			
			// If cache file exists - return it
			if(file_exists($cache_path . $cache_key)) {
				header('Content-Type: application/json');
				echo file_get_contents($cache_path . $cache_key);
				exit;
			}
		} */
		
		// Connect
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_SECRET);
		
		// Get Tweets
		if(!empty($list_slug)) {
			$params = array(
				'owner_screen_name' => $username,
				'slug' => $list_slug,
				'per_page' => $number
			);
			
			$url = '/lists/statuses';
		}elseif($hashtag) {
			$params = array(
				'count' => $number,
				'q' => '#'.$hashtag
			);
			
			$url = '/search/tweets';
		}else{
			$params = array(
				'count' => $number,
				'exclude_replies' => $exclude_replies,
				'screen_name' => $username
			);
			
			$url = '/statuses/user_timeline';
		}
		
		$tweets = $connection->get($url, $params);
		//if(CACHE_ENABLED) file_put_contents($cache_path . $cache_key, $tweets);
		
		$this->response($tweets);
	}
}

/* End of file ajax */
