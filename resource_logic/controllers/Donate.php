<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Donate extends ST_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('Master_mod'));
		
		$params = array('server_key' => MIDTRANS_SERVERKEY, 'production' => MIDTRANS_PRODUCTION, 'secure' => MIDTRANS_3DSECURE);
		$this->load->library(array('midtrans', 'veritrans'));
		$this->midtrans->config($params);
		$this->veritrans->config($params);
	}
	
	public function index()
	{
		$data = array(
			'meta_title' => translation('page_donate_title'),
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => '',
		);
		
		$this->render(array('donate/home'), $data, 0);
	}
	
	public function token()
    {
	//ini_set("display_errors",1);
		if (! $this->input->is_ajax_request()) { $this->response(array('success' => FALSE)); }
		
		if($this->input->post()){
			$this->form_validation->set_rules('gross_amount', 'gross_amount', 'trim|required|min_length[5]');
			$this->form_validation->set_rules('first_name', 'first_name', 'trim|required|max_length[50]'); 
			$this->form_validation->set_rules('last_name', 'last_name', 'trim|required|max_length[50]'); 
			$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|max_length[255]'); 
			$this->form_validation->set_rules('phone', 'phone', 'trim|required|min_length[6]|max_length[20]');
			
			if ($this->form_validation->run()==TRUE) {

				//Variable
				$gross_amount = (int)$this->input->post('gross_amount');
				$first_name = $this->input->post('first_name');
				$last_name = $this->input->post('last_name');
				$email = $this->input->post('email');
				$phone = $this->input->post('phone');
				$monthly = $this->input->post('monthly');
				
				//Generate TX/Transaction ID
				$dates = date('ym');
				$count = $this->db->limit(1)->get_where('donate_counter', array('dates' => $dates))->row();
				if(! $count){
					$this->db->insert('donate_counter', array('dates' => $dates, 'counter' => 1));
					$counter = 1;
				}else{
					$this->db->where(array('id' => $count->id))->set('counter','counter+1', FALSE)->update('donate_counter');
					$counter = ($count->counter + 1);
				}
				$uid =  substr_replace('00000000',$counter,-strlen($counter));
				$orderid = $this->_genToken(3).$dates.$uid;
				
				// Required
				$transaction_details = array(
					'order_id' => $orderid,
					'gross_amount' => $gross_amount, // no decimal allowed for creditcard
				);
				
				//User Donate
				$user = $this->db->limit(1)->get_where('donate_user', array('email' => $email, 'phone' => $phone))->row();

				if($user){
					$info = array(
						'updated' => date('Y-m-d H:i:s'),
						'agent' => $this->_myagent(),
					);
					
					$this->db->update('donate_user', $info, array('user_id' => $user->user_id));
					
					$userid = $user->user_id;
				}else{
					$info = array(
						'first_name' => $first_name,
						'last_name' => $last_name,
						'email' => $email,
						'phone' => $phone,
						'monthly' => ($monthly ? $monthly : 'false'),
						'status' => 'spam',
						'created' => date('Y-m-d H:i:s'),
						'updated' => date('Y-m-d H:i:s'),
						'agent' => $this->_myagent(),
					);
					
					$this->db->insert('donate_user', $info);
					$userid = $this->db->insert_id();
				}
				
				//User subscribe
				if($this->input->post('subscribe')){
					$subscribe = $this->db->limit(1)->get_where('subscribe', array('email' => $email))->row();
					if(! $subscribe){
						$info_subscribe = array(
							'email' => $email,
							'phone' => $phone,
							'created' => date('Y-m-d H:i:s'),
							'updated' => date('Y-m-d H:i:s'),
							'ip' => $this->input->ip_address(),
							'agent' => $this->_myagent(),
						);
						
						if($this->db->insert('subscribe', $info_subscribe)){
							//send to email
							$message = array(
								'title' => 'YKAN Subscription',
								'message' => 'Anda telah berhasil melakukan subscribe, setiap bulannya Anda akan menerima newsletter.'
							);
							$this->_sendtoEmail('subscription', $email, $message);
						}
					}
				}
				
				// Optional
				$item_details = array(
					array(
					  'id' => $userid,
					  'price' => $gross_amount,
					  'quantity' => 1,
					  'name' => "Donasi YKAN"
					)
				);
				
				// Optional
				$customer_details = array(
				  'first_name'    => $first_name,
				  'last_name'     => $last_name,
				  'email'         => $email,
				  'phone'         => $phone,
				  'billing_address'  => '',
				  'shipping_address' => ''
				);
			
				// CC
				$cc = array(
				  'secure'    => true,
				);


				
				// Fill transaction details
				$transaction = array(
				  'credit_card'		=> $cc,
				  'transaction_details' => $transaction_details,
				  'customer_details' => $customer_details,
				  'item_details' => $item_details,
				);
				
				$snapToken = $this->midtrans->getSnapToken($transaction);

				if($snapToken){
					$this->response(array('success' => TRUE, 'token' => $snapToken, 'orderid' => $orderid, 'userid' => $userid));
				}
			}
		}
		
		$this->response(array('success' => FALSE));
    }
	
	public function notification()
	{

		$json_result = file_get_contents('php://input');
		$result = json_decode($json_result);
/*
echo '<pre>';
print_r($result);
echo '</pre>';
echo $result->order_id;
*/

		if($result->order_id){
			$notif = $this->veritrans->status($result->order_id);

			try{
					$transaction = $notif->transaction_status;
					$type = $notif->payment_type;
					$order_id = $notif->order_id;
					$fraud = $notif->fraud_status;

					if($transaction == 'capture'){
						// For credit card transaction, we need to check whether transaction is challenge by FDS or not
						if($type == 'credit_card'){
							if($fraud == 'challenge'){
								// TODO set payment status in merchant's database to 'Challenge by FDS'
								// TODO merchant should decide whether this transaction is authorized or not in MAP
								 echo "Transaction order_id: " . $order_id ." is challenged by FDS";
								$this->db->update('donate_transaction', array('result_type' => 'challenge', 'result_data' => json_encode($notif)), array('order_id' => $order_id));
							}else{
								// TODO set payment status in merchant's database to 'Success'
								 echo "Transaction order_id: " . $order_id ." successfully captured using " . $type;
								$this->db->update('donate_transaction', array('result_type' => 'success', 'result_data' => json_encode($notif)), array('order_id' => $order_id));
							}
						}
					}elseif($transaction == 'settlement'){
						// TODO set payment status in merchant's database to 'Settlement'
						 echo "Transaction order_id: " . $order_id ." successfully transfered using " . $type;
						$this->db->update('donate_transaction', array('result_type' => 'settlement', 'result_data' => json_encode($notif)), array('order_id' => $order_id));
					}elseif($transaction == 'pending'){
						// TODO set payment status in merchant's database to 'Pending'
						 echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
						$this->db->update('donate_transaction', array('result_type' => 'pending', 'result_data' => json_encode($notif)), array('order_id' => $order_id));
					}elseif($transaction == 'deny'){
						// TODO set payment status in merchant's database to 'Denied'
						echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
						$this->db->update('donate_transaction', array('result_type' => 'deny', 'result_data' => json_encode($notif)), array('order_id' => $order_id));
					}else if ($transaction == 'expire') {
						// TODO set payment status in merchant's database to 'expire'
						$this->db->update('donate_transaction', array('result_type' => 'expire', 'result_data' => json_encode($notif)), array('order_id' => $order_id));
						echo "Payment using " . $type . " for transaction order_id: " . $order_id . "is expired.";
					}else if ($transaction == 'cancel') {
					  	// TODO set payment status in merchant's database to 'Denied'
						$this->db->update('donate_transaction', array('result_type' => 'cancel', 'result_data' => json_encode($notif)), array('order_id' => $order_id));
					  	echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is canceled.";
					}
				}catch(Exception $e) {
    				echo 'Caught exception: ',  $e->getMessage(), "\n";				
				}
		}else{
			echo 'OrderID Notfound';
		}
		//header("HTTP/1.1 200 OK");
	}
	
	public function saved()
	{
		if($this->input->post()){
			$this->form_validation->set_rules('result_data', 'result_data', 'trim|required');
			$this->form_validation->set_rules('result_type', 'result_type', 'trim|required');
			$this->form_validation->set_rules('gross_amount', 'gross_amount', 'trim|required|min_length[6]');
			$this->form_validation->set_rules('order_id', 'order_id', 'trim|required');
			$this->form_validation->set_rules('user_id', 'user_id', 'trim|required');
			
			if ($this->form_validation->run()==TRUE) {
				$info = array(
					'user_id' => $this->input->post('user_id'),
					'order_id' => $this->input->post('order_id'),
					'gross_amount' => $this->input->post('gross_amount'),
					'result_data' => $this->input->post('result_data'),
					'result_type' => $this->input->post('result_type'),
					'created' => date('Y-m-d H:i:s'),
					'updated' => date('Y-m-d H:i:s'),
					'agent' => $this->_myagent(),
				);
				
				if($this->db->insert('donate_transaction', $info)){
					$this->session->set_userdata('donate_success', true);
					redirect('donasi/sukses');
				}
			}
		}
		
		redirect('donasi');
	}
	
	public function success()
	{
		if(! $this->session->userdata('donate_success')){
			redirect('donasi');
		}
		
		//Unset
		$this->session->unset_userdata('donate_success');
		
		$data = array(
			'meta_title' => translation('page_donate_title'),
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => '',
		);
		
		$this->render(array('donate/success'), $data, 0);
	}
	
	public function unfinish()
	{
		$data = array(
			'meta_title' => translation('page_donate_title'),
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => '',
		);
		
		$this->render(array('donate/unfinish'), $data, 0);
	}
	
	public function error()
	{
		$data = array(
			'meta_title' => translation('page_donate_title'),
			'meta_description' => '',
			'meta_picture' => '',
			'meta_tags' => '',
		);
		
		$this->render(array('donate/error'), $data, 0);
	}
}
