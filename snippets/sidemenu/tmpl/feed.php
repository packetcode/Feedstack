<?php
		$all = $text=$photo=$video=$link=null;
		$node = pathang::getInstance('node');
		if($node->get('n2'))
		{
			$active = $node->get('n2');
			$$active = 'active';
		}else{
			$all= 'active';
		}
?>	
	<div class="flip">
	<div class="feed-menu" menuwidth="261">
		<ul class="feed-menu-list" >
			<a href="<?php echo ROOT;?>feed" class="feed-menu-list-item-link"><li class="feed-menu-list-item <?php echo $all; ?>">
				<i class="fa fa-space fa-th"></i><span class="feed-menu-text">All Feeds</span>
			</li></a>
			<a href="<?php echo ROOT;?>feed/text" class="feed-menu-list-item-link"><li class="feed-menu-list-item <?php echo $text; ?>">
				<i class="fa fa-space fa-bars"></i><span class="feed-menu-text">Text Feeds</span>
			</li></a>
			<a href="<?php echo ROOT;?>feed/photo" class="feed-menu-list-item-link"><li class="feed-menu-list-item <?php echo $photo; ?>">
				<i class="fa fa-space fa-picture-o"></i><span class="feed-menu-text">Photo Feeds</span>
			</li></a>
			<a href="<?php echo ROOT;?>feed/video" class="feed-menu-list-item-link"><li class="feed-menu-list-item <?php echo $video; ?>"> 
				<i class="fa fa-space fa-video-camera"></i><span class="feed-menu-text">Video Feeds</span>
			</li></a>
			<a href="<?php echo ROOT;?>feed/link" class="feed-menu-list-item-link"><li class="feed-menu-list-item <?php echo $link; ?>" > 
				<i class="fa fa-space fa-code"></i><span class="feed-menu-text">Link Feeds</span>
			</li></a>
		</ul>
	</div>
	</div>