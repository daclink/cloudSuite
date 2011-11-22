<?php namespace CloudSuite

/**
 * This file represents the primary REST portion
 * of CloudSuite. This file supplies all the
 * functions, utilities, and objects necessary
 * for CloudSuite to function.
 *
 * @author daclink
 */

class RestUtils
	{
		public static function processRequest()
		{
			//fetch our verb
			$request_method	= strtolower($_SERVER['REQUEST_METHOD']);
			$return_obj		= new RestRequest();

			$data			= array();

			switch ($request_method)
			{
				case 'get':
					$data = $_GET;
					break;
				case 'post':
					$data = $_POST;
					break;
				case 'put':
					parse_str(file_get_contents('php://input'), $put_vars);
					break;
			}
			$return_obj->setRequestVars($data);

			if(isset($data['data']))
			{
				// translate the JSON to an Object for use.
				//TODO:add XML too.
				$return_obj->setData(json_decode($data['data']));
			}
			return $return_obj;
		}
		
		public static function sendResponse($status = 200, $body = '', $content_type = 'text/html')
		{
		}

		public static function getStatusCodeMessage($status)
		{
			$codes = Array(
				100 => 'Continue',
				200 => 'Ok',
				400 => 'Bad request'
				);

			return (isset($codes[$status])) ? $codes[$status] : '';
		}
    
	}

class RestRequest
{
	private $request_vars;
	private $data;
	private $http_accept;
	private $method;

	public function __construct()
	{
		$this->request_vars	= array();
		$this->data			= '';
		$this->http_accept	= (strpos($_SERVER['HTTP_ACCEPT'], 'json')) ? 'json' : 'xml';
		$this->method		= 'get';
	}

	public function setData($data)
	{
		$this->data = $data;
	}
	
	public function setMethod($method)
	{
		$this->method = $method;
	}

	public function getRequestVars($request_vars)
	{
		$this->request_vars = $request_vars;
	}

	public function getData()
	{
		return $this->data;
	}

	public function getMethod()
	{
		return $this->method;
	}

	public function getHttpAccept()
	{
		return $this->http_accept;
	}

	public function getRequestVars()
	{
		return $this->request_vars;
	}

	}
}
?>
