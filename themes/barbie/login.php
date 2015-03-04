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
    <link rel="stylesheet" href="<?php echo ROOT; ?>lib/font-awesome/css/font-awesome.css" >
    <link href="<?php echo ROOT.'themes'.DS.'barbie'.DS.'css'.DS.'bottle.css';?>" rel="stylesheet">
    <link href="<?php echo ROOT.'themes'.DS.'barbie'.DS.'css'.DS.'index.css';?>" rel="stylesheet">
    <link href="<?php echo ROOT.'themes'.DS.'barbie'.DS.'css'.DS.'userlog.css';?>" rel="stylesheet">
    <!-- Jquery script-->
   <script src="<?php echo ROOT.'lib'.DS.'jquery'.DS.'jquery.js';?>"></script>
  </head>
<body>
  <!-- Main Container -->

  <div class="body">
      <div class="container-main pad-20">
        <div class="app"><?php pathang::app(); ?></div>
        <div class="clear"></div>
      </div>
  </div>
  <div class="feed-menu-container"></div>
 <div class="footer">
    <div class="container-main pad-20">
      <div class="footer-pad"><?php pathang::Snippet('footer'); ?>
      </div>
    </div>
   </div> 
  <!-- adding script files -->
  <script src="<?php echo ROOT.'themes'.DS.'barbie'.DS.'script'.DS.'menu.js';?>"></script>
  <script src="<?php echo ROOT.'themes'.DS.'barbie'.DS.'script'.DS.'feed-menu.js';?>"></script>
</body>
</html>