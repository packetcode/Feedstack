$(function(){
	var menu = $('.menu-bar');
	var current_width = $(window).width();
	if(current_width>480)
		menu.show();
	else
		menu.hide();

	$('.menu-text').on('click',function(){
		var check = menu.is(":visible") ;
		if(check)
			menu.slideToggle();
		else
			menu.slideToggle();
	});	

	$(window).resize(function(){
		var current_width = $(window).width();
	   	if(current_width>480)
			menu.show();
		else
			menu.hide();
  });
});