<style>
.notify-block{
	margin:10px;
	margin-top:0px;
	margin-bottom: 20px;
	padding:10px;
	background: white;
	width:240px;
	border-radius: 5px;
}
.notify-title a{
	color:#039;
}
.unread{
	font-size: 12px;
	color:silver;
	font-weight: bold;
}
.ago{
	font-size: 10px;
	color:silver;
}
.unread-count{
	background: #95a5a6;
	color:white;
	padding:4px;
	border-radius: 10px;
}
.table{
	width:100%;
}
</style>
<link href="<?php echo ROOT; ?>lib/expresscss/style.css" rel="stylesheet">
<?php 	$notify = pathang::GetInstance('packet')->get('notify'); 
		$unread = pathang::GetInstance('packet')->get('count'); 
		if(isset(pathang::GetInstance('session')->get('liveuser')->username))
		$username = pathang::GetInstance('session')->get('liveuser')->username;
		$count =null;
		$i = 0;
		if(isset($notify->$i))
			$count = 1;
?>
<div class="notify-block">
<div>
<?php 	 

if($count && $unread >0){
?>
<table class="table" id="hor-minimalist-b" >
	<tr>
		<th><div class="notify-title"><a href="<?php echo ROOT.$username.'/notifications'; ?>">
			Notifications <span class="unread"> <span class="unread-count">
			<?php echo $unread; ?></span> unread</span></a></div></th>
	</tr>
	<?php foreach($notify as $a =>$b){ ?>
	<tr>
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
					<a href='".ROOT.'feed/'.$b->target."'>you</a>";
		elseif($b->action == 'unfollow')
			echo "<a href='".ROOT.$b->username."'>$b->name</a> has ".$b->action."ed  
					<a href='".ROOT.'feed/'.$b->target."'>you</a>";		
		echo "<div class='ago'>".$b->time_stamp."</div>";								
	?>
	</td></tr>
	<?php } ?>
</table>
<?php }else{
?>
<div class="notify-title"><a href="<?php echo ROOT.$username.'/notifications'; ?>">
			Notifications <span class="unread"> 0 unread</span></a></div>
<?php
} ?>
</div>
</div>