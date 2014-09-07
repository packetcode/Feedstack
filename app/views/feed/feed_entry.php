<?php
	$basket = pathang::getInstance('basket');
	$image = $basket->get('image');
	$feed = $basket->get('feed');
	$feed_container = $basket->get('feed_container');
	$feed_id = $basket->get('feed_id');
	$name = $basket->get('name');
	$profile_link = $basket->get('profile_link');

	$feed_type = strtoupper($basket->get('feed_type'));
	if(isset(pathang::getInstance('session')->get('liveuser')->id))
		$liveuser_id =  pathang::getInstance('session')->get('liveuser')->id;
	else
		$liveuser_id = null;
?>
<div class="feed feed-<?php echo $feed_id; ?>" liveuser-id="<?php echo $liveuser_id; ?>" feed-id='<?php echo $feed_id; ?>'>
		<div class="bcol-15">
			<div class="feed-user mobile-hidden">
				<a href="<?php echo $profile_link; ?>">
					<img src="<?php echo $image;?>" class="feed-user-image"/>
				</a>	
			</div>
		</div>
		<div class="bcol-85">
		<div class="feed-container">
			<div class="feed-block">
				<div class="bcol-10x mobile-visible">
					<div class="feed-user">
						<a href="<?php echo $profile_link; ?>">
						<img src="<?php echo $image; ?>" class="feed-user-image-mobile"/>
						</a>
					</div>
				</div>
				<div class="bcol-90x">
					<div class="feed-title">
					<b><a href="<?php echo $profile_link; ?>"> <?php echo $name; ?></a></b> 
					<span class="feed-delete"><i class="fa fa-trash-o "></i></span><br> 
					<small class="feed-time-mobile mobile-visible">just now</small>
				</div>
				</div>
				
				<div class="clear"></div>
				<div class="feed-content">
					<?php echo nl2br($feed).$feed_container;?>
				</div>
				<small>
					<span class="feed-view-count">
						<a href="<?php echo ROOT.'feed'.DS.$feed_id; ?>"><i class="fa fa-eye "></i> No views</a>
					</span>
					<span class="feed-like-count feed-like feed-like-<?php echo $feed_id; ?>"
					 liveuser-id="<?php echo $liveuser_id; ?>" 
					 feed-id='<?php echo $feed_id; ?>' unlike='0'
					 count='0'>
							<i class="fa fa-thumbs-o-up"></i> 
							<span class="like-count-<?php echo $feed_id; ?>">0</span> 
							<span class="likes-word-<?php echo $feed_id; ?>"> Likes</span>
					</span>
					<span class="feed-comment-count" feed-id='<?php echo $feed_id; ?>'>
						<i class="fa fa-comment-o "></i> 
						<span class="comment-count-<?php echo $feed_id; ?>">
							0 </span> Comments
					</span>
					<span class="loading-likers" style="display:none"><img src="<?php echo ROOT; ?>img/loading1.gif"/></span>
					<div class="feed-time mobile-hidden">just now </div>
				</small>
			</div>
			<?php 
				echo "<div class='like-entry-$feed_id'><span class='you-like-".$feed_id."'></span></div>"; 
			?>
		<div class="comment-block-entry-<?php echo $feed_id; ?>" style="display:none"></div>
		</div>
		</div>
		<div class="clear"></div>
	</div>
	
