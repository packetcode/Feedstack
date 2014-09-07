<?php
/*	Feedstack - A Social Networking Script
 *	----------------------------------------
 *	package 		- app/controllers
 *	file 			- feed.php
 * 	Developer 		- Krishna Teja G S
 *	Website			- http://www.feedstack.asia
 *	license			- GNU General Public License version 2 or later
*/
 
defined('_PATHANG') or die;

// Controller to deal with Feeds and associated items
class ControllerFeed{

	/*
		** FEED FUNCTIONALITY **
	*/

	public function __Construct(){
		$liveuser= pathang::getInstance('session')->get('liveuser');
		if(isset($liveuser->username))
		pathang::getInstance('pathang')->FEEDSTACK->FEED_COUNT = $liveuser->feeds_per_page;	
	}
	
	// process and store feed in database	
	public function post(){
		$feed = pathang::GetInstance('request')->filterHTMLSQL('feed');
		$username = pathang::GetInstance('request')->filterHTMLSQL('username');
		$uid = pathang::GetInstance('request')->filterHTMLSQL('uid');
		$name = pathang::GetInstance('request')->filterHTMLSQL('name');
		$image = pathang::GetInstance('request')->filterHTMLSQL('image');
		$basket = pathang::GetInstance('basket');

		//check for validity of access token
		pathang::getHelper('userlog')->ajaxAuthentication();

		//feed process
		$feedObj = pathang::getHelper('feedprocess')->process($feed);

		//storing feed in database
		$status = pathang::GetModel('feed')
									->addFeed($uid,$feedObj->feed,$feed,
												$feedObj->feed_url,
												$feedObj->feed_container,
												$feedObj->feed_type);						
		//$feed = pathang::getHelper('feedprocess')->markUp($feedObj);
		$basket->set('feed',$feedObj->feed);
		$basket->set('feed_container',$feedObj->feed_container);
		$basket->set('feed_id',$status);
		$basket->set('name',$name);
		$basket->Set('profile_link',ROOT.$username);
		$basket->set('image',$image);
		pathang::Render('feed','feed_entry');
	}

	// display feeds on wall as per followers
	public function wall(){
		$basket = pathang::GetInstance('basket');
		$allowedType = array("text", "photo", "video", "link");
		$feed_type = pathang::GetInstance('node')->get('n1');

		pathang::getInstance('basket')->set('feed_type',$feed_type);
		$limit = pathang::getInstance('pathang')->FEEDSTACK->FEED_COUNT;
		//var_dump(pathang::getInstance('pathang'));

		//check if user is admin
		if(isset(pathang::getInstance('session')->get('liveuser')->id))
			$liveuser_id=pathang::getInstance('session')->get('liveuser')->id;
		else
			$liveuser_id = null;
		
		$allowed_delete = pathang::getModel('userlog')->isAdmin($liveuser_id);
		$basket->set('allowed_delete',$allowed_delete);
		$feedArray = pathang::getModel('feed')->getFeedsFollowing($liveuser_id,$feed_type,null,$limit);
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

		//set limit counter
		$basket->set('limit_counter',$limit);
		pathang::render('general','home');
	}

