<?php
/*	PATHANG		- A SLEAK PHP MVC FRAMEWORK
 *	package 	- Snippets/sidemenu
 *	file 		- sidemenu.php
 * 	Developer	- Krishna Teja G S
 *	Website		- http://www.pathang.net
 *	license		- GNU General Public License version 2 or later
*/
defined('_PATHANG') or die;

class snippetSidemenu
{
	public function main()
	{
		//openmenu based on page either 'feed','admin' or 'mainpage'
		$page = strtoupper(pathang::getInstance('node')->get('n1'));
		if($page==='FEED' || $page === 'ADMIN')
			pathang::display(strtolower($page));
		else
			pathang::display();
	}
}

?>

