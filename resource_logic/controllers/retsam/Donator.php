<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Donator extends ST_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		$params = array('server_key' => MIDTRANS_SERVERKEY, 'production' => MIDTRANS_PRODUCTION);
		$this->load->library(array('midtrans', 'veritrans'));
		$this->midtrans->config($params);
		$this->veritrans->config($params);
	}
	
	public function index()
	{
		redirect(DIRADMIN.'/'.$this->router->fetch_class().'/home');
	}
	
	public function home()
	{
		$data = array(
			'meta_title' => 'User Donate',
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => ''
		);
		
		$this->display(array('main_header','donator/home','main_footer'), $data, 0);
	}
	
	public function ajax_master_datatable()
	{
		if (! $this->input->is_ajax_request()) { die('denied!'); }
		
		$this->datatables->select('donate_user.user_id AS user_id, donate_user.first_name AS first_name, donate_user.last_name As last_name, donate_user.email AS email, donate_user.phone AS phone, donate_user.status AS status, donate_user.agent AS agent, donate_user.created AS created, donate_user.updated AS updated');
		$this->datatables->from('donate_user');
		$data = json_decode($this->datatables->generate());
		
		$newjson = array();
		foreach($data->aaData AS $red){
			$tracking_history = (array)json_decode($red->agent);
			$str_history = '<ul>';
			if(count($tracking_history) > 1){
				$str_history .= '<li>IP: '.$tracking_history['ip'].'</li>';
				$str_history .= '<li>Agents: '.$tracking_history['agents'].'</li>';
				$str_history .= '<li>Platform: '.$tracking_history['platform'].'</li>';
				$str_history .= '<li>Version: '.$tracking_history['version'].'</li>';
				$str_history .= '<li>Browser: '.$tracking_history['browser'].'</li>';
				$str_history .= '<li>Mobile: '.$tracking_history['mobile'].'</li>';
				$str_history .= '<li>Robot: '.$tracking_history['robot'].'</li>';
			}
			$str_history .= '</ul>';
			
			$total = $this->db->select_sum('gross_amount')->get_where('donate_transaction', array('user_id' => $red->user_id, 'result_type' => 'success'))->row();
			
			$newjson[] = array(
				'first_name' => $red->first_name.' '.$red->last_name,
				'email' => $red->email,
				'phone' => $red->phone,
				'status' => $red->status,
				'total' => ($total->gross_amount ? $total->gross_amount : 0),
				'created' => $red->created.'<hr>Last update: '.$red->updated,
				'agent' => $str_history
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
