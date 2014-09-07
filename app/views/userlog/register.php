<!--
	
	Register Page
	_________________________________________
	-Input box to take name,username,email and password and post
	 it to url user/register for processing.
	-A Registration validation script to do front end validation
	-back to login button

-->

<div class="box-userlog">
<div class="root" root="<?php echo ROOT; ?>" access-token='<?php echo pathang::GetInstance('session')->get('token'); ?>'></div>
<h1>Register</h1>
<form action="<?php echo ROOT; ?>user/register" method="post" class="form">
<input type="text" class="input name " name="name" placeholder="Name"/>
<div class="error-drop e-name">Enter Name</div>

<input type="text" class="input email" name="email" placeholder="email"/><br>
<div class="error-drop e-email">Enter Name</div>

<input type="text" class="input username" name="username" autocomplete="off" placeholder="username"/><br>
<div class="error-drop e-username availability">Enter Name</div>

<input type="password" class="input password" name="password" placeholder="password"/>
<div class="error-drop e-password">Enter Name</div>

<input type="password" class="input re_password" name="re-password" placeholder="re-type password"/><br>
<div class="error-drop e-re_password">Enter Name</div>


<button class="btn btn-login register" type="submit" error='0'>Register</button>
<div class="">
	<a href="<?php echo ROOT; ?>user/login">&lt;&lt;&nbsp;back to login</a> <br>
</div>
</form>
</div>

<script src="<?php echo ROOT; ?>app/script/register_validation.js" ></script>
