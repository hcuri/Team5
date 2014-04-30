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
var draw = false;

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
                    updatedSlide++;
                    updateSlide();
                }
	});
	$("#previous").click(function() {
		if(currentSlide > 1) {
		updatedSlide--;
		updateSlide();
		}
	});
	$("#next").click(function() {
            if(currentSlide < numSlides) {
		updatedSlide++;
		updateSlide();
            }
	});
	
	$(document).keydown(function(e) {
		if(e.keyCode == 37) {
			if(currentSlide > 1) {
				updatedSlide--;
				updateSlide();
			}
		}
		if(e.keyCode == 39) {
			if(currentSlide < numSlides) {
				updatedSlide++;
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
			chart.draw(data, options);
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



function updateSlide() {
	$("#slide").attr("src", slides[updatedSlide]);
	
	if(updatedSlide < 2) {
		$("#next").attr("src", slides[updatedSlide+1]);
		$("#previous").attr("src", "");
		$("#previous").css("background-color", "black");
	} else if(updatedSlide == numSlides) {
		$("#previous").attr("src", slides[updatedSlide-1]);
		$("#next").attr("src", "");
		$("#next").css("background-color", "black");
	} else {
		$("#previous").attr("src", slides[updatedSlide-1]);
		$("#next").attr("src", slides[updatedSlide+1]);
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
		data.setValue(i, 1, result[i].option_results);
	}
	chart.draw(data, options);
};

// Helper function to serialize all the form fields into a JSON string
function slideFormToJSON(pN) {
	return JSON.stringify({
		"presId" : presID,
		"currSlide": updatedSlide
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