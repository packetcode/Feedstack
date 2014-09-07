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
	margin:0px auto 40px;
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
.left{
	margin-right:10px;
}
.right{
	margin-left:10px;
}
.well{
	background: #f8f8f8;
	font-weight: bold;
	padding:10px 10px 10px;
	border-radius: 5px;
	margin: 15px 0px;
}
.item-name{
	margin-top: 10px;
}
input.item-element{

	width:100%;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
}
.info{
	font-weight: normal;
	font-size: 12px;

}
.setting-item-info{
	font-weight: normal;
	background: #f8f8f8;
	padding:3px 6px;
	color:silver;
	margin-top: -3px;
	margin-bottom: 5px;
	font-size: 12px;
}
</style>
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
  			
  	<div class="installation">Installation wizard</div>	
  		</div>
  	</div>
  </div>
  <div class="container-footer">
  	<div class="bcol-50">
  	<div class="left">
  	<div class="well">Administrator Details
  		<p class="info">The below details would be used to login to the website as administrator</p>
  	</div>
  	<div class="item">
  		<div class="bcol-30"><div class="item-name">Name</div></div>
		<div  class="bcol-70">
			<input class="item-element" name="name" type="text" placeholder="Enter you full name" >
		 </div>
		<div class="clear"></div>
	</div>
	<div class="item">
  		<div class="bcol-30"><div class="item-name">Username</div></div>
		<div  class="bcol-70">
			<input class="item-element"name="username" type="text" placeholder="Enter your desired username" >
		 </div>
		<div class="clear"></div>
	</div>  
	<div class="item">
  		<div class="bcol-30"><div class="item-name">Email</div></div>
		<div  class="bcol-70">
			<input class="item-element"name="email" type="text" placeholder="Enter your email" >
		 </div>
		<div class="clear"></div>
	</div> 
	<div class="item">
  		<div class="bcol-30"><div class="item-name">Password</div></div>
		<div  class="bcol-70">
			<input class="item-element"name="password" type="password" placeholder="Enter password" >
		 </div>
		<div class="clear"></div>
	</div> 



	</div>
  	</div>
  	<div class="bcol-50">
  	<Div class="right">
  	<div class="well">Website Details</div>
  	<div class="item">
  		<div class="bcol-30"><div class="item-name">Website Name</div></div>
		<div  class="bcol-70">
			<input class="item-element"name="site_name" type="text" placeholder="Enter your website Name" >
		 </div>
		<div class="clear"></div>
	</div> 
	<div class="item">
  		<div class="bcol-30"><div class="item-name">Website Url</div></div>
		<div  class="bcol-70">
			<input class="item-element"name="site_url" type="text" placeholder="Enter the website url" >
			<div class="setting-item-info">This will be used as absolute path for all css and script files in the theme.Make sure to add http;// prefix and a '/' at the end of url.</div>
				
		 </div>
		<div class="clear"></div>
	</div> 
	<div class="well">Database Details</div>
	<div class="item">
  		<div class="bcol-30"><div class="item-name">DB Type</div></div>
		<div  class="bcol-70">
			<input class="item-element"  type="text" placeholder="MySQL" disabled>
		 </div>
		<div class="clear"></div>
	</div> 
	<div class="item">
  		<div class="bcol-30"><div class="item-name">Database Name</div></div>
		<div  class="bcol-70">
			<input class="item-element"  name="db_name" type="text" placeholder="Enter Database name">
			<div class="setting-item-info">Enter the desired database name. Some shared hostings have a compulsory prefix..if so add the prefix while naming it.</div>
		
		 </div>
		<div class="clear"></div>
	</div> 
	<div class="item">
  		<div class="bcol-30"><div class="item-name">Host</div></div>
		<div  class="bcol-70">
			<input class="item-element"  name="host" type="text" placeholder="Enter Host name">
			<div class="setting-item-info">This will be usually 'localhost'</div>
		
		 </div>
		<div class="clear"></div>
	</div> 
	<div class="item">
  		<div class="bcol-30"><div class="item-name">DB Username</div></div>
		<div  class="bcol-70">
			<input class="item-element"  name="db_username" type="text" placeholder="Enter Database username">
			<div class="setting-item-info">Mention the DB username provided by your hosting provider. Or create one db user in control panel and use it here.</div>
		
		 </div>
		<div class="clear"></div>
	</div> 
	<div class="item">
  		<div class="bcol-30"><div class="item-name">DB Password</div></div>
		<div  class="bcol-70">
			<input class="item-element"  name="db_password" type="password" placeholder="Enter Database password">
			<div class="setting-item-info">Mention the DB password provided by your hosting provider. Or create one db user/password in control panel and use it here.</div>
		
		 </div>
		<div class="clear"></div>
	</div> 

  	</div>
  	</div>
  	<div class="clear"></div>
  	<div class="well"><button type="submit" class="btn">Install</button></div>
  </div>
 </form> 
</body>
</html>
   