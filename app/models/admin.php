<?php
/*	Feedstack - A Social Networking Script
 *	----------------------------------------
 *	package 		- app/models
 *	file 			- admin.php
 * 	Developer 		- Krishna Teja G S
 *	Website			- http://www.feedstack.asia
 *	license			- GNU General Public License version 2 or later
*/

defined('_PATHANG') or die;

class modelAdmin{

	public function getCount($table){

		//pdo object and table
		$pdo = pathang::getInstance('pdo');

		if($table=='followers'){
			$sql = "SELECT count(*) 'count'  
					FROM $table where uid!=follow_id";
		}else
		// sql insert statement
		$sql = "SELECT count(*) 'count'  
					FROM $table";

		//query and fetch the result
		$res=$pdo->query($sql);
		$result = $res->fetch(PDO::FETCH_ASSOC);

		//if record found return activation else false	
		if($result)
			return $result['count'];
		else
			return null;
	}

	
}