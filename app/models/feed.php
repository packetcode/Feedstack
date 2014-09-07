<?php
/*	Feedstack - A Social Networking Script
 *	----------------------------------------
 *	package 		- app/models
 *	file 			- userlog.php
 * 	Developer 		- Krishna Teja G S
 *	Website			- http://www.feedstack.asia
 *	license			- GNU General Public License version 2 or later
*/

defined('_PATHANG') or die;

// Userlog model to check user details in database
class modelFeed{



	public function addFeed($uid,$feed,$original,$feed_url,$feed_container,$feed_type){

		$views = 0;
		$time_stamp = date("Y-m-d H:i:s");

		//pdo object and table
		$pdo = pathang::getInstance('pdo');
		$table = 'feeds';

		// sql insert statement
		$sql ="INSERT INTO $table 
						(uid,feed,feed_original,feed_url,feed_container,feed_type,time_stamp,views) 
				 VALUES ($uid,'$feed','$original','$feed_url','$feed_container','$feed_type','$time_stamp',$views)";
	
		//echo $sql;		 
		$result = $pdo->exec($sql);
		$insertId = $pdo->lastInsertId();
		if($insertId)
			return $insertId;
		else
			return '2';
	}

	public function addFeedComment($uid,$feed_id,$comment){
		
		$time_stamp = date("Y-m-d H:i:s");

		//pdo object and table
		$pdo = pathang::getInstance('pdo');
		$table = 'comments';

		// sql insert statement
		$sql ="INSERT INTO $table 
						(uid,feed_id,comment,time_stamp) 
				 VALUES ($uid,$feed_id,'$comment','$time_stamp')";
	

		$result = $pdo->exec($sql);
		$insertId = $pdo->lastInsertId();
		if($insertId)
			return $insertId;
		else
			return false;
	}

	
	public function getFeedComments($feed_id,$from=null,$limit=null){
		//pdo object and table
		$pdo = pathang::getInstance('pdo');
		$table = 'comments';

		if(!$limit)
			$limit =5;

		if($from){
			$sql = "SELECT u.name,u.username,u.email,u.image_type,c.comment,c.time_stamp,c.id,c.uid
				FROM comments c, users u 
				WHERE c.feed_id = $feed_id and c.uid = u.id and c.id < $from 
				ORDER BY c.id desc
				LIMIT $limit";
		}else{
			$sql = "SELECT u.name,u.username,u.email,u.image_type,c.comment,c.time_stamp,c.id,c.uid
				FROM comments c, users u 
				WHERE c.feed_id = $feed_id and c.uid = u.id 
				ORDER BY c.id desc
				LIMIT $limit";
		}
		

		//query and fetch the result
		$res=$pdo->query($sql);
		$result = $res->fetchAll(PDO::FETCH_ASSOC);
		//if record found return result
		if($result)
			return $result;
		else
			return null;	
	}

	public function getCommentCount($id){
		//pdo object and table
		$pdo = pathang::getInstance('pdo');
		$table = 'comments';

		$sql = "SELECT count(id)
				FROM $table 
				WHERE feed_id = $id";
		//query and fetch the result
		$res=$pdo->query($sql);
		$result = $res->fetch(PDO::FETCH_ASSOC);
		//if record found return result
		if($result)
			return $result['count(id)'];
		else
			return null;	
	}

	public function deleteFeedComment($comment_id){
		//deleting comment
		$pdo = pathang::getInstance('pdo');
		$table = 'comments';
		$sql ="DELETE FROM $table 
			    WHERE id = $comment_id";
		$result = $pdo->exec($sql);
	}

	public function updateViewCount($id,$count){
		//pdo object and table
		$pdo = pathang::getInstance('pdo');
		$table = 'feeds';	
		$sql = "UPDATE $table
				SET views = $count
				WHERE id = $id";
		$result = $pdo->exec($sql);
		return true;		
	}

	public function getLikeCount($id){
		//pdo object and table
		$pdo = pathang::getInstance('pdo');
		$table = 'likes';

		$sql = "SELECT count(id)
				FROM $table 
				WHERE feed_id = $id";
		//query and fetch the result
		$res=$pdo->query($sql);
		$result = $res->fetch(PDO::FETCH_ASSOC);
		//if record found return result
		if($result)
			return $result['count(id)'];
		else
			return null;	
	}

