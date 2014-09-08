<?php
/*	Feedstack - A Social Networking Script
 *	----------------------------------------
 *	package 		- app/controllers
 *	file 			- Profile.php
 * 	Developer 		- Krishna Teja G S
 *	Website			- http://www.feedstack.asia
 *	license			- GNU General Public License version 2 or later
*/
 
defined('_PATHANG') or die;

// Controller to deal with Profile page of user
class ControllerProfile{

	public function __Construct(){
		$liveuser= pathang::getInstance('session')->get('liveuser');
		if(isset($liveuser->username))
		pathang::getInstance('pathang')->FEEDSTACK->FEED_COUNT = $liveuser->feeds_per_page;	
	}

	public function main(){
		pathang::render('admin','dashboard');
	}

	public function page($username){
		
		$basket = pathang::GetInstance('basket');
		$allowedType = array("text", "photo", "video", "link");
		$feed_type = pathang::GetInstance('node')->get('n2');
		$basket->set('feed_type',$feed_type);
		$limit = pathang::getInstance('pathang')->FEEDSTACK->FEED_COUNT;

		//check if user is admin
		if(isset(pathang::getInstance('session')->get('liveuser')->id))
		$liveuser_id=pathang::getInstance('session')->get('liveuser')->id;
		else
			$liveuser_id = null;
		$allowed_delete = pathang::getModel('userlog')->isAdmin($liveuser_id);
		$basket->set('allowed_delete',$allowed_delete);

		//get user information
		$result = pathang::GetModel('profile')->getUserProfile($username);
		if(!$result){
			pathang::GetInstance('pathang')->SITE->PAGE = 'login';
			$basket->set('heading','OPPS !');
			$basket->set('message','The page your searching for doesnot exist.
							Please contact the site administrator for further queries.');	
			pathang::render('general','errorpage');
			exit();
		}
		

		$user = new stdclass();
		foreach($result as $key => $item)
			$user->$key = $item;
		$user->image = pathang::getHelper('userlog')->getUserImage($user);
		$following = pathang::GetModel('profile')->isFollowing($liveuser_id,$user->id);
		$basket->set('following',$following);
		$basket->set('user',$user);

		//check if user profile is public
		if(!$user->access && $liveuser_id==null){
			pathang::GetInstance('pathang')->SITE->PAGE = 'login';
			$basket->set('heading','Private Page');
			$basket->set('message','Requested profile is private, can be accessed only by
				registered users. Please <a href="'.ROOT.'user/login"><b>login</b></a> to the website to view the profile.
					');	
			pathang::render('general','errorpage');
			exit();
		}

		//get user feeds
		if(!$feed_type){
		$feedArray = pathang::getModel('feed')->getFeeds($user->id,null,null,$limit);
			if($feedArray){
				$feedObj = new stdclass();
				foreach($feedArray as $a =>$b){
					$feedTemp = new stdClass();
					foreach($b as $c => $d)
						$feedTemp->$c = $d;
					$feedTemp->image ='';
					$feedTemp->feed = $feedTemp->feed;
					$feedTemp->profile_link = ROOT.$feedTemp->username;
					$feedTemp->image = pathang::getHelper('userlog')->getUserImage($feedTemp);
					$feedTemp->time_stamp = pathang::getHelper('feedprocess')->ago($feedTemp->time_stamp);
					$feedTemp->like_count = pathang::getModel('feed')->getLikeCount($feedTemp->id);
					$feedTemp->liveuser_like = pathang::getModel('feed')->checkLiveuserLike($liveuser_id,$feedTemp->id);
					$feedTemp->comment_count = pathang::getModel('feed')->getCommentCount($feedTemp->id);
		
					$feedObj->$a = $feedTemp;
				}	
				$basket->set('feeds',$feedObj);
			}	
		}else
		{
			$feedArray = pathang::getModel('feed')->getFeeds($user->id,$feed_type,null,$limit);
			if($feedArray){
				$feedObj = new stdclass();
				foreach($feedArray as $a =>$b){
					$feedTemp = new stdClass();
					foreach($b as $c => $d)
						$feedTemp->$c = $d;
					$feedTemp->image ='';
					$feedTemp->feed = $feedTemp->feed;
					$feedTemp->profile_link = ROOT.$feedTemp->username;
					$feedTemp->image = pathang::getHelper('userlog')->getUserImage($feedTemp);
					$feedTemp->time_stamp = pathang::getHelper('feedprocess')->ago($feedTemp->time_stamp);
					$feedTemp->like_count = pathang::getModel('feed')->getLikeCount($feedTemp->id);
					$feedTemp->liveuser_like = pathang::getModel('feed')->checkLiveuserLike($liveuser_id,$feedTemp->id);
					$feedTemp->comment_count = pathang::getModel('feed')->getCommentCount($feedTemp->id);
					
					$feedObj->$a = $feedTemp;
				}	
				$basket->set('feeds',$feedObj);
			}

		}	
		//set limit counter
		$basket->set('limit_counter',$limit);
		pathang::GetInstance('pathang')->SITE->PAGE = 'profile';
		pathang::Render('profile','profile');

		if($user->id==$liveuser_id)
			pathang::GetModel('profile')->updateReadNotifications($user->id);
	}

	public function popular($uid=null){
		$count = pathang::getInstance('pathang')->FEEDSTACK->MEMBER_COUNT;
		$from = pathang::GetInstance('request')->get('from');
		$snippet = pathang::GetInstance('request')->get('snippet');

		$follows = pathang::getModel('profile')->popular();

		$uObj = new stdclass();
		if($follows)
		foreach($follows as $a =>$b){
			$uTemp = new stdClass();
			if($uid!=$b['id'])
			foreach($b as $c => $d)
				$uTemp->$c = $d;
			if(isset($uTemp->id)){
			$uTemp->profile_link = ROOT.$uTemp->username;
			$uTemp->image = pathang::getHelper('userlog')->getUserImage($uTemp);
			$uObj->$a = $uTemp;
			}
		}
		if($snippet)
			return $uObj;
	}

	public function following($uid=null){
		$count = pathang::getInstance('pathang')->FEEDSTACK->MEMBER_COUNT;
		$from = pathang::GetInstance('request')->get('from');
		$snippet = pathang::GetInstance('request')->get('snippet');

		$username =pathang::getInstance('node')->get('n1');
		$uid = pathang::GetModel('userlog')->getUserId($username);
		$uname = pathang::GetModel('userlog')->getUserFullname($username);

		if(!$from)
		$follows = pathang::getModel('profile')->following($uid);
		else
		$follows = pathang::getModel('profile')->following($uid,$from);

		$uObj = new stdclass();
		if($follows)
		foreach($follows as $a =>$b){
			$uTemp = new stdClass();
			if($uid!=$b['id'])
			foreach($b as $c => $d)
				$uTemp->$c = $d;
			if(isset($uTemp->id)){
			$uTemp->profile_link = ROOT.$uTemp->username;
			$uTemp->image = pathang::getHelper('userlog')->getUserImage($uTemp);
			$uObj->$a = $uTemp;
			}
		}

		if($snippet)
			return $uObj;

		pathang::getInstance('pathang')->SITE->PAGE='members';
		$basket = pathang::GetInstance('basket');
		$basket->set('members',$uObj);
		$basket->set('count',$count);
		$basket->set('heading',"$uname :: Following");
		if($from)
			pathang::render('members','members_loadmore');
		else
			pathang::render('members');
	}

	public function followers(){
		$count = pathang::getInstance('pathang')->FEEDSTACK->MEMBER_COUNT;
		$from = pathang::GetInstance('request')->get('from');
		$snippet = pathang::GetInstance('request')->get('snippet');

		$username =pathang::getInstance('node')->get('n1');
		$uid = pathang::GetModel('userlog')->getUserId($username);
		$uname = pathang::GetModel('userlog')->getUserFullname($username);

		if(!$from)
		$follows = pathang::getModel('profile')->followers($uid);
		else
		$follows = pathang::getModel('profile')->followers($uid,$from);

		$uObj = new stdclass();
		if($follows)
		foreach($follows as $a =>$b){
			$uTemp = new stdClass();
			if($uid!=$b['id'])
			foreach($b as $c => $d)
				$uTemp->$c = $d;
			if(isset($uTemp->id)){
			$uTemp->profile_link = ROOT.$uTemp->username;
			$uTemp->image = pathang::getHelper('userlog')->getUserImage($uTemp);
			$uObj->$a = $uTemp;
			}
		}

		if($snippet)
			return $uObj;

		pathang::getInstance('pathang')->SITE->PAGE='members';
		$basket = pathang::GetInstance('basket');
		$basket->set('members',$uObj);
		$basket->set('count',$count);
		$basket->set('heading',"$uname :: Followers");
		if($from)
			pathang::render('members','members_loadmore');
		else
			pathang::render('members');
	}

	public function edit(){
		$basket = pathang::getInstance('basket');
		$request = pathang::getInstance('request');
		$user = pathang::getInstance('node')->get('n1');
		$liveuser = pathang::getInstance('session')->get('liveuser')->username;
		if($user==$liveuser){
			if($request->Get('name')){
				pathang::GetModel('profile')->saveUser();
				header('Location: '.ROOT.$user);
			}
			pathang::getInstance('pathang')->SITE->PAGE = 'no_cache';
			$result = pathang::GetModel('profile')->getUserProfile($user);

			$user = new stdclass();
			foreach($result as $key => $item)
			$user->$key = $item;
			$user->image = pathang::getHelper('userlog')->getUserImage($user);
			$basket->set('user',$user);
			pathang::render('profile','edit');
		}
		else{
			pathang::getInstance('pathang')->SITE->PAGE = 'login';
			$basket->set('heading','Restricted Access');
			$basket->set('message','You dont have enough permission to access this page.');	
			pathang::render('general','errorpage');
			exit();
		}
	}

	public function notifications(){
		$basket = pathang::getInstance('basket');
		$request = pathang::getInstance('request');
		$snippet = $request->get('snippet');
		$user = pathang::getInstance('node')->get('n1');
		
		$limit = pathang::GetInstance('pathang')->FEEDSTACK->NOTIFICATION_CENTER_COUNT;
		if($request->get('limit'))
			$limit = $request->get('limit');
		
		$liveuser = null;
		if(pathang::getInstance('session')->get('liveuser')){
		$liveuser = pathang::getInstance('session')->get('liveuser')->username;
		$uid = pathang::getInstance('session')->get('liveuser')->id;
		}
		if($user==$liveuser){
			$notify = pathang::getModel('profile')->getUserNotifications($user,$limit);
			$notifyObj = new stdclass();
			if(isset($notify))
			foreach($notify as $a =>$b){
					$notifyTemp = new stdClass();
					foreach($b as $c => $d)
						$notifyTemp->$c = $d;
						$notifyTemp->time_stamp = pathang::getHelper('feedprocess')->ago($notifyTemp->time_stamp);		
				$notifyObj->$a = $notifyTemp;

			}
			$notifyTemp2 = new stdclass();
			$notifyTemp2->unread = pathang::GetModel('profile')->getUnreadNotificationCount($uid);
			$notifyTemp2->messages = $notifyObj;
			if($snippet)
				return $notifyTemp2;
			$basket->set('notify',$notifyObj);
			pathang::getInstance('pathang')->SITE->PAGE = 'members';
			pathang::render('profile','notifications');

			//update notifacations read
			pathang::GetModel('profile')->updateReadNotifications($uid);
		}
		else{
			pathang::getInstance('pathang')->SITE->PAGE = 'login';
			$basket->set('heading','Restricted Access');
			$basket->set('message','You dont have enough permission to access this page.');	
			pathang::render('general','errorpage');
			exit();
		}
	}


	public function image(){
		$user = pathang::getInstance('node')->get('n1');
		$basket = pathang::GetInstance('basket');
		$liveuser = pathang::getInstance('session')->get('liveuser')->username;
		if($user==$liveuser){
		pathang::getInstance('pathang')->SITE->PAGE = 'members';
		pathang::render('profile','image_upload');
		}else{
			pathang::getInstance('pathang')->SITE->PAGE = 'login';
			$basket->set('heading','Restricted Access');
			$basket->set('message','You dont have enough permission to access this page.');	
			pathang::render('general','errorpage');
			exit();
		}
	}

	public function image_upload(){
		// an array of allowed extensions
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		if(!isset($_FILES["file"]["name"]))
			exit();
		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);
		$ext= strtolower($extension);

		//check if the file type is image and then extension
		// store the files to upload folder
		//echo '0' if there is an error
		if($ext){
		if ((($_FILES["file"]["type"] == "image/gif")
		|| ($_FILES["file"]["type"] == "image/jpeg")
		|| ($_FILES["file"]["type"] == "image/jpg")
		|| ($_FILES["file"]["type"] == "image/pjpeg")
		|| ($_FILES["file"]["type"] == "image/x-png")
		|| ($_FILES["file"]["type"] == "image/png"))
		&& in_array($ext, $allowedExts)) {
		  if ($_FILES["file"]["error"] > 0) {
		    echo "0";
		  } else {
		    $target = "tmp/";
		    move_uploaded_file($_FILES["file"]["tmp_name"], $target. $_FILES["file"]["name"]);
		    $image = $this->_moveImage("tmp/" . $_FILES["file"]["name"],$extension);
		    echo  ROOT.$image;
		  }
		} else {
		  echo "0";
		}
		}
	}

	public function image_dupload(){
		$str = file_get_contents('php://input');
		$ext = pathang::getInstance('request')->get('ext');
		if($ext){
			$filename = md5(time()).'.'.$ext;
			file_put_contents('tmp/'.$filename,$str);
			$image = $this->_moveImage("tmp/".$filename);
			echo  ROOT.$image;	
		}
	}

	public function _moveImage($img,$et=null){
		$session = pathang::getInstance('session');
		$basket = pathang::getInstance('basket');
		$path = explode('.',$img);

		if($et == 'JPEG' || $et == 'JPG' || $et == 'PNG' || $et == 'GIF')
		{
			rename ($img, "tmp/updated.".strtolower($et));
			unlink($img);
			$img = "tmp/updated.".strtolower($et);
		}

		$ext = end($path);
		if($et)
			$ext = strtolower($et);

		if($ext == 'jpeg' || $ext == 'png')
			$ext = 'jpg';
		$name = $session->get('liveuser')->username;
		if(!$name)
			$name = 'guest';
		$image_name = 'img/users/'.$name.'.'.$ext;
		$image_name_original = 'img/users/'.$name.'_original.'.$ext;

		require_once 'lib/hashimage/hashimage.php';
		$image = new hashimage();
		$image->load($img);
		$w = $image->width;
		$h = $image->height;
		if($w>$h)
			$s=$h;
		else
			$s=$w;

		$image->crop(0,0,$s,$s)->resize(200,200)->save($image_name); 
		
		$image->load($img);
		$w = $image->width;
		$h = $image->height;
		$image->resize($w,$h)->save($image_name_original); 
		unlink($img);

		pathang::getInstance('session')->get('liveuser')->image = ROOT.$image_name;
		$basket->set('image',$image_name);
		return $image_name;
	}

	public function crop(){
				$user = pathang::getInstance('node')->get('n1');
		$basket = pathang::GetInstance('basket');
		$liveuser = pathang::getInstance('session')->get('liveuser')->username;
		if($user==$liveuser){
		pathang::getInstance('pathang')->SITE->PAGE = 'no_responsive';
		pathang::render('profile','crop');
		
		}else{
			pathang::getInstance('pathang')->SITE->PAGE = 'login';
			$basket->set('heading','Restricted Access');
			$basket->set('message','You dont have enough permission to access this page.');	
			pathang::render('general','errorpage');
			exit();
		}

	}


	public function cropimage(){
		$request = pathang::getInstance('request');
		$username = $request->get('username');
		
		$imagefile = 'img/users/'.$username.'_original.jpg';
		$image_edit = 'img/users/'.$username.'.jpg';
		$edit_page = ROOT.$username.'/edit';	
		
		require_once 'lib/hashimage/hashimage.php';
		$image = new hashimage();
		$image->load($imagefile);

		$a_width = $image->width;
		$a_height = $image->height;
		if($a_width>599)
		$percent = $a_width/600;
		else
		$percent = 1;
			
		$x = 0;
		$y = 0;
		$width = $a_width;
		$height = $a_height;


		if(!$request->get('w'))
		{
			exit();
		}
		if($request->get('x'))
			$x = $request->get('x');
		if($request->get('y'))
			$y = $request->get('y');
		if($request->get('w'))
			$width = $request->get('w');
		if($request->get('h'))
			$height = $request->get('h');

		$x = $x*$percent;
		$width = $width*$percent;
		$y = $y*$percent;
		$height = $height*$percent;
		
		echo $x.' '.$y.' '.$width.' '.$height;
		//exit();
		$image = new hashimage();
		$image->load($imagefile)->crop($x,$y,$width,$height)
							->save($image_edit); 			
		header('Location: '.$edit_page);
	}
}