<?php $members = pathang::GetInstance('basket')->get('members'); ?>
<div class="member-container">
<?php

if(!isset($members->a0))
	echo '<div class="no-member">No User Found</div>';
else
	foreach($members as $a =>$b){
?>
<div class="bcol-member-block">
	<div class="member-image">
		<a href="<?php echo $b->profile_link; ?>">
		<?php
			echo "<img src='".$b->image."' class='member' />";
		?>
		</a>
	</div>
	<div class="member-name">
		<a href="<?php echo $b->profile_link; ?>"><?php echo $b->name;?></a>
	</div>
</div>
<?php } ?>
<div class="clear"></div>
</div>