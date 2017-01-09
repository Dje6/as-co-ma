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