	// display feeds on wall in general
	public function view(){
		$feed_id = pathang::GetInstance('node')->get('n2');
		$allowedType = array("text", "photo", "video", "link");
		$limit = pathang::getInstance('pathang')->FEEDSTACK->FEED_COUNT;
		pathang::getInstance('basket')->set('limit_counter',$limit);

		//check if user is admin
		if(isset(pathang::getInstance('session')->get('liveuser')->id))
		$liveuser_id=pathang::getInstance('session')->get('liveuser')->id;
		else
			$liveuser_id = null;
		$allowed_delete = pathang::getModel('userlog')->isAdmin($liveuser_id);
		pathang::getInstance('basket')->set('allowed_delete',$allowed_delete);

		if(!$feed_id || in_array($feed_id, $allowedType)){
			if($feed_id){
				$feedArray = pathang::getModel('feed')->getFeeds(null,$feed_id,null,$limit);
				pathang::getInstance('basket')->set('feed_type',$feed_id);
			}else
				$feedArray = pathang::getModel('feed')->getFeeds(null,null,null,$limit);
			
			if($feedArray){
				$feedObj = new stdclass();
				foreach($feedArray as $a =>$b){
					$feedTemp = new stdClass();
					foreach($b as $c => $d)
						$feedTemp->$c = $d;
					$feedTemp->feed = $feedTemp->feed;
					$feedTemp->image ='';
					$feedTemp->profile_link = ROOT.$feedTemp->username;
					$feedTemp->image = pathang::getHelper('userlog')->getUserImage($feedTemp);
					$feedTemp->time_stamp = pathang::getHelper('feedprocess')->ago($feedTemp->time_stamp);
					$feedTemp->like_count = pathang::getModel('feed')->getLikeCount($feedTemp->id);
					$feedTemp->liveuser_like = pathang::getModel('feed')->checkLiveuserLike($liveuser_id,$feedTemp->id);
					$feedTemp->comment_count = pathang::getModel('feed')->getCommentCount($feedTemp->id);
					$feedObj->$a = $feedTemp;
				}	

				pathang::GetInstance('pathang')->SITE->PAGE = 'index';
				pathang::getInstance('basket')->set('feeds',$feedObj);
				pathang::Render('feed','public_page');
			}
			else{
				pathang::GetInstance('pathang')->SITE->PAGE = 'login';
				$basket->set('heading','OPPS !');
				$basket->set('message','The page your searching for doesnot exist.
							Please contact the site administrator for further queries.');	
				pathang::render('general','errorpage');
				exit();	
			}

		}else
		{
			$feedArray = pathang::getModel('feed')->getFeed($feed_id);
		
			if($feedArray){
				$feedTemp = new stdclass();
				foreach($feedArray as $a => $b)
					$feedTemp->$a = $b;
					$feedTemp->image ='';
					$feedTemp->feed = $feedTemp->feed;
					$feedTemp->profile_link = ROOT.$feedTemp->username;
					$feedTemp->image = pathang::getHelper('userlog')->getUserImage($feedTemp);
					$feedTemp->time_stamp = pathang::getHelper('feedprocess')->ago($feedTemp->time_stamp);
					$feedTemp->like_count = pathang::getModel('feed')->getLikeCount($feedTemp->id);
					$feedTemp->liveuser_like = pathang::getModel('feed')->checkLiveuserLike($liveuser_id,$feedTemp->id);
					$feedTemp->comment_count = pathang::getModel('feed')->getCommentCount($feedTemp->id);
					
				$feedTemp->views = $feedTemp->views+1;
				//update the feed view count
				pathang::getModel('feed')->updateViewCount($feed_id,$feedTemp->views);
				pathang::getInstance('basket')->set('feed',$feedTemp);

				//update the meta data
				$pathang=pathang::GetInstance('pathang');
				$pathang->META->AUTHOR = $feedTemp->name;
				$pathang->META->KEYWORDS = $pathang->META->KEYWORDS.','.$feedTemp->name;
				$pathang->META->TITLE = $feedTemp->name.' posted in '.$pathang->META->TITLE;
				$pathang->META->DESC = $feedTemp->feed_original;
				if($feedTemp->feed_type == 'photo')
				$pathang->META->IMAGE = $feedTemp->feed_url;
				else{
					$pathang->META->IMAGE = $feedTemp->image;
				}
				$pathang->META->SITE_URL = ROOT.pathang::getInstance('request')->get('url');
				pathang::Render('feed','feed_display');
			}
			else{
				$basket = pathang::GetInstance('basket');
				pathang::GetInstance('pathang')->SITE->PAGE = 'login';
				$basket->set('heading','OPPS !');
				$basket->set('message','The page your searching for doesnot exist.
								Please contact the site administrator for further queries.');	
				pathang::render('general','errorpage');
				exit();
			}
		}	
	}

	// ajax loading of the feeds
	public function load(){
		$request = pathang::GetInstance('request');
		$lastid = $request->get('lastid');
		$type = $request->get('feed-type');
		$uid = $request->get('uid');
		$wall = $request->get('wall');

		//check if user is admin
		$liveuser_id=$request->get('liveuser-id');
		$allowed_delete = pathang::getModel('userlog')->isAdmin($liveuser_id);
		pathang::getInstance('basket')->set('allowed_delete',$allowed_delete);
		$limit = pathang::getInstance('pathang')->FEEDSTACK->FEED_COUNT;
		pathang::getInstance('basket')->set('limit_counter',$limit);
		pathang::getInstance('basket')->set('uid',$uid);
		pathang::getInstance('basket')->set('feed_type',$type);

		if(!$wall)
		$feedArray = pathang::getModel('feed')->getFeeds($uid,$type,$lastid,$limit);
		else{
			$feedArray = pathang::getModel('feed')->getFeedsFollowing($liveuser_id,$type,$lastid,$limit);	
			pathang::getInstance('basket')->set('wall','wall');
		}
		
			if($feedArray){
				$feedObj = new stdclass();
				foreach($feedArray as $a =>$b){
					$feedTemp = new stdClass();
					foreach($b as $c => $d)
						$feedTemp->$c = $d;
					$feedTemp->image ='';
					$feedTemp->profile_link = ROOT.$feedTemp->username;
					$feedTemp->feed = $feedTemp->feed;
					$feedTemp->image = pathang::getHelper('userlog')->getUserImage($feedTemp);
					$feedTemp->time_stamp = pathang::getHelper('feedprocess')->ago($feedTemp->time_stamp);
					$feedTemp->like_count = pathang::getModel('feed')->getLikeCount($feedTemp->id);
					$feedTemp->liveuser_like = pathang::getModel('feed')->checkLiveuserLike($liveuser_id,$feedTemp->id);
					$feedTemp->comment_count = pathang::getModel('feed')->getCommentCount($feedTemp->id);
					$feedObj->$a = $feedTemp;
				}	

				pathang::GetInstance('pathang')->SITE->PAGE = 'index';
				pathang::getInstance('basket')->set('feeds',$feedObj);
				pathang::Render('feed','feed_loadmore');
			}
			else{
				$feedObj=null;
				pathang::GetInstance('pathang')->SITE->PAGE = 'index';
				pathang::getInstance('basket')->set('feeds',$feedObj);
				pathang::Render('feed','feed_loadmore');
			}
	}

	/*
		** COMMENT FUNCTIONALITY **
	*/

	// Comment on Feed
	public function comment(){
		$request = pathang::getInstance('request');
		$uid = $request->get('uid');
		$feed_id = $request->get('feed_id');
		$comment = $request->get('comment');

		//check for validity of access token
		pathang::getHelper('userlog')->ajaxAuthentication();

		$comment_id = pathang::getModel('feed')->addFeedComment($uid,$feed_id,$comment);
		$liveuser = pathang::GetInstance('session')->get('liveuser');
		$basket = pathang::getInstance('basket');
		$basket->set('comment',$comment);
		$basket->set('comment_id',$comment_id);
		$basket->set('user',$liveuser);
		pathang::render('feed','comment_entry');
	}

	// Loading Comments
	public function commentload(){
		$request = pathang::getInstance('request');
		$basket= pathang::getInstance('basket');
		$feed_id = $request->get('feed_id');
		$from = $request->get('from');
		$limit = pathang::getInstance('pathang')->FEEDSTACK->COMMENT_COUNT;
		//check if user is admin
		if(isset(pathang::getInstance('session')->get('liveuser')->id))
		$liveuser_id=pathang::getInstance('session')->get('liveuser')->id;
		else
			$liveuser_id = null;
		$allowed_delete = pathang::getModel('userlog')->isAdmin($liveuser_id);
		$basket->set('allowed_delete',$allowed_delete);

		$comments = pathang::getModel('feed')->getFeedComments($feed_id,$from,$limit);
		$comment_count = pathang::getModel('feed')->getCommentCount($feed_id);
		$basket->set('comment_count',$comment_count-$limit);
		$basket->set('comment_show_count',$limit);
		$basket->set('lastid',$from);

		$commentObj = new stdclass();
		if($comments){
			foreach($comments as $a =>$b){
				$commentTemp = new stdClass();
				foreach($b as $c => $d)
					$commentTemp->$c = $d;
					$commentTemp->profile_link = ROOT.$commentTemp->username;
					$commentTemp->image = pathang::getHelper('userlog')->getUserImage($commentTemp);
					$commentTemp->time_stamp = pathang::getHelper('feedprocess')->ago($commentTemp->time_stamp);
					$commentObj->$a = $commentTemp;
				}
		}
		$basket->set('comments',$commentObj);
		$basket->set('feed_id',$feed_id);
		if($from)
		pathang::render('feed','comment_loadmore');	
		else	
		pathang::render('feed','comment_list');		
	}

	/*
		** LIKE FUNCTIONALITY **
	*/

	// Like a Feed
	public function like(){
		$request = pathang::getInstance('request');
		$uid = $request->get('uid');
		$feed_id = $request->get('feed_id');

		//check for validity of access token
		pathang::getHelper('userlog')->ajaxAuthentication();

		$status = pathang::getModel('feed')->likeFeed($uid,$feed_id);
		if($status)
			echo '1';
		else
			echo '0';
	}

	// UnLike a Feed
	public function unlike(){
		$request = pathang::getInstance('request');
		$uid = $request->get('uid');
		$feed_id = $request->get('feed_id');
		//check for validity of access token
		pathang::getHelper('userlog')->ajaxAuthentication();

		$status = pathang::getModel('feed')->unlikeFeed($uid,$feed_id);
	}

	// Show the Likers
	public function showLikers(){
		$request = pathang::getInstance('request');
		$feed_id = $request->get('feed_id');
		$likersArray = pathang::getModel('feed')->feedLikers($feed_id);
		$feedLikers = new stdclass();
			foreach($likersArray as $a =>$b){
				$feedLikerObj = new stdClass();
				foreach($b as $c => $d)
					$feedLikerObj->$c = $d;
					$feedLikerObj->image ='';
					$feedLikerObj->profile_link = ROOT.$feedLikerObj->username;
					$feedLikerObj->image = pathang::getHelper('userlog')->getUserImage($feedLikerObj);
					$feedLikers->$a = $feedLikerObj;
				}	
		pathang::getInstance('basket')->set('likers',$feedLikers);
		pathang::render('feed','feed_likers');		
	}

	/*
		** DELETE FUNCTIONALITY **
	*/

	// delete feed 
	public function delete(){
		$request = pathang::getInstance('request');
		$feed_id = $request->get('feed_id');
		//check for validity of access token
		pathang::getHelper('userlog')->ajaxAuthentication();

		pathang::getModel('feed')->deleteFeed($feed_id);
		return 1;
	}

	// delete comment
	public function deleteComment(){
		$request = pathang::getInstance('request');
		$comment_id = $request->get('comment_id');
		//check for validity of access token
		pathang::getHelper('userlog')->ajaxAuthentication();
		
		pathang::getModel('feed')->deleteFeedComment($comment_id);
		return 1;
	}

}