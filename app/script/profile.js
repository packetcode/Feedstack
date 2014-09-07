$(function(){

	var access_token = $('.root').attr('access-token');
	$(document).on('click','.btn-follow-btn',function(){
		var posturl = $('.root').attr('root');
		var notifyurl = $('.root').attr('root')+'user/notify';
		var profile = $(this).closest('.profile-buttons');
		var button = $(this);
		var uid = profile.attr('uid');
		var lid = profile.attr('liveuser-id');
		if(lid){
			if(button.attr('follow')=='0'){
				$.post(posturl+'user/follow',{'uid':uid,'liveuser_id':lid,'access_token':access_token},function(data){
					button.removeClass('btn-follow');
					button.addClass('btn-unfollow');
					button.html('Unfollow');
					button.attr('follow','1');

					var action = 'follow';
					if(lid!=uid)
					$.post(notifyurl,{'target':uid,'action':action,'agent':lid,'uid':uid,'access_token':access_token},function(data){
					});
				});
			}else{
				$.post(posturl+'user/unfollow',{'uid':uid,'liveuser_id':lid,'access_token':access_token},function(data){
					button.removeClass('btn-unfollow');
					button.addClass('btn-follow');
					button.html('Follow');
					button.attr('follow','0');

					var action = 'unfollow';
					if(lid!=uid)
					$.post(notifyurl,{'target':uid,'action':action,'agent':lid,'uid':uid,'access_token':access_token},function(data){
					});
				});

			}
		}else{
			$('.login-popup').bPopup();
		}
	});

	$(document).on('click','.btn-block-btn',function(){
		var posturl = $('.root').attr('root');
		var profile = $(this).closest('.profile-buttons');
		var button = $(this);
		var uid = profile.attr('uid');
		var lid = profile.attr('liveuser-id');
			if(button.attr('blocked')=='0'){
				$.post(posturl+'admin/blockuser',{'uid':uid,'access_token':access_token},function(data){
					button.removeClass('btn-block');
					button.addClass('btn-unblock');
					button.html('Unblock');
					button.attr('blocked','1');
					console.log(data);
				});
			}else{
				$.post(posturl+'admin/unblockuser',{'uid':uid,'access_token':access_token},function(data){
					button.removeClass('btn-unblock');
					button.addClass('btn-block');
					button.html('Block');
					button.attr('blocked','0');
						console.log(data);
				});
			}
	});

	/* User delete Process*/
	$(document).on('click','.btn-delete-user',function(){
		var profile = $(this).closest('.profile-buttons');
		var uid = profile.attr('uid');
		$('.login-popup').html('<h2>Confirm Deletion</h2><p>\
			The User and associated data would be permanently \
			deleted from our records</p>\
			<div><button class="btn delete-btn delete-btn-user" uid="'+uid+'">Delete</button>\
			<buton class="btn delete-close">Cancel</button></div>');
			$('.login-popup').bPopup();
	});

	$(document).on('click','.delete-btn-user',function(){
		var posturl = $('.root').attr('root');
		var button = $(this);
		var uid = button.attr('uid');
		$.post(posturl+'admin/deleteuser',{'uid':uid,'access_token':access_token},function(data){
				window.location = posturl;	
			}); 

	});

	$(document).on('click','.activate-user',function(){
		var posturl = $('.root').attr('root');
		var button = $(this);
		var profile = $(this).closest('.profile-buttons');
		var uid = profile.attr('uid');

		$.post(posturl+'admin/activateuser',{'uid':uid,'access_token':access_token},function(data){
				$('.login-popup').html('<h2>User Activated</h2><p>\
				<buton class="btn delete-close">Close</button></div>');
				$('.login-popup').bPopup();
				button.hide();
			}); 

	});
});