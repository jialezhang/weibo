// JavaScript Document
jQuery(function($){
	
	fnsharetools();
	$(window).onresize = function() {
        fnsharetools();
    }
	$(window).scroll(function(){
		if($(this).scrollTop()>61){
			$('#header-2').addClass('topfixed');
		} 
		else 
		{
			$('#header-2').removeClass('topfixed');
		}
		fnsharetools();
		if ($(document.documentElement).scrollTop() > 0 || $(document.body).scrollTop() > 0) {
            $("#backtotop").show();
            $("#backtotop").die().live("click",
            function() {
                $("body,html").animate({
                    scrollTop: 0
                },
                500)
            })
        } else {
            $("#backtotop").hide()
        }
	});	
});
function fnsharetools() {
    var _scrotop = $(document).scrollTop();
    var _cheight = document.documentElement.clientHeight;
    var _cwidth = document.documentElement.clientWidth;
    var thisheight = $('.sharetoolsbody').height();
    var _tooltop = parseInt(_scrotop + _cheight / 2 - thisheight / 2 - 132) + 'px';
	
    if (_cwidth <= 1043) {
        var _toolright = 983 - _cwidth + 'px';
        $('#sharetoolsbody').css({
            'top': _tooltop,
            'right': _toolright
        })
    } else $('#sharetoolsbody').css({
        'top': _tooltop,
        'right': '-55px'
    })
}