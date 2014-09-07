	
<?php
	$basket = pathang::GetInstance('basket');
	$user = $basket->get('user');
	$comment = $basket->get('comment');
	$comment_id = $basket->get('comment_id');
?>
	<div class="feed-comment-block feed-comment-block-<?php echo $comment_id;?>">
		<div class="bcol-20x">
			<div class="feed-comment-user">
				<a href="<?php echo $user->profile_link; ?>">
					<img src="<?php echo $user->image; ?>" class="feed-comment-user-image"/>
				</a>	
			</div>
		</div>
		<div class="bcol-80x">
			<div class="feed-comment-card">
				<div class="feed-comment-name">
					<a href="<?php echo $user->profile_link; ?>">
						<small><b><?php echo $user->name; ?></b></small>
					 </a>
					 <small>just now</small>
					<span class="feed-comment-delete"  comment-id="<?php echo $comment_id;?>"><i class="fa fa-trash-o "></i></span>
				</div>
				<div class="feed-comment-text">
					<?php echo $comment; ?>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>