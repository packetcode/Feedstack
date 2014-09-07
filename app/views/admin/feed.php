<script src="<?php echo ROOT.'app'.DS.'script'.DS.'admin.js';?>"></script>
<?php 
		$pathang = pathang::getInstance('pathang'); 
		$save = pathang::getInstance('basket')->get('save'); 
?>
<form action="<?php echo ROOT; ?>admin/feed" method="post">
<div class="head-dashboard">
	<div >
		<div class="heading-admin"><i class="fa fa-bars"></i> Feed Settings</div>
	</div>
</div>
<div class="header-bar">
<?php if($save=='saved'){ ?>	
<div class="save">Successfully Saved !</div>	<br>
<?php } ?>
	<div class="settings-block">

		<div class="settings-body">
			<div class="setting-item">
				<div class="bcol-30">Feeds Count </div>
				<div class="bcol-70">	
				<input name='feed_count' class="input" value="<?php echo $pathang->FEEDSTACK->FEED_COUNT; ?>" >
				<div class="setting-item-info">The number of feeds to be displayed on home/profile page</div>
				
				</div>
				<div class="clear"></div>
			</div>
			<div class="setting-item">
				<div class="bcol-30">Comments Count</div>
				<div class="bcol-70">	
				<input name='comment_count' class="input" value="<?php echo $pathang->FEEDSTACK->COMMENT_COUNT; ?>" >
				<div class="setting-item-info">The number of comments to show below feed when user clicks to load</div>
				
				</div>
				<div class="clear"></div>
			</div>
			<div class="setting-item">
				<div class="bcol-30"> Members Count</div>
				<div class="bcol-70">	
				<input name='member_count' class="input" value="<?php echo $pathang->FEEDSTACK->MEMBER_COUNT; ?>" >
				<div class="setting-item-info">The number of members to be display on member search page</div>
			
				</div>
				<div class="clear"></div>
			</div>
			<div class="setting-item">
				<div class="bcol-30"> Notifications Count</div>
				<div class="bcol-70">	
				<input name='notification_center_count' class="input" value="<?php echo $pathang->FEEDSTACK->NOTIFICATION_CENTER_COUNT; ?>" >
				<div class="setting-item-info">The number of notifications to be displayed in notification center page</div>
				
				</div>
				<div class="clear"></div>
			</div>
			<div class="setting-item">
				<div class="bcol-30"> Default Followers</div>
				<div class="bcol-70">	
				<input name='default_follow' class="input" value="<?php echo $pathang->FEEDSTACK->DEFAULT_FOLLOW; ?>" >
				<div class="setting-item-info">Please mention usernames seperated by commas. These users will be automatically followed on new user creation.</div>
				
				</div>
				<div class="clear"></div>
			</div>
		</div>	
	</div>

	<div class="well"><button class='btn green'>Save Changes</button> </div>

</div>
</form>