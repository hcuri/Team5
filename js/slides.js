// JavaScript Document

var root_url = "http://localhost/UPresent/api/index.php";
var slides = new Array();
var currentSlide = 1;	
var presID = 1;
var numSlides;

$(document).ready(function(e) {
	var slidesJSON = $.ajax({
		type: 'GET',
		url: root_url + "/getSlides/" + presID,
		dataType: "json",
		async: false,
	});
	slidesJSON = slidesJSON.responseJSON;
	numSlides = slidesJSON.numSlides;
	slides = slidesJSON.slides;
	//var title = slidesJSON.title;
	//var author = slidesJSON.author;
	
	
	$("#slide").attr("src", slides[1]);
	//$("#presName").html(title);
	//$("#presAuthor").html(author);
	
});

function updateSlide() {
	$("#slide").attr("src", slides[currentSlide]);
	$("#slideNum").html(currentSlide + "/" + numSlides);
}

setInterval(function() {
	var cS = $.ajax({
		type: 'GET',
		url: root_url + "/getCurrentSlide/" + presID,
		dataType: "json",
		async: false,
	});
	cS = cS.responseJSON;
	currentSlide = cS.currSlide;
	updateSlide();
}, 1000);
