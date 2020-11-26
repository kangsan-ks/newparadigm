<?php
namespace App\Classes;

class jsonRPCClient {
	/**
	 * Debug state
	 *
	 * @var boolean
	 */
	private $debug;

	/**
	 * The server URL
	 *
	 * @var string
	 */
	private $url;
	/**
	 * The request id
	 *
	 * @var integer
	 */
	private $id;
	/**
	 * If true, notifications are performed instead of requests
	 *
	 * @var boolean
	 */
	private $notification = false;

	/**
	 * Takes the connection parameters
	 *
	 * @param string $url
	 * @param boolean $debug
	 */
	public function __construct($url,$debug = false) {
		// server URL
		$this->url = $url;
		// proxy
		empty($proxy) ? $this->proxy = '' : $this->proxy = $proxy;
		// debug state
		empty($debug) ? $this->debug = false : $this->debug = true;
		// message id
		$this->id = 1;
	}

	/**
	 * Sets the notification state of the object. In this state, notifications are performed, instead of requests.
	 *
	 * @param boolean $notification
	 */
	public function setRPCNotification($notification) {
		empty($notification) ? $this->notification = false  :  $this->notification = true;
	}

	/**
	 * Performs a jsonRCP request and gets the results as an array
	 *
	 * @param string $method
	 * @param array $params
	 * @return array
	 */
	public function __call($method,$params) {

		// check
		if (!is_scalar($method)) {
			throw new Exception('Method name has no scalar value');
		}

		// check
		if (is_array($params)) {
			// no keys
			$params = array_values($params);
		} else {
			throw new Exception('Params must be given as array');
		}

		// sets notification or request task
		if ($this->notification) {
			$currentId = NULL;
		} else {
			$currentId = $this->id;
		}

		// prepares the request
		$request = array(
		'method' => $method,
		'params' => $params,
		'id' => $currentId
		);
		$request = json_encode($request);
		$this->debug && $this->debug.='***** Request *****'."\n".$request."\n".'***** End Of request *****'."\n\n";

		// performs the HTTP POST               
		$ch = curl_init($this->url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		
		if (curl_errno($ch)) {
			//throw new Exception('JSON-RPC Error: %s.', curl_error($ch));
			return "rpcerror";
			exit;
		}
		$response = curl_exec($ch);
		if($response === false)
		{
			//throw new Exception('Unable to connect to '.$this->url);
			return "rpcerror";
			exit;
		}
				
		$this->debug && $this->debug.='***** Server response *****'."\n".$response.'***** End of server response *****'."\n";
		$response = json_decode($response,true);

		// debug output
		if ($this->debug) {
			echo nl2br($debug);
		}

		// final checks and return
		if (!$this->notification) {
		// check
			if ($response['id'] != $currentId) {
					//throw new Exception('Incorrect response id (request id: '.$currentId.', response id: '.$response['id'].')');
					return "rpcerror";
					exit;
			}
			if (!is_null($response['error'])) {
					//throw new Exception('Request error: '.$response['error']['message']);
					return "rpcerror";
					exit;
			}
			$data['message']=$response['result'];
			$data['error']=$response['error'];
			
			

			return $data;

		} else {
			return true;
		}
	}
}