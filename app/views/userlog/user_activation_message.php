<!--
	
	User Activation Message Page
	_________________________________________
	-Dynamic heading and message data page
	 used for user activation related task set.
	-back to login button

-->
<?php
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