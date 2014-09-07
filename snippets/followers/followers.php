<?php
/*	PATHANG		- A SLEAK PHP MVC FRAMEWORK
 *	package 	- Snippets
 *	file 		- followers.php
 * 	Developer	- Krishna Teja G S
 *	Website		- http://www.pathang.net
 *	license		- GNU General Public License version 2 or later
*/
defined('_PATHANG') or die;

class snippetFollowers
{
	public function main()
	{
		$username = pathang::getInstance('node')->get('n1');
		$uid = pathang::getModel('userlog')->getUserId($username);
		pathang::GetInstance('request')->set('snippet',1);
		$followers = pathang::getController('profile')->followers();
		$count = pathang::getModel('profile')->followerCount($uid);
		pathang::GetInstance('packet')->Set('followers',$followers);
		pathang::GetInstance('packet')->Set('count',$count);
		pathang::display();
	}
}

?>

