// JavaScript Document

var root_url = "http://localhost/UPresent/api/index.php";
var slides = new Array();
var currentSlide = null;	
var presID = null;
var numSlides;
var poll = false;
var liveResults = new Array();
var letters = ['A','B','C','D'];
var data = new google.visualization.arrayToDataTable([
		['Response','Number', {role: 'style'}],
		['A', 0, '#FF0000'],
		['B', 0, '#FFFF00'],
		['C', 0, '#FF00FF'],
		['D', 0, '#000000'],]
		);
var chart;
var options = {
			legend: {position: 'none'},
			backgroundColor: "#EDEDED",
        };

$(document).ready(function(e) {
	
	google.load("visualization", "1", {packages:["corechart"]});
	
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
	
	$("#slideNum").html(currentSlide + "|" + numSlides);
	$("#slide").attr("src", slides[currentSlide]);
	
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
		//clearInterval(getCurrSlide);
		//setInterval(getPollResults, 500);
	});
});

function updateSlide() {
	$("#slide").attr("src", slides[currentSlide]);
	$("#slideNum").html(currentSlide + "/" + numSlides);
}

function submitResponse(response) {
	//AJAX POST CALL TO SUBMIT RESPONSE
	
	
	
	//TEST INFO FOR GRAPH STUFF
	google.setOnLoadCallback(drawChart);
	getPollResults();
	drawChart();
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
function getPollResults() {
	while(liveResults.length > 0) {
		liveResults.pop();
	}
	
	var results = $.ajax({
		type: 'GET',
		url: root_url + "/getPollResults/" + presID + "/" + currentSlide,
		dataType: "json",
		async: false,
	});
	results = results.responseJSON;
	liveResults = results.results;
	
	for(var i = 0; i < 4; i++) {
		
	}
};

function drawChart() {
	chart = new google.visualization.ColumnChart(document.getElementById('bInfoGraph'));

	for(var i = 0; i < 4; i++) {
		data.setValue(i, 1, liveResults[i]);
	}
	chart.draw(data, options);
}