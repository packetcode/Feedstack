$(function(){
	$(document).on('click','.register',function(d){

		if($('.error-drop').is(":visible") ){
					d.preventDefault();
					alert('please fill the form properly before submitting.');
		}
			
	});

	$(document).on('focusout','input.name',function(){
		var posturl =$('.root').attr('root');
		var name = $('.name').val().trim();
		if(!name){
			error_fun('name','Please enter your name');	
		}else{
			no_error_fun('name');
		}
	});

	$(document).on('focusout','input.password',function(){
		var posturl =$('.root').attr('root');
		var name = $('.password').val();
		if(!name){
			error_fun('password','Please enter your password');	
		}else{
			no_error_fun('password');
		}
	});

	$(document).on('focusout','input.re_password',function(){
		var posturl =$('.root').attr('root');
		var pass = $('.re_password').val();
		if(!pass){
			error_fun('re_password','Please re-enter your password');	
		}else{
			var pass_re = $('.password').val();
			if(pass!=pass_re){
				error_fun('re_password','Password and Re-password dint match');
			}else
			no_error_fun('re_password');
		}
	});

	$(document).on('focusout','input.email',function(){
		var posturl =$('.root').attr('root');
		var email = $('.email').val();
		if(!email || !isValidEmailAddress(email)){
			error_fun('email','Please enter valid email');	
		}else{
			if(email){
				$.post(posturl+'user/emailcheck',{'email':email},function(data){
				if(parseInt(data)==1){
					error_fun('email','<b>Email</b> already registered. please click forgot password on login page to proceed.');
				}else{
					no_error_fun('email');
				}	
				});
			}
		}
	});

	$(document).on('focusout','input.username',function(){
			var posturl =$('.root').attr('root');
			var username = $('.username').val().trim();
			if(username){
				var regx = /^[a-zA-Z0-9_]*$/;
				if(regx.test(username) == false) {
					$('.availability').removeClass('a-green');
					$('.availability').addClass('a-red');
					error_fun('username','Invalid : No Special Characters Accepted');
				}else{
				$.post(posturl+'user/usernamecheck',{'username':username},function(data){
				if(parseInt(data)==1){	
					error_fun('username','Username Not Available');		
					$('.availability').html('Username Not Available');
					$('.availability').removeClass('a-green');
					$('.availability').addClass('a-red');
				}else{
					error_fun('username','Username Available');	
					$('.availability').html('Username Available');
					$('.availability').removeClass('a-red');
					$('.availability').addClass('a-green');
					setTimeout(function() {
						$('.availability').slideUp();
					}, 2000);
				}
				});
			}
		}else{
			error_fun('username','Please enter valid username');
		}
		});


	function error_fun(error,message){
		$('.e-'+error).html(message);
		$('.e-'+error).show();
	}

	function no_error_fun(error){
		$('.e-'+error).hide();
	}
	
	function isValidEmailAddress(emailAddress) {
	    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
	    return pattern.test(emailAddress);
	};

	String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}

	$('.error-drop').hide();
});