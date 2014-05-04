// JavaScript Document

var slides = new Array();
var currentSlide = null;
var updatedSlide = null;	
var presID = null;
var numSlides;
var poll = false;
var pollDone = false;
var submitted = false;
var interval = null;
var show = false;
var fullS = false;
var backToFS = false;
var liveResults = new Array();
var letters = ['A','B','C','D','E','F'];
var numQ;
var data;
var data1 = new google.visualization.arrayToDataTable([
		['Response','Number', {role: 'style'}],
		['A', 0, '#32CD32'],]
		);
var data2 = new google.visualization.arrayToDataTable([
		['Response','Number', {role: 'style'}],
		['A', 0, '#32CD32'],
		['B', 0, '#1C86EE'],]
		);
var data3 = new google.visualization.arrayToDataTable([
		['Response','Number', {role: 'style'}],
		['A', 0, '#32CD32'],
		['B', 0, '#1C86EE'],
		['C', 0, '#FFA500'],]
		);
var data4 = new google.visualization.arrayToDataTable([
		['Response','Number', {role: 'style'}],
		['A', 0, '#32CD32'],
		['B', 0, '#1C86EE'],
		['C', 0, '#FFA500'],
		['D', 0, '#FF4500'],]
		);
var data5 = new google.visualization.arrayToDataTable([
		['Response','Number', {role: 'style'}],
		['A', 0, '#32CD32'],
		['B', 0, '#1C86EE'],
		['C', 0, '#FFA500'],
		['D', 0, '#FF4500'],
		['E', 0, '#FFD700'],]
		);
var data6 = new google.visualization.arrayToDataTable([
		['Response','Number', {role: 'style'}],
		['A', 0, '#32CD32'],
		['B', 0, '#1C86EE'],
		['C', 0, '#FFA500'],
		['D', 0, '#FF4500'],
		['E', 0, '#FFD700'],
		['F', 0, '#CD00CD'],]
		);
var chart;
var options = {
			legend: {position: 'none'},
			backgroundColor: "#FFFFFF",
			width: 525,
			height: 200,
			vAxis: {
				textStyle: {
					color: 'white',
				},
			},
        };
var elem = null;
var openFS = null;


$(document).ready(function() {
	elem = document.getElementById("slide");
	openFS = elem.requestFullScreen || elem.webkitRequestFullScreen || elem.mozRequestFullScreen;
	
	$("#bottomInfo").css("display", "none");
	$("#bInfoData").css("display", "none");
	$("#content").css("height", "475");

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
	
	$("#slide").click(function() {
		if(fullS) {
    		document.webkitCancelFullScreen();
			fullS = false;
		} else {
			openFS.call(elem);
			fullS = true;
		}
	});
});

function updateSlide() {
	$("#slide").attr("src", slides[currentSlide]);
	$("#slideNum").html(currentSlide + "/" + numSlides);
	clearInterval(interval);
	interval = null;
}

function submitResponse(response) {
	//AJAX POST CALL TO SUBMIT RESPONSE
	$.ajax({
            type: 'POST',
            url: root_url + '/submitResponse',
            data: submitFormToJSON(response),
            async: false,
            success: function(){
            },
            error: function(jqXHR, textStatus, errorThrown){
            	alert('Something went wrong\nregister() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
            }
        });
	
	if(show) {
		//TEST INFO FOR GRAPH STUFF
		$("#bInfoGraph").animate({
			opacity: 0
		}, 500, function() {
			interval = setInterval(getPollResults, 1000);
		});
		
	} else {
            pollDone = true;
            getCurrSlide;
        }
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
			if(fullS) {
				document.webkitCancelFullScreen();
			}
			$( "#content" ).animate({
				height: 700
			}, 500, function() {	
				$("#bottomInfo").css("display", "block");
				$("#bInfoData").css("display", "block");
				$( "#bottomInfo" ).animate({
					opacity: 1
				}, 500, function() {
				});	
			});
			
			var pollJSON = $.ajax({
				type: 'GET',
				url: root_url + "/getPollInfo/" + presID + "/" + currentSlide,
				dataType: "json",
				async: false,
			});
			pollJSON = pollJSON.responseJSON;
			
			var q = pollJSON.question;
			var opts = pollJSON.options;
			numQ = pollJSON.numOptions;
			show = pollJSON.showResults;
			
			$(".question").html(q);
			
			var qS = document.getElementsByClassName("q");
			
			var tableContents = '<tr><th></th><th class="question">' + q +'</th></tr>';
			
			for(var i = 0; i < numQ; i++) {
				tableContents += '<tr><td>' + letters[i] + ':</td><td class="q">' + opts[letters[i]] + '</td></tr>';
			}
			
			switch(numQ) {
				case 1:
					data = data1;
					break;
				case 2:
					data = data2;
					break;
				case 3:
					data = data3;
					break;
				case 4:
					data = data4;
					break;
				case 5:
					data = data5;
					break;
				case 6:
					data = data6;
					break;
			}
			
			$("#bInfoData").html(tableContents);
			
			var buttonData = "";
			buttonData += '<h2>Choose a Response:</h2><table id="pollSubmission"><tr>';
			
			for(var i = 0; i < numQ; i++) {
				buttonData += '<td id="response' + letters[i] + '" class="submitButton"><input type="submit" value="' + letters[i] + '" id="' + letters[i] + 'Submit" /></td>';
			}
			
			buttonData += '</tr></table>';
			
			$("#bInfoGraph").html(buttonData);
			//ADD CLICK LISTENERS TO ALL SUBMISSION BUTTONS
			$(".submitButton").click(function(event) {
				var pollResponse = event.target;
				pollResponse = $(pollResponse).val();
				submitted = true;
				submitResponse(pollResponse);
			});
			
			poll = false;
			pollDone = false;
			
		} else if (pollDone) {
			console.log("clearing poll");
			$( "#bottomInfo" ).animate({
				opacity: 0
			}, 500, function() {
				$("#bInfoData").css("display", "none");
				$("#bottomInfo").css("display", "none");
				$( "#content" ).animate({
					height: 475
				}, 500, function() {
					// Animation complete.
				});	
			});
			
			pollDone = false;
			submitted = false;
		}
}, 1000);

//CHECK FOR NEW UPDATES TO POLL
var getPollResults = function() {
	console.log("getPollResults");
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
	
	for(var i = 0; i < numQ; i++) {
		data.setValue(i, 1, result[i].option_results);
	}
	
	chart = new google.visualization.ColumnChart(document.getElementById('bInfoGraph'));
	chart.draw(data, options);
	
	var opacity = $("#bInfoGraph").css("opacity");
	if(opacity == 0){
		$("#bInfoGraph").animate({
			opacity: 1
		}, 500, function() {
		});
	}
};

// Helper function to serialize all the form fields into a JSON string
function submitFormToJSON(response) {
	return JSON.stringify({
		"presId" : presID,
		"currSlide" : currentSlide,
		"response" : response
	});
}