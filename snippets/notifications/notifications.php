<?php
/*	PATHANG		- A SLEAK PHP MVC FRAMEWORK
 *	package 	- Snippets
 *	file 		- notifications.php
 * 	Developer	- Krishna Teja G S
 *	Website		- http://www.pathang.net
 *	license		- GNU General Public License version 2 or later
*/
defined('_PATHANG') or die;

class snippetNotifications
{
	public function main()
	{
		// get request object
		$request=pathang::GetInstance('request');
		// set the snippet,limit and unread varaibles
		$request->Set('snippet','one');
		$request->set('limit',3);
		$request->set('unread',true);
		// if user exists then only display
		if(isset(pathang::GetInstance('session')->get('liveuser')->username))
		{
			$liveuser = pathang::GetInstance('session')->get('liveuser')->username;
			$user = pathang::GetInstance('node')->get('n1');
			//if the user is liveuser then display
			if($user==$liveuser){
				//get notification and counter
				$notify = pathang::getController('profile')->notifications()->messages;
				$count = pathang::getController('profile')->notifications()->unread;
				pathang::GetInstance('packet')->set('notify',$notify);
				pathang::GetInstance('packet')->set('count',$count);
				pathang::display();
			}
		}
	}
}

?>

