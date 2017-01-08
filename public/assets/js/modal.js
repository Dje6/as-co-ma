
jQuery(function($){

	//Lorsque vous cliquez sur un lien de la classe poplight
	$('a.poplight').on('click', function() {
		var popID = $(this).data('rel'); //Trouver la pop-up correspondante

    $.ajax({
      type: "GET",
      url: $(this).attr("href"),
        success: function(response) {
          $('#' + popID).fadeIn();

          //Apparition du fond - .css({'filter' : 'alpha(opacity=80)'}) pour corriger les bogues d'anciennes versions de IE
          $('body').append('<div id="fade"></div>');
          $('#fade').css({'filter' : 'alpha(opacity=80)'}).fadeIn();

          var $position = $('#' + popID).offset();
          $('#' + popID).css({
            'margin-top' : -($position.top-$(window).scrollTop()),
          });

          if($.isPlainObject(response.resultat) == true){

            $donnee = response.resultat;
            $('#' + popID +' .modal_user_pseudo').html($donnee.pseudo);
            $('#' + popID +' .modal_avatar').html('<img alt="User Pic" src="../../../Assets/'+$donnee.avatar+'" class="img-circle img-responsive ">');
            $('#' + popID +' .modal_nom').html($donnee.nom);
            $('#' + popID +' .modal_prenom').html($donnee.prenom);
            $('#' + popID +' .modal_mail').html('<a href="mailto:'+$donnee.mail+'">'+$donnee.mail+'</a>');
            $('#' + popID +' .modal_adresse').html($donnee.adresse);
            $('#' + popID +' .modal_code_postal').html($donnee.code_postal);
            $('#' + popID +' .modal_ville').html($donnee.ville);
            if(jQuery.isEmptyObject($donnee.fix)){
              $('#' + popID +' .modal_fix').html('Fix Non renseigné');
            }else {
              $('#' + popID +' .modal_fix').html('<a href="tel:'+$donnee.fix+'">'+$donnee.fix+'</a>');
            }
            if(jQuery.isEmptyObject($donnee.mobile)){
              $('#' + popID +' .modal_portable').html('Mobile Non renseigné');
            }else {
              $('#' + popID +' .modal_portable').html('<a href="tel:'+$donnee.mobile+'">'+$donnee.mobile+'</a>');
            }
          }else {

            $('#' + popID +' .modal_user_pseudo').html(response.resultat);
            $('#' + popID +' .modal_avatar').empty();
            $('#' + popID +' .modal_nom').empty();
            $('#' + popID +' .modal_prenom').empty();
            $('#' + popID +' .modal_mail').empty();
            $('#' + popID +' .modal_adresse').empty();
            $('#' + popID +' .modal_code_postal').empty();
            $('#' + popID +' .modal_ville').empty();
            $('#' + popID +' .modal_fix').empty();
            $('#' + popID +' .modal_portable').empty();
          }
        },
        error: function(response) {
          console.log(response);
        }
      })
      		return false;
	});

	//Close Popups and Fade Layer
	$('body').on('click', 'a.close, #fade', function() { //Au clic sur le body...
		$('#fade , .popup_block').fadeOut(function() {
			$('#fade, a.close').remove();

      var popID = $('.popup_block').attr('id');

      $('#' + popID).css({
        'margin-top' : 0,
      });
	}); //...ils disparaissent ensemble

		return false;
	});


});
