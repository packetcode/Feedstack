<!--
	
	Login Page
	_________________________________________
	-Input box to take username and password and post
	 it to url user/login for processing.
	-A Php block to display error messages if any
	-A login validation script..to do front end validation
	-links to forgot password and register

-->
<?php
	//get the instance of basket object
	$basket = pathang::getInstance('basket');
	//get message,error,username from basket object
	$message = $basket->get('status_message');
	$error = $basket->get('status_error');
	$username = $basket->get('username');
?>
<div class="box-userlog">

<div class="root" root="<?php echo ROOT; ?>" access-token='<?php echo pathang::GetInstance('session')->get('token'); ?>'></div>
<h1>Login</h1>
<?php
	// Error Messages alert 
	if($message){ 
		if($error==4){
			$activation_link = ROOT.'user/register/sendactivation/'.$username;
			$alert = $message.'<div class="activation"><a href="'.$activation_link.'">
								>> re-send activation mail<a></div>';
		}else
			$alert=$message;
		//echo the alert message
		echo "<div class='error'>$alert</div>";	
	}
?>
<form action="<?php echo ROOT; ?>user/login" method="post" >
<input type="text" class="input username" name="username" placeholder="username"/><br>
<input type="password" class="input password" name="password" placeholder="password"/><br>
<button class="btn btn-login">Login</button>
</form>
<div class="">
	<a href="<?php echo ROOT; ?>user/forgot">Forgot password</a> <br>
	<a href="<?php echo ROOT;?>user/register">Register Now </a>
</div>
</div>
<script src="<?php echo ROOT; ?>app/script/login_validation.js" ></script>