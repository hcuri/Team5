// JavaScript Document

var root_url = "http://localhost/UPresent/api/index.php";
var slides = new Array();

$(document).ready(function(e) {
	
	var presID = 1;
  
	var slidesJSON = $.ajax({
		type: 'GET',
		url: root_url + "getSlides" + presID,
		dataType: "json",
		async: false,
	});
	var slidesJSON = slidesJSON.responseJSON;
	var numSlides = slidesJSON.slides;
	
	for(var i = 0; i < numSlides; i++) {
		slides[i] = slidesJSON[i].url;
	}
	
	$("#slide").attr("src", slides[0]);
	
});

function updateSlide(num) {
	$("#slide").attr("src", slides[num]);
}