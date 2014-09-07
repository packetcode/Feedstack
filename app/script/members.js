$(function(){
	$('.member-search').keyup(function(){
			var search = $(this).val();
			var root = $(this).attr('root');
			$.post(root+'user/search.html',{"user":search},function(data){
			$('.entry').html(data);
			});
	});
	$(document).on('click','.loadmore-members',function(){
		var clear = $('.clear-'+$(this).attr('id'));
		var from = clear.attr('from');
		var posturl = $('.root').attr('root')+'members.html';
		$(this).remove();
		$.post(posturl,{'from':from},function(data){
			clear.replaceWith(data);
		});

	});
});