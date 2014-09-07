<?php
/*	Feedstack - A Social Networking Script
 *	----------------------------------------
 *	package 		- app/controllers
 *	file 			- userlog.php
 * 	Developer 		- Krishna Teja G S
 *	Website			- http://www.feedstack.asia
 *	license			- GNU General Public License version 2 or later
*/

defined('_PATHANG') or die;

// Controller to deal with user log operations
// like login/logout/register etc
class ControllerUserLog{

	public function __construct(){
		//set the page to login on object load
		pathang::getInstance('pathang')->SITE->PAGE = 'login';
	}

	//function to process user login
	public function login(){
		//get the instances of session and basket
		$session = pathang::getInstance('session');
		$basket = pathang::getInstance('basket');
		//get username from request object
		$username = trim(pathang::getInstance('request')->filterHTMLSQL('username'));
		//get liveuser from session
		$liveuser = $session->get('liveuser');

		//if live user is available then load the user
		//else if username is available then check for login validation
		// else show the login page
		if($liveuser){
			//show the dashboard
			pathang::render('userlog','loggedin');
		}elseif($username){
			// get the username and password
			$password = trim(pathang::getInstance('request')->filterHTMLSQL('password'));
			//validate user in userlog model
			$status = pathang::getModel('userlog')->validateUser($username,$password);
			// if there is no error then load the userdetails into liveuser and store
			// it in session 
			if(!$status->error){
				$liveuser = new stdclass();
				//load user details
				$liveuser->username = $username;
				$liveuser->id = pathang::getModel('userlog')->getUserId($username);
				$liveuser->name = pathang::getModel('userlog')->getUserFullName($username);
				$liveuser->email = pathang::getModel('userlog')->getUserEmail($username);
				$liveuser->type = pathang::getModel('userlog')->getUserType($username);
				$liveuser->profile_link = ROOT.$liveuser->username;
				$liveuser->image_type = pathang::getModel('userlog')->getUserImageType($username);
				$liveuser->image = pathang::getHelper('userlog')->getUserImage($liveuser);
				$liveuser->feeds_per_page = pathang::getModel('userlog')->getFeedCount($username);
				$liveuser->access_token = pathang::getHelper('userlog')->getToken(pathang::getModel('userlog')->getUserLastLogin($username),$liveuser->id);

				//store liveuser in session
				$session->set('liveuser',$liveuser);
				// show dashboard
				pathang::redirect(ROOT);
			}else{
				//if error in login display error in login page
				// Error could be
				// error 1 - User not found
				// error 2 - Wrong password
				// error 3 - User blocked
				// error 4 - User not activated
				$basket->set('status_message',$status->message);
				$basket->set('status_error',$status->error);
				$basket->set('username',$username);
				//show login page
				pathang::render('userlog','login');
			}
		}
		else{
			//show login page
			pathang::render('userlog','login');
		}
	}

	//function to register the user with database
	public function register(){
		//load request and basket object
		$request = pathang::getInstance('request');
		$username = $request->filterHTMLSQL('username');
		$basket = pathang::getInstance('basket');
		//load node object and get n3 and n4 nodes
		$node = pathang::getInstance('node');
		$n3 = $node->get('n3');
		$n4 = $node->get('n4');
		//get the userlog model
		$userlogModel = pathang::getModel('userlog');
		// if the node is sendactivation 
		// get the code from database based on username
		// re-send in email
		if($n3=='sendactivation'){
			$code = $userlogModel->getActivationCode($n4);
			$email = $userlogModel->getUserEmail($n4);
			//echo $code;
			pathang::getHelper('userlog')->resendActivationMail($code,$email);
			if($code!=1){
				pathang::render('userlog','register_reactivation');
			}else{
				$basket->set('heading','User Activated');
				$basket->set('message','User is already activated. Please login
						to utilize the website services');
				pathang::Render('userlog','user_activation_message');
			}
		// if the node is activate
		//	activate account in userlog model and display message accordingly
		}elseif($n3=='activate'){
			$code = $n4;
			$activated = $userlogModel->activateUser($code);
			if($activated)
			{
				$basket->set('heading','User Activated');
				$basket->set('message','Your account has been successfully 
					activated.Please enter your login credentials
					in the login page to singin to the website.');
			}else{
				$basket->set('heading','Error in activation');
				$basket->set('message','Please contact the site administrator
					 to rectify the error.');
			}
			pathang::Render('userlog','user_activation_message');
		}
		elseif($username){
			// if the username is defined in request parameter
			// process the registration
			// display the success or error message
			$code = $userlogModel->registerUser();
			$basket->set('username',$username);
			$email = $request->filterHTMLSQL('email');
			$basket->set('email',$email);
			pathang::getHelper('userlog')->sendActivationMail($code,$email);
			pathang::render('userlog','register_activation');
		}else
		{
			pathang::render('userlog','register');
		}

	}

	public function forgot(){
		$node = pathang::getInstance('node');
		$request = pathang::getInstance('request');
		$basket = pathang::getInstance('basket');
		$email = $request->filterHTMLSQL('email');
		$password = $request->filterHTMLSQL('password');
		$n3 = $node->get('n3');
		pathang::getInstance('pathang')->SITE->PAGE = 'login';
		if($email){
			$code = pathang::getModel('userlog')->setForgotCode($email);
			if($code == 2)
			{
				$basket->set('heading','Error in Operation');
				$basket->set('message','There is an error in the operation performed.
						Please redo the process.');
			}elseif($code == 3)
			{
				$basket->set('heading','Email Not Found');
				$basket->set('message','Email you have provided is not registered with our
					database.Please enter the correct email id and redo the process.');
			}else
			{
				$basket->set('heading','Reset Password Email');
				$basket->set('message','Password reset instructions has been sent to your email. Follow
					the instructions in the mail to create a new password. Please check your spam box
					if in case you dont recieve a mail.');

				//echo $code;
				pathang::getHelper('userlog')->sendForgotPasswordMail($code,$email);
			}
			pathang::Render('userlog','forgot_message');
		}elseif($n3){
			if($password){
				$update = pathang::getModel('userlog')->updateForgotPassword($n3,$password);
				if($update==1){
					$basket->set('heading','Successfully Updated Password');
					$basket->set('message','Your password has been successfully updated.Please
						login to enter the site');
				}else
				{
					$basket->set('heading','Error in Operation');
					$basket->set('message','There is an error in the operation performed.
						Please redo the process.');
				}
				pathang::Render('userlog','forgot_message');
			}else{
				pathang::render('userlog','reset_password');
			}
		}else{
			pathang::getInstance('pathang')->SITE->PAGE = 'login';
			pathang::render('userlog','forgot');	
		}
	}

	public function usernameCheck(){
		$username= pathang::getInstance('request')->filterHTMLSQL('username');
		$checkUsername = pathang::getModel('userlog')->usernameCheck($username);
		if($checkUsername)
		{
			echo 1;
		}else{
			echo 0;
		}
	}

	public function emailCheck(){
		$email = pathang::getInstance('request')->filterHTMLSQL('email');
		$checkEmail = pathang::getModel('userlog')->emailCheck($email);
		if($checkEmail)
		{
			echo 1;
		}else{
			echo 0;
		}
	}

	public function logout(){
		$session = pathang::getInstance('session');
		$session->destroy();
		pathang::getInstance('pathang')->SITE->PAGE = 'login';
		pathang::render('userlog','login');
	}
}