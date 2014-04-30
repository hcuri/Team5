// JavaScript Document

var root_url = "http://localhost/UPresent/api/index.php";
var slides = new Array();
var currentSlide = null;
var updatedSlide = null;	
var presID = null;
var numSlides;
var poll = false;
var pollDone = false;
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
			backgroundColor: "#FFFFFF",
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
		setInterval(getCurrSlide, 1000);
		setInterval(getPollResults, 1000);
	});
});

function updateSlide() {
	$("#slide").attr("src", slides[currentSlide]);
	$("#slideNum").html(currentSlide + "/" + numSlides);
	setInterval(getCurrSlide, 1000);
	clearInterval(getPollResults);
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
		if(currentSlide !== cS.currSlide){
			currentSlide = cS.currSlide;
			updatedSlide = currentSlide;
			poll = cS.poll;
			pollDone = !poll;
			updateSlide();
		}
		
		if(poll) {
			$( "#content" ).animate({
				height: 675
			}, 1000, function() {	
				$("#bottomInfo").css("display", "block");
				$("#bInfoData").css("display", "block");
				$( "#bottomInfo" ).animate({
					opacity: 1
				}, 1000, function() {
				});	
			});
			
			var pollJSON = $.ajax({
				type: 'GET',
				url: root_url + "/getPollInfo/" + presID + "/" + currentSlide,
				dataType: "json",
				async: false,
			});
			pollJSON = pollJSON.responseJSON;
			
			var q = pollJSON[0].question;
			
			var qS = document.getElementsByClassName("q");
			
			for(var i = 0; i < 4; i++) {
				$(qS[i]).html(pollJSON[i+1].option_text);
			}
			
			chart = new google.visualization.ColumnChart(document.getElementById('bInfoGraph'));
			setInterval(getPollResults,1000);
			poll = false;
			pollDone = false;
			
		} else if (pollDone) {
			clearInterval(getPollResults);
			$( "#bottomInfo" ).animate({
				opacity: 0
			}, 1000, function() {
				$("#bottomInfo").css("display", "none");
				$("#bInfoData").css("display", "none");
			});	
			$( "#content" ).animate({
				height: 475
			}, 1000, function() {
				// Animation complete.
			});	
			pollDone = false;
		}
}, 1000);

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