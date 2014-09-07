	<?php
		$basket = pathang::getInstance('basket');
		$feed_id=$basket->get('feed_id');
		$comments = $basket->Get('comments');
		$more_comments = $basket->Get('more-comments');
		$comment_count = $basket->Get('comment_count');
		$comment_show_count = $basket->Get('comment_show_count');
		$liveuser = pathang::GetInstance('session')->get('liveuser');

		if(isset(pathang::getInstance('session')->get('liveuser')->id))
		$liveuser_id =  pathang::getInstance('session')->get('liveuser')->id;
		else
		$liveuser_id = null;
		$first =0;
		for($i=0;$i<5;$i++)
			if(isset($comments->$i->id))
			$first=$comments->$i->id;
		$allowed_delete = $basket->get('allowed_delete');
	?>
	<?php if($comment_count>0){ ?>
	<div class="load-more-comments" comment-count ="<?php echo $comment_count; ?>" last-comment-id="<?php echo $first; ?>" comment-show-count ="<?php echo $comment_show_count; ?>"feed-id = "<?php echo $feed_id; ?>">load more comments (<span class="comment-out-of"><?php echo $comment_count; ?></span>)</div>
	<?php } ?>
	<div class="feed-comment">
		<div class="feed-comment-list feed-comment-list-<?php echo $feed_id; ?>">
		<?php
		for($k=4;$k>-1	;$k--){
			if(isset($comments->$k)){
			$comment = $comments->$k;
		?>
			<div class="feed-comment-block feed-comment-block-<?php echo $comment->id;?>">
				<div class="bcol-20x">
					<div class="feed-comment-user">
						<a href="<?php echo $comment->profile_link;?>">
						<img src="<?php echo $comment->image;?>" class="feed-comment-user-image"/>
						</a>
					</div>
				</div>
				<div class="bcol-80x">
					<div class="feed-comment-card">
						<div class="feed-comment-name">
							<small><b>
								<a href="<?php echo $comment->profile_link;?>">
									<?php echo $comment->name; ?>
								</a>
							</b></small> 
							<small><?php echo $comment->time_stamp; ?></small>	
							<?php if($liveuser_id == $comment->uid || $allowed_delete){ ?>		
							<span class="feed-comment-delete" comment-id="<?php echo $comment->id;?>"><i class="fa fa-trash-o "></i></span>
							<?php } ?>
						</div>
						<div class="feed-comment-text">
							<?php echo $comment->comment; ?>
						</div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		<?php
			}
			}
		?>
			<div class="feed-comment-entry feed-comment-entry-<?php echo$feed_id; ?>"></div>
		</div>
		<?php
		if($liveuser){
		?>
		<div class="feed-comment-input" feed-id="<?php echo $feed_id; ?>" >
			<div class="bcol-20x">
				<div class="feed-comment-user">
					<a href="<?php echo $liveuser->profile_link;?>">
						<img src="<?php echo $liveuser->image;?>" class="feed-comment-user-image"/>
					</a>	
				</div>
			</div>
			<div class="bcol-80x">
				<div class="feed-comment-input-box">
				<input type="text" class="feed-comment-input-entry " placeholder="Enter the comment...">
				</div>	
			</div>
			<div class="clear"></div>
		</div>
		<?php
			}else{
		?>
			<div class="comment-login">please <a href="<?php echo ROOT.'user/login';?>"><b>login</b></a> to comment</div>
		<?php } ?>
	</div>