<?php
/*	Feedstack - A Social Networking Script
 *	----------------------------------------
 *	package 		- app/controllers
 *	file 			- userMain.php
 * 	Developer 		- Krishna Teja G S
 *	Website			- http://www.feedstack.asia
 *	license			- GNU General Public License version 2 or later
*/

defined('_PATHANG') or die;

// Controller to deal with user operations
class ControllerUserMain{

	public function search(){
		$usr = pathang::getInstance('request')->get('user');
		$members = pathang::GetModel('usermain')->searchDB($usr);
		$users = new stdClass();
		foreach($members as $a=>$b){
			$temp = new stdClass();
			foreach($b as $x=>$y){
				$temp->$x = $y;	
			}
			
			$temp->profile_link = ROOT.$temp->username;
			$temp->image='';
			$w='a'.$a;
			$users->$w = $temp;
		}
		
		$result = pathang::GetHelper('userlog')->getUsersImage($users);
		pathang::GetInstance('basket')->set('members',$result);
		pathang::render('members','search');
	}

	public function follow(){
		$uid = pathang::getInstance('request')->get('uid');
		$liveuser_id = pathang::getInstance('request')->get('liveuser_id');
		//check for validity of access token
		pathang::getHelper('userlog')->ajaxAuthentication();
		
		//echo $uid.$liveuser_id;
		$status = pathang::GetModel('usermain')->followMember($liveuser_id,$uid);

		echo 1;
	}

	public function unfollow(){
		$uid = pathang::getInstance('request')->get('uid');
		$liveuser_id = pathang::getInstance('request')->get('liveuser_id');
		//check for validity of access token
		pathang::getHelper('userlog')->ajaxAuthentication();
		
		//echo $uid.$liveuser_id;
		$status = pathang::GetModel('usermain')->unfollowMember($liveuser_id,$uid);

		echo 1;
	}

	public function showMembers(){
		$count = pathang::getInstance('pathang')->FEEDSTACK->MEMBER_COUNT;
		$from = pathang::getInstance('request')->get('from');
		if($from)
		$members = pathang::GetModel('usermain')->listMembers($count,$from);
		else	
		$members = pathang::GetModel('usermain')->listMembers($count);

		$users = new stdClass();
		foreach($members as $a=>$b){
			$temp = new stdClass();
			foreach($b as $x=>$y)
			$temp->$x = $y;
			$temp->image='';
			$temp->profile_link = ROOT.$temp->username;
			$users->$a = $temp;
		}
		
		$result = pathang::GetHelper('userlog')->getUsersImage($users);
		$basket = pathang::GetInstance('basket');
		$basket->set('members',$result);
		$basket->set('count',$count);
		$basket->set('heading','Members');
		if($from)
		pathang::render('members','members_loadmore');
		else
		pathang::render('members');
	}

	public function notify(){
		$request = pathang::GetInstance('request');
		$target = $request->get('target');
		$agent = $request->get('agent');
		$action = $request->get('action');
		$uid = $request->get('uid');
		//check for validity of access token
		pathang::getHelper('userlog')->ajaxAuthentication();
		
		pathang::getModel('usermain')->saveNotification($uid,$agent,$target,$action);
	}

}