<?php 
	  $error = pathang::GetInstance('basket'); 
	  $heading = $error->get('heading');
	  $message = $error->get('message');

	  if($heading)
	  	echo '<h1>'.$heading.'</h1>';
	  if($message)
	  	echo '<p>'.$message.'</p>';

?>
<a href="<?php echo ROOT; ?>"><button class="btn"> back to homepage</button></a>