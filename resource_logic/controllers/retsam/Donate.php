<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Donate extends ST_Controller {
	
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
			'meta_title' => 'Transaction Donate',
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => ''
		);
		
		$this->display(array('main_header','donate/home','main_footer'), $data, 0);
	}
	
	public function process($action = null, $order_id = null)
    {
		if (! $this->input->is_ajax_request()) { $this->response(array('success' => FALSE, 'message' => 'Something wrong!')); }
		
		if(!$action || !$order_id){
			$this->response(array('success' => FALSE, 'message' => 'Something wrong!'));
		}
		
		$response = '';
		
    	switch ($action) {
		    case 'status':
		        $tracking_data = (array)$this->status($order_id);
				
				if(count($tracking_data) > 0){
					$response .= '<ul>';
					if(count($tracking_data) > 1){
						foreach($tracking_data AS $key => $track){
							$label = $track;
							if(in_array($key, array('order_id','transaction_status','gross_amount'))){
								$label = '<b class="label bg-orange">'.$track.'</b>';
							}
							
							$response .= '<li>'.ucwords(str_replace('_',' ', $key)).': '.($key == 'signature_key' ? '<a target="_blank" title="'.$track.'" href="'.prep_url($track).'">CLICK ME!</a>' : $label).'</li>';
						}
					}
					$response .= '</ul>';
					
					//Status
					if($tracking_data['transaction_status'] == 'capture'){
						if($tracking_data['payment_type'] == 'credit_card'){
							if($tracking_data['fraud_status'] == 'challenge'){
								$result_type = 'challenge';
							}else{
								$result_type = 'success';
							}
						}
					}else{
						$result_type = $tracking_data['transaction_status'];
					}
					
					$info = array(
						'result_type' => $result_type,
						'result_data' => json_encode($tracking_data),
						'updated' => date('Y-m-d H:i:s'),
					);
					
					$this->db->update('donate_transaction', $info, array('order_id' => $order_id));
				}
				
		        break;
		   	default:
		        $this->response(array('success' => FALSE, 'message' => 'Something wrong!'));
		}
		
		if($response){
			$this->response(array('success' => TRUE, 'message' => $response));
		}else{
			$this->response(array('success' => FALSE, 'message' => 'Something wrong!'));
		}
    }

	private function status($order_id)
	{
		return $this->veritrans->status($order_id);
	}
	
	public function ajax_master_datatable()
	{
		if (! $this->input->is_ajax_request()) { die('denied!'); }
		
		$this->datatables->select('donate_transaction.order_id AS order_id, donate_transaction.gross_amount AS gross_amount, donate_transaction.result_type AS result_type, donate_transaction.result_data AS result_data, donate_transaction.created AS created, donate_transaction.updated AS updated, donate_transaction.agent AS agent');	
		$this->datatables->select('donate_user.first_name AS first_name, donate_user.last_name As last_name, donate_user.email AS email, donate_user.phone AS phone, donate_user.status AS status');	
		$this->datatables->join('donate_user', 'donate_user.user_id = donate_transaction.user_id', 'inner');
		$this->datatables->from('donate_transaction');
		$data = json_decode($this->datatables->generate());
		
		$newjson = array();
		foreach($data->aaData AS $red){
			//button action
			$action = '<div class="text-center">
				<a onClick="return checkdonate(\''.base_url(DIRADMIN.'/donate/process/status/'.$red->order_id).'\')" href="javascript:;" class="btn bg-black btn-xs btn-block"><i class="fa fa-flag"></i> update status</a>
			</div>';
			
			$str_data = '<ul>';
			if($red->result_data){
				$tracking_data = (array)json_decode($red->result_data);
				if(count($tracking_data) > 1){
					foreach($tracking_data AS $key => $track){
						$label = $track;
						if(in_array($key, array('order_id','transaction_status','gross_amount'))){
							$label = '<b class="label bg-orange">'.$track.'</b>';
						}
						
						$str_data .= '<li>'.ucwords(str_replace('_',' ', $key)).': '.($key == 'signature_key' ? '<a target="_blank" title="'.$track.'" href="'.prep_url($track).'">CLICK ME!</a>' : $label).'</li>';
					}
				}
			}
			$str_data .= '</ul>';
			
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
			
			$newjson[] = array(
				'first_name' => 'Fullname:<br/>'.$red->first_name.' '.$red->last_name.'<br/>Email:<br/>'.$red->email.'<br/>Phone:<br/>'.$red->phone.'<br/>Status:<br/>'.$red->status,
				'email' => $red->email,
				'phone' => $red->phone,
				'status' => $red->status,
				'order_id' => 'OrderID:<br/><b class="label bg-orange">'.$red->order_id.'</b><br/>Amount:<br/><b class="label bg-orange">'.$red->gross_amount.'</b><br/>Status:<br/><b class="label bg-orange">'.$red->result_type.'</b>',
				'gross_amount' => $red->gross_amount,
				'result_type' => $red->result_type,
				'result_data' => $action.''.$str_data,
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
