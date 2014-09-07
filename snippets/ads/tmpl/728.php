<style>
.ad-block-728{
	padding:20px;
	background: white;
}
.inner{
	background: white;
	width:728px;
	padding-right:20px;
}
.outer{
	background: #DDDDDD;
	height: 90px;
	width:100%;
}
</style>
<div class="ad-block-728">
<div class="outer">	
	<div class="inner">	
<?php 
if(isset(pathang::getInstance('pathang')->AD_BLOCK->$tmpl)){
	$code = pathang::getInstance('pathang')->AD_BLOCK->$tmpl;
 	echo $code;
 }else{ ?>
<img src="<?php echo ROOT; ?>img/728.png"/>
<?php } ?>
</div>
</div>
</div>	