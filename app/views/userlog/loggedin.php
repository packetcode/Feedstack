<!--
	
	Logged in Page
	_________________________________________
	-User Page after login which displays the username
	 and logout button.

-->
<div class="box-userlog">
<?php $liveuser = pathang::getInstance('session')->get('liveuser'); ?>
<img src="<?php echo $liveuser->image; ?>" class="login-image"/ >
<h1>Hi 
	<a href="<?php echo ROOT.$liveuser->username; ?>">
		<span style="color:#2980b9"><?php echo $liveuser->name; ?></span>
	</a> 
</h1>
<h4><a href="<?php echo ROOT; ?>user/logout">Logout</a></h4>
<a href="<?php echo ROOT; ?>"><< home page</a>
</div>