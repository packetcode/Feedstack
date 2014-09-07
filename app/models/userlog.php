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
class modelUserlog{

	public $table = 'users';

	//function to validate the username and password
	//called during user login
	public function validateUser($username,$password){

		//get the instance of pdo object
		$pdo = pathang::getInstance('pdo');
		$table = $this->table;

		//sql statement to retrive the user login information
		$sql = "SELECT password,block,activation,id  
					FROM $table 
					WHERE username='$username' ";
		$timestamp =  date("Y-m-d H:i:s");
		//query and fetch the results
		$res=$pdo->query($sql);
		$result = $res->fetch(PDO::FETCH_ASSOC);

		//create a status object to return the login status
		$status = new stdclass();

		//User validation
		//check username/password validity
		//then check if user in block/actiavted
		//update the status object and return control
		if($result)
		{
			if(md5($password) ===$result['password'])
			{
				$status->error = 0;
				$status->message = 'Login Success';

				if($result['block'] == 1)
				{
					$status->error = 3;
					$status->message = 'User Blocked';
				}
				if($result['activation'] != 1)
				{
					$status->error = 4;
					$status->message = 'User Not Activated';
				}

				if($status->error == 0){
					$this->updateLastLogin($result['id'],$timestamp);
				}
			}	
			else
			{
				$status->error = 2;
				$status->message = 'Wrong Password';
			}

		}else{
			$status->error = 1;
			$status->message = 'Username not found';
		}

		return $status;
	}	

	//function to add user details from registration
	//page to the backend database
	// --------SQL Table Data Info ------------------------------
	// type 1 - users, type 2 - moderator, type 3 - administrator
	// creation and lastlogin time is set to same value 
	// password is md5 hash of the given value
	// activation is a random 8 char code
	public function registerUser(){
		
		//get the instance of request object
		$request = pathang::getInstance('request');
		//get the filtered data from request object
		$name = ucwords($request->filterHTMLSQL('name'));
		$username = $request->filterHTMLSQL('username');
		$password = $request->filterHTMLSQL('password');
		$email = $request->filterHTMLSQL('email');
		//create the other required data
		$hash = md5($password);
		$activation = substr(md5(time()),-8);
		$timestamp = date("Y-m-d H:i:s");
		$feeds_per_page = pathang::getInstance('pathang')->FEEDSTACK->FEED_COUNT;
		$access = 1;
		$bio = "Hey people im a new entry to this website..hope to have fun..follow me to get updates.";
		$image_type = 'server';

		//pdo object and table
		$pdo = pathang::getInstance('pdo');
		$table = 'users';

		// sql insert statement
		$sql ="INSERT INTO $table 
						(bio,image_type,name,username,password,email,type,block,
						  activation,creation_timestamp,feeds_per_page,access,lastlogin_timestamp) 
				 VALUES ('$bio','$image_type','$name','$username','$hash','$email',1,0,
				   		 '$activation','$timestamp',$feeds_per_page,$access,'$timestamp')";
		
		// type 1 - users, type 2 - moderator, type 3 - administrator
		// creation and lastlogin time is set to same value 
		// password is md5 hash of the given value
		// activation is a random 8 char code
		$result = $pdo->exec($sql);
		$insertId = $pdo->lastInsertId();

		//self follow
		$this->selfFollow($insertId);
		$this->globalFollow($insertId);

		if($insertId)
			return $activation;
		else
			return false;
	}

	// function to set the user follow himself
	public function globalFollow($id){
		
		$time_stamp = date("Y-m-d H:i:s");
		$users = pathang::GetInstance('pathang')->FEEDSTACK->DEFAULT_FOLLOW;
		$u = explode(',',$users);

		//pdo object and table
		$pdo = pathang::getInstance('pdo');
		$table = 'followers';
		$uid = $id;

		foreach($u as $a => $b)
		{
			$follow_id = $this->getUserId(trim($b));
			// sql insert statement
			$sql ="INSERT INTO $table 
						(uid,follow_id,time_stamp) 
				 VALUES ($uid,$follow_id,'$time_stamp')";
			$result = $pdo->exec($sql);
		}
		return true;
	}

