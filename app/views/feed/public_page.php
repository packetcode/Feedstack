<?php
	$feed_type = strtoupper(pathang::GetInstance('node')->get('n2'));
?>
<div class="feed-heading">
	<h1>
	<?php if(!$feed_type)
			echo '<i class="fa fa-space fa-th"></i> All Feeds';
		  else{
		  	switch($feed_type){
		  		case 'TEXT':
				echo '<i class="fa fa-space fa-bars"></i> Text Feeds';
				break;
				case 'PHOTO':
				echo '<i class="fa fa-space fa-picture-o"></i> Photo Feeds';
				break;
				case 'VIDEO':
				echo '<i class="fa fa-space fa-video-camera"></i> Video Feeds';
				break;
				case 'LINK':
				echo '<i class="fa fa-space fa-code"></i> Link Feeds';
				break;
		  	}
		  }
	?>
	</h1>
</div>
<?php require_once('app/views/feed/feed_list.php'); ?>
