<style>
.ad-block-468{
	background: white;
	margin-right:5px;
	margin-top:0px;
	margin-left:15px;
	margin-bottom: 20px;
}
.inner{
	background: #EEF4F4;
	width:468px;
	height: 60px;
	padding-right:10px;
}
.outer{
	background: #DDDDDD;
	height: 60px;
	width:100%;
}
</style>
<div class="ad-block-468">
	<div class="outer">
		<div class="inner">
<?php 
if(isset(pathang::getInstance('pathang')->AD_BLOCK->$tmpl)){
	$code = pathang::getInstance('pathang')->AD_BLOCK->$tmpl;
 	echo $code;
 }else{ ?>
<img src="<?php echo ROOT; ?>img/468.png"/>
<?php } ?>
</div>	
</div>
</div>
