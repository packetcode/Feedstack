<?php
/*	PATHANG			- A SLEAK PHP MVC FRAMEWORK
 *	package 		- root
 *	file 			- index.php
 * 	Developer 		- Krishna Teja G S
 *	Website			- http://www.pathang.net
 *	license			- GNU General Public License version 2 or later
*/

//*********************************************
//
// Hacked Pathang Framework for Feedstack app
//
//*********************************************
/*
	Feedstack - A Social Networking Script
	----------------------------------------
	Users can post text,photo,video or link feeds.
	Users can Follow/Unfollow others.
	Users can like comment or view the feed of the following users.
	Admin can add/delete/block the users.
	Admin can view the feed/user statistics.
	Admin can alter the configuration.
	-----------------------------------------
*/

//defining a global constant to block direct access to files
define('_PATHANG',true);
// directory separator
define('DS',DIRECTORY_SEPARATOR);

//load the error class and pathang class
require_once "lib".DS."error.php";
require_once "lib".DS."pathang.php";
//creating the instance of kite object
$pathang = pathang::getInstance('pathang')->main();
