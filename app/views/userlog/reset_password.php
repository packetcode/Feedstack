<!--
	
	Reset Password Page
	_________________________________________
	-Input box to take new password and post to url
	 user/forgot for processing.
	-Code in the url is the key factor to change the
	 password in backend processing.

-->
<?php
	//get the hash code to form the url
	$code = pathang::getInstance('node')->get('n3');
?>
<div class="box-userlog">
<h1>Reset Password</h1>
<form action="<?php echo ROOT; ?>user/forgot/<?php echo $code; ?>" method="post" >
<input type="password" class="input" name="password" placeholder="password"/><br>
<input type="password" class="input" name="re-password" placeholder="retype password"/><br>
<button class="btn btn-login">Reset Password</button>
</form>
</div>
