<?php
/*	PATHANG			- A SLEAK PHP MVC FRAMEWORK
 *	package 		- lib
 *	file 			- basket.php
 * 	Developer	 	- Krishna Teja G S
 *	Website			- http://www.pathang.net
 *	license			- GNU General Public License version 2 or later
*/

// The basket object is used to carry data to the view
// any data extracted from database is stored in basket object
defined('_PATHANG') or die;

class basket{

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