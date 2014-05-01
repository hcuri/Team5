// JavaScript Document



$(document).ready(function(e) {
    var today = new Date().toISOString().split('T')[0];
	$("#datePick").attr("min", today);
});

function flashErr(num, msg) {
  if(num == 1) {
    $('div#errBox').text("");
    $('div#errBox').text(msg);
    $('div#errBox').css({opacity: 1.0});
    $("div#errBox").animate({opacity: 1.0}, "slow", function(){
      $("div#errBox").animate({opacity: 0.0}, "slow");
    });
  }
  else if(num == 2) {
    $('div#errBox').text("");
    $('div#errBox').text(msg);
    $('div#errBox').css({opacity: 1.0});
    $("div#errBox").animate({opacity: 1.0}, "slow", function(){
      $("div#errBox").animate({opacity: 0.0}, "slow");
    });
  }
  else {
    alert("Internal error. You just broke the internet.");
  }
}