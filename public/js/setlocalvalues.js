function setRatingAndDistance(){
  // ratings
  var ratingval = parseFloat($('#rating').val());
  var ratings = localStorage.getItem('ratings');
  if(ratings == null){
    ratings = [];
  }
  else{
    ratings = JSON.parse(ratings);
  }
  if(ratingval != 0){
    ratings.push(ratingval);
  }
  localStorage.setItem('ratings', JSON.stringify(ratings));

  // distances
  var distanceval = parseFloat($('#distance').val());
  var distances = localStorage.getItem('distances');
  if(distances == null){
    distances = [];
  }
  else{
    distances = JSON.parse(distances);
  }
  if(distanceval != 0){
    distances.push(distanceval);
  }
  localStorage.setItem('distances', JSON.stringify(distances));

}

function getRatings(){
  console.log(localStorage.getItem('ratings'));
}
function getDistances(){
  console.log(localStorage.getItem('distances'));
}

$(document).ready(function(){
  setRatingAndDistance();
  getRatings();
  getDistances();
});
