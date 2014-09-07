<?php
/*	PATHANG			- A SLEAK PHP MVC FRAMEWORK
 *	package 		- lib
 *	file 			- rest.php
 * 	Developer 		- Krishna Teja G S
 *	Website			- https://www.pathang.net
 *	license			- GNU General Public License version 2 or later
*/

defined('_PATHANG') or die;

// Class to deal with rest operations 
class REST {
		
		//defining the content type and base code
		public $_content_type = "application/json";	
		private $_code = 200;
		
		//function to get the referer header
		public function getReferer(){
			return $_SERVER['HTTP_REFERER'];
		}
		
		//function to display failure status in json format
		public function responseFailure($data,$status){
			$this->_code = $status;
			$this->setHeaders();
			$error = new stdClass();
			$msg = new stdClass();
			$error->status = 'fail';
			$msg->code  = $status;
			$msg->message = $data;
			$error->error = $msg;
			print(json_encode($error,JSON_PRETTY_PRINT));
			exit;
		}

		//function to display success status in json format
		public function responseSuccess($data){
			$this->_code = 200;
			$this->setHeaders();
			$success = new stdClass();
			$success->status = 'success';
			$success->data = $data;
			print(json_encode($success,JSON_PRETTY_PRINT));
			exit;
		}
		
		//function to get the request method post/get		
		public function getRequestMethod(){
			return $_SERVER['REQUEST_METHOD'];
		}
		
		//A private function to set the headers
		private function setHeaders(){
			http_response_code($this->_code);
			header("Content-Type:".$this->_content_type);
		}
}	