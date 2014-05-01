$(document).ready(function(){
	var isMousedOver = false;
	$("img#fs").css({opacity: 0.0});

	$("img#slide").mouseover(function() {
      	$("img#fs").animate({opacity: 1.0}, "fast");
	});
	$("img#slide").mouseout(function() {
		if (!isMousedOver) {
			$("img#fs").animate({opacity: 0.0}, "fast");
		}
	});

	$("img#fs").click(function(){
		$("img#fs").requestFullscreen();
	});


});