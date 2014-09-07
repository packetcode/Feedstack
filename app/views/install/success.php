<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php pathang::Meta('desc'); ?>">
    <meta name="author" content="<?php pathang::Meta('author'); ?>">
	  <meta name="keywords" content="<?php pathang::Meta('keywords'); ?>">
    <title><?php pathang::Meta('title'); ?></title>
    <!-- Adding Favicon -->
    <link rel="shortcut icon" href="<?php echo ROOT;?>favicon.ico">
    <!-- Linking style sheets -->
    <link rel="stylesheet" href="lib/font-awesome/css/font-awesome.css" >
    <link href="<?php echo 'themes'.DS.'simplex'.DS.'css'.DS.'bottle.css';?>" rel="stylesheet">
  <style>
body{
	background:#EEF4F4;
}
.container-top{
	width:800px;
	background: white;
	margin:20px auto 0px;
	padding:20px;
}
.container-body{
	width:800px;
	background: #f8f8f8;
	margin:0px auto;
	padding:20px;
	border-left:2px solid silver;
	border-right:2px solid silver;
}
.container-footer{
	width:800px;
	background: white;
	margin:0px auto;
	padding:20px;
}
.header{
	background: #f8f8f8;
}
.installation{
	font-size: 25px;
	line-height: 30px;
	margin-bottom: 10px;
	float: right;
	margin-top: 5px;
	color:silver;
}
.success{
	font-size: 20px;
	line-height: 30px;

}
a,a:visited{
	font-style: italic;
	color:#2980b9;
}
a:hover{
	color:black;
}

</style>
<script>
function redirect(){
   window.location = document.URL;
}
setTimeout(redirect, 5000);
</script>
  </head>
<body>

  <!-- Main Container -->
 <form action="index.php" method="post">
  <div class="container-top">
  	
  </div>
  <div class="container-body">	
  	<div class="header">
  		<div class="feedstack">
  			<img src="img/logo_feedstack.png" />
  			
  	<div class="installation">SUCCESS</div>	
  		</div>
  	</div>
  </div>
  <div class="container-footer">
  	<div class="success"><i class='fa fa-flash'></i> Successfully Installed</div>
  	<i>This page will be redirected in 5sec, otherwise refresh the page</i><br><br>
  	<p>
  		Welcome to the <a href="http://feedstack.asia">feedstack</a> faternity, now you are the proud owner of a social networking website. You can login with your username and password to explore further. please take sometime to provide us the feedback/suggestions/complaints in our 
  		<a href="https://www.facebook.com/groups/packetcode/">facebook group packetcode</a>.<br>
  		<br>
  		- Gooday <br>
  		<a href="https://twitter.com/shaadomanthra">Krishna Teja</a> @packetcode  
  	</p>
  </div>
 </form> 
</body>
</html>
   