<?php
/*	Feedstack - A Social Networking Script
 *	----------------------------------------
 *	package 		- app/models
 *	file 			- userMain.php
 * 	Developer 		- Krishna Teja G S
 *	Website			- http://www.feedstack.asia
 *	license			- GNU General Public License version 2 or later
*/

defined('_PATHANG') or die;

// UserMain model to check user details in database
class modelUserMain{

	public $table = 'users';

	public function searchDB($usr){

		$count = pathang::getInstance('pathang')->FEEDSTACK->MEMBER_COUNT;
		// create pdo object
		$pdo = pathang::getInstance('pdo');
		$table =$this->table;

		//sql statement to get user id based on hash code
		$sql = "SELECT id,name,username,email,image_type
				FROM $table 
				WHERE  name LIKE '%$usr%' LIMIT $count";
		//query and fetch the result
		$res=$pdo->query($sql);
		$result = $res->fetchALL(PDO::FETCH_ASSOC);

		//if the id exists update the activation by 
		//setting it to 1 else return false		
		if(isset($result))
		{
			return $result;
		}else
			return false;
	}


	public function followMember($uid,$follow_id){

		$time_stamp = date("Y-m-d H:i:s");

		//pdo object and table
		$pdo = pathang::getInstance('pdo');
		$table = 'followers';

		// sql insert statement
		$sql ="INSERT INTO $table 
						(uid,follow_id,time_stamp) 
				 VALUES ($uid,$follow_id,'$time_stamp')";
	

		$result = $pdo->exec($sql);
		$insertId = $pdo->lastInsertId();
		if($insertId)
			return $insertId;
		else
			return false;
	}

	public function unfollowMember($uid,$follow_id){

		$time_stamp = date("Y-m-d H:i:s");

		//pdo object and table
		$pdo = pathang::getInstance('pdo');
		$table = 'followers';

		$sql ="DELETE FROM $table 
			    WHERE uid = $uid and follow_id=$follow_id";
		$result = $pdo->exec($sql);
		
	}

	public function listMembers($count,$from=null){
		// create pdo object
		$pdo = pathang::getInstance('pdo');
		$table =$this->table;

		if(!$from)
		$sql = "SELECT id,name,username,email,image_type
				FROM $table  LIMIT $count";
		else
		$sql = "SELECT id,name,username,email,image_type
				FROM $table  where id>$from LIMIT $count";		
		//query and fetch the result
		$res=$pdo->query($sql);
		$result = $res->fetchALL(PDO::FETCH_ASSOC);

		//if the id exists update the activation by 
		//setting it to 1 else return false		
		if(isset($result))
		{
			return $result;
		}else
			return false;
	}

	public function saveNotification($uid,$agent,$target,$action){
		$time_stamp = date("Y-m-d H:i:s");
		$status =1;
		//pdo object and table
		$pdo = pathang::getInstance('pdo');
		$table = 'notifications';

		// sql insert statement
		$sql ="INSERT INTO $table 
						(uid,agent,target,action,time_stamp,status) 
				 VALUES ($uid,$agent,$target,'$action','$time_stamp',$status)";
	

		$result = $pdo->exec($sql);
		$insertId = $pdo->lastInsertId();
		if($insertId)
			return $insertId;
		else
			return false;
	}

}