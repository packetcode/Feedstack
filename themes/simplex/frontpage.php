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
    <link href="<?php echo ROOT.'themes'.DS.'simplex'.DS.'css'.DS.'bottle.css';?>" rel="stylesheet">
    <link href="<?php echo ROOT.'themes'.DS.'simplex'.DS.'css'.DS.'feed-menu.css';?>" rel="stylesheet">
    <link href="<?php echo ROOT.'themes'.DS.'simplex'.DS.'css'.DS.'menu.css';?>" rel="stylesheet">
    <link href="<?php echo ROOT.'themes'.DS.'simplex'.DS.'css'.DS.'index.css';?>" rel="stylesheet">
    <link href="<?php echo ROOT.'themes'.DS.'simplex'.DS.'css'.DS.'userlog.css';?>" rel="stylesheet">
  </head>
<body>
  <!-- Main Container -->
  <div class="header">
    <div class="container-main pad-header">
      <div class="bcol-25 logo"><?php pathang::snippet('logo'); ?></div>
      <div class="bcol-75 menu">
        <span class="menu-text">+ menu</span>
        <?php pathang::snippet('menu'); ?>
      </div>
      <div class="clear"></div>
    </div>
   </div>
  <div class="body">
      <div class="container-main pad-20">
        <div class="app bcol-70"><?php pathang::app(); ?></div>
        <div class="sidebar bcol-30"><?php pathang::snippet('login'); ?></div>
        <div class="clear"></div>
        <?php
  $show = pathang::GetInstance('pathang')->AD_BLOCK->VISIBLE;
  if($show){  
  ?>
  <div >
        <?php
          pathang::getInstance('packet')->set('tmpl','front');
          pathang::snippet('ads');
        ?>

  </div>
  <?php } ?>

      </div>
  </div>
  <div class="footer">
    <div class="container-main pad-20"><?php pathang::Snippet('footer'); ?></div>
   </div> 
  <!-- adding script files -->
  <script src="<?php echo ROOT.'lib'.DS.'jquery'.DS.'jquery.js';?>"></script>
  <script src="<?php echo ROOT.'themes'.DS.'simplex'.DS.'script'.DS.'menu.js';?>"></script>
   <script src="<?php echo ROOT.'themes'.DS.'simplex'.DS.'script'.DS.'feed-menu.js';?>"></script>
</body>
</html>