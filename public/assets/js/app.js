//SLICKNAV MENU SUR HEADER FRONT LAYOUT. Menu classique disparait en mobile et s'ajoute dans slicknav
// verifie si le #menu du front est présent (pour pas d'erreur avec le back)
if ($('#menu').length) {
	$(function(){
		$('#menu').slicknav();
	});
}


// Mise en place du scrollTop
// apparait seulement lorsque l'on a besoin de scroll la page.
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

// deroule les CGU sur le click de #toggleCGU
$('#toggleCGU').click(function(event) {
	event.preventDefault();

	$('.cguHidden').slideToggle("slow");

	if ($(this).text() == 'Dérouler') {
		$(this).text('Cacher');
	} else {
		$(this).text('Dérouler');
	}
});
