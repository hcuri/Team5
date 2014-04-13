// JavaScript Document

var root_url = "http://localhost/UPresent/api/index.php";
var slides = new Array();
var currentSlide = 1;
var numSlides;

$(document).ready(function(e) {
 
  	$("#previous").css("background-color", "black");
	$("#previous").removeAttr("src");
	
	var presID = 1;
	
	var slidesJSON = $.ajax({
		type: 'GET',
		url: root_url + "/getSlides/" + presID,
		dataType: "json",
		async: false,
	});
	slidesJSON = slidesJSON.responseJSON;
	numSlides = slidesJSON.numSlides;
	slides = slidesJSON.slides;
	
	$("#slide").attr("src", slides[1]);
	$("#next").attr("src", slides[2]);
	
	$("#slide").click(function() {
		currentSlide++;
		updateSlide();
	});
	$("#previous").click(function() {
		if(currentSlide > 1) {
		currentSlide--;
		updateSlide();
		}
	});
	$("#next").click(function() {
		currentSlide++;
		updateSlide();
	});
	
	$(document).keydown(function(e) {
		if(e.keyCode == 37) {
			if(currentSlide > 1) {
				currentSlide--;
				updateSlide();
			}
		}
		if(e.keyCode == 39) {
			currentSlide++;
			updateSlide();
		}
	});
	
	
});

function updateSlide() {
	$("#slide").attr("src", slides[currentSlide]);
	
	if(currentSlide < 2) {
		$("#next").attr("src", slides[currentSlide+1]);
		$("#previous").attr("src", "");
		$("#previous").css("background-color", "black");
	} else if(currentSlide === (slides.length-1)) {
		$("#previous").attr("src", slides[currentSlide-1]);
		$("#next").attr("src", "");
		$("#next").css("background-color", "black");
	} else {
		$("#previous").attr("src", slides[currentSlide-1]);
		$("#next").attr("src", slides[currentSlide+1]);
	}
}