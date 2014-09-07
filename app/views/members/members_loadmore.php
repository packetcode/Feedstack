
<?php
	$members = pathang::GetInstance('basket')->get('members');
	$id = null;
	foreach($members as $a =>$b)
	{
		if(isset($b->id))
		{
			$more = 'yes';
			break;
		}
	}
	if(isset($more)){
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
<?php 
	} 
	$id = $b->id;
	?>

<div class="clear clear-<?php echo $id; ?>" from="<?php echo $id; ?>"></div>
<div class="loadmore-members" id="<?php echo $id; ?>"> Load more members </div>
	<?php
	}else{
?>

<div class="clear " ></div>
<div class="no-member" > No more members</div>
<?php } ?>
