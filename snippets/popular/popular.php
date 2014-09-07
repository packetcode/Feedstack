<?php
/*	PATHANG		- A SLEAK PHP MVC FRAMEWORK
 *	package 	- Snippets/popular
 *	file 		- popular.php
 * 	Developer	- Krishna Teja G S
 *	Website		- http://www.pathang.net
 *	license		- GNU General Public License version 2 or later
*/
defined('_PATHANG') or die;

class snippetPopular
{
	public function main()
	{
		//$username = pathang::getInstance('node')->get('n1');
		//$uid = pathang::getModel('userlog')->getUserId($username);
		pathang::GetInstance('request')->set('snippet',1);
		$popular = pathang::getController('profile')->popular();
		$count = 0;
		pathang::GetInstance('packet')->Set('popular',$popular);
		pathang::GetInstance('packet')->Set('count',$count);
		pathang::display();
	}
}

?>

