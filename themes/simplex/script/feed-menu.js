$(function(){
	var fmenu = $('.feed-menu-list');
	var menu_width = $('.feed-menu').attr('menuwidth');
	var current_width = $(window).width();
	var pos = (current_width - menu_width)/2;
	if(current_width<480)
		$('.feed-menu').css('left',pos+'px');

	   	$('.feed-menu-list-item').css('padding-left','20px');

	$(window).resize(function(){
		var current_width = $(window).width();
		var menu_width = $('.feed-menu').attr('menuwidth');
		var pos = (current_width - menu_width)/2;
	   	$('.feed-menu').css('left',pos+'px');
  });
});