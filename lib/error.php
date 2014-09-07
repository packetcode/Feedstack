<?php
/*	PATHANG			- A SLEAK PHP MVC FRAMEWORK
 *	package 		- lib
 *	file	 		- error.php
 * 	Developer	 	- Krishna Teja G S
 *	Website			- http://www.pathang.net
 *	license			- GNU General Public License version 2 or later
*/
defined('_PATHANG') or die;

// Error Class
 class Error{
 
	//function to display error messages to screen
	public static function message($error){
		echo $error;
		exit();
	}
	//function to display restricted message	
	public static function restricted($key){
		echo "Restricted Access to '".$key."'";
		exit();
	}
	//function to display undefined error messages
	public static function undefined($key){
		echo "Definition  for '".$key."' is not found";
		exit();
	}	

 }