function rate(t){
  $('.ratingicons').removeClass('active');
  var v = t.attr('id');
  for (var i = 1; i <= 5; i++) {
    if(i <= v){
      $('#'+i).addClass('active');
    }
  }
  $('#rating').val(v);
}

function showreviewinput(){
  $('#finishtaskdiv').addClass('active');
}

function hidereviewinput(){
  $('.ratingicons').removeClass('active');
  $('#1').addClass('active');
  $('#finishtaskdiv').removeClass('active');
}

$(document).ready(function(){
  $('.ratingicons').click(function(){
    rate($(this));
  });
  $('#finishbutton').click(showreviewinput);
  $('#cancelreviewbutton').click(hidereviewinput);
});
