$(document).ready(function(){
  $('#editbutton').click(function(){
    if($(this).text() == 'Edit'){
      $('.inputs').removeAttr('disabled');
      $(this).text('Stop Editing');
    }
    else{
      $('.inputs').attr('disabled', 'disabled');
      $(this).text('Edit');
    }
  });
});
