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
.follower-count{
	font-size:11px;
	font-weight:bold;
	color:silver;
}
</style>
<?php
	$following = pathang::getInstance('packet')->get('following');
	$username = pathang::getInstance('node')->get('n1');
	$count = pathang::getInstance('packet')->get('count');
	$check =0;
	foreach($following as $follow)
	{
		$check = 1;
		break;
	}
?>
<div class="follower-container">
	<div class="block">
	<a href="<?php echo ROOT.$username; ?>/following">
	<div class="follower-title">Following <span class="follower-count"><?php echo $count; ?></span></div>
	</a>
<?php
	if(!$check){
		echo '<div class="well">Not Following any member</div>';
	}else
	foreach($following as $user)
	echo "<a href='".$user->profile_link."'><img src='".$user->image."' class='followers tooltip' title='".$user->name."' /></a>";

?>
</div>
</div>