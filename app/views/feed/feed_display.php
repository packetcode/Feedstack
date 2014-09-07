
<script src="<?php echo ROOT.'app'.DS.'script'.DS.'popup.js';?>"></script>
<script src="<?php echo ROOT.'app'.DS.'script'.DS.'readmore.js';?>"></script>
<script src="<?php echo ROOT.'app'.DS.'script'.DS.'wall.js';?>"></script>
<?php
	$feed = pathang::getInstance('basket')->Get('feed');
	$profile_link = ROOT.$feed->username;
	$basket = pathang::getInstance('basket');
	$token=null;
	if(isset(pathang::getInstance('session')->get('liveuser')->id)){
		$liveuser_id =  pathang::getInstance('session')->get('liveuser')->id;
		$token = pathang::getInstance('session')->get('liveuser')->access_token;
	}else
		$liveuser_id = null;
	$allowed_delete = $basket->get('allowed_delete');
?>
<div class="login-popup popup" ><b>Please Login to continue</b> <br>
	<a href="<?php echo ROOT;?>user/login"><button class='btn btn-login'>login</button></a>
	<button class='btn btn-cancel'>cancel</button>
</div>
<div class="root" root="<?php echo ROOT; ?>" access-token='<?php echo $token; ?>'></div>
<div class="feed feed-display feed-<?php echo $feed->id; ?>" liveuser-id="<?php echo $liveuser_id; ?>" feed-id='<?php echo $feed->id; ?>'>
		<div class="bcol-15">
			<div class="feed-user mobile-hidden">
				<a href="<?php echo $feed->profile_link; ?>">
					<img src="<?php echo $feed->image;?>" class="feed-user-image"/>
				</a>	
			</div>
		</div>
		<div class="bcol-85">
		<div class="feed-container">
			<div class="feed-block">
				<div class="bcol-10x mobile-visible">
					<div class="feed-user">
						<a href="<?php echo $feed->profile_link; ?>">
						<img src="<?php echo $feed->image; ?>" class="feed-user-image-mobile"/>
						</a>
					</div>
				</div>
				<div class="bcol-90x">
					<div class="feed-title">
					<b><a href="<?php echo $feed->profile_link; ?>"> <?php echo $feed->name; ?></a></b> 
					<?php if($liveuser_id == $feed->uid || $allowed_delete){ ?>
						<span class="feed-delete"><i class="fa fa-trash-o "></i></span><br> 
					<?php } ?>
					<small class="feed-time-mobile mobile-visible"><?php echo $feed->time_stamp; ?> </small>
				</div>
				</div>
				
				<div class="clear"></div>
				<div class="feed-content">
				<?php echo "<div class='article'>".nl2br($feed->feed).'</div>'.$feed->feed_container;?>
			
				</div>
				<small>
					<span class="feed-view-count">
						<a href="<?php echo ROOT.'feed'.DS.$feed->id; ?>"><i class="fa fa-eye "></i> <?php echo $feed->views; ?> views </a>
					</span>
					<span class="feed-like-count feed-like feed-like-<?php echo $feed->id; ?>" 
						liveuser-id="<?php echo $liveuser_id; ?>" 
						feed-id='<?php echo $feed->id; ?>' 
						unlike='<?php if($feed->liveuser_like)echo '1';else echo'0';?>'
						count='<?php echo $feed->like_count; ?>'>
							<i class="fa fa-thumbs-o-up"></i> 
							<?php if(!$feed->liveuser_like)
										echo '<span class="like-count-'.$feed->id.'">'.$feed->like_count.'</span> 
										<span class="likes-word-'.$feed->id.'"> Likes</span>';
									else 
										echo '<span class="like-count-'.$feed->id.' hidden">'.$feed->like_count.'</span>
										<span class="likes-word-'.$feed->id.'"> unlike</span>'; 
							?>
					</span>
					<span class="feed-comment-count" feed-id='<?php echo $feed->id; ?>'>
						<i class="fa fa-comment-o "></i> 
						<span class="comment-count-<?php echo $feed->id; ?>">
							<?php echo $feed->comment_count; ?></span> Comments
					</span>
					<span class="loading-likers" style="display:none"><img src="<?php echo ROOT; ?>img/loading1.gif"/></span>
					<div class="feed-time mobile-hidden"><?php echo $feed->time_stamp; ?> </div>
				</small>
			</div>
			<?php 
			
				if($feed->like_count>0){
					echo '<div class="feed-connect like-entry-'.$feed->id.'" >';
				if($feed->liveuser_like){
					if($feed->like_count>2){ ?>
						<span class='you-like-<?php echo $feed->id; ?>'>you and</span> <span class='feed-likers' feed-id='<?php echo $feed->id; ?>'><?php echo $feed->like_count-1; ?> members</span> liked it
					<?php }elseif($feed->like_count==2) { ?>
						<span class='you-like-<?php echo $feed->id; ?>'>you and</span> <span class='feed-likers' feed-id='<?php echo $feed->id; ?>'><?php echo $feed->like_count-1; ?> member</span> liked it
					<?php }elseif($feed->like_count==1){ ?>
						<span ='you-like-<?php echo $feed->id; ?>'>you liked it</span> 
					<?php }
				}else{
					if($feed->like_count>1){ ?>
					<span class='you-like-<?php echo $feed->id; ?>'></span> <span class='feed-likers' feed-id='<?php echo $feed->id; ?>'><?php echo $feed->like_count; ?> members</span> liked it
					<?php }elseif($feed->like_count==1) { ?>
					<span class='you-like-<?php echo $feed->id; ?>'></span> <span class='feed-likers' feed-id='<?php echo $feed->id; ?>'><?php echo $feed->like_count; ?> member</span> liked it
					<?php }
				}
				echo '<span class="loading-likers" style="display:none"><img src="'.ROOT.'img/loading1.gif"/></span></div>';
				}else
				echo "<div class='like-entry-$feed->id'><span class='you-like-".$feed->id."'></span></div>"; 
			?>
		<div class="comment-block-entry-<?php echo $feed->id; ?>" style="display:none"></div>
		</div>
		</div>
		<div class="clear"></div>
	</div>