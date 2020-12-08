function startedit(){
  $('#savediv').addClass('active');
  $('.custominputs').addClass('active').removeAttr('readonly');
  $('#editbutton').removeClass('active');
}

function endedit(){
  $('#savediv').removeClass('active');
  $('.custominputs').removeClass('active').attr('readonly', true);
  $('#editbutton').addClass('active');
}

$(document).ready(function(){
  $('#editbutton').click(function(){
    startedit();
  });
  $('#savebutton').click(function(){
    endedit();
  });
  $('#cancelbutton').click(function(){
    endedit();
  });
  $('#profile_pic').change(function(){
    if($(this).val() != ""){
      $('#upload_pic_form').submit();
    }
  });
});
