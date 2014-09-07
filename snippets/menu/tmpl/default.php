<?php 
		$username = pathang::getInstance('session')->get('liveuser')->username; 
		$unread = pathang::getInstance('packet')->get('unread');
?>
<style>

</style>
<ul class="menu-bar">
	<a href="<?php echo ROOT; ?>" ><li><i class="fa fa-space fa-home"></i>Home</li></a>
	<a href="<?php echo ROOT.$username; ?>" ><li><i class="fa fa-space fa-user">
		</i>Profile
			<?php if($unread){ ?>
			<span class="menu-unread"><i class="fa da-space fa-bell"></i> <?php echo $unread; ?></span>
			<?php } ?>
		</li>
	</a>
	<a href="<?php echo ROOT; ?>members" ><li><i class="fa fa-space fa-group"></i>Members</li></a>
	<a href="<?php echo ROOT; ?>user/logout" ><li><i class="fa fa-space fa-sign-out"></i>Logout</li></a>
</ul>
