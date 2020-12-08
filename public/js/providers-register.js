function setlocalities(){
  var v = $('#localities').val();
  v = JSON.parse(v);
  var data = {};
  v.forEach((item) => {
    data[item] = null;
  });
  $('#locality').autocomplete({
    data: data,
  });
}


$(document).ready(function(){
  setlocalities();
});
