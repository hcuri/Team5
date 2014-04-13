// JavaScript Document

var root_url = "http://localhost/UPresent/api/index.php";
var slides = new Array();

$(document).ready(function(e) {
	
	var presID = 1;
  
	var slidesJSON = $.ajax({
		type: 'GET',
		url: root_url + "/getSlides/" + presID,
		dataType: "json",
		async: false,
	});
	var slidesJSON = slidesJSON.responseJSON;
	alert(JSON.stringify(slidesJSON));
	var numSlides = slidesJSON.numSlides;
	var slides = slidesJSON.slides;
	
	alert(slides[1]);
	
	$("#slide").attr("src", slides[1]);
	
});

function updateSlide(num) {
	$("#slide").attr("src", slides[num]);
}