	// function to set the user follow himself
	public function selfFollow($id){
		
		$time_stamp = date("Y-m-d H:i:s");

		//pdo object and table
		$pdo = pathang::getInstance('pdo');
		$table = 'followers';
		$uid=$follow_id = $id;

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

	//function to activateUser based on the hash code
	public function activateUser($code){

		// create pdo object
		$pdo = pathang::getInstance('pdo');
		$table =$this->table;

		//sql statement to get user id based on hash code
		$sql = "SELECT id
				FROM $table 
				WHERE activation='$code' ";
		//query and fetch the result
		$res=$pdo->query($sql);
		$result = $res->fetch(PDO::FETCH_ASSOC);

		//if the id exists update the activation by 
		//setting it to 1 else return false		
		if(isset($result['id']))
		{
			$id = $result['id'];
			$sql = "UPDATE $table 
					SET activation='1'
					WHERE id=$id";
			$result = $pdo->exec($sql);			
			if(isset($result))
				return true;
			else
				return false;
		}else
			return false;
			
	}

	public function deleteUser($uid){
		// create pdo object
		$pdo = pathang::getInstance('pdo');
		$users ='users';
		$notifications ='notifications';
		$followers = 'followers';
		$feeds = 'feeds';
		$comments = 'comments';
		$likes = 'likes';

		//delete user from users table
		$sql = "DELETE from $users where id =$uid";
		$pdo->exec($sql);	

		//delete notifications
		$sql = "DELETE from $notifications where uid =$uid";
		$pdo->exec($sql);	

		//delete followers
		$sql = "DELETE from $followers where uid =$uid OR follow_id=$uid";
		$pdo->exec($sql);	

		//delete feeds
		$sql = "DELETE from $feeds where uid =$uid";
		$pdo->exec($sql);	

		//delete comments
		$sql = "DELETE from $comments where uid =$uid";
		$pdo->exec($sql);	

		//delete likes
		$sql = "DELETE from $likes where uid =$uid";
		$pdo->exec($sql);	

	}

	public function blockuser($uid){

		// create pdo object
		$pdo = pathang::getInstance('pdo');
		$table =$this->table;


			$sql = "UPDATE $table 
					SET block='1'
					WHERE id=$uid";
			$result = $pdo->exec($sql);			
			return true;
	}

	public function activateUserByAdmin($uid){

		// create pdo object
		$pdo = pathang::getInstance('pdo');
		$table =$this->table;


			$sql = "UPDATE $table 
					SET activation='1'
					WHERE id=$uid";
			$result = $pdo->exec($sql);			
			return true;
	}

	public function unblockuser($uid){

		// create pdo object
		$pdo = pathang::getInstance('pdo');
		$table =$this->table;


			$sql = "UPDATE $table 
					SET block='0'
					WHERE id=$uid";
			$result = $pdo->exec($sql);			
			return true;
	}

	public function updateLastLogin($uid,$lastlogin){

		// create pdo object
		$pdo = pathang::getInstance('pdo');
		$table =$this->table;


			$sql = "UPDATE $table 
					SET lastlogin_timestamp = '$lastlogin'
					WHERE id=$uid";
			$result = $pdo->exec($sql);			
			return true;
	}

	//function to get activation code from database
	public function getActivationCode($username){

		//pdo object
		$pdo = pathang::getInstance('pdo');
		$table = $this->table;
		//sql statement to get activation code based 
		//on username
		$sql = "SELECT activation
				FROM $table 
				WHERE username='$username' ";
		//query and fetch the result
		$res=$pdo->query($sql);
		$result = $res->fetch(PDO::FETCH_ASSOC);

		//if record found return activation else false	
		if(isset($result['activation']))
		{
			return $result['activation'];
		}
		else
			return false;
	}

	
	//function to set the forgot hash code in password feild
	public function setForgotCode($email){

		//create pdo object
		$pdo = pathang::getInstance('pdo');
		$table = $this->table;

		//sql statement to get the user id based on email
		$sql = "SELECT id
				FROM $table 
				WHERE email='$email' ";
		//query and fetch result
		$res=$pdo->query($sql);
		$result = $res->fetch(PDO::FETCH_ASSOC);	

		// if record exists take the id and update the
		// password feild with 8 char random hash code
		// and set block feild to 2 indicating the user has been
		// blocked because of forgot password reset
		// return code if success
		// return 2 if error in the update and 3 if 
		// email doesnt exist in records
		if(isset($result['id']))
		{
			$id = $result['id'];
			$code = substr(md5(time()),-8);
			$sql = "UPDATE $table 
					SET password='$code',block=2
					WHERE id=$id";
			$result = $pdo->exec($sql);			
			if(isset($result))
				return $code;
			else
				return '2'; // error-2 if error in update
		}
		else
			return '3'; // error-3 if no email found
	}


	//function to update the database record
	// to reset password based on hash code
	public function updateForgotPassword($code,$password){

		// create pdo object
		$pdo = pathang::getInstance('pdo');
		$table = $this->table;

		//sql statement to get user id based on hash code
		$sql = "SELECT id
				FROM $table 
				WHERE password='$code' ";
		//query and fetch results
		$res=$pdo->query($sql);
		$result = $res->fetch(PDO::FETCH_ASSOC);	

		//if the record is found update the record
		// with the id with new password and unblock the user
		// by setting the value to 0
		// return 1 if success and 2 is error in update
		// or 3 if the hash code is not found in records
		if(isset($result['id']))
		{
			$id = $result['id'];
			$password = md5($password);
			$sql = "UPDATE $table 
						SET password='$password',block=0
						WHERE id=$id";
			$result = $pdo->exec($sql);			
			if(isset($result))
				return 1;
			else
				return 2; // error-2 if error in update
		}
		else
			return 3; // error-3 if no code found
	}

	// function to check email exists in the database 
	public function emailCheck($email){
		//create pdo object
		$pdo = pathang::getInstance('pdo');
		$table =$this->table;

		//sql statement to fetch the user id
		//with specified email id
		$sql = "SELECT id 
				FROM $table 
				WHERE email='$email' ";
		//query and fetch result
		$res=$pdo->query($sql);
		$result = $res->fetch(PDO::FETCH_ASSOC);		

		//return true if record exists else false
		if(isset($result['id']))
			return true;
		else
			return false;	
	}

	//function to check if username exists in database 
	public function usernameCheck($username){
		// create pdo object
		$pdo = pathang::getInstance('pdo');
		$table = $this->table;

		//sql statement to get user id based on
		// specified username
		$sql = "SELECT id 
				FROM $table 
				WHERE username='$username' ";		
		// query and fetch result
		$res=$pdo->query($sql);
		$result = $res->fetch(PDO::FETCH_ASSOC);		

		// return true if record exists else false
		if(isset($result['id']))
			return true;
		else
			return false;			
	}

	public function isAdmin($id){
		//get the instance of pdo object
		$pdo = pathang::getInstance('pdo');
		$table = $this->table;
		$sql = "SELECT type  
					FROM $table 
					WHERE id='$id' ";
		//query and fetch the results
		$res=$pdo->query($sql);
		$result = $res->fetch(PDO::FETCH_ASSOC);
		if(isset($result)){
		if($result['type']==2)
			return true;
		else
			return false;
		}else
			return false;
	}
	//function to fetch the Name of user based 
	// on username
	public function getUserFullname($username,$email=null){

		//get the instance of pdo object
		$pdo = pathang::getInstance('pdo');
		$table = $this->table;
		if($email)
		$sql = "SELECT name  
					FROM $table 
					WHERE email='$email' ";
		else	
		$sql = "SELECT name  
					FROM $table 
					WHERE username='$username' ";
		//query and fetch the results
		$res=$pdo->query($sql);
		$result = $res->fetch(PDO::FETCH_ASSOC);
		if($result)
			return $result['name'];
		else
			return null;
	}


	//function to fetch the user email based 
	// on username
	public function getUserEmail($username){

		//get the instance of pdo object
		$pdo = pathang::getInstance('pdo');
		$table = 'users';
		$sql = "SELECT   email
					FROM $table 
					WHERE username='$username' ";
		//query and fetch the results
		$res=$pdo->query($sql);
		$result = $res->fetch(PDO::FETCH_ASSOC);
		if($result)
			return $result['email'];
		else
			return null;
	}

	//function to fetch the user email based 
	// on username
	public function getUserLastLogin($username){

		//get the instance of pdo object
		$pdo = pathang::getInstance('pdo');
		$table = 'users';
		$sql = "SELECT   lastlogin_timestamp
					FROM $table 
					WHERE username='$username' ";
		//query and fetch the results
		$res=$pdo->query($sql);
		$result = $res->fetch(PDO::FETCH_ASSOC);
		if($result)
			return $result['lastlogin_timestamp'];
		else
			return null;
	}

		//function to fetch the user email based 
	// on username
	public function getUserId($username){

		//get the instance of pdo object
		$pdo = pathang::getInstance('pdo');
		$table = 'users';
		$sql = "SELECT   id
					FROM $table 
					WHERE username='$username' ";
		//query and fetch the results
		$res=$pdo->query($sql);
		$result = $res->fetch(PDO::FETCH_ASSOC);
		if($result)
			return $result['id'];
		else
			return null;
	}

	//function to fetch the user type based 
	// on username
	public function getUserType($username){

		//get the instance of pdo object
		$pdo = pathang::getInstance('pdo');
		$table = 'users';
		$sql = "SELECT   type
					FROM $table 
					WHERE username='$username' ";
		//query and fetch the results
		$res=$pdo->query($sql);
		$result = $res->fetch(PDO::FETCH_ASSOC);

		//type 1- user 2-admin
		if($result)
			return $result['type'];
		else
			return null;
	}

	//function to fetch the user image type based 
	// on username
	public function getUserImageType($username){

		//get the instance of pdo object
		$pdo = pathang::getInstance('pdo');
		$table = 'users';
		$sql = "SELECT   image_type
					FROM $table 
					WHERE username='$username' ";
		//query and fetch the results
		$res=$pdo->query($sql);
		$result = $res->fetch(PDO::FETCH_ASSOC);

		if($result)
			return $result['image_type'];
		else
			return null;
	}

	//function to fetch the user email based 
	// on username
	public function getFeedCount($username){

		//get the instance of pdo object
		$pdo = pathang::getInstance('pdo');
		$table = 'users';
		$sql = "SELECT   feeds_per_page
					FROM $table 
					WHERE username='$username' ";
		//query and fetch the results
		$res=$pdo->query($sql);
		$result = $res->fetch(PDO::FETCH_ASSOC);
		if($result)
			return $result['feeds_per_page'];
		else
			return null;
	}


	public function validateTimestamp($id,$timestamp){

		//get the instance of pdo object
		$pdo = pathang::getInstance('pdo');
		$table = 'users';
		$sql = "SELECT   count(*) 'count'
					FROM $table 
					WHERE id='$id' and lastlogin_timestamp='$timestamp' ";
		//query and fetch the results
		$res=$pdo->query($sql);
		$result = $res->fetch(PDO::FETCH_ASSOC);
		if($result)
			return $result['count'];
		else
			return false;
	}
}
