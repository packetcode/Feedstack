<style>
.followers{
	padding:2px;
	width:40px;
}
.follower-container{
	padding-left:10px;
}
.follower-title{
	font-size: 20px;
	line-height: 25px;
	padding:10px 0px 15px;
}
.block{
	background: white;
	padding:10px;
	margin-top:20px;
	border-radius: 5px;
}
</style>
<?php
	$popular = pathang::getInstance('packet')->get('popular');
	$count = pathang::getInstance('packet')->get('count');
	$username = pathang::getInstance('node')->get('n1');
	$check =0;
	foreach($popular as $follow)
	{
		$check = 1;
		break;
	}
?>

<div class="follower-container">
	<div class="block">
		<div class="follower-title">Popular Members</div>
<?php

	if(!$check){
		echo '<div class="well">Just started..it takes sometime for members to get popular..stay tuned ;P</div>';
	}else
	foreach($popular as $user)
	echo "<a href='".$user->profile_link."' id='tooltip' >
			<img src='".$user->image."' class='followers tooltip' title='".$user->name."' /></a>";
?>
</div>
</div>