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
	padding:10px 0px; 
}
.follower-title{
	font-size: 20px;
	line-height: 25px;
	padding:10px 0px 15px;
}
.block{
	background: white;
	padding:10px;
	border-radius: 5px;
}
</style>
<?php
	$followers = pathang::getInstance('packet')->get('followers');
	$count = pathang::getInstance('packet')->get('count');
	$username = pathang::getInstance('node')->get('n1');
	$check =0;
	foreach($followers as $follow)
	{
		$check = 1;
		break;
	}
?>
<div class="follower-container">
	<div class="block">
	<a href="<?php echo ROOT.$username; ?>/followers">
		<div class="follower-title">Followers <span class="follower-count"><?php echo $count; ?></span></div>
	</a>
<?php
	if(!$check){
		echo '<div class="well">No member is following</div>';
	}else
	foreach($followers as $user)
	echo "<a href='".$user->profile_link."' id='tooltip' >
			<img src='".$user->image."' class='followers tooltip' title='".$user->name."' /></a>";

?>
</div>
</div>