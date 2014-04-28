// JavaScript Document

var root_url = "http://localhost/UPresent/api/index.php";
var slides = new Array();
var currentSlide = null;	
var presID = null;
var numSlides;
var poll = false;
var liveResults = new Array();

$(document).ready(function(e) {
	
	var slideInfo = $.ajax({
		type: 'GET',
		url: root_url + "/getPresInfo",
		dataType: "json",
		async: false,
	});
	slideInfo = slideInfo.responseJSON;
	presID = slideInfo.presId;
	//poll = slideInfo.poll;
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
	
	
	
	
	//TEST INFO FOR GRAPH STUFF
	$("#bInfoGraph").html('<canvas id="results" width="475" height="200"></canvas>');
	
	var testData = "{labels : ['A','B','C','D'],datasets : [{fillColor : '#2C17B1',strokeColor : '#FF9F00',data : [6,2,9,1]}]}";

	
	var ctx = document.getElementById("results").getContext("2d");
	var newChart = new Chart(ctx).Bar(testData);
	
	//GET POLL INFO IF THERE IS A POLL
	if(poll) {
		
		var pollJSON = $.ajax({
			type: 'GET',
			url: root_url + "/getPollInfo/" + presID + "/" + currentSlide,
			dataType: "json",
			async: false,
		});
		pollJSON = pollJSON.responseJSON;
		var numQs = pollJSON.numSlides;
		var questions = new Array();
		questions = pollJSON.questions;
		
		//DISPLAY POLL QUESTIONS
		//BLAH BLAH BLAH
	}
		
		//ADD CLICK LISTENERS TO ALL SUBMISSION BUTTONS
		$(".submitButton").click(function(event) {
			alert("test");
			var pollResponse = event.target;
			pollResponse = $(pollResponse).html();
			submitResponse(pollResponse);
			clearInterval(getCurrSlide);
			setInterval(getPollResults, 500);
		});
		
	
	
	
});

function updateSlide() {
	$("#slide").attr("src", slides[currentSlide]);
	$("#slideNum").html(currentSlide + "/" + numSlides);
}

function updateResults() {
	
}

function submitResponse(response) {
	//AJAX POST CALL TO SUBMIT RESPONSE
}


var getCurrSlide = setInterval(function() {
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

//CHECK FOR NEW UPDATES TO POLL
var getPollResults = function () {
		var results = $.ajax({
			type: 'GET',
			url: root_url + "/getPollResults/" + presID + "/" + currentSlide,
			dataType: "json",
			async: false,
		});
		results = results.responseJSON;
		liveResults = results.results;
		updateResults();
};


/*

<canvas id="results" width="475" height="200"></canvas>


function displayResultsBar(data) {
	var ctx = document.getElementById("results").getContext("2d");
	var newChart = new Chart(ctx).Bar(data);
}


	var data = {
	labels : ["A","B","C","D"],
	datasets : [
		{
			fillColor : "#2C17B1",
			strokeColor : "#FF9F00",
			data : [6,2,9,1]
		}]}

		displayResultsBar(data);


*/