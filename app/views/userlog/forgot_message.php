<!--
	
	Forgot Password Message Page
	_________________________________________
	A custom message page to display the messages
	to user. And a back to login button

-->
<?php
	//load the basket object
	//get the heading a message from basket object
	$basket = pathang::getInstance('basket');
	$heading = $basket->get('heading');
	$message = $basket->get('message');
?>
<div class="box-userlog">
<div class="box">
	<h1><?php echo $heading; ?></h1>
	<p><?php echo $message; ?><p>
<a href="<?php echo ROOT; ?>user/login"><button  class="btn btn-login red">back to login</button></a>
</div><br>
</div>