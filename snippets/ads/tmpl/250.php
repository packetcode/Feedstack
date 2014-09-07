<style>
.ad-block{
	margin:10px;
	margin-top:20px;
	padding:5px;
	background: white;
	width:250px;
	height:250px;
}
</style>
<div class="ad-block">
<?php 
if(isset(pathang::getInstance('pathang')->AD_BLOCK->$tmpl)){
	$code = pathang::getInstance('pathang')->AD_BLOCK->$tmpl;
 	echo $code;
 }else{ ?>
<img src="<?php echo ROOT; ?>img/250.png"/>
<?php } ?>
</div>	