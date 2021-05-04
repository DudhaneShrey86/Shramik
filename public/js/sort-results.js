var scorearr = [];
var resultarr = [];

// function sortResults(){
//   $('#loading').addClass('active');
//   $('#tempresults .itema').each(function(){
//     var score = 0;
//     var reviews = parseInt($(this).find('#result-review-rating').data('reviews'));
//     var ratings = parseFloat($(this).find('#result-review-rating').data('ratings'));
//     var distance = parseFloat($(this).find('#result-distance').text());
//     var verified = parseInt($(this).find('#result-verified').length);
//     var verified_score = -5;
//     if(verified == 1){
//       verified_score = 10;
//     }
//     var time_elapsed = parseInt($(this).find('#result-last-seen').data('days'));
//     var time_to_divide = 24; // minutes
//     if(time_elapsed != 0){
//       time_to_divide = time_to_divide * time_elapsed;
//     }
//     if(ratings != 0){
//       if(reviews == 0 || reviews == 1){
//         score = (1 * Math.pow(2, ratings)) + (3/distance) + (verified_score) + (1/time_to_divide);
//       }
//       else{
//         score = (Math.log2(reviews) * Math.pow(2, ratings)) + (3/distance) + (verified_score) + (1/time_to_divide);
//       }
//     }
//     else{
//       score = (3/distance) + (verified_score) + (1/time_to_divide);
//     }
//     score = parseFloat(score.toFixed(4));
//     scorearr.push(score);
//     $(this).attr('data-score', score);
//   });
//   // sort and append to sorted results
//   scorearr.sort(function(a, b){
//     return b - a;
//   });
//
//   //appending results
//   scorearr.forEach((item, i) => {
//     $('#tempresults [data-score="'+item+'"]').appendTo('#sortedresults');
//   });
//   $('#loading').removeClass('active');
// }

function setValues(){
  // localStorage.removeItem('ratings');
  // localStorage.removeItem('distances');
  var distances = JSON.parse(localStorage.getItem('distances'));
  var ratings = JSON.parse(localStorage.getItem('ratings'));
  var avg_distance = 0;
  var avg_rating = 0;
  var deviation_distance = 0;
  var deviation_rating = 0;

  if(distances != null && distances.length != 0){
    var avg_distance = distances.reduce(addElementsDistance)/distances.length;
    function addElementsDistance(sumdistance1, ndistance1){
      return sumdistance1 + ndistance1;
    }
    var deviation_distance = 0;
    var sum_distance = 0;
    distances.forEach((item, i) => {
      sum_distance += (item - avg_distance)*(item - avg_distance);
    });
    deviation_distance = sum_distance/distances.length;
    // var deviation_distance = (distances.reduce(addSquaresDistance)/distances.length) - Math.pow(avg_distance, 2);
    // function addSquaresDistance(sumdistance2, ndistance2){
    //   return sumdistance2 + ndistance2*ndistance2;
    // }
  }
  if(ratings != null && ratings.length != 0){
    var avg_rating = ratings.reduce(addElementsRating)/ratings.length;
    function addElementsRating(sumrating1, nrating1){
      return sumrating1 + nrating1;
    }
    var deviation_rating = 0;
    var sum_rating = 0;
    ratings.forEach((item, i) => {
      sum_rating += (item - avg_rating)*(item - avg_rating);
    });
    deviation_rating = sum_rating/ratings.length;

    // var deviation_rating = (ratings.reduce(addSquaresRatings)/ratings.length) - Math.pow(avg_rating, 2);
    // function addSquaresRatings(sumrating2, nrating2){
    //   return sumrating2 + nrating2*nrating2;
    // }
  }

  avg_distance = parseFloat(Math.abs(avg_distance).toFixed(2));
  deviation_distance = parseFloat(Math.abs(deviation_distance).toFixed(2));
  avg_rating = parseFloat(Math.abs(avg_rating).toFixed(2));
  deviation_rating = parseFloat(Math.abs(deviation_rating).toFixed(2));
  $('#avg_distance').val(avg_distance);
  $('#deviation_distance').val(deviation_distance);
  $('#avg_rating').val(avg_rating);
  $('#deviation_rating').val(deviation_rating);
  // console.log(ratings.reduce(addSquaresRating)/(ratings.length));
}

// function temp(){
//   var distances = [0.5, 0.2, 1.2, 1.5, 0.3, 0.1];
//   var ratings = [5, 4.2, 4.6, 4.5, 3.9, 5];
//   localStorage.setItem('distances', JSON.stringify(distances));
//   localStorage.setItem('ratings', JSON.stringify(ratings));
// }

function sortResults2(){
  var arr = [];
  var idarr = []
  var table = document.getElementById("table");
  var rowlen = table.rows.length;
  $('#loading').addClass('active');
  $('#loading_text').html('Sorting results');
  var celllen = 5;
  for (var i = 1; i < rowlen; i++) {
    var subarr = []
    idarr.push(table.rows[i].cells[0].innerHTML);
    for (var j = 1; j < celllen; j++){
      subarr.push(table.rows[i].cells[j].innerHTML);
    }
    arr.push(subarr);
  }
  arr = JSON.stringify(arr);
  $.ajax({
    type: "POST",
    url: '/consumers/sortResults',
    data: {
      arr: arr,
      idarr: idarr,
    },
    success: function(dataarr){
      console.log(dataarr);
      idarr.forEach((item, i) => {
        $('#tempresults [data-id="'+item+'"]').attr('data-probability', dataarr[i]);
      });
      dataarr.sort(function(a, b){
        return b - a;
      });
      dataarr.forEach((item, i) => {
        $('#tempresults [data-probability="'+item+'"]').appendTo('#sortedresults');
      });
      $('#loading').removeClass('active');
    }
  });
}

$(document).ready(function(){
  // temp();
  if($('#search').length != 0){
    // sortResults();
    sortResults2();
  }
  else{
    // setting avg and deviation values
    setValues();
  }
});
