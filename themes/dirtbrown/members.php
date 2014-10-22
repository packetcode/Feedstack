<!DOCTYPE html>
<html lang="en" itemscope itemtype="http://schema.org/Product">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php pathang::Meta('desc'); ?>">
    <meta name="author" content="<?php pathang::Meta('author'); ?>">
	  <meta name="keywords" content="<?php pathang::Meta('keywords'); ?>">
    <title><?php pathang::Meta('title'); ?></title>

    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="<?php pathang::Meta('title'); ?>">
    <meta itemprop="description" content="<?php pathang::Meta('desc'); ?>">
    <meta itemprop="image" content="<?php pathang::Meta('image'); ?>">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:url" content="<?php pathang::Meta('SITE_URL');?>">
    <meta name="twitter:title" content="<?php pathang::Meta('title'); ?>">
    <meta name="twitter:description" content="<?php pathang::Meta('desc'); ?>">
    <!-- Twitter Summary card images must be at least 200x200px -->
    <meta name="twitter:image" content="<?php pathang::Meta('image'); ?>">

    <!-- Open Graph data -->
    <meta property="og:title" content="<?php pathang::Meta('title'); ?>" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="<?php pathang::Meta('site_url'); ?>" />
    <meta property="og:image" content="<?php pathang::Meta('image'); ?>" />
    <meta property="og:description" content="<?php pathang::Meta('desc'); ?>" /> 
    <meta property="og:site_name" content="<?php pathang::Meta('site_name'); ?>" />

    <!-- Adding Favicon -->
    <link rel="shortcut icon" href="<?php echo ROOT;?>favicon.ico">
    <!-- Linking style sheets -->
    <link rel="stylesheet" href="<?php echo ROOT; ?>lib/font-awesome/css/font-awesome.css" >
    <link href="<?php echo ROOT.'themes'.DS.'dirtbrown'.DS.'css'.DS.'bottle.css';?>" rel="stylesheet">
    <link href="<?php echo ROOT.'themes'.DS.'dirtbrown'.DS.'css'.DS.'feed-menu.css';?>" rel="stylesheet">
    <link href="<?php echo ROOT.'themes'.DS.'dirtbrown'.DS.'css'.DS.'menu.css';?>" rel="stylesheet">
    <link href="<?php echo ROOT.'themes'.DS.'dirtbrown'.DS.'css'.DS.'wall.css';?>" rel="stylesheet">
    <link href="<?php echo ROOT.'themes'.DS.'dirtbrown'.DS.'css'.DS.'members.css';?>" rel="stylesheet">
     <link href="<?php echo ROOT.'themes'.DS.'dirtbrown'.DS.'css'.DS.'profile.css';?>" rel="stylesheet">
    <link href="<?php echo ROOT.'themes'.DS.'dirtbrown'.DS.'css'.DS.'index.css';?>" rel="stylesheet">
      
  <!-- adding script files -->
  <script src="<?php echo ROOT.'lib'.DS.'jquery'.DS.'jquery.js';?>"></script>
  <script src="<?php echo ROOT.'themes'.DS.'dirtbrown'.DS.'script'.DS.'menu.js';?>"></script>
   <script src="<?php echo ROOT.'themes'.DS.'dirtbrown'.DS.'script'.DS.'feed-menu.js';?>"></script>

  </head>
<body>
  <!-- Main Container -->
  <div class="header">
    <div class="container-main pad-header">
      <div class="bcol-100 logo"><?php pathang::snippet('logo'); ?></div>
      <div class="bcol-100 menu">
        <span class="menu-text">+ menu</span>
        <?php pathang::snippet('menu'); ?>
      </div>
      <div class="clear"></div>
    </div>
   </div>
  <div class="body">
      <div class="container-main pad-20">
        <div class="app"><?php pathang::app(); ?></div>
      </div>
  </div>
   <div class="footer">
    <div class="container-main pad-20">
      <div class="footer-pad"><?php pathang::Snippet('footer'); ?>
      </div>
    </div>
   </div> 
</body>
</html>