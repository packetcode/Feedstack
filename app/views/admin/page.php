<script src="<?php echo ROOT.'app'.DS.'script'.DS.'admin.js';?>"></script>
<?php 
		$pathang = pathang::getInstance('pathang'); 
		$basket = pathang::getInstance('basket');
		$save = $basket->get('save'); 
		$about = $basket->get('about');
			$terms = $basket->get('terms');
				$contact = $basket->get('contact');
?>
<form action="<?php echo ROOT; ?>admin/page" method="post">
	<div class="head-dashboard">
	<div >
		<div class="heading-admin"><i class="fa fa-html5"></i> Custom Pages</div>
	</div>
</div>	
<div class="header-bar">
<?php if($save=='saved'){ ?>	
<div class="save">Successfully Saved !</div><Br>	
<?php } ?>
	<div class="settings-block">

		<div class="settings-body">
			<div class="setting-item">
				<div class="bcol-30">About </div>
				<div class="bcol-70">	
				<textarea class="input" name="about" rows="8"><?php echo $about; ?></textarea>
				</div>
				<div class="clear"></div>
			</div>
			<div class="setting-item">
				<div class="bcol-30">Terms of Use</div>
				<div class="bcol-70">
					<textarea class="input" name="terms" rows="8"><?php echo $terms; ?></textarea>
				</div>
				<div class="clear"></div>
			</div>
			<div class="setting-item">
				<div class="bcol-30"> Contact</div>
				<div class="bcol-70">
				<textarea class="input" name="contact" rows="8"><?php echo $contact; ?></textarea>
				</div>
				<div class="clear"></div>
			</div>
			<input name="post" type="hidden" value= 'yes' />
		</div>	
	</div>

	<div class="well"><button class='btn green'>Save Changes</button> </div>

</div>
</form>