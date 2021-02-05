
function placetasks(){
  var cancelled = 0, active = 0, finished = 0;
  $('.customrow').each(function(){
    var status = $(this).data('status');
    if(status == 0){
      $(this).appendTo('#cancelled');
      cancelled = 1;
    }
    else if(status == 1){
      $(this).appendTo('#active');
      active = 1;
    }
    else if(status == 2){
      $(this).appendTo('#finished');
      finished = 1;
    }
  });
  if(cancelled == 0){
    $('#cancelled').append('<p class="flow-text">No cancelled tasks found!</p>');
  }
  if(active == 0){
    $('#active').append('<p class="flow-text">No active tasks found!</p>');
  }
  if(finished == 0){
    $('#finished').append('<p class="flow-text">No finished tasks found!</p>');
  }
}

$(document).ready(function(){
  placetasks();
});
