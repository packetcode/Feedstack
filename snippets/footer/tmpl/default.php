<?php  
	$pathang = pathang::GetInstance('pathang');
?>
<div class="ftrr">
<div class="bcol-70">	
<ul class="ftr_menu">
  <a href="<?php echo ROOT; ?>"><li>Home</li></a>
  <a href="<?php echo ROOT; ?>about"><li>About</li></a>
  <a href="<?php echo ROOT; ?>feed"><li>Feeds</li></a>
    <a href="<?php echo ROOT; ?>terms"><li>Terms of use</li></a>
  <a href="<?php echo ROOT; ?>contact"><li>contact</li></a>
</ul>
</div>
<div class="bcol-30">
<div class="pull-right up">
	<a href="<?php echo $pathang->SOCIAL_LINKS->FACEBOOK; ?>"><i class="fa fa-facebook-square s-icons"></i></a>&nbsp; 
	<a href="<?php echo $pathang->SOCIAL_LINKS->GOOGLE_PLUS; ?>"><i class="fa fa-google-plus-square s-icons"></i></a>&nbsp; 
	<a href="<?php echo $pathang->SOCIAL_LINKS->TWITTER; ?>"><i class="fa fa-twitter-square s-icons"></i></a>
</div>
</div>
<div class="clear"></div>
</div> 
 <div class="ftr"><?php echo $pathang->SITE->FOOTER; ?></div> 
</div> 