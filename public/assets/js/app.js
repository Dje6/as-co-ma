//SLICKNAV MENU SUR HEADER FRONT LAYOUT
$(function(){
	$('#menu').slicknav();
});


// Mise en place du scrollTop
$(document).ready(function () {
  $(window).scroll(function () {
    if ($(this).scrollTop() > 100) {
        $('.return').show();
    }
  }).scroll();

  $('.return').click(function () {
    $("html, body").animate({
        scrollTop: 0
    }, 600);
    return false;
  });
});

// deroule les CGU
$('#toggleCGU').click(function(event) {
	event.preventDefault();

	$('.cguHidden').slideToggle("slow");

	if ($(this).text() == 'Dérouler') {
		$(this).text('Cacher');
	} else {
		$(this).text('Dérouler');
	}
});
