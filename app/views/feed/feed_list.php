<script src="<?php echo ROOT.'app'.DS.'script'.DS.'readmore.js';?>"></script>
<script src="<?php echo ROOT.'app'.DS.'script'.DS.'popup.js';?>"></script>
<script src="<?php echo ROOT.'app'.DS.'script'.DS.'wall.js';?>"></script>
<?php
	$basket = pathang::GetInstance('basket');
	$open_banner = pathang::getInstance('node')->get('n1');
	$feeds = $basket->get('feeds');
	$token=null;
	if(!isset($uid))
		$uid=null;
	$feed_type = ucfirst(strtolower($basket->get('feed_type')));
	if(isset(pathang::getInstance('session')->get('liveuser')->id)){
		$liveuser_id =  pathang::getInstance('session')->get('liveuser')->id;
		$token = pathang::getInstance('session')->get('liveuser')->access_token;
	}else
		$liveuser_id = null;

	$limit_counter = $basket->get('limit_counter');
	$allowed_delete = $basket->get('allowed_delete');
?>
<style>
body{
	background:#EEF4F4;
}
.footer{
	background: white;
}
.profile-container-box{
	min-height: 210px;
}

</style>

<div class="login-popup popup" ><b>Please Login to continue</b> <br>
	<a href="<?php echo ROOT;?>user/login"><button class='btn btn-login'>login</button></a>
	 <button class='btn btn-cancel' type='button'>cancel</button>
</div>
<div class="root" root="<?php echo ROOT; ?>" access-token='<?php echo $token; ?>'></div>
<?php
if($feeds) 
foreach($feeds as $a => $feed){
?>
<div class="feed feed-<?php echo $feed->id; ?>" liveuser-id="<?php echo $liveuser_id; ?>" uid ='<?php echo $feed->uid; ?>' feed-id='<?php echo $feed->id; ?>'>
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
					<span class="feed-like-count feed-like feed-like-<?php echo $feed->id; ?>" liveuser-id="<?php echo $liveuser_id; ?>" feed-id='<?php echo $feed->id; ?>' 
							unlike='<?php if($feed->liveuser_like)echo '1';else echo'0';?>' count='<?php echo $feed->like_count; ?>'>
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
	
<?php
	}else {
	if(!$open_banner){
		echo "<div class='profile-card no-border'><img src='".ROOT."img/open_banner.jpg' width='100%'/></div>";
	}else{	
?>
	<div class="profile-card" count="0">Opps ! No <?php echo $feed_type; ?> feeds yet </div>

<?php
		}
	 } 
	if(isset($feed)){
	if($a==$limit_counter-1){
?>
	<div class="loadmore-entry" root="<?php echo ROOT; ?>">
	<div class="bcol-15">&nbsp;</div>
	<div class="bcol-85">
	<div class="loadmore" lastid="<?php echo $feed->id;?>" feed-type="<?php echo $feed_type; ?>" 
		liveuser-id="<?php echo $liveuser_id; ?>" uid="<?php echo $uid; ?>" wall="<?php if(isset($wall))echo $wall; ?>">
		Load more feeds</div>
	</div>
	<div class="clear"></div>
	</div>
<?php }else{
	?>
	<div class="bcol-15">&nbsp;</div>
	<div class="bcol-85">
	<div class="no-feeds" >No more Feeds</div>
	</div>
	<div class="clear"></div>
<?php
	} 
}
?>
<br>

<?php 
$show = pathang::GetInstance('pathang')->AD_BLOCK->VISIBLE;
	if($show){	
	?>
	<div>
		<div class="bcol-15">&nbsp;</div>
		<div class="bcol-85">
				<?php
					pathang::getInstance('packet')->set('tmpl','468');
					pathang::snippet('ads');
				?>
		</div>
		<div class="clear"></div>
	</div>
<?php } ?>