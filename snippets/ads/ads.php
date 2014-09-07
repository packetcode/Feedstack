<?php
/*	PATHANG		- A SLEAK PHP MVC FRAMEWORK
 *	package 	- Snippets
 *	file 		- ads.php
 * 	Developer	- Krishna Teja G S
 *	Website		- http://www.pathang.net
 *	license		- GNU General Public License version 2 or later
*/
defined('_PATHANG') or die;

class snippetAds
{
	public function main()
	{
		$tmpl = pathang::getInstance('packet')->get('tmpl');
		if($tmpl)
			pathang::display($tmpl);
	}
}

?>

