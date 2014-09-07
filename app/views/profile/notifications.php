<link href="<?php echo ROOT; ?>lib/expresscss/style.css" rel="stylesheet">
<?php $notify = pathang::GetInstance('basket')->get('notify'); 
		$count =null;
		$i = 0;
		if(isset($notify->$i))
			$count = 1;
?>
<div class="notify-container">
	<h2> Notification Center</h2>
<div>
<?php 	 

if($count){
?>
<table class="table" id="hor-minimalist-b" >
	<tr>
		<th>Time lapse</th>
		<th>Notification</th>
	</tr>
	<?php foreach($notify as $a =>$b){ 
		
	?>
	<tr >
	<td>
	<?php
		echo $b->time_stamp;
	?>
	</td>
	<td>
	<?php
		if($b->action=='comment')
			echo "<a href='".ROOT.$b->username."'>$b->name</a> has ".$b->action."ed on your 
					<a href='".ROOT.'feed/'.$b->target."'>feed</a>";
		elseif($b->action=='like')
			echo "<a href='".ROOT.$b->username."'>$b->name</a> has ".$b->action."d your
					<a href='".ROOT.'feed/'.$b->target."'>feed</a>";
		elseif($b->action=='unlike')
			echo "<a href='".ROOT.$b->username."'>$b->name</a> ".$b->action."d your
					<a href='".ROOT.'feed/'.$b->target."'>feed</a>";			
		elseif($b->action == 'follow')
			echo "<a href='".ROOT.$b->username."'>$b->name</a> is ".$b->action."ing   
					you";
		elseif($b->action == 'unfollow')
			echo "<a href='".ROOT.$b->username."'>$b->name</a> has ".$b->action."ed  
					you";	

		if($b->status)
			echo "<span class='new-unread'> NEW&nbsp;</span>";
								
	?>

	</td></tr>
	<?php } ?>
</table>
<?php }else{
		echo "<div class='no-notify'>No notifications</div>";
} ?>
</div>
</div>