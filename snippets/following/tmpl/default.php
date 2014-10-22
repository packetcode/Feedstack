<style>

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