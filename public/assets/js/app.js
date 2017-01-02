//SLICKNAV MENU SUR HEADER FRONT LAYOUT
$(function(){
	$('#menu').slicknav();
});


// Mise en place du scrollTop
$(document).ready(function () {
  $(window).scroll(function () {
    if ($(this).scrollTop() > 100) {
        $('.return').fadeIn();
    } else {
        $('.return').fadeOut();
    }
  });
  $('.return').click(function () {
    $("html, body").animate({
        scrollTop: 0
    }, 600);
    return false;
  });
});
