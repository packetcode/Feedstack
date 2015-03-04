<?php
/*	Feedstack - A Social Networking Script
 *	----------------------------------------
 *	package 		- app/models
 *	file 			- profile.php
 * 	Developer 		- Krishna Teja G S
 *	Website			- http://www.feedstack.asia
 *	license			- GNU General Public License version 2 or later
*/

defined('_PATHANG') or die;

class modelProfile{

	public function getUserProfile($username){

		//pdo object and table
		$pdo = pathang::getInstance('pdo');
		$table = 'users';

		// sql insert statement
		$sql = "SELECT *  
					FROM $table 
					WHERE username='$username' ";

		//query and fetch the result
		$res=$pdo->query($sql);
		$result = $res->fetch(PDO::FETCH_ASSOC);

		//if record found return activation else false	
		if($result)
			return $result;
		else
			return null;
	}

	public function saveUser(){
		$pdo = pathang::getInstance('pdo');
		$table = 'users';
		$request = pathang::getInstance('request');
		$id = $request->filterHTMLSQL('id');
		$name = $request->filterHTMLSQL('name');
		$username=$request->filterHTMLSQL('username');
		$email = $request->filterHTMLSQL('email');
		if($this->isValidMd5($request->filterHTMLSQL('password')))
			$password =  $request->filterHTMLSQL('password');
		else
			$password = md5($request->filterHTMLSQL('password'));
		$bio = $request->filterHTMLSQL('bio');
		$feeds_per_page = intval($request->get('feeds_per_page'));
		pathang::getInstance('session')->get('liveuser')->feeds_per_page = $feeds_per_page;
		$access = $request->get('access');


		$sql = "UPDATE $table 
				SET name = '$name',
					username='$username',
					email = '$email',
					password='$password',
					bio = '$bio',
					feeds_per_page=$feeds_per_page,
					access=$access
					WHERE id = $id";
		$result = $pdo->exec($sql);				
	}

	public function isValidMd5($md5 ='') {
  		return strlen($md5) == 32 && ctype_xdigit($md5);
	}

	public function getUserFeeds($uid,$type=null,$from=null){
		//pdo object and table
		$pdo = pathang::getInstance('pdo');
		$table = 'feeds';
		$limit = '5';

		if($type){
			if($from)
			$sql = "SELECT *  
					FROM $table 
					WHERE uid='$uid' and feed_type ='$type' and id > $from ORDER BY id desc LIMIT $limit";
			else
			$sql = "SELECT *  
					FROM $table 
					WHERE uid='$uid' and feed_type ='$type'  ORDER BY id desc LIMIT $limit";
		}
		else{
		
			if($from)
			$sql = "SELECT *  
					FROM $table 
					WHERE uid='$uid' and id > $from ORDER BY id desc LIMIT $limit";
			else
			$sql = "SELECT *  
					FROM $table 
					WHERE uid='$uid'  ORDER BY id desc LIMIT $limit";
					
		}

		//query and fetch the result
		$res=$pdo->query($sql);
		$result = $res->fetchALL(PDO::FETCH_ASSOC);

		//if record found return activation else false	
		if($result)
			return $result;
		else
			return null;
	}

	public function updateReadNotifications($uid){
		//pdo object and table
		$pdo = pathang::getInstance('pdo');
		$table = 'notifications';

		$sql = "UPDATE $table 
				SET status = 0
				WHERE uid = $uid and status = 1";
		$result = $pdo->exec($sql);		
	}

	public function getUnreadNotificationCount($uid){
		//pdo object and table
		$pdo = pathang::getInstance('pdo');
		$table = 'notifications';
		$sql = "SELECT count(*) 'unread' 
				FROM $table
				WHERE uid = $uid and status =1";

		//query and fetch the result
		$res=$pdo->query($sql);
		$result = $res->fetch(PDO::FETCH_ASSOC);
		//if record found return activation else false	
		if($result)
			return $result['unread'];
		else
			return null;
	}

