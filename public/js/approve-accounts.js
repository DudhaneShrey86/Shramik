
function performaction(t){
  var parentelement = t.parent().parent().parent();
  var pid = parentelement.data('id');
  var action = t.data('actiontype');
  var toast = M.toast({
    html: "Verifying...",
    displayLength: 10000,
  });
  $.ajax({
    type: "POST",
    url: '/admins/approve-accounts',
    data: {
      id: pid,
      actiontype: action,
    },
    success: function(data){
      parentelement.fadeOut('200');
      toast.dismiss();
      var str = "Account Rejected";
      if(data == 'yes'){
        str = 'Account Approved!';
      }
      var toast2 = M.toast({
        html: str,
        displayLength: 2000,
      });
    }
  });
}

$(document).ready(function(){
  $('.actionbuttons').click(function(){
    performaction($(this));
  });
});
