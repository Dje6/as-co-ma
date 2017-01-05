// JAVASCRIPT LOL
$('.update_user,.update_admin').on("click", function(event) {
  event.preventDefault();

  var $this = $(this);
  // console.log('HELLO');
  $.ajax({
    type: "GET",
    url: $(this).attr("href"),
    // data: {},
    // dataType: 'json',
    success: function(response) {

      if(response.result){
        var classList = $($this).attr('class').split(/\s+/);
        var classListSpan = $('#span_roles'+classList[1]).attr('class').split(/\s+/);
        var nbr = classListSpan.length-1;
        var pseudo = classListSpan[nbr];

        if( ($('.'+classList[0]+'_btn'+classList[1]).html()) == 'Passer en mode User'){
          $('.'+classList[0]+'_btn'+classList[1]).html('Passer en mode Admin');
          $('#span_roles'+classList[1]).html(pseudo+' : User');

        }else if( ($('.'+classList[0]+'_btn'+classList[1]).html()) == 'Passer en mode Admin') {
          $('.'+classList[0]+'_btn'+classList[1]).html('Passer en mode User');
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
