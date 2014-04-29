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

$(document).ready(function() {
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
	
	$("#slideNum").html(currentSlide + "|" + numSlides);
	$("#slide").attr("src", slides[currentSlide]);
		
	//ADD CLICK LISTENERS TO ALL SUBMISSION BUTTONS
	$(".submitButton").click(function(event) {
		var pollResponse = event.target;
		pollResponse = $(pollResponse).html();
		submitResponse(pollResponse);
		clearInterval(getCurrSlide);
		setInterval(getPollResults, 1000);
	});
});

function updateSlide() {
	$("#slide").attr("src", slides[currentSlide]);
	$("#slideNum").html(currentSlide + "/" + numSlides);
}

function submitResponse(response) {
	//AJAX POST CALL TO SUBMIT RESPONSE
	$.ajax({
            type: 'POST',
            url: root_url + '/submitResponse',
            data: submitFormToJSON(response),
            async: false,
            success: function(){
            	alert("Response Submitted");
            },
            error: function(jqXHR, textStatus, errorThrown){
            	alert('Something went wrong\nregister() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
            }
        });
			
	//TEST INFO FOR GRAPH STUFF
	google.setOnLoadCallback(drawChart);
	getPollResults();
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
		//var poll = cS.poll;
		var poll = true;
		updateSlide();
		
		if(poll) {
			/*var pollJSON = $.ajax({
				type: 'GET',
				url: root_url + "/getPollInfo/" + presID + "/" + currentSlide,
				dataType: "json",
				async: false,
			});
			pollJSON = pollJSON.responseJSON;
			var q = pollJSON.question;*/
			var questions = new Array();
			//questions = pollJSON.questions;
			
			questions.push("question 1");
			questions.push("question 2");
			questions.push("question 3");
			questions.push("question 4");
			
			//DISPLAY POLL QUESTIONS
			//BLAH BLAH BLAH
			var qS = document.getElementsByClassName("q");
			
			for(var i = 0; i < 4; i++) {
				$(qS[i]).html(questions[i]);
			}
			
		} else {
			//make poll shit disappear	
		}
}, 5000);

//CHECK FOR NEW UPDATES TO POLL
function getPollResults() {
	while(liveResults.length > 0) {
		liveResults.pop();
	}
	
	var result = $.ajax({
		type: 'GET',
		url: root_url + "/getPollResults/" + presID + "/" + currentSlide,
		dataType: "json",
		async: false,
	});
	result = result.responseJSON;
	
	for(var i = 0; i < 4; i++) {
		liveResults.push(result[i].option_results);
	}
	drawChart();
};

function drawChart() {
	chart = new google.visualization.ColumnChart(document.getElementById('bInfoGraph'));

	for(var i = 0; i < 4; i++) {
		data.setValue(i, 1, liveResults[i]);
	}
	chart.draw(data, options);
}

// Helper function to serialize all the form fields into a JSON string
function submitFormToJSON(response) {
	return JSON.stringify({
		"presId" : presID,
		"currSlide" : currentSlide,
		"response" : response
	});
}