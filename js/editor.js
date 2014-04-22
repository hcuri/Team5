$(document).ready(function(){

  var left = (window.width / 2) - 250;
  $("div#invContainer").css({left: 350});
  
  $("div#fadeout").hide();
  $("div#invContainer").hide();

  $("#inv").click(function(){
  	$("div#fadeout").show();
  	$("div#invContainer").show();
    $("div#fadeout").animate({opacity: 0.7}, "fast");
    $("div#invContainer").animate({opacity: 1.0}, "fast");
  });
  $("div#fadeout").click(function(){
  	$("div#fadeout").animate({opacity: 0.0}, "fast", function(){
  		$("div#fadeout").hide();
  	});
  	$("div#invContainer").animate({opacity: 0.0}, "fast", function(){
  		$("div#invContainer").hide();
  	});
  });

  //groupTable
  var isClicked = false;
  $("div#uName").click(function() {
      if($(this).attr('class') === 'selected') {
        $(this).css("background-color","#ffffff");
      }
      else if($(this).attr('class') !== 'selected')
        $(this).css("background-color","#ededed");
      $(this).toggleClass('selected');
  });

});