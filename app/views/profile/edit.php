<?php 
	$user = pathang::GetInstance('basket')->get('user'); 
?>
<style>
.edit-container{
	background:white;
	padding:10px;
}
.input-feild{
	width:100%;
	-webkit-box-sizing: border-box;
       -moz-box-sizing: border-box;
            box-sizing: border-box;
}
.input-container{
	padding:10px 4px;
}
.input-text-name{
	font-weight: bold;
	margin-top:10px;
}
.image{
	padding:10px 20px 10px 10px;
}
.btn-cancel{
	background: #d35400;
}
.btn-save{
	background: #27ae60;
}
.heading{
	padding:10px 5px;
	background: #f8f8f8;
}
.heading h2{
	font-size: 20px;
	padding-left:10px;
}
.change-picture{
	background: #2980b9;
	font-weight: bold;
	color:white;
	padding:0px 5px 5px;
	text-align: center;
	cursor: pointer;
}
.img-cont{
	background: #2980b9;
}
.general-details{
	padding:10px;
}
.general{
	background: #f8f8f8;
	padding:10px;
	border-radius: 5px;
}
.general-title{
	font-size: 15px;
	font-weight: bold;
	background: #f8f8f8;
	padding:5px;
	border-radius: 3px;
	color:#bdc3c7;
}
.dropdown{
	padding:8px;
	border-radius: 3px;
}
</style>
<form action="<?php echo ROOT.$user->username; ?>/edit" method="post">
	<div class="root" root="<?php echo ROOT; ?>" access-token='<?php echo pathang::GetInstance('session')->get('token'); ?>'></div>
<div class="edit-container">
	<div class="heading"><h2 >Edit Profile</h2></div>
	<div class="bcol-70">
	<div class="bcol-30">
		<div class="image">
			<div class="img-cont">
			<img src="<?php echo $user->image; ?>" width="100%"/>
			<a href="<?php echo ROOT.$user->username; ?>/image">
				<div class="change-picture">change picture</div>
			</a>	
			</div>
		</div>
	</div>
	<div class="bcol-70">
	<div class="input-container">
		<div class="input-text-name">Name</div>
		<input type="text" class="input-feild" name="name" value="<?php echo $user->name; ?>" >

		<div class="input-text-name">Username</div>
		<input type="text" class="input-feild"  value="<?php echo $user->username; ?>" disabled>

		<div class="input-text-name">Email</div>
		<input type="text" class="input-feild" name="email" value="<?php echo $user->email; ?>" >

		<div class="input-text-name">Password</div>
		<input type="password" class="input-feild" name="password" value="<?php echo $user->password; ?>" >

		<div class="input-text-name">Short Introduction</div>
		<textarea class="input-feild" rows='3' maxlength='100' name="bio" ><?php echo $user->bio; ?></textarea>

	

	</div>
	</div>
	</div>
	<div class="bcol-30">
		<div class='general-details'>
			<div class="input-container general">
				<div class="input-text-name">Feeds per page</div>
					<select class="input-feild dropdown" name="feeds_per_page">
					<?php for($i=5; $i<25;$i=$i+5){ 
						if($i==$user->feeds_per_page)
						echo "<option value='".$i."' selected>".$i."</option>";
						else
						echo "<option value='".$i."'>".$i."</option>";
					 } ?>
					</select>
				<div class="input-text-name">Profile Access</div>
				<select class="input-feild dropdown" name="access">
					<?php 
						if('1'==$user->access){
						echo "<option value='1' selected>Public</option>";
						echo "<option value='0' >Private</option>";
						}elseif('0'==$user->access){
						echo "<option value='1' >Public</option>";
						echo "<option value='0' selected>Private</option>";
						}
					 ?>
				</select>
			</div>
		</div>
	</div>
	<div class="clear"></div>
	<br>
		<input type="hidden"  name="id" value="<?php echo $user->id; ?>" >
		<input type="hidden"  name="username" value="<?php echo $user->username; ?>" >
		<button type="submit" class="btn btn-save"> Save</button>
		<button type="submit" class="btn btn-cancel"> Cancel</button>
</div>
</form>