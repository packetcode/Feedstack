
<script src="<?php echo ROOT.'app'.DS.'script'.DS.'members.js';?>"></script>
<?php
	$members = pathang::GetInstance('basket')->get('members');
	$count= pathang::GetInstance('basket')->get('count');
	$heading= pathang::GetInstance('basket')->get('heading');
?>
<div class="member-body">
<div class="header-member">
	<?php if($heading=='Members'){ ?>
	<i class="fa fa-space fa-group"></i> <?php } echo $heading; ?>
	<?php if($heading=='Members'){ ?>
	<span class='member-seach-span'><input type="text" class="member-search" placeholder="search..." root="<?php echo ROOT; ?>"/></span>
	<?php } ?>
</div>
<div class="root" root="<?php echo ROOT; ?>" access-token='<?php echo pathang::GetInstance('session')->get('token'); ?>'></div>
<div class="entry">
<div class="member-container">
<?php
	$i=0;
	$id=0;
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
		$i=$i+1;
	} 
	if(isset($b))
	$id = $b->id;
	else
		echo '<div class="no-member"> no members</div>';
?>
<div class="clear clear-<?php echo $id; ?>" from="<?php echo $id; ?>"></div>
<?php if($count==$i && $heading=='Members'){ ?>
<div class="loadmore-members" id="<?php echo $id; ?>"> Load more members </div>
<?php }?>
</div>
</div>
<?php
	$show = pathang::GetInstance('pathang')->AD_BLOCK->VISIBLE;
	if($show){	
	?>
	<div >
				<?php
					pathang::getInstance('packet')->set('tmpl','728');
					pathang::snippet('ads');
				?>

	</div>
	<?php } ?>
</div>