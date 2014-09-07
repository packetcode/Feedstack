<?php
/*	PATHANG			- A SLEAK PHP MVC FRAMEWORK
 *	package 		- lib
 *	file 			- packet.php
 * 	Developer 		- Krishna Teja G S
 *	Website			- http://www.pathang.net
 *	license			- GNU General Public License version 2 or later
*/
defined('_PATHANG') or die;

// The packet object is used to carry data from snippet to view
class packet{

	//function to store a value as object variable
	function set($key,$value){
		$this->$key = $value;
	}
	
	//function to retrieve the stored object variables
	function get($key){
		if(isset($this->$key))
			return $this->$key;
		else
			return null;
	}
}