// DELETE UNE ASSOC DANS LES MAIRIE
$('.delete_user, .delete_assoc , .delete_mairie').on("click", function(event) {
  event.preventDefault();

  var $this = $(this);
  var $messageAssoc = 'Voulez vous vraiment supprimer cette association ?';
  var $messageMairie = 'Voulez vous vraiment supprimer cette mairie ?';
  var $messageUser = 'Voulez vous vraiment supprimer ce membre ?';

if($(this).attr('class') == 'delete_assoc'){
  $message = $messageAssoc;
}else if ($(this).attr('class') == 'delete_mairie') {
  $message = $messageMairie;
}else if ($(this).attr('class') == 'delete_user') {
  $message = $messageUser;
}

  if (confirm($message)){
    $.ajax({
      type: "GET",
      url: $(this).attr("href"),
        success: function(response) {
          console.log(response);

          if($.isArray(response.resultat) == false){
            // var $parents = $($this).parents();
            // var $pere = $parents[0];
            // var $grandPere = $parents[1];
            if($($this).attr('class') != 'delete_user'){
              $($this).parent().parent().remove();
            }else {
// console.log(response);
               window.location.replace(response.resultat);
            }
          }else {
            // afficher les erreurs du tableau
            console.log(response.result);
            for (var i = 0; i < response.result.length; i++){
              $($this).parent().append('<span>'+response.result[i]+'</span>');
            }
          }
        },
        error: function(response) {
          console.log(response);
        }
      })
  }else {
    console.log('operation annuler');

  }
})