	public function getUserNotifications($user,$limit){
		//pdo object and table
		$pdo = pathang::getInstance('pdo');
		$request = pathang::getInstance('request');
		$table = 'notifications';
		$uid = pathang::GetModel('userlog')->getUserId($user);

		if($request->Get('unread'))
		$sql = "SELECT u.name,u.username,n.uid,n.action,n.agent,n.target,n.time_stamp,n.status  
				FROM $table n,users u
				WHERE n.uid= $uid and n.agent = u.id and n.status = 1
				ORDER BY n.id desc 
				LIMIT $limit";
		else	
		$sql = "SELECT u.name,u.username,n.uid,n.action,n.agent,n.target,n.time_stamp,n.status  
				FROM $table n,users u
				WHERE n.uid= $uid and n.agent = u.id
				ORDER BY n.id desc 
				LIMIT $limit";

		//query and fetch the result
		$res=$pdo->query($sql);
		$result = $res->fetchAll(PDO::FETCH_ASSOC);

		//if record found return activation else false	
		if($result)
			return $result;
		else
			return null;
	
	}

	public function following($uid){
		//pdo object and table
		$pdo = pathang::getInstance('pdo');
		$table = 'followers';

		$sql = "SELECT u.name,u.id,u.username,u.email,u.image_type FROM followers f,users u
				WHERE f.uid= $uid and f.follow_id = u.id LIMIT 20";

		//query and fetch the result
		$res=$pdo->query($sql);
		$result = $res->fetchAll(PDO::FETCH_ASSOC);

		//if record found return activation else false	
		if($result)
			return $result;
		else
			return null;
	}

	public function followingCount($uid){
		//pdo object and table
		$pdo = pathang::getInstance('pdo');
		$table = 'followers';

		$sql = "SELECT count(*) FROM $table
				WHERE uid = $uid ";

		//query and fetch the result
		$res=$pdo->query($sql);
		$result = $res->fetchAll(PDO::FETCH_ASSOC);

		//if record found return activation else false	
		if($result)
			return $result[0]['count(*)']-1;
		else
			return 0;
	}

	public function followers($uid){
		//pdo object and table
		$pdo = pathang::getInstance('pdo');
		$table = 'followers';

		$sql = "SELECT u.name,u.id,u.username,u.email,u.image_type FROM followers f,users u
				WHERE f.follow_id= $uid and f.uid= u.id LIMIT 20";	

		//query and fetch the result
		$res=$pdo->query($sql);
		$result = $res->fetchAll(PDO::FETCH_ASSOC);

		//if record found return activation else false	
		if($result)
			return $result;
		else
			return null;
	}

	public function popular(){
		//pdo object and table
		$pdo = pathang::getInstance('pdo');
		$table = 'followers';

		$sql = "SELECT u.name,u.id,u.username,u.email,u.image_type,COUNT(*)-1 'counter' 
				FROM followers f,users u
				WHERE f.follow_id= u.id GROUP BY f.follow_id ORDER BY counter desc LIMIT 15";	

		//query and fetch the result
		$res=$pdo->query($sql);
		$result = $res->fetchAll(PDO::FETCH_ASSOC);

		//if record found return activation else false	
		if($result)
			return $result;
		else
			return null;
	}

	public function followerCount($uid){
		//pdo object and table
		$pdo = pathang::getInstance('pdo');
		$table = 'followers';

		$sql = "SELECT count(*) FROM $table
				WHERE follow_id = $uid ";

		//query and fetch the result
		$res=$pdo->query($sql);
		$result = $res->fetchAll(PDO::FETCH_ASSOC);

		//if record found return activation else false	
		if($result)
			return $result[0]['count(*)']-1;
		else
			return 0;
	}

	public function isFollowing($uid,$follow_id){

		//pdo object and table
		$pdo = pathang::getInstance('pdo');
		$table = 'followers';

		if($uid)
		$sql = "SELECT * FROM $table 
				WHERE uid= $uid and follow_id=$follow_id LIMIT 20";
		else
			return '0';		

		//query and fetch the result
		$res=$pdo->query($sql);
		$result = $res->fetch(PDO::FETCH_ASSOC);

		//if record found return activation else false	
		if($result)
			return '1';
		else
			return '0';
	}
}