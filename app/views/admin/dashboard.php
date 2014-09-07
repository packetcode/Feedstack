<link href="<?php echo ROOT; ?>lib/expresscss/style.css" rel="stylesheet">
<style>
#hor-minimalist-b th{
	border-bottom: 2px solid silver;
	color:#2c3e50;
}
#hor-minimalist-b tbody tr:hover td{
	color:#2c3e50;
}
#hor-minimalist-b td {
	color:#7f8c8d;
}
</style>

<?php $pathang = pathang::GetInstance('pathang');
		$count= pathang::GetInstance('basket')->Get('count');  

?>
<div class="head-dashboard">
	<div >
		<div class="heading-admin"><i class="fa fa-dashboard"></i> Dashboard</div>
	</div>
</div>
<div class="dashboard">

	<div class="stats">
		<div class="bcol-25">
			<div class="stat-item">
				<div class="stat-item-number"><?php echo $count['users']; ?></div>
				<div class="stat-item-term"><i class="fa fa-user"></i> Users</div>
			</div>
		</div>
		<div class="bcol-25">
			<div class="stat-item">
				<div class="stat-item-number"><?php echo $count['likes']; ?></div>
				<div class="stat-item-term"><i class="fa fa-thumbs-o-up"></i> Likes</div>
			</div>
		</div>
		<div class="bcol-25">
			<div class="stat-item">
				<div class="stat-item-number"><?php echo $count['comments']; ?></div>
				<div class="stat-item-term"><i class="fa fa-comment-o"></i> Comments</div>
			</div>
		</div>
		<div class="bcol-25">
			<div class="stat-item">
				<div class="stat-item-number"><?php echo $count['connections']; ?></div>
				<div class="stat-item-term"><i class="fa fa-plus"></i> Connections</div>
			</div>
		</div>
		<div class="Clear"></div>
	</div>

	<div class="info-block">
		<div class="bcol-50">
			<div class="info-block-inner">
				<table class="table" id="hor-minimalist-b" >
					<tr><th><i class="fa fa-cog"></i> General</th>
						<th><a href="<?php echo ROOT.'admin/general'; ?>">
							<div class="pull-right btn">edit</div>
							</a>
						</th>
					<tr>
					
					<tr><td>Site Name</td><td><?php echo $pathang->META->SITE_NAME; ?></td><tr>
					<tr><td>Theme</td><td><?php echo $pathang->SITE->THEME; ?></td><tr>
					<tr><td>Session Expire</td><td><?php echo $pathang->SITE->SESSION_EXPIRE; ?> secs</td><tr>
					<tr><td>Database</td><td><?php echo $pathang->DB->DB_NAME; ?></td><tr>	
				</table>
			</div>
		</div>
		<div class="bcol-50">
			<div class="info-block-inner">
			<table class="table" id="hor-minimalist-b" >
					<tr><th><i class="fa fa-bars"></i> Feed </th>
						<th><a href="<?php echo ROOT.'admin/feed'; ?>">
							<div class="pull-right btn">edit</div>
							</a>
						</th>
					<tr>
					<tr>
					<tr><td>Feed Count</td><td><?php echo $pathang->FEEDSTACK->FEED_COUNT; ?></td><tr>
					<tr><td>Comment Count</td><td><?php echo $pathang->FEEDSTACK->COMMENT_COUNT; ?></td><tr>
					<tr><td>Member Count</td><td><?php echo $pathang->FEEDSTACK->MEMBER_COUNT; ?></td><tr>
					<tr><td>Notification Count</td><td><?php echo $pathang->FEEDSTACK->NOTIFICATION_CENTER_COUNT; ?></td><tr>	
				</table>
			</div>	
		</div>
		<div class="clear"></div>
	</div>
	<div class="info-block b2">
		<div class="bcol-50">
			<div class="info-block-inner">
				<table class="table" id="hor-minimalist-b" >
					<tr><th><i class="fa fa-adn"></i> Ads</th>
						<th><a href="<?php echo ROOT.'admin/ads'; ?>">
							<div class="pull-right btn">edit</div>
							</a>
						</th>
					<tr>
					
					<tr><td>Ad Blocks</td>
						<td><?php if($pathang->AD_BLOCK->VISIBLE)echo'Enabled';else echo 'Disabled' ; ?></td><tr>
				</table>
			</div>
		</div>
		<div class="bcol-50">
			<div class="info-block-inner">
			<table class="table" id="hor-minimalist-b" >
					<tr><th><i class="fa fa-send"></i> Mailgun </th>
						<th><a href="<?php echo ROOT.'admin/mailgun'; ?>">
							<div class="pull-right btn">edit</div>
							</a>
						</th>
					<tr>
					<tr><td>API </td><td><?php if($pathang->MAILGUN->API_KEY)echo 'Configured'; else echo 'Not Configured'; ?></td><tr>
				</table>
			</div>	
		</div>
		<div class="clear"></div>
	</div>
	<div class="info-block b2">
		<div class="info-feedstack">
			<div ><a href="http://feedstack.asia"><img src="<?php echo ROOT; ?>img/logo_feedstack.png"  class="feedstack_logo"/></a></div>
			<p>A social networking script developed using <a href="https://pathang.net"><i><b>pathang framework</b></i></a> by 
				<a href="https://twitter.com/shaadomanthra"><i>me <b>(krishna teja)</b></i></a>.<br>For queries and complaints you can reach
				me at <i>packetcode@gmail.com</i> or post in this <a href="https://www.facebook.com/groups/packetcode/">
				<i><b>facebook group</b></i></a> ill make my time to reply you. 
				happy coding :)</p>
		</div>
	</div>
</div>