<?php
/*	Feedstack - A Social Networking Script
 *	----------------------------------------
 *	package 		- app/helpers
 *	file 			- userlog.php
 * 	Developer 		- Krishna Teja G S
 *	Website			- http://www.feedstack.asia
 *	license			- GNU General Public License version 2 or later
*/

defined('_PATHANG') or die;

// A support helper file for the controller userlog
class HelperUserLog{

	public function sendActivationMail($code,$email){
		$to = $email;

		$url = ROOT.'user/register/activate/'.$code;
		$subject = 'Activate your account';
		$from = pathang::getInstance('pathang')->MAILGUN->ADMIN_EMAIL;
		$title = pathang::getInstance('pathang')->META->TITLE;
		$desc = pathang::getInstance('pathang')->META->DESC;
		$name = pathang::GetModel('userlog')->getUserFullName(null,$to);
		
		$headers = "From: " . strip_tags($from) . "\r\n";
		$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
		$message = '<html><body>';
		$message .= '<p>hi '.$name.' !</p>';
		$message .= '<p>your account has been successfully created.
					please click on the below link to activate your account </p>';
		$message .= '<p><a href="'.$url.'">'.$url.'</a></p><br>';
		$message .= "<p><b>$title</b><br>$desc<br>";
		$message .= "<small><a href='".ROOT."'>".ROOT."</a></small></p>";
		$message .= '</body></html>';
		
		$this->email($to, $subject, $message);
	}

	public function resendActivationMail($code,$email){
		$to = $email;

		$url = ROOT.'user/register/activate/'.$code;
		$subject = 'Activate your account';
		$from = pathang::getInstance('pathang')->MAILGUN->ADMIN_EMAIL;
		$title = pathang::getInstance('pathang')->META->TITLE;
		$desc = pathang::getInstance('pathang')->META->DESC;
		$name = pathang::GetModel('userlog')->getUserFullName(null,$to);
		
		$headers = "From: " . strip_tags($from) . "\r\n";
		$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
		$message = '<html><body>';
		$message .= '<p>hi '.$name.' !</p>';
		$message .= '<p>please click on the below link to activate your account </p>';
		$message .= '<p><a href="'.$url.'">'.$url.'</a></p><br>';
		$message .= "<p><b>$title</b><br>$desc<br>";
		$message .= "<small><a href='".ROOT."'>".ROOT."</a></small></p>";
		$message .= '</body></html>';
		
		$this->email($to, $subject, $message);
	}

	public function email($to,$subject,$msg) {
		$email = $to;
		$pathang = pathang::GetInstance('pathang');
 		$api_key= $pathang->MAILGUN->API_KEY;
 		$domain =$pathang->MAILGUN->DOMAIN_NAME;
 		$from = $pathang->MAILGUN->ADMIN_EMAIL;
 		$title = Ucfirst(pathang::getInstance('pathang')->META->TITLE);
	 
		 $ch = curl_init();
		 curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		 curl_setopt($ch, CURLOPT_USERPWD, 'api:'.$api_key);
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		 curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v2/'.$domain.'/messages');
		 curl_setopt($ch, CURLOPT_POSTFIELDS, array(
		  'from' => $title.'<'.$from.'>',
		  'to' => $email,
		  'subject' => $subject,
		  'html' => $msg
		 ));
		 $result = curl_exec($ch);
		 curl_close($ch);

		 return $result;
	}

	public function sendForgotPasswordMail($code,$email){
		$to = $email;
		$url = ROOT.'user/forgot/'.$code;
		$subject = 'Forgot Password Instruction';
		$from = pathang::getInstance('pathang')->MAILGUN->ADMIN_EMAIL;
		$title = pathang::getInstance('pathang')->META->SITE_NAME;
		$desc = pathang::getInstance('pathang')->META->DESC;
		$name = pathang::GetModel('userlog')->getUserFullName(null,$to);
		
		$headers = "From: " . strip_tags($from) . "\r\n";
		$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
		$message = '<html><body>';
		$message .= '<p>hi '.$name.' !</p>';
		$message .= '<p>please click on the below link to create a new password </p>';
		$message .= '<p><a href="'.$url.'">'.$url.'</a></p><br>';
		$message .= "<p><b>$title</b><br>$desc<br>";
		$message .= "<small><a href='".ROOT."'>".ROOT."</a></small></p>";
		$message .= '</body></html>';
		
		$this->email($to, $subject, $message);
	}


	public function getUsersImage($users){
		
		foreach($users as $a=>$b){

			$username = $b->username;
			$email = $b->email;
			$image_type = $b->image_type;

			switch($image_type){
				case 'gravatar':
				$image= $this->_getServerImage($username);
					//$image= $this->_getGravatar($email);
				break;
				case 'server':
					$image= $this->_getServerImage($username);
				break;
				default:
					$image = $this->_getServerImage($username);
			}

			$users->$a->image = $image;
		}

		return $users;
	}

	public function getUserImage($liveuser){
		$username = $liveuser->username;
		$email = $liveuser->email;
		$image_type = $liveuser->image_type;

		switch($image_type){
			case 'gravatar':
				//return $this->_getGravatar($email);
			//break;
			case 'server':
				return $this->_getServerImage($username);
			break;
			default:
				return $this->_getServerImage($username);
		}
		
	}

	public function _getGravatar($email){
		$con = $this->_is_connected();
		if($this->is_localhost() && $con)
		 	$default = 'http://feedstack.asia/img/user.jpg';
		elseif($this->is_localhost() && !$con)
			$default = ROOT.'img/user.jpg';
		else
			$default = ROOT.'img/user.jpg';

		if($con)
		return  "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) .
			 "?d=" . urlencode( $default ) . "&s=120";
		else
			return $default;
	}

	public function _getServerImage($username){
		$imagepath_jpg = 'img'.DS.'users'.DS.$username.'.jpg';
		$imagepath_png = 'img'.DS.'users'.DS.$username.'.png';
		$default_imagepath = 'img'.DS.'user.jpg';

		if(file_exists($imagepath_jpg))
			return ROOT.$imagepath_jpg;
		elseif(file_exists($imagepath_png))
			return ROOT.$imagepath_png;
		else
			return ROOT.$default_imagepath;
	}

	public function _is_connected($path=null){
		if(!$path)
	    $connected = @fsockopen("www.feedstack.asia", 80); 
		else
		$connected = @fsockopen($path, 80); 
	                                        //website, port  (try 80 or 443)
	    if ($connected){
	        $is_conn = true; //action when connected
	        fclose($connected);
	    }else{
	        $is_conn = false; //action in connection failure
	    }
	    return $is_conn;

	}

	public function is_localhost() {
    	$whitelist = array( '127.0.0.1', '::1' );
    	if( in_array( $_SERVER['REMOTE_ADDR'], $whitelist) )
        	return true;
        else
        	return false;
	}

	public function getToken($time_stamp,$uid){
		return str_rot13(strtotime($time_stamp).'t'.$uid);
	}

	public function checkToken($token){
		$string = str_rot13($token);
		$peices = explode('t',$string);
		$time_stamp = date('Y-m-d H:i:s',$peices[0]);
		$uid = $peices[1];

		$status = pathang::getModel('userlog')->validateTimestamp($uid,$time_stamp);
		return $status;
	}

	public function ajaxAuthentication(){
		$request = pathang::getInstance('request');
		if(!$request->get('access_token')){
			echo 'Error:Access Token required to perform this operation';
			exit();
		}else{
			$token = $request->get('access_token'); 
			if($this->checkToken($token)){
				return true;
			}else
			{
				echo 'Error: Access Token Invalid ';
				exit();
			}
		}
	}
}