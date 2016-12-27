
// initialisation des variables
var fileInput  = document.querySelector( ".input-file" ),
    urlRoute  = document.querySelector( ".urlRoute" ),
    button     = document.querySelector( ".input-file-trigger" );

// action lorsque la "barre d'espace" ou "Entrée" est pressée
button.addEventListener( "keydown", function( event ) {
    if ( event.keyCode == 13 || event.keyCode == 32 ) {
        fileInput.focus();
    }
});

// action lorsque le label est cliqué
button.addEventListener( "click", function( event ) {
   fileInput.focus();
   return false;
});

fileInput.addEventListener( "change", function( event ) {
  console.log(urlRoute.value);
  // window.location.href = urlRoute.value;
  $.ajax({
      url: urlRoute.value,
      type: "POST",
      data: {image: this.value
          },
      success: function(response){
        console.log(response);
      },
      error: function(response){
        console.log(response);
      }

  });
});