	public function likeFeed($uid,$feed_id){
		$time_stamp = date("Y-m-d H:i:s");
		//pdo object and table
		$pdo = pathang::getInstance('pdo');
		$table = 'likes';

		// sql insert statement
		$sql ="INSERT INTO $table 
						(uid,feed_id,time_stamp) 
				 VALUES ($uid,$feed_id,'$time_stamp')";

		$result = $pdo->exec($sql);
		$insertId = $pdo->lastInsertId();
		if($insertId)
			return $insertId;
		else
			return false;
	}

	public function unlikeFeed($uid,$feed_id){
		//pdo object and table
		$pdo = pathang::getInstance('pdo');
		$table = 'likes';

		// sql insert statement
		$sql ="DELETE FROM $table 
			    WHERE feed_id = $feed_id 
			    	and uid = $uid";

		$result = $pdo->exec($sql);
	}

	public function checkLiveuserLike($uid,$feed_id)
	{
		//pdo object and table
		$pdo = pathang::getInstance('pdo');
		$table = 'likes';

		if($uid)
		$sql = "SELECT *
				FROM $table 
				WHERE feed_id = $feed_id and uid = $uid";
		else		
			return null;
		//query and fetch the result
		$res=$pdo->query($sql);
		$result = $res->fetch(PDO::FETCH_ASSOC);
		//if record found return result
		if($result)
			return '1';
		else
			return null;	
	}
	
	public function feedLikers($feed_id){
		//pdo object and table
		$pdo = pathang::getInstance('pdo');
		$table = 'likes';

		$sql = "SELECT u.name,u.username,u.email,u.image_type
				FROM likes l, users u 
				WHERE l.feed_id = $feed_id and l.uid = u.id";
		//query and fetch the result
		$res=$pdo->query($sql);
		$result = $res->fetchAll(PDO::FETCH_ASSOC);
		//if record found return result
		if($result)
			return $result;
		else
			return null;	
	}


	public function deleteFeed($feed_id){
		//deleting feed
		$pdo = pathang::getInstance('pdo');
		$table = 'feeds';
		$sql ="DELETE FROM $table 
			    WHERE id = $feed_id";
		$result = $pdo->exec($sql);

		//delete likes
		$table = 'likes';
		$sql ="DELETE FROM $table 
			    WHERE feed_id = $feed_id";
		$result = $pdo->exec($sql);
		
		//delete comments
		$table = 'comments';
		$sql ="DELETE FROM $table 
			    WHERE feed_id = $feed_id";
		$result = $pdo->exec($sql);

	}

	public function getFeed($id){
		
		//pdo object and table
		$pdo = pathang::getInstance('pdo');

		$sql = "SELECT f.feed,f.time_stamp,f.uid,f.views,f.feed_original,f.feed_type,f.feed_url,f.feed_container,u.username,u.name,u.image_type,u.email,f.id  
				FROM feeds f, users u 
				WHERE f.id='$id' and f.uid= u.id ";

		//query and fetch the result
		$res=$pdo->query($sql);
		$result = $res->fetch(PDO::FETCH_ASSOC);

		//if record found return result
		if($result)
			return $result;
		else
			return null;
	}

