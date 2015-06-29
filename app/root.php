<?php
/*	Feedstack - A Social Networking Script
 *	----------------------------------------
 *	package 		- app
 *	file 			- root.php
 * 	Developer 		- Krishna Teja G S
 *	Website			- http://www.feedstack.asia
 *	license			- GNU General Public License version 2 or later
*/

defined('_PATHANG') or die;

// The central controller of the application
// each method corresponds to the urls first fragment

class controllerRoot{

	//starting the session
	public function __construct(){
		session_start();
	}

	// function to perform the installation
	public function installation(){
		$request=pathang::getInstance('request');
		if($request->get('username')){
			pathang::GetModel('install')->main($request);
			pathang::getInstance('node')->set('terminal_ext','html');
			pathang::Render('install','success');
		}else{
		pathang::getInstance('node')->set('terminal_ext','html');
		pathang::Render('install','main');
		}
	}

	//This is the function called if no node is defined in the url
	public function main()
	{
		$session = pathang::GetInstance('session');
		$liveuser = $session->get('liveuser');
		$username = pathang::getInstance('node')->get('n1');
		$option = pathang::getInstance('node')->get('n2');
		$allowedType = array("text", "photo", "video", "link");
		$type = pathang::getInstance('node')->get('n2');
		if($username && !in_array($username, $allowedType)){
			$allowedType = array('following','followers','edit','image',
					'image_upload','image_dupload','crop','cropimage','notifications');
			if($option && in_array($option, $allowedType))
					pathang::getController('profile')->$option();
			else	
				pathang::GetController('profile')->page($username);
		}else
		{
			if($liveuser){

				pathang::getInstance('pathang')->SITE->PAGE = 'index';
					pathang::getController('feed')->wall();
			}else{
				pathang::getInstance('pathang')->SITE->PAGE = 'frontpage';
				pathang::render('general','frontpage');
			}	
		}
		
	}

	public function about(){
		pathang::getInstance('pathang')->SITE->PAGE='members';
		pathang::render('general','about');
	}

	public function terms(){
		pathang::getInstance('pathang')->SITE->PAGE='members';
		pathang::render('general','terms');
	}
	public function contact(){
		pathang::getInstance('pathang')->SITE->PAGE='members';
		pathang::render('general','contact');
	}

	public function members(){
		pathang::getInstance('pathang')->SITE->PAGE='members';
		pathang::getController('usermain')->showMembers();
	}

	public function feed(){
		pathang::getInstance('pathang')->SITE->PAGE='members';
		$n2 = strtoupper(pathang::getInstance('node')->get('n2'));
		$feedController = pathang::getController('feed');

		if(method_exists($feedController, $n2))
			$feedController->$n2();
		else
			$feedController->view();
	}

	public function admin(){
		$n2 = strtoupper(pathang::getInstance('node')->get('n2'));
		$liveuser_id =null;
		$liveuser = pathang::GetInstance('session')->get('liveuser');
		if($liveuser)
			$liveuser_id = $liveuser->id;
		$isadmin = pathang::getModel('userlog')->isAdmin($liveuser_id);

		if(!$isadmin){
			pathang::GetInstance('pathang')->SITE->PAGE = 'login';
			$basket = pathang::GetInstance('basket');
			$basket->set('heading','Restricted Access !');
			$basket->set('message','You dont have enough privilege to acces this page. Sorry for the inconvenience. ');	
			pathang::render('general','errorpage');
			exit();
		}else{
			if($n2==null)
				$n2='main';
			pathang::getController('admin')->$n2();
		}
	}

	public function user(){
		$n2 = strtoupper(pathang::getInstance('node')->get('n2'));
		switch($n2){
			case 'LOGIN':
			case 'LOGOUT':
			case 'REGISTER':
			case 'FORGOT':
			case 'USERNAMECHECK':
			case 'EMAILCHECK':
				pathang::getController('userlog')->$n2();
				break;
			case 'SEARCH':
			case 'FOLLOW':
			case 'UNFOLLOW':
			case 'NOTIFY':
				pathang::getController('usermain')->$n2();
				break;	
			default:
				$this->main();	
		}

	}
}
