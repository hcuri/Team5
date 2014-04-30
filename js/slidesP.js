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
			backgroundColor: "#FFFFFF",
        };

$(document).ready(function(e) {
	presID = $.cookie('pres');
 
  	$("#previous").css("background-color", "black");
	$("#previous").removeAttr("src");
	
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
        if(numSlides > 1)
            $("#next").attr("src", slides[2]);
        else {
            $("#next").attr("src", ""); //need contingincy for this
            $("#next").css("background-color", "black");
        }
	
	$("#slide").click(function() {
                if(currentSlide < numSlides) {
                    currentSlide++;
                    updateSlide();
                }
	});
	$("#previous").click(function() {
		if(currentSlide > 1) {
		currentSlide--;
		updateSlide();
		}
	});
	$("#next").click(function() {
            if(currentSlide < numSlides) {
		currentSlide++;
		updateSlide();
            }
	});
	
	$(document).keydown(function(e) {
		if(e.keyCode == 37) {
			if(currentSlide > 1) {
				currentSlide--;
				updateSlide();
			}
		}
		if(e.keyCode == 39) {
			if(currentSlide < numSlides) {
				currentSlide++;
				updateSlide();
			}
		}
	});
        $("#endPres").click(function() {
                finishPresentation();
		window.location = "http://localhost/user.php";
	});
});

var getCurrSlide = setInterval(function() {
		var cS = $.ajax({
			type: 'GET',
			url: root_url + "/getCurrentSlide/" + presID,
			dataType: "json",
			async: false,
		});
		cS = cS.responseJSON;
		currentSlide = cS.currSlide;
		var poll = cS.poll;
		updateSlide();
		
		if(poll) {
			$("#content").css("height", 675);
			$("#bottomInfo").css("display", "block");
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
			setInterval(getPollResults,500);
			
		} else {
			$("#content").css("height", 600);
			$("#bottomInfo").css("display", "none");
			
		}
}, 3000);



function updateSlide() {
	$("#slide").attr("src", slides[currentSlide]);
	
	if(currentSlide < 2) {
		$("#next").attr("src", slides[currentSlide+1]);
		$("#previous").attr("src", "");
		$("#previous").css("background-color", "black");
	} else if(currentSlide == numSlides) {
		$("#previous").attr("src", slides[currentSlide-1]);
		$("#next").attr("src", "");
		$("#next").css("background-color", "black");
	} else {
		$("#previous").attr("src", slides[currentSlide-1]);
		$("#next").attr("src", slides[currentSlide+1]);
	}
	
	$.ajax({
		type: 'POST',
		url: root_url + 'setCurrentSlide',
		data: slideFormToJSON(),
		async: false,
		success: function(){
			//alert("Slide Changed");
		},
		error: function(jqXHR, textStatus, errorThrown){
			alert('Something went wrong\nregister() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
		}
	});
	
}

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
function slideFormToJSON() {
	return JSON.stringify({
		"presId" : presID,
		"currSlide": currentSlide
	});
}

function finishPresentation() {
    $.ajax({
		type: 'POST',
		url: root_url + 'finishPresentation',
		data: endFormToJSON(),
		async: false,
		success: function(msg){
			alert(msg);
		},
		error: function(jqXHR, textStatus, errorThrown){
			alert(jqXHR + ' Something went wrong\nregister() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
		}
	});
}

function endFormToJSON() {
    return JSON.stringify({
        "presId" : presID
    });
}