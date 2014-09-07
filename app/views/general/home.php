
<Script src="<?php echo ROOT; ?>app/script/jquery.autosize.min.js" ></script>
<Script>
$(function(){
	$('textarea').autosize();
});
</script>
<!-- ToolTip -->
<link href="<?php echo ROOT.'app'.DS.'script'.DS.'tooltip'.DS.'css'.DS.'tooltipster.css';?>" rel="stylesheet">
<script src="<?php echo ROOT.'app'.DS.'script'.DS.'tooltip'.DS.'js'.DS.'jquery.tooltipster.min.js';?>"></script>
<Script>
	$(function(){
		 $('.tooltip').tooltipster();
	});
</script>
<style>
.loading{
	display: none;
}
</style>
<div class="wall">
	<?php
	$liveuser = pathang::getInstance('session')->get('liveuser');
	$wall = 'wall';
	?>
	<div class="feed">
		<div class="bcol-15">
			<div class="feed-user mobile-hidden" 
				 username="<?php echo $liveuser->username; ?>" 
				 name="<?php echo $liveuser->name; ?>"
				 uid='<?php echo $liveuser->id; ?>'>
				<a href="<?php echo ROOT.$liveuser->username; ?>">
					<img src="<?php echo $liveuser->image; ?>" class="feed-user-image"/> 
				</a>	
			</div>
		</div>
		<div class="bcol-85">
			<div class="feed-container">
				<div class="feed-input">
					<textarea class="feed-box" placeholder=""></textarea>
					<div >
						&nbsp;<img src="<?php echo ROOT; ?>img/loading.gif" class="loading" />
						<span class="right"><button class="post-btn">post</button></span>
					</div>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>
<div class="feed-entry"></div>
<?php require_once('app/views/feed/feed_list.php'); ?>	
	
	