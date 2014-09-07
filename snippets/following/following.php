<?php
/*	PATHANG		- A SLEAK PHP MVC FRAMEWORK
 *	package 	- Snippets
 *	file 		- following.php
 * 	Developer	- Krishna Teja G S
 *	Website		- http://www.pathang.net
 *	license		- GNU General Public License version 2 or later
*/
defined('_PATHANG') or die;

class snippetFollowing
{
	public function main()
	{
		$username = pathang::getInstance('node')->get('n1');
		$uid = pathang::getModel('userlog')->getUserId($username);
		pathang::GetInstance('request')->set('snippet',1);
		$following = pathang::getController('profile')->following();
		$count = pathang::getModel('profile')->followingCount($uid);
		pathang::GetInstance('packet')->Set('following',$following);
		pathang::GetInstance('packet')->Set('count',$count);
		pathang::display();
	}
}

?>

