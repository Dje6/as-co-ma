// UPDATE ROLES USERS DANS ASSOC
$('.update_user,.update_admin').on("click", function(event) {
  event.preventDefault();

  var $this = $(this);
  $.ajax({
    type: "GET",
    url: $(this).attr("href"),
    success: function(response) {

      if(response.result){
        var classList = $($this).attr('class').split(/\s+/);
        var classListSpan = $('#span_roles'+classList[1]).attr('class').split(/\s+/);
        var nbr = classListSpan.length-1;
        var pseudo = classListSpan[nbr];

        if( ($('.'+classList[0]+'_btn'+classList[1]).html()) == 'Attribuer role User'){
          $('.'+classList[0]+'_btn'+classList[1]).html('Attribuer role Admin');
          $('#span_roles'+classList[1]).html(pseudo+' : User');

        }else if( ($('.'+classList[0]+'_btn'+classList[1]).html()) == 'Attribuer role Admin') {
          $('.'+classList[0]+'_btn'+classList[1]).html('Attribuer role User');
          $('#span_roles'+classList[1]).html(pseudo+' : Admin');
        }
      }else {
        console.log(response.result);
      }
    },
    error: function(response) {
      console.error(response);
    }
  })
})


// UPDATE ASSOC DES MAIRIES
$('.update_suspendre,.update_activer').on("click", function(event) {
  event.preventDefault();

  var $this = $(this);
  $.ajax({
    type: "GET",
    url: $(this).attr("href"),
    success: function(response) {

      if(response.result){
        var classList = $($this).attr('class').split(/\s+/);
        var classListSpan = $('#span_update'+classList[1]).attr('class').split(/\s+/);
        var nbr = classListSpan.length-1;
        // var pseudo = classListSpan[nbr];

        if( ($('.'+classList[0]+'_btn'+classList[1]).html()) == 'Suspendre'){
          $('.'+classList[0]+'_btn'+classList[1]).html('Activer');
          $('.'+classList[0]+'_btn'+classList[1]).removeClass('btn-warning');
          $('.'+classList[0]+'_btn'+classList[1]).addClass('btn-success');
          // $('#span_roles'+classList[1]).html(pseudo+' : User');

        }else if( ($('.'+classList[0]+'_btn'+classList[1]).html()) == 'Activer') {
          $('.'+classList[0]+'_btn'+classList[1]).html('Suspendre');
          $('.'+classList[0]+'_btn'+classList[1]).removeClass('btn-success');
          $('.'+classList[0]+'_btn'+classList[1]).addClass('btn-warning');

          // $('#span_roles'+classList[1]).html(pseudo+' : Admin');
        }
      }else {
        console.log(response.result);
      }
    },
    error: function(response) {
      console.error(response);
    }
  })
})