	public function getFeeds($uid=null,$type=null,$from=null,$limit=null){
		//pdo object and table
		$pdo = pathang::getInstance('pdo');
		$table = 'feeds';
		if(!$limit)
		$limit = '3';
		if($uid){
		if($type){
			if($from)
			$sql = "SELECT f.feed,f.uid,f.views,f.feed_container,u.username,u.name,u.image_type,u.email,f.id,f.time_stamp   
					FROM feeds f,users u
					WHERE f.uid='$uid' and f.uid =  u.id and f.feed_type ='$type' and f.id < $from ORDER BY f.id 
					desc LIMIT $limit";
			else
			$sql = "SELECT f.feed,f.uid,f.views,f.feed_container,u.username,u.name,u.image_type,u.email,f.id,f.time_stamp   
					FROM feeds f,users u
					WHERE f.uid='$uid' and f.uid =  u.id and f.feed_type ='$type'  ORDER BY f.id 
					desc LIMIT $limit";	
		}
		else{
		
			if($from)
			$sql = "SELECT f.feed,f.uid,f.views,f.feed_container,u.username,u.name,u.image_type,u.email,f.id,f.time_stamp   
					FROM feeds f,users u
					WHERE f.uid='$uid' and f.uid =  u.id and f.id < $from ORDER BY f.id 
					desc LIMIT $limit";
			else
			$sql = "SELECT f.feed,f.uid,f.views,f.feed_container,u.username,u.name,u.image_type,u.email,f.id,f.time_stamp   
					FROM feeds f,users u
					WHERE f.uid='$uid' and f.uid =  u.id
					ORDER BY f.id 
					desc LIMIT $limit";
					
		}
		}else{

		if($type){
			if($from)
			$sql = "SELECT f.feed,f.uid,f.views,f.feed_container,u.username,u.name,u.image_type,u.email,f.id,f.time_stamp   
					FROM feeds f,users u
					WHERE f.feed_type ='$type' and f.id < $from and f.uid =  u.id ORDER BY f.id 
					desc LIMIT $limit";
			else
			$sql = "SELECT f.feed,f.uid,f.views,f.feed_container,u.username,u.name,u.image_type,u.email,f.id,f.time_stamp   
					FROM feeds f,users u
					WHERE  f.feed_type ='$type' and f.uid =  u.id ORDER BY f.id 
					desc LIMIT $limit";
		}
		else{
		
			if($from)
			$sql = "SELECT f.feed,f.uid,f.views,f.feed_container,u.username,u.name,u.image_type,u.email,f.id,f.time_stamp   
					FROM feeds f,users u
					WHERE  f.id < $from and f.uid = u.id ORDER BY f.id 
					desc LIMIT $limit";
			else
			$sql = "SELECT f.feed,f.uid,f.views,f.feed_container,u.username,u.name,u.image_type,u.email,f.id,f.time_stamp   
					FROM feeds f,users u
					WHERE f.uid =  u.id
					ORDER BY f.id 
					desc LIMIT $limit";
					
		}	
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

	public function getFeedsFollowing($uid=null,$type=null,$from=null,$limit=null){
		//pdo object and table
		$pdo = pathang::getInstance('pdo');
		$table = 'feeds';

		if(!$limit)
		$limit = '3';
		if($uid){
		if($type){
			if($from)
			$sql = "SELECT f.feed,f.uid,f.views,f.feed_container,u.username,u.name,u.image_type,u.email,f.id,f.time_stamp   
					FROM feeds f,users u,followers w
					WHERE (w.follow_id = f.uid )
					and w.uid = $uid  and f.uid =  u.id and f.feed_type ='$type' and f.id < $from ORDER BY f.id 
					desc LIMIT $limit";
			else
			$sql = "SELECT f.feed,f.uid,f.views,f.feed_container,u.username,u.name,u.image_type,u.email,f.id,f.time_stamp   
					FROM feeds f,users u,followers w
					WHERE  w.uid=$uid and f.uid = w.follow_id and f.uid =  u.id and f.feed_type ='$type'
					ORDER BY f.id 
					desc LIMIT $limit";	
		}
		else{
		
			if($from)
			$sql = "SELECT f.feed,f.uid,f.views,f.feed_container,u.username,u.name,u.image_type,u.email,f.id,f.time_stamp   
					FROM feeds f,users u,followers w
					WHERE (w.follow_id = f.uid) and w.uid = $uid and f.uid = u.id and f.id < $from ORDER BY f.id 
					desc LIMIT $limit";
			else
			$sql = "SELECT f.feed,f.uid,f.views,f.feed_container,u.username,u.name,u.image_type,u.email,f.id,f.time_stamp   
					FROM feeds f,users u,followers w
					WHERE f.uid =  u.id and (w.follow_id = f.uid ) and w.uid = $uid 
					ORDER BY f.id 
					desc LIMIT $limit";
					
		}
		}
		if(isset($sql)){
		//query and fetch the result
		$res=$pdo->query($sql);
		$result = $res->fetchALL(PDO::FETCH_ASSOC);

		//if record found return activation else false	
		if($result)
			return $result;
		else
			return null;
		}else
			return null;
	}

}
