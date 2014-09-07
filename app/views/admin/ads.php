<script src="<?php echo ROOT.'app'.DS.'script'.DS.'admin.js';?>"></script>
<?php 
		$pathang = pathang::getInstance('pathang'); 
		$save = pathang::getInstance('basket')->get('save'); 
?>
<form action="<?php echo ROOT; ?>admin/ads" method="post">
<div class="head-dashboard">
	<div >
		<div class="heading-admin"><i class="fa fa-adn"></i> Ads Management</div>
	</div>
</div>
<div class="header-bar">
<?php if($save=='saved'){ ?>	
<div class="save">Successfully Saved !</div>	<br>
<?php } ?>
	<div class="settings-block">

		<div class="settings-body">
			<div class="setting-item">
				<div class="bcol-30">Enable</div>
				<div class="bcol-70">	
				<select name="visible" class='input'>
					<?php
						$yes=$no=null; 
						if($pathang->AD_BLOCK->VISIBLE==1)
							$yes='selected';
						 else
						 	$no ='selected';	
					?>
					<option value='1' <?php echo $yes; ?>>yes</option>
					<option value='0' <?php echo $no; ?>>no</option>
				</select>
				</div>
				<div class="clear"></div>
			</div>
			<div class="setting-item">
				<div class="bcol-30">Block 250x250</div>
				<div class="bcol-70">	
				<textarea class="input" name="250" rows="8"><?php $i=250; echo trim($pathang->AD_BLOCK->$i); ?></textarea>
				</div>
				<div class="clear"></div>
			</div>
			<div class="setting-item">
				<div class="bcol-30">Block 728x90</div>
				<div class="bcol-70">	
				<textarea class="input" name="728" rows="8"><?php $i=728; echo trim($pathang->AD_BLOCK->$i); ?></textarea>
				</div>
				<div class="clear"></div>
			</div>
			<div class="setting-item">
				<div class="bcol-30">Block 468x60</div>
				<div class="bcol-70">	
				<textarea class="input" name="468" rows="8"><?php $i=468; echo trim($pathang->AD_BLOCK->$i); ?></textarea>
				</div>
				<div class="clear"></div>
			</div>

		</div>	
	</div>

	<div class="well"><button class='btn green'>Save Changes</button> </div>

</div>
</form>