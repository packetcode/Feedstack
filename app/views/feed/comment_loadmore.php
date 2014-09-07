	<?php
		$basket = pathang::getInstance('basket');
		$feed_id=$basket->get('feed_id');
		$comments = $basket->Get('comments');
		$lastid = $basket->Get('lastid');
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
		<div class="load-more-check-<?php echo $feed_id; ?>-<?php echo $lastid; ?>" last-comment-id="<?php echo $first; ?>"></div> 
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
		