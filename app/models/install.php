<?php
/*	Feedstack - A Social Networking Script
 *	----------------------------------------
 *	package 		- app/models
 *	file 			- install.php
 * 	Developer 		- Krishna Teja G S
 *	Website			- http://www.feedstack.asia
 *	license			- GNU General Public License version 2 or later
*/

defined('_PATHANG') or die;

class modelInstall{

	public function main($request){

			$db_name = $request->get('db_name');
			$host = $request->get('host');
			$user =$request->get('db_username');
			$pass = $request->get('db_password');
			
			
			$site_name = $request->get('site_name');
			$site_url = $request->Get('site_url');

			$this->create_db($db_name,$host,$user,$pass);
			$this->create_tables($db_name,$host,$user,$pass);
			$this->update_config($site_name,$site_url,$db_name,$host,$user,$pass);

	}

	public function create_db($db_name,$host,$user,$pass)
	{
			try {
				$db = new PDO("mysql:host=$host", $user, $pass);
				$db->exec("CREATE DATABASE `$db_name`;") 
				or die(print_r($db->errorInfo(), true));
			} catch (PDOException $e) {
				die("DB ERROR: ". $e->getMessage());
			}	
	}

	public function create_tables($db_name,$host,$user,$pass)
	{
		$db = new PDO("mysql:host=localhost;dbname=$db_name", $user, $pass);
		
		$file = 'app/db.json';
		if(file_exists($file))
		{
			$setting = json_decode(file_get_contents($file));
			foreach($setting as $key =>$value)
					$db->exec($value);
		}	

		//create admin
		$request = pathang::GetInstance('request');
		$name = ucwords($request->filterHTMLSQL('name'));
		$username = $request->filterHTMLSQL('username');
		$password = $request->filterHTMLSQL('password');
		$email = $request->filterHTMLSQL('email');
		$hash = md5($password);
		$activation = 1;
		$timestamp = date("Y-m-d H:i:s");
		$feeds_per_page = pathang::getInstance('pathang')->FEEDSTACK->FEED_COUNT;
		$access = 1;
		$bio = "Hey people im a new entry to this website..hope to have fun..follow me to get updates.";
		$image_type = 'server';

		//pdo object and table
		$pdo = $db;
		$table = 'users';

		// sql insert statement
		$sql ="INSERT INTO $table 
						(bio,image_type,name,username,password,email,type,block,
						  activation,creation_timestamp,feeds_per_page,access,lastlogin_timestamp) 
				 VALUES ('$bio','$image_type','$name','$username','$hash','$email',2,0,
				   		 '$activation','$timestamp',$feeds_per_page,$access,'$timestamp')";
		
		// type 1 - users, type 2 - moderator, type 3 - administrator
		// creation and lastlogin time is set to same value 
		// password is md5 hash of the given value
		// activation is a random 8 char code
		$result = $pdo->exec($sql);
		$uid = $pdo->lastInsertId();	
		//self follow
				
		$time_stamp = date("Y-m-d H:i:s");

		$table = 'followers';
		$follow_id = $uid;

		// sql insert statement
		$sql ="INSERT INTO $table 
						(uid,follow_id,time_stamp) 
				 VALUES ($uid,$follow_id,'$time_stamp')";
	

		$result = $pdo->exec($sql);
		
	}


	public function update_config($site_name,$site_url,$db_name,$host,$user,$pass)
	{
		if(!$site_url)
		$site_url= 'http'.(empty($_SERVER['HTTPS'])?'':'s').'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		
		$config = json_decode(file_get_contents('config.json'));
		$config->META->SITE_NAME = $site_name;
		$config->META->TITLE = $site_name;
		$config->SITE->ROOT = $site_url;
		$config->SITE->INSTALLATION = '1';
		$config->META->SITE_URL = $site_url;
		$config->SITE->HASH = substr(md5(rand()), 0, 7);
		$config->DB->DB_NAME = $db_name;
		$config->DB->HOST = $host;
		$config->DB->USERNAME = $user;
		$config->DB->PASSWORD = $pass;
		
		file_put_contents('config.json', json_encode($config,JSON_PRETTY_PRINT));
	}

	
}