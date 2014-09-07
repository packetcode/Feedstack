<!-- 
	
	Forgot Passord Page
	_______________________________
	Displays a input box to enter email address
	which is posted to url user/forgot for processing
	and a back to login button

-->
<div class="box-userlog">
<h1>Forgot Password</h1>
<form action="<?php echo ROOT; ?>user/forgot" method="post">
<input type="text" class="input" name="email" placeholder="Enter email address"/><br>
<button class="btn btn-login">Send Password</button>
</form>
<div class="">
	<a href="<?php echo ROOT; ?>user/login">&lt;&lt;&nbsp;back to login</a> <br>
</div>
</div>