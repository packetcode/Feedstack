
<div class="login-box">
	<div class="log-title">Login Form</div>
	<form action="<?php echo ROOT; ?>user/login" method="post" >
	<div class="log-input"><input type="text" class="input " name="username" placeholder="username"/><br></div>
	<div class="log-input"><input type="password" class="input " name="password" placeholder="password"/><br></div>
	<div class="log-input"><button class="btn btn-login">Login</button></div>
	</form>
	<div class="">
		<a href="<?php echo ROOT; ?>user/forgot">Forgot password</a> <br>
		<a href="<?php echo ROOT;?>user/register">Register Now </a>
	</div>
</div>