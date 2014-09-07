<script src="<?php echo ROOT.'app'.DS.'script'.DS.'admin.js';?>"></script>
<?php 
		$pathang = pathang::getInstance('pathang'); 
		$save = pathang::getInstance('basket')->get('save'); 
?>
<form action="<?php echo ROOT; ?>admin/mailgun" method="post">
<div class="head-dashboard">
	<div >
		<div class="heading-admin"><i class="fa fa-send"></i> Mailgun Configuration</div>
	</div>
</div>	
<div class="header-bar">
<?php if($save=='saved'){ ?>	
<div class="save">Successfully Saved !</div><br>	
<?php } ?>
	<div class="settings-block">
		<div class="setting-item-info">To ensure the emails are delivered inbox of your customers we added mailgun api to the script. please
			create an account with http://mailgun.com/ and register your website with them. Store the api key in the below feild to get started.</div>
				
		<div class="settings-body">
			<div class="setting-item">
				<div class="bcol-30">API KEY </div>
				<div class="bcol-70">	
				<input name='api_key' class="input" value="<?php echo $pathang->MAILGUN->API_KEY; ?>" >
				</div>
				<div class="clear"></div>
			</div>
			<div class="setting-item">
				<div class="bcol-30">Domain Name</div>
				<div class="bcol-70">	
				<input name='domain_name' class="input" value="<?php echo $pathang->MAILGUN->DOMAIN_NAME; ?>" >
				</div>
				<div class="clear"></div>
			</div>
			<div class="setting-item">
				<div class="bcol-30"> Admin Email</div>
				<div class="bcol-70">	
				<input name='admin_email' class="input" value="<?php echo $pathang->MAILGUN->ADMIN_EMAIL; ?>" >
				</div>
				<div class="clear"></div>
			</div>
			
		</div>	
	</div>

	<div class="well"><button class='btn green'>Save Changes</button> </div>

</div>
</form>