$(document).ready(function(){

  var left = (window.width / 2) - 250; 
  $("div#invContainer").css({left: left});
  
  $("div#fadeout").hide();
  $("div#invContainer").hide();

  $("#inv").click(function(){
  	$("div#fadeout").show();
  	$("div#invContainer").show();
    $("div#fadeout").animate({opacity: 0.7}, "fast");
    $("div#invContainer").animate({opacity: 0.7}, "fast");
  });
  $("div#fadeout").click(function(){
  	$("div#fadeout").animate({opacity: 0.0}, "fast", function(){
  		$("div#fadeout").hide();
  	});
  	$("div#invContainer").animate({opacity: 0.0}, "fast", function(){
  		$("div#invContainer").hide();
  	});
  });
});