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


// FENETRE MODALE (popup) SUR LES IMG DE NEWS EN ASSOC ET MAIRIE
// Get the modal
var modal = document.getElementById('myModal');

// on get l'img et on l'insert dans la modale - on utiliser le ALT de l'img en caption en dessous
var img = document.getElementById('newsImg');
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function(){
    modal.style.display = "block";
    modalImg.src = this.src;
    captionText.innerHTML = this.alt;
}

// get le span qui ferme la modale
var span = document.getElementsByClassName("close")[0];

//cliquer sur la X en haut a droite de l'ecran pour fermer la modale
span.onclick = function() {
  modal.style.display = "none";
}
//on peut fermer la modale avec echap aussi
document.addEventListener('keyup', function(e) {
    if (e.keyCode == 27) {
      modal.style.display = "none";
    }
});
