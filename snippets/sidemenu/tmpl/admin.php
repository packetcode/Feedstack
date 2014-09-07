<style>
	.admin-card{
		background: white;
		padding: 15px;
		font-size: 20px;
	}
	.flip{
		margin-right: 10px;
		margin-left: 0px;
	}
	.feed-menu-list li{
		background: #2980b9;
	}
	.feed-menu-list li:hover{
		background:#3498db;
	}
	.feed-menu-list li.active{
		background: #3498db;
	}
</style>
	<?php
		$admin = $general=$feed=$page=$ads=$mailgun=null;
		$node = pathang::getInstance('node');
		if($node->get('n2'))
		{
			$active = $node->get('n2');
			$$active = 'active';
		}else{
			$admin = 'active';
		}
	?>
	
	<div class="flip">
	<div class="feed-menu" menuwidth="311">
		<ul class="feed-menu-list">
			<a href="<?php echo ROOT;?>admin/" class="feed-menu-list-item-link">
			<li class="feed-menu-list-item <?php echo $admin; ?>">
				<i class="fa fa-space fa-dashboard "></i><span class="feed-menu-text">Dashboard</span>
			</li></a>
			<a href="<?php echo ROOT;?>admin/general" class="feed-menu-list-item-link"><li class="feed-menu-list-item <?php echo $general; ?>">
				<i class="fa fa-space fa-cog"></i><span class="feed-menu-text">General Settings</span>
			</li></a>
			<a href="<?php echo ROOT;?>admin/feed" class="feed-menu-list-item-link"><li class="feed-menu-list-item <?php echo $feed ?>">
				<i class="fa fa-space fa-bars"></i><span class="feed-menu-text">Feed Settings</span>
			</li></a>
			<a href="<?php echo ROOT;?>admin/page" class="feed-menu-list-item-link"><li class="feed-menu-list-item <?php echo $page; ?>" > 
				<i class="fa fa-space fa-html5"></i><span class="feed-menu-text">Custom Pages</span>
			</li></a>
			<a href="<?php echo ROOT;?>admin/ads" class="feed-menu-list-item-link"><li class="feed-menu-list-item <?php echo $ads; ?>"> 
				<i class="fa fa-space fa-adn"></i><span class="feed-menu-text">Ad Management</span>
			</li></a>
			<a href="<?php echo ROOT;?>admin/mailgun" class="feed-menu-list-item-link"><li class="feed-menu-list-item <?php echo $mailgun; ?>">
				<i class="fa fa-space fa-send"></i><span class="feed-menu-text">Mailgun Config</span>
			</li></a>
		</ul>
	</div>
	</div>