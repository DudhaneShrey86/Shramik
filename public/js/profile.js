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

function setLocation(){
  if(navigator.geolocation){
    var geo = navigator.geolocation;
    geo.getCurrentPosition(showPosition, showError);
  }
}
function showPosition(position){
  var lat = position.coords.latitude;
  var lon = position.coords.longitude;
  $('#latitude').val(lat);
  $('#longitude').val(lon);
  $('#form').submit();
}
function showError(error){
  var p = $('#erroroutput');
  p.removeClass('amber-text text-darken-1');
  switch(error.code) {
    case error.PERMISSION_DENIED:
      p.text('Please make sure to allow location access');
      p.addClass('amber-text text-darken-1');
      break;
    case error.POSITION_UNAVAILABLE:
      p.text('Position unavailable');
      p.addClass('amber-text text-darken-1');
      break;
    case error.UNKNOWN_ERROR:
      p.text('Some error occured');
      p.addClass('amber-text text-darken-1');
      break;
  }
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
