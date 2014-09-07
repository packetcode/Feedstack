<style>
.ad-block-728{
	margin-top:20px;
}
.inner{
	background: #EEF4F4;
	width:728px;
	height:90px;
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
	$tmpl = '728';
if(isset(pathang::getInstance('pathang')->AD_BLOCK->$tmpl)){

	$code = pathang::getInstance('pathang')->AD_BLOCK->$tmpl;
 	echo $code;
 }else{ ?>
<img src="<?php echo ROOT; ?>img/728.png"/>
<?php } ?>
</div>
</div>
</div>	