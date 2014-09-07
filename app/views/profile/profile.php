<?php
	$basket = pathang::GetInstance('basket');
	$user = $basket->get('user');
	$uid = $user->id;
	$username = $user->username;
	if(isset(pathang::getInstance('session')->get('liveuser')->id))
		$liveuser_id =  pathang::getInstance('session')->get('liveuser')->id;
	else
		$liveuser_id = null;
	$admin = $basket->get('allowed_delete');
	$following = $basket->get('following');
	if($following)
		$follow_text = 'Unfollow';
	else
		$follow_text = 'Follow';

	//check for blocking
	if($user->block)
		$block_class = 'btn-unblock';
	else
		$block_class='btn-block';
?>

<script src="<?php echo ROOT.'app'.DS.'script'.DS.'profile.js';?>"></script>
<!-- ToolTip -->
<link href="<?php echo ROOT.'app'.DS.'script'.DS.'tooltip'.DS.'css'.DS.'tooltipster.css';?>" rel="stylesheet">
<script src="<?php echo ROOT.'app'.DS.'script'.DS.'tooltip'.DS.'js'.DS.'jquery.tooltipster.min.js';?>"></script>
<Script>
	$(function(){
		 $('.tooltip').tooltipster();
	});
</script>
<div class="wall">

	<div class="profile">
		<div class="profile-mobile-bg">

	<img src="<?php echo $user->image; ?>" class="profile-image-mobile"/></div>
		<div class="bcol-30">
			<div class="feed-user mobile-hidden mobile-hidden-main-image">
				<img src="<?php echo $user->image; ?>" class="profile-image"/>
			</div>
		</div>
		<div class="bcol-70">
			<div class="profile-container">
				<div class="profile-name">
					<div class="profile-name-span"><?php echo $user->name; ?></div>
				</div>
				<div class="profile-desc">
					<?php echo $user->bio; ?>
				</div>
				<div class="profile-link">
					<a href="<?php echo ROOT.$username;?>"><i class="fa fa-space profile-fa-link fa-th"></i></a> &nbsp;
					<a href="<?php echo ROOT.$username;?>/text"><i class="fa fa-space profile-fa-link fa-bars"></i></a> &nbsp;
					<a href="<?php echo ROOT.$username;?>/photo"><i class="fa fa-space profile-fa-link fa-picture-o"></i></a> &nbsp;
					<a href="<?php echo ROOT.$username;?>/video"><i class="fa fa-space profile-fa-link fa-video-camera"></i></a> &nbsp;
					<a href="<?php echo ROOT.$username;?>/link"><i class="fa fa-space profile-fa-link fa-code"></i></a>
				</div>
				<div class="mobile-links">
					<?php if($uid == $liveuser_id){ ?>
					<a href="<?php echo ROOT.$username.'/notifications'; ?>"><span class="mb-link-span">Notifications</span></a>
					<?php } ?>
					<a href="<?php echo ROOT.$username.'/following'; ?>"><span class="mb-link-span">Following</span></a>
					<a href="<?php echo ROOT.$username.'/followers'; ?>"><span class="mb-link-span">Followers</span></a>
				</div>
				<div class="profile-buttons" uid="<?php echo $uid; ?>" liveuser-id="<?php echo $liveuser_id; ?>">
					<?php if($uid != $liveuser_id){ ?>
					<button class="btn btn-follow-btn btn-<?php echo strtolower($follow_text); ?>" follow='<?php echo $following; ?>'><?php echo $follow_text; ?></button>
					<?php }else{ ?>
					<a href="<?php echo ROOT.$username.DS.'edit'; ?>">
						<button class="btn btn-edit" >Edit Profile</button>
					</a>	
					<?php }if($admin){ 
						if($uid!=$liveuser_id){
					?>
					<button class="btn <?php echo $block_class; ?> btn-block-btn" blocked='<?php echo $user->block; ?>'>
						<?php if($user->block) echo 'Unblock'; else echo 'Block'; ?></button>
					<?php if($user->activation != 1){	?>
					<button class="btn  btn-activate activate-user ">
						Activate</button>	
					<?php } ?>	
					<button class="btn btn-delete btn-delete-user">Delete</button>
					<?php } }?>
				</div>	
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>	
<div class="profile-container-box">
<?php require_once('app/views/feed/feed_list.php'); ?>
</div>