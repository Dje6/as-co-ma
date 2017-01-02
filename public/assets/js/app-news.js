// FENETRE MODALE (popup) SUR LES IMG DE NEWS EN ASSOC ET MAIRIE
// Get the modal
var modal = document.getElementById('myModal');

// on get l'img et on l'insert dans la modale - on utiliser le ALT de l'img en caption en dessous
var img = document.getElementsByClassName('newsImg');
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
for (var i = 0; i < img.length; i++) {
	img[i].onclick = function(){
		modal.style.display = "block";
		modalImg.src = this.src;
		captionText.innerHTML = this.alt;
	}

}

// get le span qui ferme la modale
var span = document.getElementsByClassName("close")[0];

//si le span pour fermer la modale est présent sur la page
//cliquer sur la X en haut a droite de l'ecran pour fermer la modale
if (modal) {
  span.onclick = function() {
    modal.style.display = "none";
  }
  //on peut fermer la modale avec echap aussi
  document.addEventListener('keyup', function(e) {
    if (e.keyCode == 27) {
      modal.style.display = "none";
    }
  });

}
