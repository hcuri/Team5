// JavaScript Document

var root_url = "http://localhost/UPresent/api/index.php";
var slides = new Array();

$(document).ready(function(e) {
 
  	$("#previous").css("background-color", "black");
	$("#previous").removeAttr("src");
	
	var presID = 0;
	
	var slidesJSON = $.ajax({
		type: 'GET',
		url: root_url + "getSlides" + presID,
		dataType: "json",
		async: false,
	});
	var slidesJSON = slidesJSON.responseJSON;
	var numSlides = slidesJSON.numSlides;
	var slides = slidesJSON.slides;
	
	for(var i = 0; i < numSlides; i++) {
		slides[i] = slidesJSON[i].url;
	}
	
	$("#slide").attr("src", slides[0]);
	$("#next").attr("src", slides[1]);
	
});

function updateSlide(num) {
	$("#slide").attr("src", slides[num]);
	
	if(num === 0) {
		$("#next").attr("src", slides[num+1]);
		$("#previous").attr("src", "");
		$("#previous").css("background-color", "black");
	} else if(num === (numSlides-1)) {
		$("#previous").attr("src", slides[num-1]);
		$("#next").attr("src", "");
		$("#next").css("background-color", "black");
	} else {
		$("#previous").attr("src", slides[num-1]);
		$("#next").attr("src", slides[num+1]);
	}
}