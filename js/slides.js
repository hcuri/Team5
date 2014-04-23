// JavaScript Document

var root_url = "http://localhost/UPresent/api/index.php";
var slides = new Array();
var currentSlide = null;	
var presID = null;
var numSlides;

$(document).ready(function(e) {
	var slideInfo = $.ajax({
		type: 'GET',
		url: root_url + "/getPresInfo",
		dataType: "json",
		async: false,
	});
	slideInfo = slideInfo.responseJSON;
	presID = slideInfo.presId;
	var presName = slideInfo.presName;
	var author = slideInfo.fName + " " + slideInfo.lName;
	currentSlide = slideInfo.currSlide;
	$("#presName").html(presName);
	$("#presAuthor").html(author);
	
	
	var slidesJSON = $.ajax({
		type: 'GET',
		url: root_url + "/getSlides/" + presID,
		dataType: "json",
		async: false,
	});
	slidesJSON = slidesJSON.responseJSON;
	numSlides = slidesJSON.numSlides;
	slides = slidesJSON.slides;
	
	$("#slideNum").html(currentSlide + "/" + numSlides);
	$("#slide").attr("src", slides[currentSlide]);
	
});

function updateSlide() {
	$("#slide").attr("src", slides[currentSlide]);
	$("#slideNum").html(currentSlide + "/" + numSlides);
}

setInterval(function () {
	var cS = $.ajax({
		type: 'GET',
		url: root_url + "/getCurrentSlide/" + presID,
		dataType: "json",
		async: false,
	});
	cS = cS.responseJSON;
	currentSlide = cS.currSlide;
	updateSlide();
}, 500);
