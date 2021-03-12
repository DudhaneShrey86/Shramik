var latitude = '';
var longitude = '';


function setlocalities(){
  var v = $('#localities').val();
  v = JSON.parse(v);
  var data = {};
  v.forEach((item) => {
    data[item] = null;
  });
  $('#locality, #locality_filter, #locality_filter_mobile').autocomplete({
    data: data,
  });
}

function search(v){
  v = v.toLowerCase();
  $('.itema').hide();
  var flag = 0;
  $('.itema').each(function(){
    var name = $(this).find('#name').text().toLowerCase();
    if(name.includes(v)){
      $(this).show();
      flag = 1;
    }
  });
  if(flag == 0){
    $('#noresult').show();
  }
  else{
    $('#noresult').hide();
  }
}

function setvalues(){
  latitude = $('#latitude').val();
  longitude = $('#longitude').val();
}

function setPosition(){
  if(navigator.geolocation){
    var geo = navigator.geolocation;
    geo.getCurrentPosition(showPosition);
  }
}
function showPosition(position){
  var newlat = position.coords.latitude;
  var newlon = position.coords.longitude;
  $('#latitude').val(newlat);
  $('#longitude').val(newlon);
}
function resetPosition(){
  $('#latitude').val(latitude);
  $('#longitude').val(longitude);
}

$(document).ready(function(){
  setlocalities();
  $('#search').keyup(function(){
    search($(this).val());
  });
  setvalues();
  $('#current_location').change(function(){
    if(this.checked){
      setPosition();
    }
    else{
      resetPosition();
    }
  });
});
