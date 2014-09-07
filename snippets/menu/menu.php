<?php
/*	PATHANG		- A SLEAK PHP MVC FRAMEWORK
 *	package 	- Snippets
 *	file 		- menu.php
 * 	Developer	- Krishna Teja G S
 *	Website		- http://www.pathang.net
 *	license		- GNU General Public License version 2 or later
*/
defined('_PATHANG') or die;

class snippetMenu
{
	public function main()
	{
		//display menu as user/guest or admin
		$n1 = pathang::getInstance('node')->get('n1');
		$session= pathang::getInstance('session');
		$liveuser = $session->get('liveuser');
		if($liveuser)
		{
			$uid = $liveuser->id;
			$unread = pathang::GetModel('profile')->getUnreadNotificationCount($uid);
			pathang::getInstance('packet')->set('unread',$unread);
			if($liveuser->type==1)
				pathang::display();	
			else
				pathang::display('admin');
		}
		else
		pathang::display('guest');
	}
}

?>

