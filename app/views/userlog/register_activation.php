<!--
	
	Register Activation Page
	_________________________________________
	-Display the success message of user activation
	-Username and Email are also displayed
	-resend activation and back to login buttons are given

-->
<?php
	//basket object
	$basket = pathang::GetInstance('basket');
	//get username and email
	$username = $basket->Get('username');
	$email = $basket->Get('email');
?>
<div class="box-userlog">
<div class="box">
	<h1>Success !</h1>
<p><b>User(<span class="ash"><?php echo $username; ?></span>) Successfully registered</b></p>
<p>An activation mail has been sent to your email <i class="ash"><?php echo $email; ?></i>. Follow the instructions
	in the mail to activate your account. Please check spam box if in case you dont 
	recieve the mail.<p>
<a href="<?php echo ROOT; ?>user/register/sendactivation/<?php echo $username; ?>">
	<button  class="btn btn-login">resend activation mail</button>
</a>	
<a href="<?php echo ROOT; ?>user/login"><button  class="btn btn-login red">back to login</button></a>
</div><br>
</div>