<script src="<?php echo ROOT.'app'.DS.'script'.DS.'admin.js';?>"></script>
<style>

</style>
<?php 
		$pathang = pathang::getInstance('pathang'); 
		$save = pathang::getInstance('basket')->get('save'); 
?>
<form action="<?php echo ROOT; ?>admin/general" method="post">

<div class="head-dashboard">
	<div >
		<div class="heading-admin"><i class="fa fa-cog"></i> General Settings</div>
	</div>
</div>
<div class="header-bar">
<?php if($save=='saved'){ ?>	
<div class="save">Successfully Saved !</div><br>	
<?php } ?>
	<div class="settings-block">
		<div class="settings-heading">
			Main Configuration
		</div>
		<div class="settings-body">
			<div class="setting-item">
				<div class="bcol-30"> Site Root Url </div>
				<div class="bcol-70">	
				<input name='root' class="input" value="<?php echo $pathang->SITE->ROOT; ?>" >
				<div class="setting-item-info">This will be used as absolute path for all css and script files in the theme.Make sure to add http;// prefix and a '/' at the end of url.</div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="setting-item">
				<div class="bcol-30"> Theme </div>
				<div class="bcol-70">	
				<input name='theme' class="input" value="<?php echo $pathang->SITE->THEME; ?>" >
				</div>
				<div class="clear"></div>
			</div>
			<div class="setting-item">
				<div class="bcol-30"> Session Expire </div>
				<div class="bcol-70">	
				<input name='session_expire' class="input" value="<?php echo $pathang->SITE->SESSION_EXPIRE; ?>" >
				<div class="setting-item-info">The session will be destroyed automatically when inactive after the above mentioned seconds</div>
				
				</div>
				<div class="clear"></div>
			</div>
			<div class="setting-item">
				<div class="bcol-30"> Logo </div>
				<div class="bcol-70">	
				<input name='logo' class="input" value="<?php echo $pathang->SITE->LOGO; ?>" >
				</div>
				<div class="clear"></div>
			</div>
			<div class="setting-item">
				<div class="bcol-30"> Footer </div>
				<div class="bcol-70">	
				<textarea class="input" name="footer" rows="5"><?php echo $pathang->SITE->FOOTER; ?></textarea>
				</div>
				<div class="clear"></div>
			</div>
		</div>	
	</div>

	<div class="settings-block">
		<div class="settings-heading">
			Database Configuration
		</div>
		<div class="settings-body">
			<div class="setting-item">
				<div class="bcol-30"> DB Name</div>
				<div class="bcol-70">	
				<input name='db_name' class="input" value="<?php echo $pathang->DB->DB_NAME; ?>" >
				</div>
				<div class="clear"></div>
			</div>
			<div class="setting-item">
				<div class="bcol-30"> Host </div>
				<div class="bcol-70">	
				<input name='host' class="input" value="<?php echo $pathang->DB->HOST; ?>" >
				</div>
				<div class="clear"></div>
			</div>
			<div class="setting-item">
				<div class="bcol-30"> Username </div>
				<div class="bcol-70">	
				<input name='username' class="input" value="<?php echo $pathang->DB->USERNAME; ?>" >
				</div>
				<div class="clear"></div>
			</div>
			<div class="setting-item">
				<div class="bcol-30"> Password </div>
				<div class="bcol-70">	
				<input name='password' class="input" value="<?php echo $pathang->DB->PASSWORD; ?>" >
				</div>
				<div class="clear"></div>
			</div>
		</div>	
	</div>

	<div class="settings-block">
		<div class="settings-heading">
			Meta Data Configuration
		</div>
		<div class="settings-body">
			<div class="setting-item">
				<div class="bcol-30"> Site Name</div>
				<div class="bcol-70">	
				<input name='site_name' class="input" value="<?php echo $pathang->META->SITE_NAME; ?>" >
				</div>
				<div class="clear"></div>
			</div>
			<div class="setting-item">
				<div class="bcol-30"> Title</div>
				<div class="bcol-70">	
				<input name='title' class="input" value="<?php echo $pathang->META->TITLE; ?>" >
				</div>
				<div class="clear"></div>
			</div>
			<div class="setting-item">
				<div class="bcol-30"> Author </div>
				<div class="bcol-70">	
				<input name='author' class="input" value="<?php echo $pathang->META->AUTHOR; ?>" >
				</div>
				<div class="clear"></div>
			</div>
			<div class="setting-item">
				<div class="bcol-30"> Description </div>
				<div class="bcol-70">	
				<textarea name='desc' class="input" rows="5"><?php echo $pathang->META->DESC; ?></textarea>
				</div>
				<div class="clear"></div>
			</div>
			<div class="setting-item">
				<div class="bcol-30"> Keywords </div>
				<div class="bcol-70">	
				<input name='keywords' class="input" value="<?php echo $pathang->META->KEYWORDS; ?>" >
				</div>
				<div class="clear"></div>
			</div>
			<div class="setting-item">
				<div class="bcol-30"> Default Image </div>
				<div class="bcol-70">	
				<input name='image' class="input" value="<?php echo $pathang->META->IMAGE; ?>" >
				</div>
				<div class="clear"></div>
			</div>
		</div>	
	</div>

		<div class="settings-block">
		<div class="settings-heading">
			Social Links
		</div>
		<div class="settings-body">
			<div class="setting-item">
				<div class="bcol-30"> Facebook</div>
				<div class="bcol-70">	
				<input name='facebook' class="input" value="<?php echo $pathang->SOCIAL_LINKS->FACEBOOK; ?>" >
				</div>
				<div class="clear"></div>
			</div>
			<div class="setting-item">
				<div class="bcol-30"> Google Plus </div>
				<div class="bcol-70">	
				<input name='google_plus' class="input" value="<?php echo $pathang->SOCIAL_LINKS->GOOGLE_PLUS; ?>" >
				</div>
				<div class="clear"></div>
			</div>
			<div class="setting-item">
				<div class="bcol-30"> Twitter</div>
				<div class="bcol-70">	
				<input name='twiter' class="input" value="<?php echo $pathang->SOCIAL_LINKS->TWITTER; ?>" >
				</div>
				<div class="clear"></div>
			</div>
		</div>	
	</div>

	<div class="well"><button class='btn green'>Save Changes</button> </div>

</div>
</form>