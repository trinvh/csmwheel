$('ul.list-group li').hover(function() {
	$(this).addClass('shake').addClass('animated');
}, function() {
	$(this).removeClass('shake').addClass('animated');
});
$('#spin_button').hover(function() {
	$(this).addClass('swing').addClass('animated');
	$(this).find('b').addClass('rotateOut').addClass('animated').addClass('forever');
}, function() {
	$(this).removeClass('swing').addClass('animated')
	$(this).find('b').removeClass('rotateOut').removeClass('animated').removeClass('forever');
});
$(".time").html(function(index, value) {
    return moment(value, "YYYY-MM-DD HH:mm:ss").locale('vi').fromNow();
});