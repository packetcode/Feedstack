<?php 
		$all = $text=$photo=$video=$link=null;
		$node = pathang::getInstance('node');
		if($node->get('n1'))
		{
			$active = $node->get('n1');
			$$active = 'active';
		}else{
			$all= 'active';
		}
?>	
	<div class="flip">
	<div class="feed-menu" menuwidth="261">
		<ul class="feed-menu-list">
			<a href="<?php echo ROOT;?>" class="feed-menu-list-item-link"><li class="feed-menu-list-item <?php echo $all; ?>">
				<i class="fa fa-space fa-th"></i><span class="feed-menu-text">All Feeds</span>
			</li></a>
			<a href="<?php echo ROOT;?>text" class="feed-menu-list-item-link"><li class="feed-menu-list-item <?php echo $text; ?>">
				<i class="fa fa-space fa-bars"></i><span class="feed-menu-text">Text Feeds</span>
			</li></a>
			<a href="<?php echo ROOT;?>photo" class="feed-menu-list-item-link"><li class="feed-menu-list-item <?php echo $photo; ?>">
				<i class="fa fa-space fa-picture-o"></i><span class="feed-menu-text">Photo Feeds</span>
			</li></a>
			<a href="<?php echo ROOT;?>video" class="feed-menu-list-item-link"><li class="feed-menu-list-item <?php echo $video; ?>"> 
				<i class="fa fa-space fa-video-camera"></i><span class="feed-menu-text">Video Feeds</span>
			</li></a>
			<a href="<?php echo ROOT;?>link" class="feed-menu-list-item-link"><li class="feed-menu-list-item <?php echo $link; ?>" > 
				<i class="fa fa-space fa-code"></i><span class="feed-menu-text">Link Feeds</span>
			</li></a>
		</ul>
	</div>
	</div>