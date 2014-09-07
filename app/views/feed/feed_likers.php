<?php 
	$likers = pathang::getInstance('basket')->get('likers'); 
?>
<h3> Feed Liked by</h3>
<div class="outer-container-liker">
<?php foreach($likers as $liker){ ?>
<div class="liker-container">
	<div class='liker-image-container'>
		<a href="<?php echo $liker->profile_link;?>">
			<img src="<?php echo $liker->image; ?>" class="liker-image" >
		</a>
		<div class="liker-name">
			<a href="<?php echo $liker->profile_link;?>"><?php echo ucfirst($liker->name); ?></a>
		</div>
	</div>	
</div>
<?php } ?>
<div class="clear"></div>
</div>