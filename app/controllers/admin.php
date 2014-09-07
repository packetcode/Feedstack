<?php
/*	Feedstack - A Social Networking Script
 *	----------------------------------------
 *	package 		- app/controllers
 *	file 			- admin.php
 * 	Developer 		- Krishna Teja G S
 *	Website			- http://www.feedstack.asia
 *	license			- GNU General Public License version 2 or later
*/

defined('_PATHANG') or die;

// Controller to deal with admin tasks
class ControllerAdmin{

	public function __construct(){
		//defining the theme page to admin for all requests through node-admin
		pathang::getInstance('pathang')->SITE->PAGE = 'admin';
	}

	// function to display Admin dashboard
	// gives the count of users,likes,comments and connections
	// and links to the other admin pages
	public function main(){
		//get basket object instance
		$basket = pathang::GetInstance('basket');

		//load the admin model and retrive the user,like,comment,connection count
		//store it in array 'count'
		$model = pathang::GetModel('admin');
		$count = array();
		$count['users'] = $model->getCount('users');
		$count['likes'] = $model->getCount('likes');
		$count['comments'] = $model->getCount('comments');
		$count['connections'] = $model->getCount('followers');

		//formatting for precision
		foreach($count as $a =>$b)
		{
			if($b>9999)
			{
				if($b>999999)
				$count[$a]=round($b/1000000, 2).'M';
				else
				$count[$a]=round($b/1000, 1).'K';
			}

		}

		//store the counter in  basket object
		$basket->set('count',$count);
		//render the dasboard page
		pathang::render('admin','dashboard');
	}

	// function to  display/manipulate the general settings of the page
	// saves the data in config.json file
	public function general(){
		//get request and pathang instance 
		$request = pathang::getInstance('request');
		$pathang = pathang::getInstance('pathang');
		//properties  to change in the config
		$site = array("root", "theme", "session_expire","footer","logo");
		$db = array("db_name", "host", "username","password");
		$social = array("facebook", "google_plus", "twitter");
		$meta = array("site_name","title","author","desc","keywords","image");

		//check the request object for above properties
		if($request->Get('root')){
			foreach($request as $a => $b)
			{
				if(in_array($a,$site)){
					$a= strtoupper($a);
					$pathang->SITE->$a = $b;
				}
				if(in_array($a,$db)){
					$a= strtoupper($a);
					$pathang->DB->$a = $b;
				}
				if(in_array($a,$social)){
					$a= strtoupper($a);
					$pathang->SOCIAL_LINKS->$a=$b;
				}
				if(in_array($a,$meta)){
					$a= strtoupper($a);
					$pathang->META->$a=$b;
				}
			}
			$pathang->META->SITE_URL = $pathang->SITE->ROOT;
			//save the config data to config.json
			file_put_contents('config.json', json_encode($pathang, JSON_PRETTY_PRINT));
			pathang::getInstance('basket')->set('save','saved');
		}
		//render the general page
		pathang::render('admin','general');
	}

	// function to display/manipulate feed settings
	// saving it to config.json
	public function feed(){
		//get instance of request/pathang objects
		$request = pathang::getInstance('request');
		$pathang = pathang::getInstance('pathang');

		// store the settings in feedstack parameter
		if($request->Get('feed_count')){
			foreach($request as $a => $b)
			{
					$a= strtoupper($a);
					if($a!='URL')
					$pathang->FEEDSTACK->$a = $b;
			}

			//save the config
			file_put_contents('config.json', json_encode($pathang, JSON_PRETTY_PRINT));
			pathang::getInstance('basket')->set('save','saved');
		}
		//render the feed page
		pathang::render('admin','feed');
	}

	// function to display/manipulate Ads settings
	// saving it to config.json
	public function ads(){
		// get the instance of  request and pathang object
		$request = pathang::getInstance('request');
		$pathang = pathang::getInstance('pathang');

		// save the request data for ads in config
		if($request->get('250') || $request->get('visible')){
			foreach($request as $a => $b)
			{
					$a= strtoupper($a);
					if($a!='URL')
					$pathang->AD_BLOCK->$a = trim(preg_replace('/\t+/', '', $b));
			}
			file_put_contents('config.json', json_encode($pathang, JSON_PRETTY_PRINT));
			pathang::getInstance('basket')->set('save','saved');
		}
		//render ads page
		pathang::render('admin','ads');
	}


	// function to display/manipulate Mailgun settings
	// saving it to config.json
	public function mailgun(){
		$request = pathang::getInstance('request');
		$pathang = pathang::getInstance('pathang');
		if($request->get('api_key') || $request->get('admin_email')){
			foreach($request as $a => $b)
			{
					$a= strtoupper($a);
					if($a!='URL')
					$pathang->MAILGUN->$a = $b;
			}
			file_put_contents('config.json', json_encode($pathang, JSON_PRETTY_PRINT));
			pathang::getInstance('basket')->set('save','saved');
		}
		pathang::render('admin','mail');
	}

	// function to display/manipulate custom page settings
	// saving it to config.json
	public function page(){
		$request = pathang::getInstance('request');
		$basket = pathang::getInstance('basket');
		if($request->get('post')){
			file_put_contents('app/views/general/about.php', $request->Get('about'));
			file_put_contents('app/views/general/terms.php', $request->Get('terms'));
			file_put_contents('app/views/general/contact.php', $request->Get('contact'));
		}
		$about = file_get_contents(ROOT.'about.html');
		$terms = file_get_contents(ROOT.'terms.html');
		$contact = file_get_contents(ROOT.'contact.html');
		$basket->set('about',$about);
		$basket->set('terms',$terms);
		$basket->set('contact',$contact);
		pathang::render('admin','page');
	}


	public function blockUser(){
		$request = pathang::GetInstance('request');
		$uid = $request->get('uid');
		//check for validity of access token
		pathang::getHelper('userlog')->ajaxAuthentication();
		
		$status = pathang::GetModel('userlog')->blockUser($uid);
		if($status)
			echo '1';
		else
			echo '0';
	}

	public function unblockUser(){
		$request = pathang::GetInstance('request');
		$uid = $request->get('uid');
		//check for validity of access token
		pathang::getHelper('userlog')->ajaxAuthentication();
		
		$status = pathang::GetModel('userlog')->unblockUser($uid);
		if($status)
			echo '1';
		else
			echo '0';
	}

	public function activateUser(){
		$request = pathang::GetInstance('request');
		$uid = $request->get('uid');
		//check for validity of access token
		pathang::getHelper('userlog')->ajaxAuthentication();
		
		$status = pathang::GetModel('userlog')->activateUserByAdmin($uid);
		if($status)
			echo '1';
		else
			echo '0';
	}

	public function deleteUser(){
		$request = pathang::GetInstance('request');
		$uid = $request->get('uid');
		//check for validity of access token
		pathang::getHelper('userlog')->ajaxAuthentication();
		
		$status = pathang::GetModel('userlog')->deleteUser($uid);
		
		if($status)
			echo '1';
		else
			echo '0';
	}
}