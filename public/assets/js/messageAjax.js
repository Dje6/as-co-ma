//pagination
$('.pagin').on("click",'.ajaxPagin', function(event) {
  event.preventDefault();

  var $this = $(this);
  var classList = $(this).attr('class').split(/\s+/);
  var $dernier = classList.length-1;
  var $page = classList[1];
  var grandParentClassList = $(this).parents("div").attr('class').split(/\s+/);
  var $key = grandParentClassList[1];

  $.ajax({
    type: "GET",
    url: $(this).attr("href"),
    data: 'key=' + $key + '&page=' + $page,
    dataType:"Json",
    success: function(response) {
      $('#'+$key).empty();
      $('#'+$key).html(response.donnee);
      $('.'+$key).empty();
      $('.'+$key).html(response.pagination);
    },
    error: function(response) {
      console.log(response);
    }
  })

})

//selection message recu ou envoyer
//
//
$('.bouton_rec ,.bouton_env ').on("click", function(event) {
  event.preventDefault();

  var $this = $(this);
  var $className = $(this).attr('class');
  var $key;
  if($className == 'bouton_rec'){
    $key = 'Recu';
    $key_oposer = 'Envoyer';
    $oposer = $('.bouton_env');
  }else if ($className == 'bouton_env') {
    $key = 'Envoyer';
    $key_oposer = 'Recu';
    $oposer = $('.bouton_rec');
  }

  $.ajax({
    type: "GET",
    url: $(this).attr("href"),
    dataType:"Json",
    success: function(response) {
      $($this[0].firstElementChild).toggleClass(' btn-primary');
      $($this[0].firstElementChild).toggleClass(' btn-secondary');
      $($oposer[0].firstElementChild).toggleClass(' btn-primary');
      $($oposer[0].firstElementChild).toggleClass(' btn-secondary');

      $('#'+$key).empty();
      $('#'+$key).html(response.donnee);
      $('.'+$key).empty();
      $('.'+$key).html(response.pagination);

      $('#Div'+$key_oposer).toggleClass('DisplayNone');
      $('#Div'+$key).toggleClass('DisplayNone');
    },
    error: function(response) {
      console.log(response);
    }
  })

})

//action btn
//
//
$('#Recu, #Envoyer').on("click", '.message_btn, .message_btn_supprimer',function(event) {
  event.preventDefault();
  var $this = $(this);
  var $key = $(this).parent().attr('id');


  if($(this).attr('class') == 'message_btn_supprimer'){
    $message = 'Voulez vous vraiment supprimer ce message ?';
    if (confirm($message)){
      $.ajax({
        type: "GET",
        url: $(this).attr("href"),
        success: function(response) {
          console.log($($this).attr("href"));
          console.log('premier succes');
          console.log(response);
          if(response.error){

          }else if(response.redirect){
            console.log('if redirect : '+response.redirect);
            $.ajax({
              type: "GET",
              url: response.redirect,
              success: function(response) {
                console.log($key);
                  $('#'+$key).empty();
                  $('#'+$key).html(response.donnee);
                  $('.'+$key).empty();
                  $('.'+$key).html(response.pagination);
              },
              error: function(response) {
                console.log(response);
              }
            })
          }
        },//fin de succes
        error: function(response) {
          console.log(response);
        }
      })
    }else {
      console.log('operation annuler');
    }
  } //fin de si c'est un supprimer
  else {
    $.ajax({
      type: "GET",
      url: $(this).attr("href"),
      success: function(response) {
        if(response.error){
          console.log('php retourne une erreur : '+response.error);
        }else if(response.redirect){
          $.ajax({
            type: "GET",
            url: response.redirect,
            success: function(response) {
                $('#'+$key).empty();
                $('#'+$key).html(response.donnee);
                $('.'+$key).empty();
                $('.'+$key).html(response.pagination);
            },
            error: function(response) {
              console.log('le deuxieem ajax a cracher');
              console.log(response);
            }
          })
        }
      },
      error: function(response) {
        console.log('le premier ajax a cracher');
        console.log(response);
      }
    })
  }
})
