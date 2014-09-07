<?php $username = pathang::GetInstance('node')->get('n1'); 
?>
<script src="<?php echo ROOT; ?>lib/jform/jform.js"></script> 
<script src="<?php echo ROOT; ?>lib/upload/script.js"></script> 
<script src="<?php echo ROOT; ?>lib/upload/drop.js"></script> 
<div class="root" root="<?php echo ROOT; ?>" access-token='<?php echo pathang::GetInstance('session')->get('token'); ?>'></div>

<div class="image_container">
	<div class="load_pad">
<div class="load">
	<div class="drop" u="<?php echo ROOT.'editor'; ?>">
	Drop the Image Here
<form action="<?php echo ROOT.$username; ?>/image_upload" method="post" id="myForm" class="form well"
enctype="multipart/form-data">
<div class="url" u="<?php echo ROOT.$username; ?>/image_dupload" r="<?php echo ROOT.$username; ?>/crop"></div>
<input type="file" name="file" id="file"><br>
<input type="submit" name="submit" class="btn btn-success" value="Upload Image"><br><br>
<div class="progress"><img src="<?php echo ROOT; ?>img/loading.gif" /></div>
<div class="image"></div>
</form>

</div>
</div>
</div>
</div>