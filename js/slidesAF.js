// JavaScript Document

var root_url = "http://localhost/UPresent/api/index.php";
var slides = new Array();
var currentSlide = 1;	
var presID = null;
var numSlides;
var poll = false;
var liveResults = new Array();
var letters = ['A','B','C','D'];
var data = new google.visualization.arrayToDataTable([
		['Response','Number', {role: 'style'}],
		['A', 0, '#32CD32'],
		['B', 0, '#1C86EE'],
		['C', 0, '#FFA500'],
		['D', 0, '#FF4500'],]
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
var draw = false;

$(document).ready(function(e) {
	presID = $.cookie('pres');
	
	$("#bottomInfo").css("display", "none");
	$("#bInfoData").css("display", "none");
	$("#content").css("height", "475");
 
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
		
	getCurrSlide();
	
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
});

function getCurrSlide() {
		var pollJSON = $.ajax({
				type: 'GET',
				url: root_url + "/getPollInfo/" + presID + "/" + currentSlide,
				dataType: "json",
				async: false,
		});
		pollJSON = pollJSON.responseJSON;
		var isEmpty = pollJSON.poll;
		if(isEmpty === "empty") {
			poll = false;
		} else {
			poll = true;		
		}
			
		if(poll) {
			getPollResults();
			$( "#content" ).clearQueue().animate({
				height: 675
			}, 500, function() {	
				$("#bottomInfo").css("display", "block");
				$("#bInfoData").css("display", "block");
				$( "#bottomInfo" ).animate({
					opacity: 1
				}, 500, function() {
				});	
			});
			
			var q = pollJSON.question;
			var opts = pollJSON.options;
			
			$(".question").html(q);
			
			var qS = document.getElementsByClassName("q");
			
			for(var i = 0; i < 4; i++) {
				$(qS[i]).html(opts[letters[i]]);
			}
		} else {
			
			$( "#bottomInfo" ).clearQueue().animate({
				opacity: 0
			}, 500, function() {
				$("#bInfoData").css("display", "none");
				$("#bottomInfo").css("display", "none");
				$( "#content" ).animate({
					height: 475
				}, 500, function() {
				//nothing
				});	
			});
		}
}



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
	getCurrSlide();
}

//CHECK FOR NEW UPDATES TO POLL
function getPollResults() {
	var result = $.ajax({
		type: 'GET',
		url: root_url + "/getPollResults/" + presID + "/" + currentSlide,
		dataType: "json",
		async: false,
	});
	
	result = result.responseJSON;
	
	var rS = document.getElementsByClassName("r");
	
	for(var i = 0; i < 4; i++) {
		data.setValue(i, 1, result[i].option_results);
		$(rS[i]).html(result[i].option_results);
	}
	
	chart = new google.visualization.ColumnChart(document.getElementById('bInfoGraph'));
	chart.draw(data, options);
};