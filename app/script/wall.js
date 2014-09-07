$(function(){


	var access_token = $('.root').attr('access-token');

	$('.article').readmore({
		  speed: 200,
		  maxHeight: 85,
		  moreLink: '<a href="#"><i class="fa fa-angle-down readmore"> Readmore</a>',
		  lessLink: '<a href="#"><i class="fa fa-angle-up readmore"> Readless</a>'
	});

	$('.loading').hide();
		$(document).on('click','.post-btn',function(){
			var posturl = $('.root').attr('root')+'feed/post.html';
			var feed = $('.feed-box').val();
			var username = $('.feed-user').attr('username');
			var name = $('.feed-user').attr('name');
			var uid = $('.feed-user').attr('uid');
			var image = $('.feed-user-image').attr('src');

			if(feed.length===0){
				alert('Please enter some text');
			}else{
				$('.loading').show();
			$.post(posturl,{'feed':feed,'username':username,'name':name,'image':image,'uid':uid,'access_token':access_token},function(data){
				console.log(data);
				$(data).insertAfter('.feed-entry');
				 $('.feed-box').val('');
				 $('.loading').hide();
				 $('.feed-box').height(35);
				 if( $('.profile-card').length ){
				 	$('.profile-card').remove();
				 }  
			});
			} 
		});

	$(document).on('click','.loadmore',function(){
		var posturl = $('.loadmore-entry').attr('root')+'feed/load.html';
		var lastid = $(this).attr('lastid');
		if($(this).attr('feed-type'))
		var type = $(this).attr('feed-type');
		else
		var type =null;

		if($(this).attr('wall'))
		var wall = $(this).attr('wall');
		else
		var wall =null;

		if($(this).attr('uid'))
			var uid = $(this).attr('uid');
		else
			var uid=null;

		if($(this).attr('liveuser-id'))
			var lid = $(this).attr('liveuser-id');
		else
			var lid=null;

		$.post(posturl,{'lastid':lastid,'uid':uid,'feed-type':type,'liveuser-id':lid,'wall':wall},function(data){
				$('.loadmore-entry').replaceWith(data);
				$('.article').readmore({
					  speed: 200,
					  maxHeight: 85,
					  moreLink: '<a href="#"><i class="fa fa-angle-down readmore"> Readmore</a>',
					  lessLink: '<a href="#"><i class="fa fa-angle-up readmore"> Readless</a>'
				});
			});
	});

	/* Feed Comments */
	$(document).on('click','.feed-comment-count',function(){
		var feed_id = $(this).closest('.feed').attr('feed-id');
		var container = $('.comment-block-entry-'+feed_id);
		var comment_count =parseInt($('.comment-count-'+feed_id).html());
		var ele = $(this).next('.loading-likers');

		if(container.is(':visible')){
			container.slideUp();
		}else{
			ele.show();
			var posturl = $('.root').attr('root')+'feed/commentload.html';
			$.post(posturl,{'feed_id':feed_id},function(data){
				container.html(data);
				container.slideDown();
			});
			ele.hide();
		}
	});

		$(document).on('click','.load-more-comments',function(){
			var posturl = $('.root').attr('root')+'feed/commentload.html';
			var feed_id = $(this).attr('feed-id');
			var cont = $(this);
			var last_comment_id = $(this).attr('last-comment-id');
			var comment_show_count = parseInt($(this).attr('comment-show-count'))+1;
			var comment_count = parseInt($(this).attr('comment-count'));
			$(this).attr('comment-count',comment_count-comment_show_count+1);
			
			$.post(posturl,{'feed_id':feed_id,'from':last_comment_id},function(data){
				//$('.comment-block-entry-'+feed_id).replaceWith(data);
				$('<div>'+data+'</div>').prependTo('.feed-comment-list-'+feed_id).hide().slideDown();;
			});
			
			setTimeout(function(){
				var lci = $('.load-more-check-'+feed_id+'-'+last_comment_id).attr('last-comment-id');
				cont.attr('last-comment-id',lci);
				if(comment_count-comment_show_count+1>0)
				{
					cont.find('.comment-out-of').html(comment_count-comment_show_count+1);
				}else
					cont.find('.comment-out-of').html(0);
				if(comment_count<comment_show_count){
				cont.slideUp();
			}
			}, 1000);
			
		});

		if($('.feed-display').length){
			load_comment();
		}
		
		function load_comment(){
		var feed = $('.feed-display');
		var feed_id = feed.attr('feed-id');
		var container = $('.comment-block-entry-'+feed_id);
		var comment_count =parseInt($('.comment-count-'+feed_id).html());
		var ele = feed.next('.loading-likers');

		if(container.is(':visible')){
			container.slideUp();
		}else{
			ele.show();
			var posturl = $('.root').attr('root')+'feed/commentload.html';
			$.post(posturl,{'feed_id':feed_id},function(data){
				container.html(data);
				container.slideDown();
			});
			ele.hide();
		}
		}

	$(document).on('keypress','.feed-comment-input-entry',function(event){
	var feed_id = $(this).closest('.feed').attr('feed-id');
	var lid = $(this).closest('.feed').attr('liveuser-id');
	var uid = $(this).closest('.feed').attr('uid');
	
	var commentBox = $(this);
	var keycode = (event.keyCode ? event.keyCode : event.which);
		if(keycode == '13'){
			var comment = commentBox.val();
			if(comment){
				var posturl = $('.root').attr('root')+'feed/comment.html';
				$.post(posturl,{'feed_id':feed_id,'uid':lid,'comment':comment,'access_token':access_token},function(data){
					$('<div>'+data+'</div>').insertBefore('.feed-comment-entry-'+feed_id);
					commentBox.val('');
					var count =parseInt($('.comment-count-'+feed_id).html())+1;
					$('.comment-count-'+feed_id).html(count);
				});
				
				var notifyurl = $('.root').attr('root')+'user/notify';
				var action = 'comment';
				if(lid!=uid)
				$.post(notifyurl,{'target':feed_id,'action':action,'agent':lid,'uid':uid,'access_token':access_token},function(data){
				});
			}
		}
	});

	$(document).on('click','.feed-comment-delete',function(){
		var comment_id = $(this).attr('comment-id');
		var feed = $(this).closest('.feed');
		var feed_id = feed.attr('feed-id');
		$('.login-popup').html('<h2>Confirm Deletion</h2><p>\
			The Comment would be permanently \
			deleted from our records</p>\
			<div><button class="btn delete-btn-comment" feed-id="'+feed_id+'" comment-id="'+comment_id+'">Delete</button>\
			<buton class="btn delete-close">Cancel</button></div>');
		$('.login-popup').bPopup();
	});

	$(document).on('click','.delete-btn-comment',function(){
		var comment_id = $(this).attr('comment-id');
		var feed_id = $(this).attr('feed-id');
		var comment = $('.feed-comment-block-'+comment_id);
		$('.login-popup').bPopup().close();
		var count =parseInt($('.comment-count-'+feed_id).html())-1;
		$('.comment-count-'+feed_id).html(count);
		comment.slideUp("normal", function() { $(this).remove(); } );
		var posturl = $('.root').attr('root')+'feed/deletecomment.html';
		$.post(posturl,{'comment_id':comment_id,'access_token':access_token},function(data){
		});
	});

	/* Feed Likes*/
	$(document).on('click','.feed-likers',function(){
		console.log('clicked feed-likers');
		var posturl = $('.root').attr('root')+'feed/showlikers.html';
		var feed_id = $(this).attr('feed-id');
		var ele = $(this).next('.loading-likers');
		ele.show();
		$.post(posturl,{'feed_id':feed_id},function(data){
			$('.login-popup').html(data);
			$('.login-popup').bPopup();
			ele.hide();
		});
	});

	$(document).on('click','.feed-like',function(){
		var root = $('.root').attr('root');
		var posturl = $('.root').attr('root')+'feed/like';
		var posturl_unlike = $('.root').attr('root')+'feed/unlike';
		var lid = $(this).attr('liveuser-id');
		var uid = $(this).closest('.feed').attr('uid');
		var feed_id = $(this).attr('feed-id');
		var unlike = $(this).attr('unlike');
		var entry = '.like-entry-'+feed_id;
		var you_like = '.you-like-'+feed_id;
		var count = $('.feed-like-'+feed_id).attr('count');
		var word = $('.likes-word-'+feed_id);
		if(!lid)
			 $('.login-popup').bPopup();
		else if(unlike=='1'){
			$.post(posturl_unlike,{'feed_id':feed_id,'uid':lid,'access_token':access_token},function(data){
				
				if(count==1)
				if($('.like-entry-'+feed_id).is(':visible')){
						$('.like-entry-'+feed_id).slideToggle();
				}

				$(you_like).html('');
				$('.feed-like-'+feed_id).attr('count',parseInt(count)-1);	
				$('.like-count-'+feed_id).html(parseInt(count)-1);
				$('.like-count-'+feed_id).show();
				word.html(' likes');	
				$('.feed-like-'+feed_id).attr('unlike','0');

				//notify
				var notifyurl = $('.root').attr('root')+'user/notify';
				var action = 'unlike';
				if(lid!=uid)
				$.post(notifyurl,{'target':feed_id,'action':action,'agent':lid,'uid':uid,'access_token':access_token},function(data){
				});
			
			});
		}
		else
		$.post(posturl,{'feed_id':feed_id,'uid':lid,'access_token':access_token},function(data){
			$(entry).addClass('feed-connect');
			if(count==0){
				count=parseInt(count)+1;
				$(you_like).html('you liked it');
			}else{
				$(you_like).html('you and ');
				count=parseInt(count)+1;
			}

			$('.like-count-'+feed_id).html(count);	
			$('.feed-like-'+feed_id).attr('count',count);	
			$('.like-count-'+feed_id).hide();
			word.html('unlike');
			$('.feed-like-'+feed_id).attr('unlike','1');

			if(!$('.like-entry-'+feed_id).is(':visible')){
				$('.like-entry-'+feed_id).slideToggle();
			}
			//$(entry).slideToggle();

			//notify
			var notifyurl = $('.root').attr('root')+'user/notify';
			var action = 'like';
			if(lid!=uid)
			$.post(notifyurl,{'target':feed_id,'action':action,'agent':lid,'uid':uid,'access_token':access_token},function(data){
			});
		
		});
	});

	/* Feed delete Process*/
	$(document).on('click','.feed-delete',function(){
		var feed = $(this).closest('.feed');
		var feed_id = feed.attr('feed-id');
		$('.login-popup').html('<h2>Confirm Deletion</h2><p>\
			The feed and associated likes and comments would be permanently \
			deleted from our records</p>\
			<div><button class="btn delete-btn" feed-id="'+feed_id+'">Delete</button>\
			<buton class="btn delete-close">Cancel</button></div>');
		if ($.fn.bPopup) {
		$('.login-popup').bPopup();
		}else
			alert('no');
	});

	$(document).on('click','.delete-close',function(){
		$('.login-popup').bPopup().close();
	});

	$(document).on('click','.btn-cancel',function(){
		//alert('one');
		$('.login-popup').bPopup().close();
	});

	$(document).on('click','.delete-btn',function(){
		var feed_id = $(this).attr('feed-id');
		var feed = $('.feed-'+feed_id);
		$('.login-popup').bPopup().close();
		feed.slideUp("normal", function() { $(this).remove(); } );
		var posturl = $('.root').attr('root')+'feed/delete.html';
		$.post(posturl,{'feed_id':feed_id,'access_token':access_token},function(data){
		});
	});
});