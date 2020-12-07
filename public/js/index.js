M.AutoInit();

function setActivePage(){
  var page = $('#parentcontainer').data('id');
  $('#'+page).addClass("active");
}

$(document).ready(function(){
  $('.custommsgs').click(function(){
    $(this).fadeOut(200);
  });
  setActivePage();
});
